<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\User;


class Chat extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted', 'updated_at_formatted','message','user'];
     
    public function getCreatedAtFormattedAttribute()
{
    if ($this->created_at) {
        $created=\Carbon\Carbon::parse($this->created_at);
        return $created->diffForHumans();
    } else {
        return "";
    }
}

public function getUpdatedAtFormattedAttribute()
{
    if ($this->updated_at) {
$updated=\Carbon\Carbon::parse($this->updated_at);
       //$day=\Carbon\Carbon::now()->diffInDays($this->updated_at);
      if ($updated->isToday()) {
         return $updated->format('h:i A');
      }else{
         return $updated->format('M d, h:i A');
      }
    } else {
        return "";
    }
}
public function getMessageAttribute()
{
    $message=Message::find($this->last_message);
    return $message;
}
public function getUserAttribute()
{
    $user=User::find($this->user_id2);
    return $user;
}
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
