<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionSlider extends Model
{
    protected $table = 'question_slider';

    public static function createQuestionSlider($data){
        $insert = DB::table('question_slider')->insert($data);

        return $insert;
    }


}