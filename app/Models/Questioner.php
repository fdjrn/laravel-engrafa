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
            ->select('question.*', 'question_types.name as question_type_name')
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


    public static function getQuestionAnswerAsking($id){
      $data = DB::select('select question_asking.*,count(answer_asking.created_by) as total_user, round((count(answer_asking.created_by)/t.count_user)*100,0) as percentage
      from question_asking
      left join answer_asking on question_asking.id = answer_asking.id_answer_asking
      cross join (select count(distinct  created_by) as count_user from  answer_asking where answer_asking.id_question = '.$id.') t
      where question_asking.id_question = '.$id.' group by question_asking.id');

      return $data;
    }

    public static function getQuestionAnswerCheckbox($id){
      $data = DB::select('select question_checkbox.*,count(answer_checkbox.created_by) as total_user, round((count(answer_checkbox.created_by)/t.count_user)*100,0) as percentage
      from question_checkbox
      left join answer_checkbox on question_checkbox.id = answer_checkbox.id_answer_checkbox
      cross join (select count(created_by) as count_user from  answer_checkbox where answer_checkbox.id_question='.$id.') t
      where question_checkbox.id_question = '.$id.' group by question_checkbox.id');

      return $data;
    }

    public static function getQuestionAnswerSlider($id){
      $data = DB::select('select count(answer_slider.created_by) as count_user, round(sum(answer_slider.value_slider)/count(answer_slider.created_by),2) as avg_value
      from question_slider join answer_slider on answer_slider.id_question = question_slider.id_question
      where answer_slider.id_question = '.$id);

      return $data[0];
    }

    public static function getQuestionAnswerStarsRating($id){
      $data = DB::select('select count(answer_stars_rating.created_by) as count_user, round(sum(answer_stars_rating.value_rating)/count(answer_stars_rating.created_by),2) as avg_rating
      from question_stars_rating join answer_stars_rating on answer_stars_rating.id_question = question_stars_rating.id_question
      where answer_stars_rating.id_question = '.$id);

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

    public static function getQuestionerQuestionAnswerAll($id){

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
            $quest->choise_asking = self::getQuestionAnswerAsking($quest->id);
          }

          if($quest->id_question_type==2){
            $quest->slider = self::getQuestionAnswerSlider($quest->id);
          }

          if($quest->id_question_type==3){
            $quest->rating = self::getQuestionAnswerStarsRating($quest->id);
          }

          if($quest->id_question_type==4){
            $quest->choise_checkbox = self::getQuestionAnswerCheckbox($quest->id);
          }

          $dataQuestion[] = $quest;
        }
      }

      $data->question = ($dataQuestion) ? $dataQuestion : [];
      
      
      return $data;
      
    }


}
