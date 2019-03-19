<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionCheckbox extends Model
{
    protected $table = 'question_checkbox';

    public static function createQuestionCheckbox($data){
        $insert = DB::table('question_checkbox')->insert($data);

        return $insert;
    }


}