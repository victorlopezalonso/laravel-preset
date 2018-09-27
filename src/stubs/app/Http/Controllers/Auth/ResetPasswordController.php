<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Copy;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'users/passwordreset/ok';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     */
    protected function resetPassword($user, $password)
    {
        $password = encryptWithAppSecret($password);

        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();
    }

    /**
     * Return a view to inform the user that the password has been reset
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function passwordResetOk()
    {
        request()->headers->add(['language' => request('language')]);

        $message = Copy::server('USER_PASSWORD_RESET_OK');

        return view('auth.passwords.reset-ok')->with(compact('message'));
    }

}
