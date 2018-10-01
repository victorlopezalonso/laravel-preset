<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * @SWG\Definition(
 *       definition="SplashResource",
 *       description="Splash ",
 *      @SWG\Property(property="copiesUpdatedAt", type="string", description="Timestamp when the copies were updated"),
 *      @SWG\Property(property="contactMail", type="string", description="App contact mail"),
 *      @SWG\Property(property="faqUrl", type="string", description="Frequently asked questions url"),
 *      @SWG\Property(property="termsUrl", type="string", description="Terms of use url"),
 *      @SWG\Property(property="privacyUrl", type="string", description="Privacy text url"),
 *      @SWG\Property(property="deepLinkUrl", type="string", description="Deeplink url"),
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
        // @var Config $this
        return [
            'copiesUpdatedAt' => $this->copiesUpdatedAt(),
            'contactMail'     => $this->contact_mail,
            'faqUrl'          => $this->faq_url,
            'termsUrl'        => $this->terms_url,
            'privacyUrl'      => $this->privacy_url,
            'deepLinkUrl'     => $this->deeplink_url,
            'languages'       => $this->localizedLanguages(),
            'copies'          => $this->localizedCopies(),
        ];
    }
}
