<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;


class Comment extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted', 'updated_at_formatted','count_sub'];
     
    public function getCreatedAtFormattedAttribute()
{
    $this->user;
     $this->project;
    if ($this->created_at) {
        return $this->created_at->diffForHumans();
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
public function getCountSubAttribute()
{
   return Comment::where('comment_id',$this->id)->count();
}

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
     public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
