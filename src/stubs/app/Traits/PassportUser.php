<?php

namespace App\Traits;

use App\Exceptions\ApiUnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\HasApiTokens;

trait PassportUser
{

    use HasApiTokens;

    public $authorization;

    /**
     * Search a user using the column specified for the user type
     * @param $username
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findForPassport($username)
    {
        $userType = [
            MAIL_USER => OAUTH_MAIL_USER_USERNAME_FIELD,
            FACEBOOK_USER => OAUTH_FACEBOOK_USER_USERNAME_FIELD,
            GOOGLE_USER => OAUTH_GOOGLE_USER_USERNAME_FIELD,
        ];

        $field = $userType[request('type') ?? MAIL_USER];

        return $this->where($field, $username)->first();
    }

    /**
     * Check the user passport against the column specified for the user type
     * @param $password
     * @return PassportUser|bool|\Illuminate\Database\Eloquent\Model|null
     */
    public function validateForPassportPasswordGrant($password)
    {
        $type = request('type') ?? MAIL_USER;

        switch ($type) {
            case MAIL_USER:
                return Hash::check($password, $this->getAuthPassword());
                break;

            case FACEBOOK_USER:
                return $this->where(OAUTH_FACEBOOK_USER_PASSWORD_FIELD, $password)->first();
                break;

            case GOOGLE_USER:
                return $this->where(OAUTH_GOOGLE_USER_PASSWORD_FIELD, $password)->first();
                break;

            default:
                return null;
        }

    }

    /**
     * @param string $scope
     * @throws \Throwable
     */
    public function generateToken($scope = '')
    {
        if (TOKEN_EXPIRES) {
            $this->createExpiringToken($scope);

            return;
        }

        $this->createNoExpiringToken();
    }

    /**
     * Create a new token and refresh token for the user
     * @param string $scope
     * @throws \Throwable
     */
    public function createExpiringToken($scope = '')
    {
        $userType = request('type') ?? MAIL_USER;

        $params = [
            'type' => $userType,
            'grant_type' => 'password',
            'client_id' => env('OAUTH_EXPIRING_CLIENT_ID'),
            'client_secret' => env('OAUTH_EXPIRING_CLIENT_SECRET'),
            'scope' => $scope
        ];

        $userTypes = [
            MAIL_USER => [
                'username' => $this->{OAUTH_MAIL_USER_USERNAME_FIELD},
                'password' => request(OAUTH_MAIL_USER_PASSWORD_FIELD)
            ],
            FACEBOOK_USER => [
                'username' => $this->{OAUTH_FACEBOOK_USER_USERNAME_FIELD},
                'password' => $this->{OAUTH_FACEBOOK_USER_PASSWORD_FIELD}
            ],
            GOOGLE_USER => [
                'username' => $this->{OAUTH_GOOGLE_USER_USERNAME_FIELD},
                'password' => $this->{OAUTH_GOOGLE_USER_PASSWORD_FIELD}
            ],
        ];

        $params['username'] = $userTypes[$userType]['username'];
        $params['password'] = $userTypes[$userType]['password'];

        request()->request->add($params);

        $request = Request::create('oauth/token', 'POST');

        /** @var Response $response */
        $response = Route::dispatch($request);

        throw_if($response->getStatusCode() !== HTTP_CODE_200_OK, new ApiUnauthorizedException(EXPIRED_TOKEN));

        $authorization = json_decode($response->getContent());

        $this->setAuthorization($authorization);
    }

    /**
     * Create a new expiring token based on the user refresh token
     * @throws \Throwable
     */
    public function refreshToken()
    {
        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => env('OAUTH_EXPIRING_CLIENT_ID'),
            'client_secret' => env('OAUTH_EXPIRING_CLIENT_SECRET'),
            'refresh_token' => request()->header('refreshToken'),
        ];

        request()->request->add($params);

        $request = Request::create('oauth/token', 'POST');

        /** @var Response $response */
        $response = Route::dispatch($request);

        throw_if($response->getStatusCode() !== HTTP_CODE_200_OK, new ApiUnauthorizedException(EXPIRED_REFRESH_TOKEN));

        $authorization = json_decode($response->getContent());

        $this->setAuthorization($authorization);
    }

    /**
     * Crea un token y un refresh token para el usuario del request
     */
    public function createNoExpiringToken()
    {
        //$name = env('APP_NAME') . " v" . Headers::getAppVersion() . " using " . Headers::getDeviceModel() . " with " . Headers::getPlatform();
        $name = 'test';
        $this->setAuthorization($this->createToken($name));
    }

    /**
     * Fill the authorization
     * @param $authorization
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = [
            'accessToken' => $authorization->access_token ?? $authorization->accessToken ?? null,
            'refreshToken' => $authorization->refresh_token ?? null,
            'expires' => $authorization->expires_in ?? null
        ];
    }
}