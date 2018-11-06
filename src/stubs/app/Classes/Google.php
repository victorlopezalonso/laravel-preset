<?php

namespace App\Classes;

use GuzzleHttp\Client;
use App\Interfaces\RRSSInterface;

class Google implements RRSSInterface
{
    protected const OPEN_GRAPH_URL = 'https://www.googleapis.com/oauth2/v2/userinfo';

    /**
     * @param string $accesToken
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public static function getProfile(string $accesToken)
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

        return json_decode($response->getBody()->getContents());
    }
}
