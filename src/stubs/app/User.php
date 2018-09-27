<?php

namespace App;

use App\Models\ApiModel;
use App\Traits\PassportUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Http\Requests\Api\Users\UserAddOrUpdatePushTokenRequest;
use App\Http\Requests\Api\Users\UserRegisterRequest;
use App\Http\Requests\Api\Users\UserUpdateRequest;
use App\Http\Requests\Api\Users\UpdatePasswordRequest;
use App\Http\Requests\Api\Users\UserLoginRequest;
use App\Exceptions\ApiNotValidatedUserException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Helpers\StorageHelper;
use App\Http\Requests\Headers;
use App\Mail\AdminCredentials;
use App\Mail\VerificationMail;
use App\Mail\ForgotPassMail;
use App\Mail\WelcomeMail;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;
use Ramsey\Uuid\Uuid;

class User extends ApiModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable, Authorizable, Notifiable, CanResetPassword, PassportUser, MustVerifyEmail;

    protected $appends = ['authorization'];

    /** @var array casts for some properties */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     *  Things to do when a user is created or updated
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->password   = $model->password ? bcrypt($model->password) : $model->password;
            $model->mail_token = Uuid::uuid1()->toString();
            $model->os         = Headers::getOsAsInteger();
        });

        self::created(function ($model) {
            /** @var User $model */
            //$model->func();
        });

        self::updating(function ($model) {
            $model->os = Headers::getOsAsInteger();
        });
    }

    /**
     * Return the user related to the request bearer token
     *
     * @return User|null
     */
    public static function byToken()
    {
        $bearerToken = request()->bearerToken();

        $tokenId = (new Parser())->parse($bearerToken)->getHeader('jti');

        if ( ! $token = Token::find($tokenId)) {
            return null;
        }

        return static::find($token->user_id);
    }

    /**
     * Revoke the requested user token
     */
    public function revokeRequestedAccessToken()
    {
        $bearerToken = request()->bearerToken();

        $tokenId = (new Parser())->parse($bearerToken)->getHeader('jti');

        $this->tokens()->find($tokenId)->revoke();
    }

    /**
     * Set the pagination limit from the request or from the API constant
     * @return int
     */
    public function getPerPage()
    {
        return request('limit') && request('limit') < 100 ? request('limit') : API_QUERY_RESULTS_PER_PAGE;
    }

    /**
     * Return the public url of the user photo
     * @param $value
     * @return null|string
     */
    public function getPhotoAttribute($value)
    {
        return $value ? asset('storage/' . USER_PHOTOS_DIRECTORY . $value) : null;
    }

    /**
     * User is admin
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * User has root permissions
     * @return bool
     */
    public function hasRootPermissions()
    {
        return $this->permissions === ROOT_USER;
    }

    /**
     * User has admin permissions or greater
     * @return bool
     */
    public function hasAdminPermissions()
    {
        return ($this->permissions !== GENERIC_USER) && ($this->permissions <= ADMIN_USER);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pushTokens()
    {
        return $this->hasMany(UserPushToken::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getPushTokens()
    {
        return $this->pushTokens->pluck('token')->toArray();
    }

    /**
     * Save the user photo
     */
    public function savePhoto()
    {
        if (request()->file('photo')) { //request file
            $fileName = StorageHelper::saveUploadedFileToPublicDisk(USER_PHOTOS_DIRECTORY, 'photo');
        } elseif (filter_var(request('photo'), FILTER_VALIDATE_URL)) { //request url
            $fileName = StorageHelper::saveUrlToPublicDisk(USER_PHOTOS_DIRECTORY, request('photo'));
        } elseif (is_binary(request()->getContent())) { //request binary
            $fileName = StorageHelper::saveBinaryFileToPublicDisk(USER_PHOTOS_DIRECTORY);
        } else {
            return;
        }

        //Delete old file
        StorageHelper::deleteFileFromPublicDisk(USER_PHOTOS_DIRECTORY, $this->photo);

        //Save fileName into model table
        $this->update(['photo' => $fileName]);
    }

    /**
     * Create a new user and send a verification Mail (if needed)
     *
     * @param $request
     * @return User
     * @throws \Throwable
     */
    public static function registerWithEmail(UserRegisterRequest $request)
    {
        /** @var User $user */
        $user = static::create($request->only('name', 'email', 'password', 'advertising'));

        $user->savePhoto();

        if (USER_MUST_VERIFY_EMAIL) {
            $user->sendVerificationMail();
        } else {
            $user->generateToken();
        }

        return $user;
    }

    /**
     * @param UserRegisterRequest $request
     * @return User
     * @throws \Throwable
     */
    public static function registerWithFacebook(UserRegisterRequest $request)
    {
        /** @var User $user */
        $user = static::create($request->params('email', 'facebookId'));

        $user->savePhoto();

        if (USER_MUST_VERIFY_EMAIL) {
            $user->sendVerificationMail();
        } else {
            $user->generateToken();
        }

        return $user;
    }

    /**
     * @param UserRegisterRequest $request
     * @return User
     * @throws \Throwable
     */
    public static function registerWithGoogle(UserRegisterRequest $request)
    {
        /** @var User $user */
        $user = static::create($request->params('email', 'googleId'));

        $user->savePhoto();

        if (USER_MUST_VERIFY_EMAIL) {
            $user->sendVerificationMail();
        } else {
            $user->generateToken();
        }

        return $user;

    }

    /**
     * Login with email
     *
     * @param UserLoginRequest $request
     * @return User|null
     * @throws \Throwable
     */
    public static function loginWithEmail(UserLoginRequest $request)
    {
        /** @var User $user */
        $user = self::where(['email' => $request->get('email')])->first();

        if ( ! $user || ! Hash::check($request->get('password'), $user->getAuthPassword())) {
            return null;
        }

        throw_if(USER_MUST_VERIFY_EMAIL && ! $user->verified, new ApiNotValidatedUserException);

        $user->update(['os' => Headers::getOsAsInteger()]);

        $user->generateToken();

        return $user;
    }

    /**
     * @param UserLoginRequest $request
     * @return User
     * @throws \Throwable
     */
    public static function loginWithFacebook(UserLoginRequest $request)
    {
        $query = static::query();

        $query = $request->get('email') ? $query->orWhere('email', $request->get('email')) : $query;

        if ( ! $user = $query->orWhere('facebook_id', $request->get('facebookId'))->first()) {
            $user = static::create($request->params('email', 'facebookId', 'name', 'advertising'));
            $user->savePhoto();
        }

        $user->update(['facebook_id' => $request->get('facebookId')]);

        $user->generateToken();

        return $user;
    }

    /**
     * Login with Google
     * @param UserLoginRequest $request
     * @return User|null
     * @throws \Throwable
     */
    public static function loginWithGoogle(UserLoginRequest $request)
    {
        $query = static::query();

        $query = $request->get('email') ? $query->orWhere('email', $request->get('email')) : $query;

        if ( ! $user = $query->orWhere('google_id', $request->get('googleId'))->first()) {
            $user = static::create($request->params('email', 'googleId', 'name', 'advertising'));
            $user->savePhoto();
        }

        $user->update(['google_id' => $request->get('googleId')]);

        $user->generateToken();

        return $user;
    }

    /**
     * Verify the user mail by the mail token
     * @param string $mailToken
     * @return User|bool
     * @throws \Exception
     */
    public static function verifyMail(string $mailToken)
    {
        if ( ! $user = static::where('mail_token', $mailToken)->first()) {
            return false;
        }

        $user->update([
            'verified'   => true,
            'mail_token' => Uuid::uuid1(),
        ]);

        return $user;
    }

    /**
     * Send a welcome mail to the user
     */
    public function sendWelcomeMail()
    {
        Mail::to($this->email)->queue(new WelcomeMail($this));
    }

    /**
     * Send a verification mail to the user
     */
    public function sendVerificationMail()
    {
        Mail::to($this->email)->queue(new VerificationMail($this));
    }

    /**
     * Send a welcome mail to the admin user with the credentials
     * @param $password
     */
    public function sendEmailWithAdminCredentials($password)
    {
        Mail::to($this->email)->send(new AdminCredentials($this, $password));
    }

    /**
     *Send a mail with forgotten password
     */
    public function sendForgotPasswordMail()
    {
        Mail::to($this->email)->send(new ForgotPassMail($this));
    }

    /**
     * @param $request
     * @return bool
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->update(['password' => bcrypt($request->get('password'))]);

        return true;
    }

    /**
     * @param UserAddOrUpdatePushTokenRequest $request
     */
    public function addOrUpdatePushToken(UserAddOrUpdatePushTokenRequest $request)
    {
        if ( ! USER_HAS_MULTIPLE_PUSH_TOKENS) {
            $this->pushTokens()->delete();
        }

        $this->pushTokens()->firstOrCreate(['token' => $request->get('token')]);
    }

    /**
     * @param UserUpdateRequest $request
     */
    public function updateProfile(UserUpdateRequest $request)
    {
        if ($password = $request->get('password')) {
            $request->set('password', bcrypt($password));
        }

        $params = $password ? $request->params() : $request->only('name', 'email');

        $this->update($params);
    }

}