<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted'];
     
    public function getCreatedAtFormattedAttribute()
{
    $this->user;
    if ($this->created_at) {
        return $this->created_at->diffForHumans();
    } else {
        return "";
    }
}
public function user(){
        return $this->belongsTo(User::class);
    }


}
