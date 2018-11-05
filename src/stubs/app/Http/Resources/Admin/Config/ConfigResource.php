<?php

namespace App\Http\Resources\Admin\Config;

use App\Models\Config;
use Illuminate\Http\Resources\Json\Resource;

class ConfigResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /* @var Config $this */
        return [
            'appInMaintenance'    => $this->appIsInMaintenance(),
            'androidVersion'      => $this->android_version,
            'iosVersion'          => $this->ios_version,
            'languages'           => $this->languagesForAdmin(),
            'contactMail'         => $this->contact_mail,
            'faqUrl'              => $this->faq_url,
            'termsUrl'            => $this->terms_url,
            'privacyUrl'          => $this->privacy_url,
            'deeplinkUrl'         => $this->deeplink_url,
            'linkedinUrl'         => $this->linkedin_url,
            'twitterUrl'          => $this->twitter_url,
            'facebookUrl'         => $this->facebook_url,
            'instagramUrl'        => $this->instagram_url,
            'youtubeUrl'          => $this->youtube_url,
            'webUrl'              => $this->web_url,
        ];
    }
}
