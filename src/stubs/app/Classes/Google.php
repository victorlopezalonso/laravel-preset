<?php

namespace App\Classes;

use GuzzleHttp\Client;
use App\Interfaces\SocialNetWorkInterface;

class Google implements SocialNetWorkInterface
{
    protected const OPEN_GRAPH_URL = 'https://www.googleapis.com/oauth2/v2/userinfo';

    /**
     * Return a user profile using an access token.
     *
     * @param string $accesToken
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public static function getProfile(string $accesToken): SocialNetworkUser
    {
        $http = new Client();

        $response = $http->request('GET', self::OPEN_GRAPH_URL, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
            'query'   => [
                'access_token' => $accesToken,
            ],
        ]);

        $response = json_decode($response->getBody()->getContents());

        return (new SocialNetworkUser())
            ->setId($response->id ?? null)
            ->setEmail($response->email ?? null)
            ->setName($response->given_name ?? null)
            ->setLastName($response->family_name ?? null)
            ->setPhoto($response->picture ?? null);
    }
}
