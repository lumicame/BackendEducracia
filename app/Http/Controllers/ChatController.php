<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;


class ChatController extends Controller
{
  public function get(Request $request)
    {
        $chats=Chat::where('user_id1',$request->id)->orderBy('updated_at', 'desc')->paginate(10);
        return $chats;
    }
}
