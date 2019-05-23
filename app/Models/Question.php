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

    public static function editQuestion($data)
    {
      $id_question = $data['id_question'];
      $id_quisioner = $data['id_quisioner'];
      $question = $data['question'];
      $id_question_type = $data['id_question_type'];

      try{
      	$update = DB::table('question')
	      ->where('id', '=', $id_question)
	      ->update([
	                'id_quisioner' => $id_quisioner,
	                'question' => $question,
	                'id_question_type' => $id_question_type
	            ]);
	    return true;	
      }catch(\Illuminate\Database\QueryException $e){
      	return false;
      }

    }

    public static function deleteQuestionByIdQuestioner($questionerId){
        $delete = DB::table('question')
            ->where('id_quisioner', $questionerId)
            ->delete();

        return $delete;
    }


}