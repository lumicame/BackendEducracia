<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Notification;
use App\Models\Chat;
use App\Models\Follow; 
use App\Models\History;



class UserController extends Controller
{
    public function create(Request $request)
    {
        if (User::where('nit',$request->nit)->first() || User::where('email',$request->email)->first()) {
            return ['status' => "ERROR"]; // Status code here
        }

          $user =new User();
          $user->name=$request->name;
          $user->email=$request->email;
          $user->password=$request->pass;
          $user->nit=$request->nit;
          $user->department_id=$request->department_id;
          $user->address=$request->address;
          $image = $request->file('image');
          if ($image) {
              $namea='user_avatar_'.$user->nit.'.'.$image->getClientOriginalExtension();
        \Storage::disk('local')->put('avatar/'.$namea,  \File::get($image));
        $user->photo=$namea;
          }else{
            $user->photo=null;
        }
        $user->save();
        $user->status="OK";
            return $user;
        
    }
    public function active(Request $request)
    {
        $user=User::find($request->id);
        $user->active=$request->active;
        $user->timestamps=false;
        $user->save();
    }
   public function photoProfile(Request $request)
    {
        $user=User::find($request->id);
        if ($user) {
            if ($request->type==0) {
                $image = $request->file('image');
                  if ($image) {
                      $namea='user_avatar_'.$user->nit.'.'.$image->getClientOriginalExtension();
                \Storage::disk('local')->put('avatar/'.$namea,  \File::get($image));
                $user->photo=$namea;
                  }else{
                    $user->photo=null;
                }
            }else{
                 $image = $request->file('image');
          if ($image) {
              $namea='user_cover_'.$user->nit.'.'.$image->getClientOriginalExtension();
        \Storage::disk('local')->put('cover/'.$namea,  \File::get($image));
        $user->cover=$namea;
          }else{
            $user->cover=null;
        }
            }
             $user->timestamps = false;
           $user->save();
        $user->status="OK";  
        }
        return $user;
        
    }
    public function show(Request $request)
    {
        $user=User::find($request->id);
        if($user){
            $balance=User::find($request->id)->transactions->where('state','APPROVED')->where('payed',0)->sum('ammount');
            $user->balance=$balance;
                $user->status="OK";
                $history=History::where('user_id',$user->id)->orderBy('created_at','desc')->first();
            if ($history) {
               $user->last_history=$history->image;
            }
                return $user;
        }else{
            return '{"status":"Este usuario no existe."}';
        }
    }
public function search(Request $request){
    $string=$request->string;
    $users=User::where('name','LIKE','%'.$string.'%')->paginate(10);
    return $users;
}
public function projects(Request $request){
    $projects=Project::where('user_id',$request->user)->orderBy('created_at','desc')->paginate(10);
    return $projects;
    
}
public function count(Request $request){
    $chats=Chat::where('user_id1',$request->user_id)->whereNotIn('view',[0])->count();
    $notifications=Notification::where('user_id',$request->user_id)->whereIn('view',[0])->count();
    $objects=array();
    $objects['countNotification']=$notifications;
    $objects['countMessage']=$chats;
    return $objects;
    
}
public function notificationView(Request $request){
    $notifications=Notification::where('user_id',$request->user_id)->whereIn('view',[0])->update(array('view' => 1));
    $objects=array();
    $objects['countNotification']=0;
    return $objects;
    
}

public function getFollow(Request $request){
    $follows=Follow::where('user_id',$request->id)->where('follow_id',$request->follow)->first();
    $objects=array();
    if ($follows) {
       $objects['state']=1;
    }else{
        $objects['state']=0;
    }
    $objects['count']=Follow::where('user_id',$request->id)->count();
    return $objects;
    
}
public function saveFollow(Request $request){
    $follow=Follow::where('user_id',$request->id)->where('follow_id',$request->follow)->first();
    $objects=array();
    if ($follow) {
        $follow->delete();
        $objects['state']=0;
        return $objects;
    }else{
        $follow=new Follow();
        $follow->user_id=$request->id;
        $follow->follow_id=$request->follow;
        $follow->save();
         $objects['state']=0;
        return $objects;
    }
    
    
}

public function login(Request $request){
    $user=User::where('nit',$request->nit)->first();
    if($user){
        if ($user->password==$request->pass) {
            $user->status="OK";
            return $user;
        }else{
            return '{"status":"La contraseña es incorrecta."}';
        }
    }else{
        return '{"status":"Este usuario no existe."}';
    }
}
public function services(Request $request){
    $user=User::find($request->id);
    $user->service=$request->servicio;
    $user->timestamps = false;
    $user->save();
    $user->status="OK";
    return $user;
}
public function life(Request $request){
    $user=User::find($request->id);
    $pdf = $request->file('pdf');
        if ($pdf) {
            $namep='pdf_'.$user->nit.'.'.$pdf->getClientOriginalExtension();
        \Storage::disk('local')->put('life/'.$namep,  \File::get($pdf));
           $user->hoja=$namep;
        }
    $user->timestamps = false;
    $user->save();
    $user->status="OK";
    return $user;
}
public function Token(Request $request){
    $user=User::find($request->id);
    $user->token=$request->token;
     $user->timestamps = false;
    $user->save();
    return $user;
}
public function huella(Request $request){
    $user=User::where('nit',$request->nit)->first();
    if($user){
        $user->status="OK";
        return $user;
    }
    else{
        return '{"status":"Este usuario no existe."}';
    }
}

    ///////////
    //ACTUALIZAR USUARIO Y FOTO DE PERFIRL
    public function getB64Image($base64_image){  
     // Obtener el String base-64 de los datos         
     // Decodificar ese string y devolver los datos de la imagen        
     $image = base64_decode($base64_image);   
     // Retornamos el string decodificado
     return $image; 
}
}
