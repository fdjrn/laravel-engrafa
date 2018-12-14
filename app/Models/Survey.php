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
}
