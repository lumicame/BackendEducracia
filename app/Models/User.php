<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\History;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

protected $appends = ['department_name'];
   
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    } 
     public function votes()
    {
        return $this->hasMany(Votes::class);
    } 
    public function views()
    {
        return $this->hasMany(View::class);
    }
     public function comments()
    {
        return $this->hasMany(Comment::class);
    } 
     public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function followers()
    {
        return $this->hasMany(Follow::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function histories(){
        return $this->belongsTo(History::class);
    }
     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    } 
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    } 
     public function getDepartmentNameAttribute()
    {
    return $this->department->name;
    }
    
}
