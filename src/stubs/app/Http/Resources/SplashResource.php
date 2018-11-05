<?php

namespace App\Http\Resources;

use App\Models\Config;
use App\Http\Requests\Headers;
use Illuminate\Http\Resources\Json\Resource;

/**
 * @SWG\Definition(
 *       definition="SplashResource",
 *       description="Splash ",
 *      @SWG\Property(property="language", type="string", description="Current language"),
 *      @SWG\Property(property="copiesUpdatedAt", type="string", description="Timestamp when the copies were updated"),
 *      @SWG\Property(property="contactMail", type="string", description="App contact mail"),
 *      @SWG\Property(property="faqUrl", type="string", description="Frequently asked questions url"),
 *      @SWG\Property(property="termsUrl", type="string", description="Terms of use url"),
 *      @SWG\Property(property="privacyUrl", type="string", description="Privacy text url"),
 *      @SWG\Property(property="deeplinkUrl", type="string", description="Deeplink url"),
 *      @SWG\Property(property="linkedinUrl", type="string", description="linkedin url"),
 *      @SWG\Property(property="twitterUrl", type="string", description="twitter url"),
 *      @SWG\Property(property="facebookUrl", type="string", description="facebook url"),
 *      @SWG\Property(property="instagramUrl", type="string", description="instagram url"),
 *      @SWG\Property(property="youtubeUrl", type="string", description="youtube url"),
 *      @SWG\Property(property="webUrl", type="string", description="web url"),
 *      @SWG\Property(property="languages", type="object", description="Localized app languages as key:value"),
 *      @SWG\Property(property="copies", type="object", description="The app localized words, null if the copies version is equal to the database version")
 * )
 */
class SplashResource extends Resource
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
            'language'            => Headers::getLanguage(),
            'copiesUpdatedAt'     => $this->copiesUpdatedAt(),
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
            'languages'           => $this->localizedLanguages(),
            'copies'              => $this->localizedCopies(),
        ];
    }
}
