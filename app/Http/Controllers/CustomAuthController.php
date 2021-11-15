<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Type;
use App\Models\Department;
use App\Models\Transaction;

use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            return redirect('/');
        }else{
            return view('welcome');
        }
        
    }  
      public function dashboard(Request $request)
    {
        if (Auth::user()) {
            $departments=Department::all();
            $types=Type::all();
            $transactions=Transaction::where('state','APPROVED')->orderBy('created_at','desc')->paginate(15);
            $retiros=Transaction::where('state','PENDING')->orderBy('created_at')->paginate(15);
            $payeds=Transaction::where('state','PAYED')->orderBy('updated_at','desc')->paginate(15);
            return view('dashboard',compact('departments','types','transactions','retiros','payeds'));
        }else{
            return redirect("login");
        }
    }

    public function Login(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if ($user) {
            if ($user->password==$request->password) {
            Auth::login($user);
            return redirect("login");
        }
        }else{

        }
    }
    public function logout(Request $request) {
      Auth::logout();
      return redirect('/login');
    }
    public function fetch_transaction(Request $request) {
       if($request->ajax())
     {
      $transactions=Transaction::where('state','APPROVED')->orderBy('created_at','desc')->paginate(15);
      return view('component.item_transaction', compact('transactions'))->render();
     }
    }
    public function fetch_retiro(Request $request) {
       if($request->ajax())
     {
            $retiros=Transaction::where('state','PENDING')->orderBy('created_at')->paginate(15);
      return view('component.item_retiro', compact('retiros'))->render();
     }
    }
     public function fetch_payed(Request $request) {
       if($request->ajax())
     {
            $payeds=Transaction::where('state','PAYED')->orderBy('updated_at','desc')->paginate(15);
      return view('component.item_payed', compact('payeds'))->render();
     }
    }

public function SavePayed($id,Request $request) {
        $transaction=Transaction::find($id);
        $transaction->state="PAYED";
        $transaction->payed=1;
        $transaction->save();
        $transactions=Transaction::where('for_id',$request->user)->where('payed',0)->where('created_at','<=',$transaction->created_at)->update(array('payed' => 1));
        $payeds=Transaction::where('state','PAYED')->orderBy('updated_at','desc')->paginate(15);
      return view('component.item_payed', compact('payeds'))->render();
    }
     public function SaveCity(Request $request) {
        $d = new Department();
        $d->name=$request->name;
        $d->save();
      return view('component.item_city',compact('d'))->render();
    }
     public function EditCity($id,Request $request) {
        $d = Department::find($id);
        $d->name=$request->name;
        $d->save();
      return view('component.item_city',compact('d'))->render();
    }
    public function SaveType(Request $request) {
        $t = new Type();
        $t->name=$request->name;
        $t->save();
      return view('component.item_type',compact('t'))->render();
    }
     public function EditType($id,Request $request) {
        $t = Type::find($id);
        $t->name=$request->name;
        $t->save();
      return view('component.item_type',compact('t'))->render();
    }
}
