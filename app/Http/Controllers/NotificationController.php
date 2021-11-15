<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class NotificationController extends Controller
{
    public function get(Request $request)
    {
        $notification=Notification::where('user_id',$request->user)->orderBy('created_at', 'desc')->paginate(10);
        return $notification;
    }
    public function message(Request $request)
    {
        $data=array('title' => $request->name,'message'=>$request->message,'type'=>'newmessage','chat'=>$request->nit);
            $this->enviarNotificacion($data,$request->token);
    }
    public function notification(Request $request)
    {
        $data=array('title' => $request->title,'message'=>$request->message,'type'=>'newnoti','post'=>$request->post);
            $this->enviarNotificacion($data,$request->token);
            return $data;
    }

    public function enviarNotificacion($data,$tokens) {
    // Cargamos los datos de la notificacion en un Array
    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60*20);

   /* $notificationBuilder = new PayloadNotificationBuilder($title);
    $notificationBuilder->setBody($message)
                        ->setSound('default');*/

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData($data);

    $option = $optionBuilder->build();
    //$notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    // You must change it to get your tokens

    $downstreamResponse = FCM::sendTo($tokens, $option, null, $data);
}
}
