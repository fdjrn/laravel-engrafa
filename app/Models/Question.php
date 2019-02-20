<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    protected $table = 'question';

    public static function createQuestion($data){
        $insert = DB::table('question')->insertGetId($data);

        return $insert;
    }


}