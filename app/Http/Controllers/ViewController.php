<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\View;
use App\Models\History;
use App\Models\Notification;
use App\Models\User;

class ViewController extends Controller
{
    public function save(Request $request){
        $view=View::where('history_id',$request->history)->where('user_id',$request->user)->first();
        if (!$view) {
           $view=new View(); 
        }
        else{
            if ($view->vote==$request->vote) {
                $view->vote=null;
                $view->save();
                $notification=Notification::where('view_id',$view->id)->first();
                if ($notification) {
                    $notification->delete();
                }
                $view->status="OK";
                return $view;
            }
            else{
                if ($request->vote) {
                     $view->vote=$request->vote;
                $view->save();
                $notification=Notification::where('view_id',$view->id)->first();
                if ($notification) {
                    //$notification->delete();
                }else{
                 $notification=new Notification();
                        $notification->view_id=$view->id;
                        $notification->user_id=$view->history->user_id;
                        $notification->save();
                }
                $view->status="OK";
                return $view;
                }else{
                    $view->status="OK";
                return $view;
                }
            }
        }
        if ($request->vote) {
            $view->vote=$request->vote;
        }
        $view->history_id=$request->history;
        $view->user_id=$request->user;
        $view->save();
        $notification=new Notification();
        $notification->view_id=$view->id;
        $notification->user_id=$view->history->user_id;
        $notification->save();
        $view->status="OK";
        return $view;
    }
   
    public function count(Request $request){
        $history=History::find($request->history);
        //$likes=$project->count_likes();
        //$unlike=Vote::where('project_id',$request->project)->get();
        if ($history) {
            $view=(object)[];
           $view->likes=$history->count_likes();
           $view->unlikes=$history->count_unlikes();
           $view->blank=$history->count_blanks();
           $view->total=$history->count_total();
           $type=View::where('history_id',$request->history)->where('user_id',$request->user)->get()->first();
           if ($type) {
               $view->type=$type->vote;
           }else{
            $view->type=null;
           }
           
           $view->status="OK";
            return $view;
        }else{
            $view=(object)[];
            $view->status="ERROR";
            return $view;
        }  
    }
     public function get(Request $request)
    {
        $views=View::where('history_id',$request->id)->orderBy('created_at', 'desc')->paginate(100);
        return $views;
    }
}
