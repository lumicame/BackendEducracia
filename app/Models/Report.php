<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted'];
     
    public function getCreatedAtFormattedAttribute()
{
    $this->user;
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
    public function user(){
        return $this->belongsTo(User::class);
    }
     public function notifications()
    {
        return $this->belongsTo(Notification::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
