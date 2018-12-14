<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard_users extends Model
{
    protected $table = 'dashboard_users';
    protected $fillable = [
        'user',
        'dashboard'        
    ];
}
