<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\User;
use Cookie;
use Illuminate\Support\Facades\Http;


class TransactionController extends Controller
{
    //
    
    public function show(Request $request){
        Cookie::queue('for_id', $request->for_id, 10);
        Cookie::queue('project_id', $request->project_id, 10);
        Cookie::queue('user_id', $request->user_id, 10);
        $email=$request->email;
        $count=Transaction::count();
        $reference="EducraciaPrueba_".($count+1);
        return view('checkout',compact('reference','email'));
    }
    public function save(Request $request){
        
        //$response =Http::get('https://production.wompi.co/v1/transactions/'.$request->id);
        $response =Http::get('https://sandbox.wompi.co/v1/transactions/'.$request->id);
        $data = json_decode($response);
        if (isset($data->error)) {
            return "Este ID de aporte no existe";
        }
        $data=json_decode($response)->data;
        $user=User::find(Cookie::get('user_id'));

        if(Transaction::where('transaction_id',$data->id)->first()){
            $transaction=Transaction::where('transaction_id',$data->id)->first();
            return "Este pago ya esta verificado.";
        }
        if ($data->status!="APPROVED") {
            return "Este pago no fue aprovado, intenta con otro.";
        }
        $transaction=new Transaction();
        $transaction->user_id=$user->id;
        $transaction->transaction_id=$data->id;
        $transaction->ammount=substr("".$data->amount_in_cents, 0, -2);
        $transaction->reference=$data->reference;
        $transaction->state=$data->status;
        $transaction->project_id=Cookie::get('project_id');
        $transaction->for_id=Cookie::get('for_id');
        $transaction->payment_method_type=$data->payment_method_type;
        $transaction->save();
        if ($transaction->for_id!=$transaction->user_id) {
            $notification=new Notification();
            $notification->transaction_id=$transaction->id;
            $notification->user_id=$transaction->for_id;
            $notification->save();
        }
        
        return "Aporte con exito, ya puedes finalizar.";
    }
    public function get(Request $request){
        $transaction=Transaction::where('user_id',$request->id)->orWhere('for_id',$request->id)->orderBy('created_at','desc')->paginate(10);
        return $transaction;
    }

    public function ammount_total(Request $request){
        $total=Transaction::Where('for_id',$request->id)->where('state','APPROVED')->where('payed',0)->sum('ammount');
        $transaction=(object)[];
        $transaction->ammount_total=$total;
        return $transaction;
    }
    public function accountPay(Request $request){
        $count=Transaction::count();
        $transaction=Transaction::where('user_id',$request->id)->where('payed',0)->where('transaction_id',null)->first();
        $total=Transaction::Where('for_id',$request->id)->where('state','APPROVED')->where('payed',0)->sum('ammount');
        if ($transaction) {
            $transaction->status="ERROR";
            return $transaction;
        }else{
           $transaction=new Transaction();
           $transaction->user_id=$request->id;
           $transaction->ammount=$total;
           $transaction->state="PENDING";
           $transaction->banco=$request->banco;
           $transaction->account_type=$request->account;
           $transaction->account_id=$request->id_account;
           $transaction->save();
           $transaction->status="OK";
           return $transaction;
       }
       
   }

}
