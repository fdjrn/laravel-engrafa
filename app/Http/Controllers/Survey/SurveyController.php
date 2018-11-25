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
    public function index($id){
        $data['survey_id'] = $id;

        $data_survey = DB::table('surveys')
            ->select('survey_process.*','it_goal.PP')
            ->leftJoin('it_related_goal','it_related_goal.survey','=','surveys.id')
            ->leftJoin('survey_process',function($join){
                $join->on('survey_process.survey', '=','surveys.id')
                     ->on('survey_process.it_related_goal', '=','it_related_goal.id');
            })
            ->leftJoin('it_goal', 'it_goal.id', '=', 'it_related_goal.id')
            ->where('surveys.id',$id)
            ->get();

        // $data['itgoalprocesses'] = DB::table('it_related_goal')
        //     ->select('it_related_goal_to_process.*','it_goal.PP')
        //     ->join('it_related_goal_to_process','it_related_goal_to_process.it_related_goal', '=','it_related_goal.id')
        //     ->join('it_goal', 'it_goal.id', '=', 'it_related_goal.id')
        //     ->where('it_related_goal.survey',$id)
        //     ->get();
        if($data_survey->first()){
            $data['surveys'] = $data_survey;
            return view('survey.survey',$data);
        }else{
            abort(404);
        }
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

    public function task($id)
    {
        $data['survey_id'] = $id;
        // $task = new \App\Models\Task;
        // $data['tasks'] = $task->get();
        $priority = array();
        $priority['1-High'] = "!!!";
        $priority['2-Medium'] = "!!";
        $priority['3-Low'] = "!";
        $data['priorities'] = $priority;

        $data_survey = DB::table('surveys')
            ->select('surveys.id')
            ->where('surveys.id',$id)
            ->get();

        if($data_survey->first()){
            $data_tasks = DB::table('tasks')
                ->select('tasks.*','users.username',DB::raw('DATE_FORMAT(tasks.due_date, "%d %b %Y, %H:%i") as due_dates'))
                ->join('users','users.id','=','tasks.assign')
                ->where('tasks.survey',$id)
                ->get();
            $data['tasks'] = $data_tasks;
            return view('survey.task',$data);  
        }else{
            abort(404);
        }
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
            if($request->get('i_n_surveyor')){
                foreach ($request->get('i_n_surveyor') as $surveyor) {
                    $surveymembers = new \App\Models\SurveyMembers;
                    $surveymembers->user = $surveyor;
                    $surveymembers->survey = $id;
                    $surveymembers->role = "2-Responden";
                    $surveymembers->save();
                }                
            }
            if($request->get('i_n_client')){
                foreach ($request->get('i_n_client') as $surveyor) {
                    $surveymembers = new \App\Models\SurveyMembers;
                    $surveymembers->user = $surveyor;
                    $surveymembers->survey = $id;
                    $surveymembers->role = "1-Surveyor";
                    $surveymembers->save();
                }
            }
            if($request->get('i_itgoal')){
                foreach ($request->get('i_itgoal') as $itgoal){
                    $id_itgoal = DB::table('it_related_goal')->insertGetId(
                        [   'it_goal' => $itgoal, 
                            'survey' => $id
                        ]
                    );
                    if($request->get('i_itgoal_process')){
                        foreach($request->get('i_itgoal_process')[$itgoal] as $itgoalprocess){
                            // $a_itgoalprocess = explode("-",$itgoalprocess);
                            // if($a_itgoalprocess[0] == $itgoal){
                                $survey_process = DB::table('survey_process')->insertGetId(
                                    [   
                                        'it_related_goal' => $id_itgoal,
                                        'process' => $itgoalprocess,
                                        'survey' => $id,
                                        'target_level' => $request->get('i_itgoal_process_level')[$itgoal][$itgoalprocess],
                                        'target_percent' => $request->get('i_itgoal_process_percent')[$itgoal][$itgoalprocess],
                                        'status' => '1-Waiting'
                                    ]
                                );
                            // }
                        }
                    }
                }
            }
            return redirect('survey/'.$id);
        }
        // return response()->json($post);
        return redirect('survey');
    }

    public function task_store(Request $request){
        $task = new \App\Models\Task;
        $task->survey = $request->post('i_n_survey_id');
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
        return redirect('survey/task/'.$request->post('i_n_survey_id'));
    }
}
