<?php

namespace App\Http\Controllers\Schedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Schedules;

class ScheduleController extends Controller
{
    //
    public function index(Request $request){
    	return view('schedule.schedule');
    }

    public function schedules_list($year, $month){
    	$schedules = Schedules::where('date_from','like',$year."-".$month."%")->get();
    	return json_encode($schedules);
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
}
