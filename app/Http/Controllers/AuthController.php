<?php

namespace App\Http\Controllers;


use App\Http\Resources\NotificationsResource;
use Validator;
use Carbon\Carbon;
use Vonage\Client;
use App\Models\User;
use Nette\Utils\Json;
use Vonage\SMS\Message\SMS;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Vonage\Client\Credentials\Basic;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\SendMailRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendEmailNotification;


class AuthController extends Controller

{
    use GeneralTrait;

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validate());
        return $this->returnSuccessMessage('Successfully created user!');
    }

    public function login(LoginRequest $request)
    {
        // return  (new UserResource($request))->addcslashes(['gg' => 'bar']);
        return new UserResource($request);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->token()->revoke();
            return $this->returnSuccessMessage('تم تسجيل الخروج بنجاح');
        } elseif (!Auth::check() && !Auth::guard('api-auth')->check()) {
            return $this->returnError('E001', 'لم يتم تسجيل الدخول');
        }
    }

    public function sendmail(SendMailRequest $request, $id)
    {
        $user = User::find($id);
        $user->notify(new SendEmailNotification($request->validated()));
        return $this->returnSuccessMessage('تم ارسال الايميل بنجاح');
    }

    public function sendmailAll(Request $request)
    {
        $users = User::all();
        Notification::send($users, new SendEmailNotification($request->all()));
        return $this->returnSuccessMessage('تم ارسال الايميل بنجاح');
    }


    public function getNotifications(Request $request)
    {
        return new NotificationsResource($request);
    }

    public function countUnreadNotifications()
    {
        return $this->returnData('count Notifications', ['count' =>  \auth('api-auth')->user()->count()]);
    }

    public function deleteNotification($notification_id)
    {
        \auth('api-auth')->user()->notifications()->where('id', $notification_id)->delete();
        return $this->returnSuccessMessage('تم حذف الاشعار بنجاح');
    }


    public function deleteNotifications()
    {
        \auth('api-auth')->user()->notifications()->delete();
        return $this->returnSuccessMessage('تم حذف جميع الاشعارات بنجاح');
    }

    public function SendSmsNotifications(Request $request)
    {
        $basic  = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
        $client = new Client($basic);

        $response = $client->sms()->send(
            new SMS("201115895569", 'Yousef', 'Hello :' . (\auth('api-auth')->user()->name)  . 'Welcome to our website')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }


}






