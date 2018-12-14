<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard_survey extends Model
{
    protected $table = 'dashboard_surveys';
    protected $fillable = [
        'survey',
        'chart'
    ];

}
