<?php

namespace App\Interfaces;

use App\Classes\SocialNetworkUser;

/**
 * Interface PushInterface.
 */
interface RRSSInterface
{

    /**
     * Return a user profile using an access token
     *
     * @param string $accesToken
     * @return mixed
     */
    public static function getProfile(string $accesToken) : SocialNetworkUser;
}
