<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Questioner extends Model
{
    protected $table = 'quisioner';

    public static function existsQuestionerByName($name)
    {
      $data = Questioner::where('name', $name)
        ->first();

      return $data;
    }

    public static function createQuestioner($data)
    {
      $questioner_name = $data['quisioner_name'];
      $questioner_category = $data['quisioner_category'];
      $created_by = $data['user_id'];

      $insert = DB::table('quisioner')->insertGetId(
        [
          'name' => $questioner_name,
          'category' => $questioner_category,
          'created_by' => $created_by,
          'created_at' => DB::raw('now()'),
          'updated_by' => $created_by,
          'updated_at' => DB::raw('now()')
        ]
      );
      
      return $insert;
    }

    public static function getQuestionerAll()
    {
      DB::statement(DB::raw('set @rownum=0'));
        
      $data = DB::table('quisioner')
            ->leftJoin('quisioner_categories', 'quisioner.category', '=', 'quisioner_categories.id')
            ->select('quisioner.*', 'quisioner_categories.name as category_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'))
            ->orderBy('quisioner.id')
            ->get();
      
      return $data;
    }

    public static function getQuestionAll($id){
      $data = DB::table('question')
            ->join('question_types', 'question.id_question_type', '=', 'question_types.id')
            ->select('question.*', 'question_types.name as question_type_name',)
            ->where('question.id_quisioner','=',$id)
            ->get();
      
      return $data;
    }

    public static function getQuestionAsking($id){
      $data = DB::table('question_asking')
        ->select('question_asking.*')
        ->where('id_question','=',$id)
        ->get();

      return $data;
    }

    public static function getQuestionCheckbox($id){
      $data = DB::table('question_checkbox')
        ->select('question_checkbox.*')
        ->where('id_question','=',$id)
        ->get();

      return $data;
    }

    public static function getQuestionSlider($id){
      $data = DB::table('question_slider')
        ->select('question_slider.*')
        ->where('id_question','=',$id)
        ->get();

      return $data[0];
    }

    public static function getQuestionStarsRating($id){
      $data = DB::table('question_stars_rating')
        ->select('question_stars_rating.*')
        ->where('id_question','=',$id)
        ->get();

      return $data[0];
    }

    public static function getQuestionerQuestionAll($id){

      $quisioner = DB::table('quisioner')
            ->leftJoin('quisioner_categories', 'quisioner.category', '=', 'quisioner_categories.id')
            ->select('quisioner.*', 'quisioner_categories.name as category_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'))
            ->where('quisioner.id','=',$id)
            ->get();

      
      $data = $quisioner[0];

      $question = (self::getQuestionAll($data->id)) ? self::getQuestionAll($data->id) : [];
      
      $dataQuestion = [];

      if(count($question) > 0){
        foreach($question as $quest){

          if($quest->id_question_type==1){
            $quest->choise_asking = self::getQuestionAsking($quest->id);
          }

          if($quest->id_question_type==2){
            $quest->slider = self::getQuestionSlider($quest->id);
          }

          if($quest->id_question_type==3){
            $quest->rating = self::getQuestionStarsRating($quest->id);
          }

          if($quest->id_question_type==4){
            $quest->choise_checkbox = self::getQuestionCheckbox($quest->id);
          }

          $dataQuestion[] = $quest;
        }
      }

      $data->question = ($dataQuestion) ? $dataQuestion : [];
      
      
      return $data;
      
    }
}
