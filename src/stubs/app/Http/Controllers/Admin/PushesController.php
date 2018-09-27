<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Pushes\SendPushRequest;
use App\Models\Notification;

class PushesController extends ApiController
{

    /**
     * Send generic push notification
     *
     * @param SendPushRequest $request
     * @return \App\Http\Responses\ApiResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
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
