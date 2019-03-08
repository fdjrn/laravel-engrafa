<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Survey extends Model
{
    protected $table = 'surveys';

    public static function mnsurvey() {

   //      $mnsurvey = DB::table('surveys')
			// ->where('created_by',Auth::user()->id)
			// ->get();


        $mnsurvey = DB::table('surveys')
            ->select('surveys.*')
            ->leftJoin('survey_members',function($join){
                $join->on('survey_members.survey','=','surveys.id')
                     ->on('survey_members.user', '=', DB::raw(Auth::user()->id));
            })
            ->where('surveys.created_by','=',Auth::user()->id)
            ->orWhere('survey_members.user', '=', Auth::user()->id)
            ->get();

        // dd($menu);

        return $mnsurvey;

	}

    public static function get_user_by_id($user_id){
        return DB::table('users')->where('id', '=', $user_id)->get()->first();
    }

    public static function get_status_ownership($survey_id){
        $data_survey = DB::table('surveys')
            ->select('created_by')
            ->where('id',$survey_id)
            ->get();

        if(!$data_survey->first()){
            abort(404);
        }

        $status_ownership = "";
        if ($data_survey->first()->created_by == Auth::user()->id){
            $status_ownership = "0-CREATOR";
        }else{
            $status_of_surveys = DB::table('survey_members')
                ->select('role')
                ->where([
                    ['survey','=',$survey_id],
                    ['user','=',Auth::user()->id]
                ])
                ->get();
            if($status_of_surveys->first()){
                $status_ownership = strtoupper($status_of_surveys->first()->role);
            }else{
                abort(404);
            }
        }

        return $status_ownership;
    }
}
