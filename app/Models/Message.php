<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted', 'updated_at_formatted'];
     
    public function getCreatedAtFormattedAttribute()
{
    $this->history;
    if ($this->created_at) {
     // $day=\Carbon\Carbon::now()->diffInDays($this->created_at);
      if ($this->created_at->isToday()) {
         return $this->created_at->format('h:i A');
      }else{
         return $this->created_at->format('M d, h:i A');
      }
        
    } else {
        return "";
    }
}

public function getUpdatedAtFormattedAttribute()
{
    if ($this->updated_at) {
        return $this->updated_at->diffForHumans();
    } else {
        return "";
    }
}
     public function chat(){
        return $this->belongsTo(Chat::class);
    }
    public function history(){
        return $this->belongsTo(History::class);
    }
}
