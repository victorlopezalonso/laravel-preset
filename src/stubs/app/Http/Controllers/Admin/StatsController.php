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
        $lang = request()->query('lang');
        $response = [
            'os'      => $this->statsByOs($lang),
            'genders' => $this->statsByGender($lang),
        ];

        return $this->response($response);
    }

    /**
     * Users stats by OS
     * @param string $lang
     * @return array
     */
    protected function statsByOs(string $lang)
    {
        $androidUsers = User::where('os', ANDROID_OS)->count();
        $iosUsers     = User::where('os', IOS_OS)->count();
        $others       = User::whereNull('os')->count();

        $labels_en = ["Android", "iOS", "Other OS's"];
        $labels_es = ["Android", "iOS", "Otro SO"];

        return [
            'labels' => ($lang === 'es' ? $labels_es : $labels_en),
            'values' => [$androidUsers, $iosUsers, $others]
        ];
    }

    /**
     * Users stats by genders
     * @param string $lang
     * @return array
     */
    protected function statsByGender(string $lang)
    {
        $men    = User::where('gender', USER_MAN_GENDER)->count();
        $women  = User::where('gender', USER_WOMAN_GENDER)->count();
        $others = User::whereNull('gender')->count();

        $labels_en = ["Men", "Women", "Not specified"];
        $labels_es = ["Hombres", "Mujeres", "Sin especificar"];

        return [
            'labels' => ($lang === 'es' ? $labels_es : $labels_en),
            'values' => [$men, $women, $others]
        ];
    }

}
