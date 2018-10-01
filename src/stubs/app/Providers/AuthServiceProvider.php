<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        //routes necessary to issue access tokens and revoke access tokens, clients, and personal access tokens
        Passport::routes();

        //the token is returned to the client without exchanging an authorization code
        Passport::enableImplicitGrant();

        //By default, Passport issues long-lived access tokens that expire after one year
        Passport::tokensExpireIn(Carbon::now()->addMinutes(ACCESS_TOKEN_EXPIRATION_MINUTES));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(ACCESS_TOKEN_REFRESHING_MINUTES));
    }
}
