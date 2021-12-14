<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\History;


class ProjectController extends Controller
{
     public function saveProject(Request $request){
        $project=new Project();
        $project->price=$request->price;
        $project->title=$request->title;
        $project->description=$request->description;
        $project->department_id=$request->department_id;
        $project->type_id=$request->type_id;
        $project->user_id=$request->user_id;
        if($request->image!=""){
        $project->image=$request->image;
        }
        if($request->pdf!=""){
            $project->pdf=$request->pdf;
        }
        $project->save();
        $project->status="OK";
        return $project;
    }
    public function Projects(Request $request){
        $projects=Project::where("department_id",$request->department)->where("type_id",$request->type)->orderBy('created_at','desc')->paginate(10);
        return $projects;
    }
     public function show(Request $request){
        $project=Project::find($request->id);
        if ($project) {
             $project->user;
            
        $project->status="OK";
        return $project;
        }else{
            $project=(object)[];
            $project->status="ERROR";
        return $project;
        }
       
    }
     public function edit(Request $request){
        $project=Project::find($request->id);
        $project->title=$request->title;
        $project->description=$request->description;
        $project->save();
            $project->status="OK";
            return $project;
    }
     public function delete(Request $request){
        $project=Project::find($request->id);
        if ($project->transactions->count()>0) {
            $project->status="ERROR";
            return $project;
        }
        \Storage::disk('local')->delete('project/'.$project->project);
        $project->delete();
        $project->status="OK";
        return $project;
       
    }
}
