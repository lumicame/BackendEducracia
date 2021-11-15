<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rating;
use App\Models\Notification;

class RatingController extends Controller
{
     public function get(Request $request){
        $rating=Rating::where('for_id',$request->id)->orderBy('created_at','desc')->paginate(10);
        return $rating;
    }
     public function save(Request $request){
        $rating=Rating::where('user_id',$request->user)->where('for_id',$request->for)->first();
    if ($rating) {
        if($request->type=="delete"){
            Notification::where('rating_id',$rating->id)->delete();
            $rating->delete();
            $rating->status="OK";
            return $rating;
        }
            $rating->comment=$request->comment;
            $rating->rating=$request->rating;
            $rating->save();
            $rating->status="OK";
            return $rating;
        }
    $rating=new Rating();
    $rating->comment=$request->comment;
    $rating->rating=$request->rating;
    $rating->user_id=$request->user;
    $rating->for_id=$request->for;
    $rating->save();
    $rating->status="OK";
    
    $notification=new Notification();
    $notification->rating_id=$rating->id;
    $notification->user_id=$rating->for_id;
    $notification->save();
    
    
    return $rating;
    }

    public function count(Request $request){
        $boolean=Rating::where('user_id',$request->user)->where('for_id',$request->for)->first();
        
        $rating=Rating::where('for_id',$request->for)->sum('rating');
        $count=Rating::where('for_id',$request->for)->count();
        if ($count>0) 
            $result=$rating/$count;
        else
        $result=0;
        $object=(object)[];
        $object->count=$count;
        $object->result=$result;
        if ($boolean) {
            $object->state=1;
            $object->rating=$boolean;
        }
        else{
         $object->state=0;
        }
        return $object;
    }
}
