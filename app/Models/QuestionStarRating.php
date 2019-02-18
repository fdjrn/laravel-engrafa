<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionStarRating extends Model
{
    protected $table = 'question_stars_rating';

    public static function createQuestionStarsRating($data){
        $insert = DB::table('question_stars_rating')->insert($data);

        return $insert;
    }


}