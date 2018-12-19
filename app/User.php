<?php

namespace App;

use App\Models\Files;
use Illuminate\Mail\Message;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\CanResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'nama', 'email', 'password',
    // ];
    protected $fillable = [
        'name','first_name','last_name','username','phone', 'role', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function files(){
        return $this->hasMany(Files::class, 'created_by', 'id');
    }

    public function bookmarks(){
        return $this->hasMany(Bookmark::class, 'created_by', 'id');
    }
}
