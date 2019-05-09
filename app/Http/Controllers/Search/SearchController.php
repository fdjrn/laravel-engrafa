<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    //
    public function search(Request $request){
    	// dd($request->search);
    	$search = $request->search;

    	//cari assessment, user, quisioner, agenda/ schedule
    	$surveys = DB::table('surveys')
    		->join('survey_members','surveys.id','=','survey_members.survey')
    		->select(DB::raw("surveys.id as id, surveys.name as name, 'survey' as type"))
    		->where('name','like','%'.$search.'%')
    		->where('survey_members.user',Auth::user()->id);
		
		$schedule = DB::table('schedules')
    		->select(DB::raw("schedules.id as id, schedules.name as name, 'schedule' as type"))
    		->where('schedules.name','like','%'.$search.'%');    	

    	$task = DB::table('tasks')
    		->join('task_participant','tasks.id','=','task_participant.task')
    		->join('survey_members','task_participant.team_member','=','survey_members.id')
    		->select(DB::raw("tasks.survey as id, tasks.name as name, 'task' as type"))
    		// ->where('tasks.name','like','%'.$search.'%')
    		->whereRaw("tasks.name like '%".$search."%' and survey_members.user = '".Auth::user()->id."' or tasks.assign = '".Auth::user()->id."' ");

    	// $user = DB::table('users')
    	// 	->select(DB::raw("users.id as id, users.name as name, 'user' as type"))
    	// 	->where('users.name','like','%'.$search.'%')
    	// 	->get();

    	$quisioner = DB::table('quisioner')
    		->select(DB::raw("quisioner.id as id, quisioner.name as name, 'quisioner' as type"))
    		->where('quisioner.name','like','%'.$search.'%');

    	$dataSearch = DB::table('users')
    		->select(DB::raw("users.id as id, users.name as name, 'user' as type"))
    		->where('users.name','like','%'.$search.'%')
    		->union($surveys)
    		->union($schedule)
    		->union($task)
    		->union($quisioner)
    		->get();


    	return json_encode($dataSearch);
    }
}
