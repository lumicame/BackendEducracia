<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chat;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Models\User;


class MessageController extends Controller
{
    public function save(Request $request){
    $chat1=Chat::where('user_id1',$request->user_id)->where('user_id2',$request->for)->first();
    $chat2=Chat::where('user_id1',$request->for)->where('user_id2',$request->user_id)->first();
    $message1=null;
    $message2=null;
    if ($chat1) {
        $message1=new Message();
        $message1->messages=$request->message;
        $message1->user_id=$request->user_id;
        $message1->chat_id=$chat1->id;
        $message1->save();
        $message1->status="OK";
        $message1->fromMe=true;
        $chat1->last_message=$message1->id;
        $chat1->view=0;
        $chat1->save();
    }else{
        $chat1=new Chat();
        $chat1->user_id1=$request->user_id;
        $chat1->user_id2=$request->for;
        $chat1->view=0;
        $chat1->save();
        $message1=new Message();
        $message1->messages=$request->message;
        $message1->user_id=$request->user_id;
        $message1->chat_id=$chat1->id;
        $message1->save();
        $message1->status="OK";
        $message1->fromMe=true;
        $chat1->last_message=$message1->id;
        $chat1->view=0;
        $chat1->save();
    }

    if ($chat2) {
        $message2=new Message();
        $message2->messages=$request->message;
        $message2->user_id=$request->user_id;
        $message2->chat_id=$chat2->id;
        $message2->save();
        $chat2->last_message=$message2->id;
        $count=$chat2->view;
        $chat2->view=$count+1;
        $chat2->save();
    }else{
        $chat2=new Chat();
        $chat2->user_id1=$request->for;
        $chat2->user_id2=$request->user_id;
        $chat2->view=0;
        $chat2->save();
        $message2=new Message();
        $message2->messages=$request->message;
        $message2->user_id=$request->user_id;
        $message2->chat_id=$chat2->id;
        $message2->save();
        $chat2->last_message=$message2->id;
        $count=$chat2->view;
        $chat2->view=$count+1;
        $chat2->save();
    }
    $message1->active=User::find($request->for)->active;
    return $message1;
    }

    public function message(Request $request)
    {
        $user=User::find($request->for);
    $user2=User::find($request->user_id);
    $data=array('title' => $user2->name,'message'=>$request->message,'type'=>'newmessage','id'=>$request->id,'chat'=>$request->user_id);
    $this->enviarNotificacion($data,$user->token);
    }

    public function get(Request $request){
        $chat=Chat::where('user_id1',$request->user_id)->where('user_id2',$request->for)->first();
        if ($chat) {
            $chat->view=0;
            $chat->timestamps = false;
            $chat->save();
            if ($request->update=="si") {
               return $chat;
            }
            $messages=Message::where('chat_id',$chat->id)->orderBy('created_at', 'desc')->paginate(15);
            return $messages;
        }
        return $chat;
    }
     public function getMessage(Request $request){
        $message=Message::find($request->id);
        return $message;
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
