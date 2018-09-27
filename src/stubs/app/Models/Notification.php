<?php

namespace App\Models;

use App\Classes\OneSignal;

class Notification extends ApiModel
{

    protected $casts = [
        'title'      => 'json',
        'header'     => 'array',
        'content'    => 'array',
        'created_at' => 'string'
    ];

    /**
     * Return the image public url
     * @param $value
     * @return null|string
     */
    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . NOTIFICATION_IMAGES_DIRECTORY . $value) : null;
    }

    /**
     * @return string|null
     */
    public function localizedTitle()
    {
        return $this->getLocalizedValueFromJson($this->title);
    }

    /**
     * @return string|null
     */
    public function localizedHeader()
    {
        return $this->getLocalizedValueFromJson($this->header);
    }

    /**
     * @return string|null
     */
    public function localizedContent()
    {
        return $this->getLocalizedValueFromJson($this->content);
    }

    /**
     * Returns the last notification id
     * @return mixed
     */
    public static function getLastId()
    {
        return Notification::orderBy('created_at', 'desc')->first()->id;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        OneSignal::make()
                 ->title($this->title)
                 ->content($this->header)
                 ->param('pushId', $this->id)
                 ->url($this->url)
                 ->send();
    }
}
