<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Project;
use App\Models\Notification;
use App\Models\User;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;


class VoteController extends Controller
{
    public function save(Request $request){
        $vote=Vote::where('project_id',$request->project)->where('user_id',$request->user)->first();
        if (!$vote) {
           $vote=new Vote(); 
        }
        else{
            if ($vote->vote==$request->vote) {
                $notification=Notification::where('vote_id',$vote->id)->first();
                if ($notification) {
                    $notification->delete();
                }
                $vote->delete();
                $vote->status="OK";
                return $vote;
            }
        }
        $vote->vote=$request->vote;
        $vote->project_id=$request->project;
        $vote->user_id=$request->user;
        $vote->save();
        $vote->status="OK";
        if ($vote->project->user_id!=$vote->user_id) {
           $notification=new Notification();
        $notification->vote_id=$vote->id;
        $notification->user_id=$vote->project->user_id;
        $notification->view1=0;
        $notification->save();
        }
        $vote->active=User::find($vote->project->user_id)->active;
        return $vote;
    }
    public function notification(Request $request)
    {
        $user=User::find($request->user);
        $user2=User::find($notification->user_id);
        $m="";
        if ($request->vote=="like") {
            $m="Voto positivo a tu proyecto.";
        }
        if ($request->vote=="unlike") {
            $m="Voto negativo a tu proyecto.";
        }
        if ($request->vote=="blank") {
            $m="Voto en blanco a tu proyecto.";
        }
        $data=array('title' => $user->name,'message'=>$m,'type'=>'newnoti','post'=>$request->project);
            $this->enviarNotificacion($data,$user2->token);
    }
    public function count(Request $request){
        $project=Project::find($request->project);
        //$likes=$project->count_likes();
        //$unlike=Vote::where('project_id',$request->project)->get();
        if ($project) {
            $vote=(object)[];
           $vote->likes=$project->count_likes();
           $vote->unlikes=$project->count_unlikes();
           $vote->blank=$project->count_blanks();
           $vote->comments=$project->count_comments();
           $vote->reports=$project->count_reports();
           $vote->num=$project->count_users();
           $vote->total=$project->count_total();
           $type=Vote::where('project_id',$request->project)->where('user_id',$request->user)->get()->first();
           if ($type) {
               $vote->type=$type->vote;
           }else{
            $vote->type="no";
           }
           
           $vote->status="OK";
            return $vote;
        }else{
            $vote=(object)[];
            $vote->status="ERROR";
            return $vote;
        }  
    }
    public function get(Request $request)
    {
        $votes=Vote::where('user_id',$request->user)->orderBy('created_at', 'desc')->paginate(10);
        return $votes;
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
