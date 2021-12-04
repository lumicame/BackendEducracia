<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted', 'updated_at_formatted'];
     
    public function getCreatedAtFormattedAttribute()
{
    $this->vote;
    $this->comment;
    $this->transaction;
    $this->rating;
    $this->view1;
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
    public function vote(){
        return $this->belongsTo(Vote::class);
    }
    public function comment(){
        return $this->belongsTo(Comment::class);
    }
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
    public function rating(){
        return $this->belongsTo(Rating::class);
    }
    public function view1(){
        return $this->belongsTo(View::class);
    }
}
