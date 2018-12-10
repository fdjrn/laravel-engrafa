<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard_charts extends Model
{
    protected $table = 'charts';
    protected $fillable = [
        'dashboard',
        'name',
        'chart_type'
    ];

}
