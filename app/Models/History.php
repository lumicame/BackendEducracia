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
    public function views()
    {
        return $this->hasMany(View::class);
    }
     public function count_likes()
    {
        return $this->views->where('vote','like')->count();
    }
    public function count_unlikes()
    {
        return $this->views->where('vote','unlike')->count();
    }
    public function count_blanks()
    {
        return $this->views->where('vote','blank')->count();
    }
    public function count_total()
    {
        return $this->views->count();
    }

}
