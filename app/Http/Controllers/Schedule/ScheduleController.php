<?php

namespace App\Http\Controllers\Schedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Schedules;

class ScheduleController extends Controller
{
    //
    public function index(Request $request){
    	return view('schedule.schedule');
    }

    public function schedules_list($year, $month){

    	if (strlen($month) == 1) {
    		# code...
    		$month = '0'.$month;
    	}

    	// $schedules = Schedules::where('date_from','like',$year."-".$month."%");
    	
    	$schedules = DB::table("tasks")
    		->select(DB::raw("tasks.id as id, tasks.name as name, tasks.due_date as date_from, tasks.due_date as date_to, '' as location, tasks.detail as detail, tasks.color as color, tasks.created_by as created_by, tasks.updated_at as updated_at, tasks.created_at as created_at, 'task' as type"))
    		->join("task_participant","tasks.id","=","task_participant.task")
    		->where('due_date','like',$year."-".$month."%")
    		->where('team_member',Auth::user()->id);
    		
    	$schedule = DB::table("schedules")
    		->select(DB::raw("*, 'schedule' as type"))
    		->where('date_from','like',$year."-".$month."%")
    		->union($schedules)
    		->get();
    	// dd($schedules);
    	return json_encode($schedule);
    }

    public function calendar_store(Request $request){
    	$message = "success";
    	$status = "success";
    	$schedule = new Schedules;

    	try {

	    	$validator = Validator::make($request->all(),[
	    		'eventName' => 'required',
	    		'dateFrom' => 'required',
	    		'dateTo' => 'required',
	    	]);

	    	if($validator->fails()){
	    		$status = "failed validation";
    			return response()->json([
	    			'status' => $status,
		    		'message' => $validator->errors()->all(),
		    		'schedule'  => $schedule,
		    	]);
	    	}
	    	
	    	$schedule->name = $request->eventName;
	    	$schedule->color = $request->eventColor;
	    	$schedule->date_from = $request->dateFrom." ".$request->timeFrom.":00";
	    	$schedule->date_to = $request->dateTo." ".$request->timeTo.":00";
	    	$schedule->location = $request->location;
	    	$schedule->detail = $request->detail;
	    	$schedule->created_at = date('Y-m-d');
	    	$schedule->updated_at = date('Y-m-d');
	    	$schedule->created_by = Auth::user()->id;

	    	$schedule->save();



	    	return response()->json([
    			'status' => $status,
	    		'message' => $message,
	    		'schedule'  => $schedule
	    	]);

    	} catch (\Exception $e) {
    		$status = "failed";
    		$message = $e->getMessage();
			return response()->json([
    			'status' => $status,
	    		'message' => $message,
	    		'schedule'  => $schedule
	    	]);    		
    	}

    }

    public function calendar_delete(Request $request){
    	// dd($request->id);
    	Schedules::where("id",$request->id)->delete();
    }

    public function CheckJadwal(Request $request){
        dd("test");
    }
}
