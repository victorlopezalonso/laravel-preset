<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Mail\ContactMail;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\SplashResource;
use App\Http\Requests\Api\Config\SplashRequest;
use App\Http\Requests\Api\App\ContactMailRequest;
use App\Http\Resources\Api\Notifications\NotificationResource;

class AppController extends ApiController
{
    /**
     * Return the app configuration.
     *
     * @param SplashRequest $request
     *
     * @throws \Exception
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function splash(SplashRequest $request)
    {
        /** @var Config $splash */
        $splash = Config::first();

        return $this->response(new SplashResource($splash));
    }

    /**
     * @param ContactMailRequest $request
     *
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
    public function notifications()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate();

        return $this->response(NotificationResource::collection($notifications));
    }

    /**
     * @param Notification $notification
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function notificationDetail(Notification $notification)
    {
        return $this->response(new NotificationResource($notification));
    }
}
