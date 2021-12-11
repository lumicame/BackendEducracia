<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Notification;

class ReportController extends Controller
{
     public function get(Request $request){
        $report=Report::where('project_id',$request->id)->orderBy('created_at','desc')->paginate(10);
        return $report;
    }
     public function save(Request $request){
   
    $report=new Report();
    $report->comment=$request->comment;
    $report->user_id=$request->user;
    $report->project_id=$request->project;
    $report->save();
    $report->status="OK";
    $notification=new Notification();
    $notification->report_id=$report->id;
    $notification->user_id=$request->for_id;
    $notification->view1=0;
    $notification->save();
    return $report;
    }
}
