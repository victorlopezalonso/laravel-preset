<?php

namespace App\Classes;

use GuzzleHttp\Client;
use App\Interfaces\RRSSInterface;

class Facebook implements RRSSInterface
{
    protected const OPEN_GRAPH_URL = 'https://graph.facebook.com/me';

    protected static $fields = 'about,id,address,age_range,birthday,can_review_measurement_request,context,education,email,favorite_athletes,favorite_teams,first_name,gender,hometown,inspirational_people,install_type,installed,interested_in,is_famedeeplinkinguser,is_shared_login,languages,last_name,link,location,meeting_for,middle_name,name,name_format,payment_pricepoints,political,public_key,quotes,relationship_status,religion,security_settings,shared_login_upgrade_required_by,short_name,significant_other,sports,test_group,video_upload_limits,viewer_can_send_gift,website,work';

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
                'fields'       => self::$fields,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
