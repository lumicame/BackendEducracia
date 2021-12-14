<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\User;
use App\Models\Follow;



class HistoryController extends Controller
{
    public function saveHistory(Request $request){
        $history=new History();
        $history->description=$request->description;
        $history->user_id=$request->user_id;
        if($request->image!=""){
        $history->image=$request->image;
        }
        $history->save();
        $history->status="OK";
        $user=User::find($request->user_id);
        $count=$user->history;
        $user->history=$count+1;
        $user->save();
        return $history;
    }
    public function getHistory(Request $request){
        //$follows=Follow::where('follow_id',$request->id)->pluck('user_id');
        //$users=User::whereIn('id',$follows)->whereNotIn('history',[0])->orderBy('updated_at','desc')->paginate(10);
        $users=User::whereNotIn('id',[$request->id])->whereNotIn('history',[0])->orderBy('updated_at','desc')->paginate(10);
         foreach($users as $u){
            $history=History::where('user_id',$u->id)->orderBy('created_at','desc')->first();
            if ($history) {
               $u->last_history=$history->image;
            }
        }
        return $users;
    }
    public function showHistory(Request $request){
        $histories=History::where('user_id',$request->id)->orderBy('created_at')->get();
        foreach($histories as $h){
            $day=\Carbon\Carbon::now()->diffInDays($h->created_at);
      if ($day>0) {
        \Storage::disk('local')->delete('history/'.$h->image);
         $h->delete();
         $user=User::find($request->id);
         $count=$user->history;
         $user->history=$count-1;
         $user->timestamps = false;
         $user->save();
      }
        }
        return $histories;
    }
    public function getOneHistory(Request $request){
        $history=History::find($request->id);
        if ($history) {
            $history->status="OK";
            return $history;
        }else{
            $history=(object)[];
            $history->status="ERROR";
            return $history;
        }
    }
}
