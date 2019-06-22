<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Answer extends Model
{
    protected $table = 'answer';

    public static function createAnswerAsking($data){
        $data['created_at'] = DB::raw('now()');
        $data['updated_at'] = DB::raw('now()');

        $insert = DB::table('answer_asking')->insert($data);

        return $insert;
    }

    public static function createAnswerCheckbox($data){
        $data['created_at'] = DB::raw('now()');
        $data['updated_at'] = DB::raw('now()');

        $insert = DB::table('answer_checkbox')->insert($data);

        return $insert;
    }

    public static function createAnswerSlider($data){
        $data['created_at'] = DB::raw('now()');
        $data['updated_at'] = DB::raw('now()');

        $insert = DB::table('answer_slider')->insert($data);

        return $insert;
    }

    public static function createAnswerStarsRating($data){
        $data['created_at'] = DB::raw('now()');
        $data['updated_at'] = DB::raw('now()');

        $insert = DB::table('answer_stars_rating')->insert($data);

        return $insert;
    }
}