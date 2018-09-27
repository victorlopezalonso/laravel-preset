<?php

namespace App\Http\Resources\Api\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @SWG\Definition(
 *       definition="NotificationResource",
 *       description="Notification info",
 *      @SWG\Property(property="id", type="integer", description="Notification ID"),
 *      @SWG\Property(property="title", type="string", description="Notification title"),
 *      @SWG\Property(property="header", type="string", description="Notification header"),
 *      @SWG\Property(property="content", type="string", description="Notification text"),
 *      @SWG\Property(property="image", type="string", description="Url of the notification image"),
 *      @SWG\Property(property="url", type="string", description="External link"),
 *      @SWG\Property(property="createdAt", type="string", description="Notification creation date"),
 * )
 */
class NotificationResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->localizedTitle(),
            'header'    => $this->localizedHeader(),
            'content'   => $this->localizedContent(),
            'image'     => $this->image,
            'url'       => $this->url,
            'createdAt' => $this->created_at,
        ];
    }
}
