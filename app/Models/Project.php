<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $appends = ['created_at_formatted', 'updated_at_formatted'];
    public function getCreatedAtFormattedAttribute()
{
    $this->type;
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
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    } 
    public function comments()
    {
        return $this->hasMany(Comment::class);
    } 
    public function reports()
    {
        return $this->hasMany(Report::class);
    } 
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    } 
    public function count_likes()
    {
        return $this->votes->where('vote','like')->count();
    }
    public function count_unlikes()
    {
        return $this->votes->where('vote','unlike')->count();
    }
    public function count_blanks()
    {
        return $this->votes->where('vote','blank')->count();
    }
    public function count_comments()
    {
        return $this->comments->where('comment_id',null)->count();
    }
    public function count_users()
    {
        return $this->transactions->count();
    }
    public function count_total()
    {
        return $this->transactions->where('state','APPROVED')->sum('ammount');
    }

}
