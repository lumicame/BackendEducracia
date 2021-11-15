<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Notification;


class CommentController extends Controller
{
   public function save(Request $request){
    $comment=new Comment();
    
    if ($request->comment_id) {
        $comment->comment_id=$request->comment_id;
    }
    $comment->comment=$request->comment;
    $comment->project_id=$request->project;
    $comment->user_id=$request->user;
    $comment->save();
    $comment->status="OK";

    if ($request->comment_id) {
        $c=Comment::find($request->comment_id);
        if ($comment->user_id!=$c->user_id) {
            $notification=new Notification();
            $notification->comment_id=$comment->id;
            $notification->user_id=$c->user_id;
            $notification->save();
        }
    }
    else{
            if ($comment->project->user_id!=$comment->user_id) {
    $notification=new Notification();
    $notification->comment_id=$comment->id;
    $notification->user_id=$comment->project->user_id;
    $notification->save();
    }
        }
    return $comment;
    }
    public function get(Request $request){
        $comments=Comment::where('project_id',$request->project)->where('comment_id',null)->orderBy('created_at', 'desc')->paginate(3);
        return $comments;
    }
    public function getSub(Request $request){
        $comments=Comment::where('project_id',$request->project)->where('comment_id',$request->comment_id)->orderBy('created_at', 'desc')->paginate(3);
        return $comments;
    }
    public function delete(Request $request){
        $comment=Comment::find($request->id);
        $comment->delete();
        $comment->status="OK";
        return $comment;
    }
}
