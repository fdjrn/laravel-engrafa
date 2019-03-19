<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionAsking extends Model
{
    protected $table = 'question_asking';

    public static function createQuestionAsking($data){
        $insert = DB::table('question_asking')->insert($data);

        return $insert;
    }


}