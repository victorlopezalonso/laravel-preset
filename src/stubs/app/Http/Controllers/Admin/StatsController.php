<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Models\User;

class StatsController extends ApiController
{

    /**
     * Return the admin stats
     * @return \App\Http\Responses\ApiResponse
     */
    public function getStats()
    {
        $response = [
            'os'      => $this->statsByOs(),
            'genders' => $this->statsByGender(),
        ];

        return $this->response($response);
    }

    /**
     * Users stats by OS
     * @return array
     */
    protected function statsByOs()
    {
        $androidUsers = User::where('os', ANDROID_OS)->count();
        $iosUsers     = User::where('os', IOS_OS)->count();
        $others       = User::whereNull('os')->count();

        return [
            'labels' => ["Android", "iOS", "Other OS's"],
            'values' => [$androidUsers, $iosUsers, $others]
        ];
    }

    /**
     * Users stats by genders
     * @return array
     */
    protected function statsByGender()
    {
        $men    = User::where('gender', USER_MAN_GENDER)->count();
        $women  = User::where('gender', USER_WOMAN_GENDER)->count();
        $others = User::whereNull('gender')->count();

        return [
            'labels' => ["Men", "Women", "Not specified"],
            'values' => [$men, $women, $others]
        ];
    }

}
