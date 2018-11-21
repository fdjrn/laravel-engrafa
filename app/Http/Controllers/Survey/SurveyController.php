<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon; 

use App\User;

class SurveyController extends Controller
{
    //
    public function index(Request $request){
        // $survey = new \App\Models\Survey;
        // $data['surveys'] = $survey->get();

        $data['surveys'] = DB::table('surveys')
            ->select('*',DB::raw('DATE_FORMAT(created_at, "%d %b %Y, %H:%i") as created_ats'))
            ->get();
    	return view('survey.survey',$data);
    }

    public function addQuestion(Request $request){
    	return view('survey.survey-add-question');	
    }

    public function chooseAnswer(Request $request){
    	return view('survey.survey-choose-answer');	
    }

    public function test(Request $request){
        $msg = $request->text;
        return response()->json(array('msg'=>$msg),200);
    }

    public function ajax_get_list_user()
    {
       echo json_encode(DB::table('users')->get());
    }

    public function task()
    {
        // $task = new \App\Models\Task;
        // $data['tasks'] = $task->get();
        $priority = array();
        $priority['1-High'] = "!!!";
        $priority['2-Medium'] = "!!";
        $priority['3-Low'] = "!";
        $data['priorities'] = $priority;

        $data['tasks'] = DB::table('tasks')
            ->select('tasks.*','users.username',DB::raw('DATE_FORMAT(tasks.due_date, "%d %b %Y, %H:%i") as due_dates'))
            ->join('users','users.id','=','tasks.assign')
            ->get();

        return view('survey.task',$data);  
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $sekolah->sekolah_id = $request->post('i-idsekolah');
        $survey = new \App\Models\Survey;
        $survey->name = $request->post('i_n_name_survey');
        $survey->expired = Carbon::createFromFormat('m/d/Y h:i A', $request->post('i_n_expire'))->format('Y-m-d H:i');
        $survey->created_by = Auth::user()->id;
        $post = $survey->save();

        if($post){
            $id = $survey->id;
            foreach ($request->get('i_n_surveyor') as $surveyor) {
                $surveymembers = new \App\Models\SurveyMembers;
                $surveymembers->user = $surveyor;
                $surveymembers->survey = $id;
                $surveymembers->role = "2-Responden";
                $surveymembers->save();
            }
            foreach ($request->get('i_n_client') as $surveyor) {
                $surveymembers = new \App\Models\SurveyMembers;
                $surveymembers->user = $surveyor;
                $surveymembers->survey = $id;
                $surveymembers->role = "1-Surveyor";
                $surveymembers->save();
            }
        }
        // return response()->json($post);
        return redirect('survey');
    }

    public function task_store(Request $request){
        $task = new \App\Models\Task;
        $task->survey = 1;
        $task->name = $request->post('i_n_name_task');
        $task->assign = $request->post('i_n_assignee');
        $task->due_date = Carbon::createFromFormat('m/d/Y h:i A', $request->post('i_n_due_date'))->format('Y-m-d H:i');
        $task->detail = $request->post('i_n_detail');
        $task->color = $request->post('i_n_color');
        $task->progress = 0;
        $task->priority = $request->post('i_n_priority');
        $task->created_by = Auth::user()->id;
        $post = $task->save();
        if($post){
            $id = $task->id;
            foreach ($request->get('i_n_participant') as $participant) {
                $taskparticipants = new \App\Models\TaskParticipants;
                $taskparticipants->task = $id;
                $taskparticipants->team_member = $participant;
                $taskparticipants->save();
            }
        }
        return redirect('survey/task');
    }
}
