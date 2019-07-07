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

    public static function deleteQuestionStarsRatingByIdQuestion($questionId){
        $delete = DB::table('question_stars_rating')
            ->where('id_question', $questionId)
            ->delete();

        return $delete;
    }


}