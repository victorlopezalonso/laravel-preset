<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\App\ContactMailRequest;
use App\Http\Requests\Api\Config\SplashRequest;
use App\Http\Resources\Api\Help\HelpResource;
use App\Http\Resources\Api\Notifications\NotificationResource;
use App\Http\Resources\SplashResource;
use App\Mail\ContactMail;
use App\Models\Config;
use App\Models\Copy;
use App\Models\Help;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class AppController extends ApiController
{

    /**
     * Return the app configuration
     * @param SplashRequest $request
     * @return \App\Http\Responses\ApiResponse
     * @throws \Exception
     */
    public function splash(SplashRequest $request)
    {
        /** @var Config $splash */
        $splash = Config::first();

        if ($splash->appIsInMaintenance()) {
            return $this->withMessage(APP_IN_MAINTENANCE)->withStatus(HTTP_CODE_503_SERVICE_UNAVAILABLE);
        }

        if ($splash->appVersionIsOutdated()) {
            return $this->withMessage(APP_VERSION_OUTDATED)->withStatus(HTTP_CODE_426_UPGRADE_REQUIRED);
        }

        return $this->response(new SplashResource($splash));
    }

    /**
     * @param ContactMailRequest $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function contact(ContactMailRequest $request)
    {
        Mail::to(Config::first()->contact_mail)->queue(new ContactMail($request->get('email'), $request->get('message')));

        return $this->withMessage('CONTACT_EMAIL_SENT');
    }

    /**
     * @return \App\Http\Responses\ApiResponse
     */
    public function help()
    {
        return $this->response(HelpResource::collection(Help::orderBy('order', 'asc')->get()));
    }

    /**
     * @return \App\Http\Responses\ApiResponse
     */
    public function notifications()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate();

        return $this->response(NotificationResource::collection($notifications));
    }

    /**
     * @param Notification $notification
     * @return \App\Http\Responses\ApiResponse
     */
    public function notificationDetail(Notification $notification)
    {
        return $this->response(new NotificationResource($notification));
    }

}
