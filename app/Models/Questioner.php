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

    public static function existsQuestionerByNameForEdit($id, $name)
    {
      $data = Questioner::where('name', '=', $name)
        ->where('id', '!=', $id)
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

    public static function editQuestioner($data)
    {
      $questioner_id = $data['quisioner_id'];
      $questioner_name = $data['quisioner_name'];
      $questioner_category = $data['quisioner_category'];
      $updated_by = $data['user_id'];

      $update = DB::table('quisioner')
      ->where('id', '=', $questioner_id)
      ->update([
                'name' => $questioner_name,
                'category' => $questioner_category,
                //'created_by' => $created_by,
                //'created_at' => DB::raw('now()'),
                'updated_by' => $updated_by,
                'updated_at' => DB::raw('now()')
            ]);

      return $update;
    }

    public static function getQuestionerAll($user, $userId)
    {
      if($user[0]->role == '1-Super Admin' || $user[0]->role == '2-Admin'){
        DB::statement(DB::raw('set @rownum=0'));
        $data = DB::table('quisioner')
              ->leftJoin('quisioner_categories', 'quisioner.category', '=', 'quisioner_categories.id')
              ->leftJoin('users', 'users.id', '=', 'quisioner.created_by')
              ->select('quisioner.*', 'quisioner_categories.name as category_name', 'users.name as creator_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'))
              ->orderBy('quisioner.id')
              ->get();
      }else{
        DB::statement(DB::raw('set @rownum=0'));
        $data = DB::table('quisioner')
              ->leftJoin('quisioner_categories', 'quisioner.category', '=', 'quisioner_categories.id')
              ->leftJoin('user_quisioner', 'quisioner.id', '=', 'user_quisioner.quisioner')
              ->leftJoin('users', 'users.id', '=', 'quisioner.created_by')
              ->select('quisioner.*', 'quisioner_categories.name as category_name', 'user_quisioner.quisioner as quisioner_to_user', 'users.name as creator_name', DB::raw('@rownum  := @rownum  + 1 AS rownum'))
              ->where('user_quisioner.user','=',$userId)
              ->orderBy('quisioner.id')
              ->get();
      }

      //dd($data);

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

    // public static function getUserQuesioner($quesionerId, $quesionerType){
    //   if($quesionerType == 'asking'){
    //     $data = DB::select('
    //       select answer_asking.*
    //       from answer_asking
    //       left join users on answer_asking.created_by = users.id
    //       where answer_asking.created_by = 
    //       ');
    //   }
      
    //   return $data;
    // }

    public static function getQuestionAnswerAsking($id){
      $data = DB::select('select question_asking.*, answer_asking.id_quisioner as answer_id_quisioner, answer_asking.id_question answer_id_question, answer_asking.id_answer_asking, count(answer_asking.created_by) as total_user, round((count(answer_asking.created_by)/t.count_user)*100,0) as percentage
      from question_asking
      left join answer_asking on question_asking.id = answer_asking.id_answer_asking
      cross join (select count(distinct  created_by) as count_user from  answer_asking where answer_asking.id_question = '.$id.') t
      where question_asking.id_question = '.$id.' 
      group by question_asking.id, question_asking.id_question, question_asking.question_asking_answer, id_answer_asking, answer_id_quisioner, answer_id_question, t.count_user');

      // $data = DB::select('select question_asking.*,count(answer_asking.created_by) as total_user, round((count(answer_asking.created_by)/t.count_user)*100,0) as percentage
      // from question_asking
      // left join answer_asking on question_asking.id = answer_asking.id_answer_asking
      // cross join (select count(distinct  created_by) as count_user from  answer_asking where answer_asking.id_question = '.$id.') t
      // where question_asking.id_question = '.$id.' group by question_asking.id');

      return $data;
    }

    public static function getQuestionAnswerCheckbox($id){
      // $data = DB::select('select question_checkbox.*,count(answer_checkbox.created_by) as total_user, round((count(answer_checkbox.created_by)/t.count_user)*100,0) as percentage
      // from question_checkbox
      // left join answer_checkbox on question_checkbox.id = answer_checkbox.id_answer_checkbox
      // cross join (select count(created_by) as count_user from  answer_checkbox where answer_checkbox.id_question='.$id.') t
      // where question_checkbox.id_question = '.$id.' 
      // group by question_checkbox.id');

      $data = DB::select('select question_checkbox.*, answer_checkbox.id_quisioner as answer_id_quisioner, answer_checkbox.id_question as answer_id_question, answer_checkbox.id_answer_checkbox, count(answer_checkbox.created_by) as total_user, round((count(answer_checkbox.created_by)/t.count_user)*100,0) as percentage
      from question_checkbox
      left join answer_checkbox on question_checkbox.id = answer_checkbox.id_answer_checkbox
      cross join (select count(created_by) as count_user from  answer_checkbox where answer_checkbox.id_question='.$id.') t
      where question_checkbox.id_question = '.$id.' 
      group by question_checkbox.id, question_checkbox.id_question, question_checkbox.question_checkbox_answer, answer_id_quisioner, answer_id_question, answer_checkbox.id_answer_checkbox, t.count_user');

      return $data;
    }

    public static function getQuestionAnswerSlider($id){
      $data = DB::select('select answer_slider.id_quisioner as answer_id_quisioner, answer_slider.id_question as answer_id_question, count(answer_slider.created_by) as count_user, round(sum(answer_slider.value_slider)/count(answer_slider.created_by),2) as avg_value
      from question_slider 
      join answer_slider on answer_slider.id_question = question_slider.id_question
      where answer_slider.id_question = '.$id. ' 
      group by answer_id_quisioner, answer_id_question');

      return $data[0];
    }

    public static function getQuestionAnswerStarsRating($id){
      $data = DB::select('select answer_stars_rating.id_quisioner as answer_id_quisioner, answer_stars_rating.id_question as answer_id_question, count(answer_stars_rating.created_by) as count_user, round(sum(answer_stars_rating.value_rating)/count(answer_stars_rating.created_by),2) as avg_rating
      from question_stars_rating 
      join answer_stars_rating on answer_stars_rating.id_question = question_stars_rating.id_question
      where answer_stars_rating.id_question = '.$id.' 
      group by answer_id_quisioner, answer_id_question');

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

    public static function getUserAll($userId){
      $data = DB::table('users')
            ->select('users.*')
            ->where('users.id','!=',$userId)
            ->get();
      
      return $data;
    }

    public static function getUserById($userId){
      $data = DB::table('users')
            ->select('users.*')
            ->where('users.id','=',$userId)
            ->get();
      
      return $data;
    }

    public static function saveShareQuestioner($data)
    {
      $quisioner = $data['quisionerId'];
      $user = $data['userId'];

      $insert = DB::table('user_quisioner')->insertGetId(
        [
          'quisioner' => $quisioner,
          'user' => $user
        ]
      );
      
      return $insert;
    }

    public static function checkExistSharedQuisioner($quisionerId, $userId){
      $data = DB::table('user_quisioner')
            ->select('user_quisioner.*')
            ->where('user_quisioner.quisioner','!=',$quisionerId)
            ->where('user_quisioner.user','!=',$userId)
            ->get();
      
      return $data;
    }

    public static function checkFilledQuisioner($quisionerId, $userId){
      $checkAnswerAsking = null;
      $checkAnswerCheckbox = null;
      $checkAnswerSlider = null;
      $checkAnswerStarsRating = null;
      $result = 0;

      $checkAnswerAsking = DB::table('answer_asking')
            ->select('answer_asking.*')
            ->where('answer_asking.id_quisioner','=',$quisionerId)
            ->where('answer_asking.created_by','=',$userId)
            ->get();
      
      $checkAnswerCheckbox = DB::table('answer_checkbox')
            ->select('answer_checkbox.*')
            ->where('answer_checkbox.id_quisioner','=',$quisionerId)
            ->where('answer_checkbox.created_by','=',$userId)
            ->get();
      
      $checkAnswerSlider = DB::table('answer_slider')
            ->select('answer_slider.*')
            ->where('answer_slider.id_quisioner','=',$quisionerId)
            ->where('answer_slider.created_by','=',$userId)
            ->get();
      
      $checkAnswerStarsRating = DB::table('answer_stars_rating')
            ->select('answer_stars_rating.*')
            ->where('answer_stars_rating.id_quisioner','=',$quisionerId)
            ->where('answer_stars_rating.created_by','=',$userId)
            ->get();

      if(count($checkAnswerAsking) > 0 || count($checkAnswerCheckbox) > 0 || count($checkAnswerSlider) > 0 || count($checkAnswerStarsRating) > 0){
        $result = 1;
      }else{
        $result = 0;
      }

      return $result;
    }

    public static function getUserQuisioner($type, $quisionerId, $questionId, $quisionerAnswerId){
      
      if($type == 'asking'){
        $data = DB::table('answer_asking')
            ->select('answer_asking.*', 'users.name as user_name')
            ->leftJoin('users', 'answer_asking.created_by', '=', 'users.id')
            ->where('answer_asking.id_quisioner','=',$quisionerId)
            ->where('answer_asking.id_question','=',$questionId)
            ->where('answer_asking.id_answer_asking','=',$quisionerAnswerId)
            ->get();
      }elseif($type == 'checkbox'){
        $data = DB::table('answer_checkbox')
            ->select('answer_checkbox.*', 'users.name as user_name')
            ->leftJoin('users', 'answer_checkbox.created_by', '=', 'users.id')
            ->where('answer_checkbox.id_quisioner','=',$quisionerId)
            ->where('answer_checkbox.id_question','=',$questionId)
            ->where('answer_checkbox.id_answer_checkbox','=',$quisionerAnswerId)
            ->get();
      }elseif($type == 'slider'){
        $data = DB::table('answer_slider')
            ->select('answer_slider.*', 'users.name as user_name')
            ->leftJoin('users', 'answer_slider.created_by', '=', 'users.id')
            ->where('answer_slider.id_quisioner','=',$quisionerId)
            ->where('answer_slider.id_question','=',$questionId)
            ->get();
      }elseif($type == 'rating'){
        $data = DB::table('answer_stars_rating')
            ->select('answer_stars_rating.*', 'users.name as user_name')
            ->leftJoin('users', 'answer_stars_rating.created_by', '=', 'users.id')
            ->where('answer_stars_rating.id_quisioner','=',$quisionerId)
            ->where('answer_stars_rating.id_question','=',$questionId)
            ->get();
      }
      
      return $data;
    }

    public static function checkAnsweredQuisioner($quisionerId){
      $checkAnswerAsking = null;
      $checkAnswerCheckbox = null;
      $checkAnswerSlider = null;
      $checkAnswerStarsRating = null;
      $result = 0;

      $checkAnswerAsking = DB::table('answer_asking')
            ->select('answer_asking.*')
            ->where('answer_asking.id_quisioner','=',$quisionerId)
            ->get();
      
      $checkAnswerCheckbox = DB::table('answer_checkbox')
            ->select('answer_checkbox.*')
            ->where('answer_checkbox.id_quisioner','=',$quisionerId)
            ->get();
      
      $checkAnswerSlider = DB::table('answer_slider')
            ->select('answer_slider.*')
            ->where('answer_slider.id_quisioner','=',$quisionerId)
            ->get();
      
      $checkAnswerStarsRating = DB::table('answer_stars_rating')
            ->select('answer_stars_rating.*')
            ->where('answer_stars_rating.id_quisioner','=',$quisionerId)
            ->get();

      if(count($checkAnswerAsking) > 0 || count($checkAnswerCheckbox) > 0 || count($checkAnswerSlider) > 0 || count($checkAnswerStarsRating) > 0){
        $result = 1;
      }else{
        $result = 0;
      }

      return $result;
    }

    public static function deleteQuestionerByIdQuestioner($questionerId){
        $delete = DB::table('quisioner')
            ->where('id', $questionerId)
            ->delete();

        return $delete;
    }

}
