<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted', 'updated_at_formatted'];
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
    /*public function getProjectModelAttribute()
    {
        return $this->project; 
    }
    public function getUserModelAttribute()
    {
        return $this->user; 
    }*/
}
