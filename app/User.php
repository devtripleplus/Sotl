<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id','name', 'email', 'password','role','remember_token','login_with','location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function hasRole($role)
    {
        return User::where('role', $role)->get();
    }

    public static function getUser($id)
    {
        return User::where('id', $id)->get();
    }

}
