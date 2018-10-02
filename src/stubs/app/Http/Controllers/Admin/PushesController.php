<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Pushes\SendPushRequest;

class PushesController extends ApiController
{
    /**
     * Send generic push notification.
     *
     * @param SendPushRequest $request
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function sendPush(SendPushRequest $request)
    {
        /** @var Notification $notification */
        $notification = Notification::create($request->params());

        $notification->saveFileOrUrl('image', NOTIFICATION_IMAGES_DIRECTORY);

        $notification->send();

        return $this->withMessage('NOTIFICATION_SENT');
    }
}
