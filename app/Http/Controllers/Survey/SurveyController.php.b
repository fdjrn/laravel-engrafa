<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\ChatRoom;
use App\Models\Files;
use App\Models\SurveyProcessOutcomes;
use App\Models\Rating;
use App\Models\Survey;
use App\Models\Task;
use App\Events\NewNotification;


class SurveyController extends Controller
{
    //
    public function index($id){
        $data['survey_id'] = $id;

        $data_survey = DB::table('surveys')
            ->select('created_by')
            ->where('id',$id)
            ->get();

        if(!$data_survey->first()){
            abort(404);
        }

        $data['status_ownership'] = Survey::get_status_ownership($id);

        $query_survey = DB::table('surveys')
            ->select('surveys.created_by','surveys.name','survey_process.*','it_goal.PP')
            ->leftJoin('it_related_goal','it_related_goal.survey','=','surveys.id')
            ->leftJoin('survey_process',function($join){
                $join->on('survey_process.survey', '=','surveys.id')
                     ->on('survey_process.it_related_goal', '=','it_related_goal.id');
            })
            ->leftJoin('it_goal', 'it_goal.id', '=', 'it_related_goal.it_goal');


        $data['survey_name'] = (clone $query_survey)
            ->where('surveys.id',$id)
            ->get()->first()->name;

        if(explode("-",$data['status_ownership'])[0] == 2){
            $data['surveys'] = (clone $query_survey)
                ->whereRaw("surveys.id = $id AND SUBSTRING_INDEX(SUBSTRING_INDEX(survey_process.status, '-', 1), '-', -1) < 4")
                ->get();
            $data['surveys_done'] = (clone $query_survey)
                ->whereRaw("surveys.id = $id AND SUBSTRING_INDEX(SUBSTRING_INDEX(survey_process.status, '-', 1), '-', -1) > 3")
                ->get();
        }else{
            $data['surveys'] = (clone $query_survey)
                ->whereRaw("surveys.id = $id AND SUBSTRING_INDEX(SUBSTRING_INDEX(survey_process.status, '-', 1), '-', -1) < 7")
                ->get();
            $data['surveys_done'] = (clone $query_survey)
                ->whereRaw("surveys.id = $id AND SUBSTRING_INDEX(SUBSTRING_INDEX(survey_process.status, '-', 1), '-', -1) = 7")
                ->get();
        }

        $data['survey_members'] = $this->ajax_get_list_user($id, 'user_survey');
        
        return view('survey.survey',$data);
    }

    public function chooseAnswer($id,$inputans){
        $inputan = explode("-",$inputans);
        $id = $inputan[0];
        $data['survey_id'] = $id;
        $it_related_goal = $inputan[1];
        $process = $inputan[2];
        $target_level = "";

        $data['status_ownership'] = Survey::get_status_ownership($id);

        $status = DB::table('survey_process')
                    ->select('survey_process.status')
                    ->where([
                        ['it_related_goal','=',$it_related_goal],
                        ['process','=',$process],
                        ['survey','=',$id]
                    ])
                    ->get()->first()->status;

        if((explode("-",$status))[0] >= 4){
            abort(404);
        }

        DB::table('survey_process')
            ->where([
                ['it_related_goal','=',$it_related_goal],
                ['process','=',$process],
                ['survey','=',$id],
                ['status','=','1-Waiting']
            ])
            ->update(['status' => '2-Process Survey']);

        $d_surveys = DB::table('surveys')
                    ->select('surveys.name','surveys.created_by','survey_process.target_level')
                    ->leftJoin('survey_process','survey_process.survey','=','surveys.id')
                    ->where([
                        ['surveys.id','=',$id],
                        ['survey_process.it_related_goal','=',$it_related_goal],
                        ['survey_process.process','=',$process]
                    ])
                    ->get();

        if($d_surveys->first()){
            if ($d_surveys->first()->created_by != Auth::user()->id){
                $data['survey_members'] = $this->ajax_get_list_user($id, 'user_survey');
                $ok = 0;
                foreach($data['survey_members'] as $surmem){
                    if($surmem->user == Auth::user()->id){
                        $ok = 1;
                    }
                }
                if(!$ok){
                    abort(404);
                }
            }else{
                abort(404);
            }
            $data['survey_name'] = $d_surveys->first()->name;
            $target_level = $d_surveys->first()->target_level;
        }else{
            abort(404);
        }

        $levels = DB::table('process_attributes')
            ->select('level')
            ->groupBy('level')
            // ->where('level','<=',$target_level)
            ->get();

        $datasurvey = array();
        foreach($levels as $index => $leveled){
            $level = $leveled->level;
            $dats = DB::table('surveys')
                ->select('process_attributes.purpose','surveys.name','process_outcome.*','outcomes.description')
                ->leftJoin('survey_process','survey_process.survey','=','surveys.id')
                ->leftJoin('process_outcome','process_outcome.process','=','survey_process.process')
                ->leftJoin('outcomes','outcomes.id','=','process_outcome.outcome')
                ->leftJoin('process_attributes', 'process_attributes.id', '=','outcomes.process_attribute')
                ->where([
                    ['surveys.id','=',$id],
                    ['survey_process.process','=',$process],
                    ['survey_process.it_related_goal','=',$it_related_goal],
                    ['process_attributes.level','=',$level]
                ])
                ->get();
            if($dats->first()){
                $datasurvey[$index]['surveys'] = $dats;
            }
        }
        $data['levels'] = $datasurvey;

        return view('survey.survey-choose-answer', $data);  
    }

    public function postAnswer($id,$inputans, Request $request){
        $inputan = explode("-",$inputans);
        $survey_id = $inputan[0];
        $it_related_goal = $inputan[1];
        $process = $inputan[2];
        $typesubmit = $request->post('btnsubmit');
        
        $status = "";
        if($typesubmit == 'finish'){
            $status = '4-Done Survey';

            foreach ($request->post('metcriteria') as $process_outcome => $answer){
                echo $process_outcome." ".$answer." ".$request->post('comment')[$process_outcome];
                DB::table('survey_process_outcomes')->insert(
                            [   'survey' => $survey_id, 
                                'it_related_goal' => $it_related_goal,
                                'process_outcome' => $process_outcome,
                                'met_criteria' => $answer,
                                'comment' => $request->post('comment')[$process_outcome],
                                'answered_by' => Auth::user()->id
                            ]
                        );
            }
        }else{
            $status = '3-On Save Survey';
        }

        DB::table('survey_process')
            ->where([
                ['it_related_goal','=',$it_related_goal],
                ['process','=',$process],
                ['survey','=',$survey_id]
            ])
            ->update(['status' => $status]);

        return redirect('assessment/'.$survey_id);
    }


    public function doneView($id, $inputans){
        $inputan = explode("-",$inputans);
        $id = $inputan[0];
        $data['survey_id'] = $id;
        $it_related_goal = $inputan[1];
        $process = $inputan[2];
        $target_level = "";

        $data['status_ownership'] = Survey::get_status_ownership($id);

        $d_surveys = DB::table('surveys')
                    ->select('surveys.name','surveys.created_by','survey_process.target_level')
                    ->leftJoin('survey_process','survey_process.survey','=','surveys.id')
                    ->where([
                        ['surveys.id','=',$id],
                        ['survey_process.it_related_goal','=',$it_related_goal],
                        ['survey_process.process','=',$process]
                    ])
                    ->get();

        if($d_surveys->first()){
            $data['survey_members'] = $this->ajax_get_list_user($id, 'user_survey');
            $ok = 0;
            foreach($data['survey_members'] as $surmem){
                if($surmem->user == Auth::user()->id){
                    $ok = 1;
                }
            }
            if ($d_surveys->first()->created_by != Auth::user()->id){
                if(!$ok){
                    abort(404);
                }
            }
            $data['survey_name'] = $d_surveys->first()->name;
            $target_level = $d_surveys->first()->target_level;
        }else{
            abort(404);
        }


        $levels = DB::table('process_attributes')
            ->select('level')
            ->groupBy('level')
            // ->where('level','<=',$target_level)
            ->get();

        $datasurvey = array();
        foreach($levels as $index => $leveled){
            $level = $leveled->level;
            $dats = DB::table('surveys')
                ->select('process_attributes.purpose','surveys.name','process_outcome.*','outcomes.description', 'survey_process_outcomes.met_criteria','survey_process_outcomes.comment','survey_process_outcomes.note','survey_process_outcomes.acceptance')
                ->leftJoin('survey_process','survey_process.survey','=','surveys.id')
                ->leftJoin('process_outcome','process_outcome.process','=','survey_process.process')
                ->leftJoin('outcomes','outcomes.id','=','process_outcome.outcome')
                ->leftJoin('process_attributes', 'process_attributes.id', '=','outcomes.process_attribute')
                ->leftJoin('survey_process_outcomes',function($join) use($id, $it_related_goal){
                    $join->on('survey_process_outcomes.process_outcome','=','process_outcome.id')
                         ->on('survey_process_outcomes.survey', '=',DB::raw($id))
                         ->on('survey_process_outcomes.it_related_goal', '=', DB::raw($it_related_goal));
                })
                ->where([
                    ['surveys.id','=',$id],
                    ['survey_process.process','=',$process],
                    ['survey_process.it_related_goal','=',$it_related_goal],
                    ['process_attributes.level','=',$level]
                ])
                ->get();
            if($dats->first()){
                $datasurvey[$index]['surveys'] = $dats;
            }
        }
        $data['levels'] = $datasurvey;

        return view('survey.survey-answer-view', $data);  
    }

    public function get_process_outcome_wp($id){
        $input = explode(",",$id);
        $survey_id = $input[1];

        $data = DB::table('process_outcome')
                ->select('working_product.*','survey_working_products.file',DB::raw('files.name as filename'),DB::raw('files.url as fileurl'),DB::raw('files.id as fileid'))
                ->leftJoin('process_outcome_wp','process_outcome_wp.process_outcome','=','process_outcome.id')
                ->leftJoin('working_product','working_product.id','=','process_outcome_wp.working_product')
                ->leftJoin('survey_working_products',function($join) use($survey_id){
                    $join->on('survey_working_products.working_product', '=','working_product.id')
                         ->on('survey_working_products.survey', '=', DB::raw($survey_id));
                })
                ->leftJoin('files','files.id','=','survey_working_products.file')
                ->where("process_outcome.id","=",$input[0])->get();
        
        echo json_encode([
            'draw' => 1,
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
            'data' => $data,
        ]);;
    }

    public function uploadWp($id,Request $request){

        $validator = Validator::make(
            $request->all(), [
            'files.*' => 'required|mimes:pdf,doc,docx,xls,xlsx'
            ],[
                'files.*.required' => 'Upload Files Failed, files must not empty!',
                'files.*.mimes' => 'Only pdf, word (.doc|.docx), and excel(.xls|.xlsx) files are allowed',
            ]
        );

        if ($validator->fails()) {
            return json_encode([
                'status' => 0,
                'messages' => $validator->errors()->first()
            ]);
        }

        $survey = \App\Models\Survey::where('id', $id)->first();

        if(!$survey){
            return json_encode([
                'status' => 0,
                'messages' => "Upload Files Failed, current Assessment not found!"
            ]);
        }

        if(!$request->file('files')){
            return json_encode([
                'status' => 0,
                'messages' => "Upload Files Failed, files must not empty!"
            ]);
        }

        $root_path = "assessment/";

        $root = Files::where('url',$root_path)->first();
        $root_id = "";
        if (!$root) {
            Storage::makeDirectory('assessment');
            $folder = new Files();
            $folder->folder_root = 0;
            $folder->name = 'assessment';
            $folder->url= $root_path;
            $folder->is_file = 0;
            $folder->created_by = Auth::user()->id;
            $folder->save();
            $root_id = $folder->id;
        }else{
            $root_id = $root->id;
        }

        $survey_path = $root_path.$survey->name.'/';
        $survey_files = Files::where('url',$survey_path)->first();
        $survey_files_id = "";
        if (!$survey_files) {
            Storage::makeDirectory('assessment/'.$survey->name.'/');
            $folder = new Files();
            $folder->folder_root = $root_id;
            $folder->name = $survey->name;
            $folder->url= $survey_path;
            $folder->is_file = 0;
            $folder->created_by = Auth::user()->id;
            $folder->save();
            $survey_files_id = $folder->id;
        }else{
            $survey_files_id = $survey_files->id;
        }

        if($survey_files_id){
            foreach ($request->file('files') as $wpid => $file) {
                if ($file->isValid()) {

                    $path = $file->store('assessment/'.$survey->name);

                    $files = [
                        'folder_root' => $survey_files_id,
                        'name' => $file->getClientOriginalName(),
                        'url' => $path,
                        'is_file' => 1,
                        'version' => 1,
                        'size' => $file->getClientSize(),
                        'created_by' => Auth::user()->id,
                        'created_at' => $now = Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => $now,
                    ];

                    $fileid = Files::insertGetId($files);

                    DB::table('survey_working_products')->insert(
                        [   'survey' => $id, 
                            'working_product' => $wpid,
                            'file' => $fileid
                        ]
                    );
                }
            }
        }

        return json_encode([
            'status' => 1,
            'messages' => "Upload Files Success!"
        ]);
    }

    public function viewWp(Files $file)
    {
        $exists = Storage::disk('public')->has(str_replace('/storage/index/', '', $file->url));
        if($exists){
            return Storage::response(str_replace('/storage/index/', '', $file->url));
        }else{
            return 1;
        }
    }

    public function downloadWp(Files $file)
    {
        $exists = Storage::disk('public')->has(str_replace('/storage/index/', '', $file->url));
        if($exists){
            return Storage::download(str_replace('/storage/index/', '', $file->url), $file->name);
        }else{
            return 1;
        }
    }

    public function analyze($id,$inputans){
        $inputan = explode("-",$inputans);
        $id = $inputan[0];
        $data['survey_id'] = $id;
        $it_related_goal = $inputan[1];
        $process = $inputan[2];
        $target_level = "";
        $data['status_ownership'] = Survey::get_status_ownership($id);
        DB::table('survey_process')
            ->where([
                ['it_related_goal','=',$it_related_goal],
                ['process','=',$process],
                ['survey','=',$id],
                ['status','=','4-Done Survey']
            ])
            ->update(['status' => '5-Analyze']);
        $d_surveys = DB::table('surveys')
                    ->select('surveys.name','surveys.created_by','survey_process.target_level')
                    ->leftJoin('survey_process','survey_process.survey','=','surveys.id')
                    ->where([
                        ['surveys.id','=',$id],
                        ['survey_process.it_related_goal','=',$it_related_goal],
                        ['survey_process.process','=',$process]
                    ])
                    ->get();

        if($d_surveys->first()){
            $data['survey_members'] = $this->ajax_get_list_user($id, 'user_survey');
            $ok = 0;
            foreach($data['survey_members'] as $surmem){
                if($surmem->user == Auth::user()->id){
                    $ok = 1;
                }
            }
            if ($d_surveys->first()->created_by != Auth::user()->id){
                if(!$ok){
                    abort(404);
                }
            }
            $data['survey_name'] = $d_surveys->first()->name;
            $target_level = $d_surveys->first()->target_level;
        }else{
            abort(404);
        }


        $levels = DB::table('process_attributes')
            ->select('level')
            ->groupBy('level')
            // ->where('level','<=',$target_level)
            ->get();

        $datasurvey = array();
        foreach($levels as $index => $leveled){
            $level = $leveled->level;
            $dats = DB::table('surveys')
                ->select('process_attributes.purpose','surveys.name','process_outcome.*','outcomes.description', 'survey_process_outcomes.met_criteria','survey_process_outcomes.comment')
                ->leftJoin('survey_process','survey_process.survey','=','surveys.id')
                ->leftJoin('process_outcome','process_outcome.process','=','survey_process.process')
                ->leftJoin('outcomes','outcomes.id','=','process_outcome.outcome')
                ->leftJoin('process_attributes', 'process_attributes.id', '=','outcomes.process_attribute')
                ->leftJoin('survey_process_outcomes',function($join) use($id, $it_related_goal){
                    $join->on('survey_process_outcomes.process_outcome','=','process_outcome.id')
                         ->on('survey_process_outcomes.survey', '=',DB::raw($id))
                         ->on('survey_process_outcomes.it_related_goal', '=', DB::raw($it_related_goal));
                })
                ->where([
                    ['surveys.id','=',$id],
                    ['survey_process.process','=',$process],
                    ['survey_process.it_related_goal','=',$it_related_goal],
                    ['process_attributes.level','=',$level]
                ])
                ->get();
            if($dats->first()){
                $datasurvey[$index]['surveys'] = $dats;
            }
        }
        $data['levels'] = $datasurvey;

        return view('survey.survey-analyze', $data);  
    }

    public function analyzePost($id,$inputans, Request $request){
        $inputan = explode("-",$inputans);
        $survey_id = $inputan[0];
        $it_related_goal = $inputan[1];
        $process = $inputan[2];
        $typesubmit = $request->post('btnsubmit');
        
        $data['status_ownership'] = Survey::get_status_ownership($survey_id);
        
        $status = "";

        $percent_level = 0;
        $count_level = 0;
        $level_tercapai = 0;
        $percent_tercapai = 0;

        $tercapai = array();

        if($typesubmit == 'finish'){
            $status = '7-Done';
            foreach ($request->post('metcriteria') as $level => $process_outcomes){
                $total_process = 0;
                $total_percent = 0;
                foreach($process_outcomes as $process_outcome => $answer){
                    $total_process++;
                    $percent = 0;
                    if($request->post('acceptance')[$level][$process_outcome] == 'agree'){
                        $datas = DB::table('process_outcome')
                                ->select('working_product.*','survey_working_products.file',DB::raw('files.name as filename'),DB::raw('files.url as fileurl'),DB::raw('files.id as fileid'))
                                ->leftJoin('process_outcome_wp','process_outcome_wp.process_outcome','=','process_outcome.id')
                                ->leftJoin('working_product','working_product.id','=','process_outcome_wp.working_product')
                                ->leftJoin('survey_working_products',function($join) use($survey_id){
                                    $join->on('survey_working_products.working_product', '=','working_product.id')
                                         ->on('survey_working_products.survey', '=', DB::raw($survey_id));
                                })
                                ->leftJoin('files','files.id','=','survey_working_products.file')
                                ->where("process_outcome.id","=",$process_outcome)->get();
                        
                        $available = 0;                 
                        foreach($datas as $index => $data){
                            if($data->file){
                                $available++;
                            }
                        }
                        
                        $percent = round($available/$datas->count()*100);
                    }
                    $total_percent += $percent;
                    
                    DB::table('survey_process_outcomes')
                        ->where([
                            ['survey','=',$survey_id],
                            ['it_related_goal','=',$it_related_goal],
                            ['process_outcome','=',$process_outcome]
                        ])
                        ->update(
                            [   
                                'note' => $request->post('note')[$level][$process_outcome],
                                'acceptance' => $request->post('acceptance')[$level][$process_outcome],
                                'percent' => $percent,
                                'recomended_by' => Auth::user()->id
                            ]
                        );
                }

                $percent_level += round($total_percent/$total_process);
                $count_level++;

                if (round($total_percent/$total_process) >= 85){
                    if(!array_key_exists("finish",$tercapai)){
                        $level_tercapai = $level;
                    }
                }else{
                    $tercapai['finish'] = $level_tercapai;
                }
            }

            $percent_tercapai = round($percent_level/$count_level);
        }else{
            $status = '6-On Save Analyze';
        }

        DB::table('survey_process')
            ->where([
                ['it_related_goal','=',$it_related_goal],
                ['process','=',$process],
                ['survey','=',$survey_id]
            ])
            ->update([
                'status' => $status,
                'level' => array_key_exists("finish",$tercapai) ? $tercapai['finish'] : $level_tercapai,
                'percent' => $percent_tercapai
            ]);

        return redirect('assessment/'.$survey_id);
    }

    public function ajax_get_list_user($id,$condition)
    {
        if($condition == 'no'){
            echo json_encode(DB::table('users')->where('id','<>',Auth::user()->id)->get());
        }elseif($condition == 'all'){
            echo json_encode(DB::table('users')->get());
        }elseif($condition == 'task'){
            $users = DB::Select("SELECT a.id, a.username FROM users a
                                LEFT JOIN surveys b ON b.id = $id
                                LEFT JOIN survey_members c ON c.survey = b.id
                                WHERE a.id = b.created_by || a.id = c.user
                                GROUP BY a.id, a.username");
            echo json_encode($users);
        }elseif($condition == 'user_survey'){
            $survey_members = DB::table('survey_members')
                ->select('survey_members.user','survey_members.role','users.username')
                ->leftJoin('users','users.id','=','survey_members.user')
                ->where([
                    ['survey','=',$id]
                ])
                ->get();

            $survey_creator = DB::table('surveys')
                ->select('surveys.created_by as user',DB::raw("'0-Creator' as role"),'users.username')
                ->leftJoin('users','users.id','=','surveys.created_by')
                ->where([
                    ['surveys.id','=',$id]
                ])
                ->get();
            return array_merge(json_decode($survey_creator), json_decode($survey_members));
        }else{
            $users = DB::Select("SELECT * FROM users where id not in (select user from survey_members where survey = $condition) and id <> (select created_by from surveys where id = $condition)");
            echo json_encode($users);
        }
    }

    public function task($id)
    {
        $data['survey_id'] = $id;

        $data['status_ownership'] = Survey::get_status_ownership($id);

        $priority = array();
        $priority['1-High'] = "!!!";
        $priority['2-Medium'] = "!!";
        $priority['3-Low'] = "!";
        $data['priorities'] = $priority;

        $data_survey = DB::table('surveys')
            ->select('surveys.id')
            ->where('surveys.id',$id)
            ->get();

        $data['survey_members'] = $this->ajax_get_list_user($id, 'user_survey');

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

    public function get_task_by_id($id,$task_id){
        $tasks = DB::table('tasks')
                ->select("*",DB::raw('DATE_FORMAT(tasks.due_date, "%m/%d/%Y %l:%i %p") as due_dates'))
                ->where([
                    ['id','=',$task_id],
                    ['survey','=',$id]
                ])
                ->get()
                ->first();

        $task_participant = DB::table('task_participant')
                ->select('team_member')
                ->where([
                    ['task','=',$task_id]
                ])
                ->get();
        return response()->json([
            'tasks' => json_encode($tasks),
            'task_participant' => json_encode($task_participant)
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
            'i_n_name_survey' => 'required|unique:surveys,name|max:255',
            'i_n_surveyor' => 'required',
            'i_n_client' => 'required',
            // 'i_n_survey_type' => 'required',
            'drivers_purpose' => 'required_without:drivers_pain',
            'i_n_expire' => 'required',
            'i_itgoal' => 'required'
            ],
            [
                'i_n_name_survey.required' => '&#8226;The <span class="text-danger">New Assessment Name</span> field is required',
                'i_n_name_survey.unique' => '&#8226;The <span class="text-danger">Assessment Name</span> already exists',
                'i_n_surveyor.required' => '&#8226;The <span class="text-danger">Manager</span> field is required',
                'i_n_client.required' => '&#8226;The <span class="text-danger">Assessor</span> field is required',
                // 'i_n_survey_type.required' => '&#8226;The <span class="text-danger">Survey Type</span> field is required',
                'drivers_purpose.required_without' => '&#8226;The <span class="text-danger">Drivers</span> field is required',
                'i_n_expire.required' => '&#8226;The <span class="text-danger">Expire</span> field is required',
                'i_itgoal.required' => '&#8226;The <span class="text-danger">It Goal</span> is required',
            ]
        );

        if ($validator->fails()) {
            return json_encode([
                'status' => 0,
                'messages' => implode("<br>",$validator->messages()->all())
            ]);
        }
        $survey_purpose = $request->post('drivers_purpose');
        $survey_pain = $request->post('drivers_pain');

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
                    $surveymembers->role = "1-Manager";
                    $surveymembers->save();
                }                
            }
            if($request->get('i_n_client')){
                foreach ($request->get('i_n_client') as $client) {
                    $surveymembers = new \App\Models\SurveyMembers;
                    $surveymembers->user = $client;
                    $surveymembers->survey = $id;
                    $surveymembers->role = "2-Assessor";
                    $surveymembers->save();
                }
            }
            if($request->get('i_itgoal')){
                if($survey_purpose){
                    foreach ($request->get('i_itgoal')[$survey_purpose] as $itgoal){
                        $id_itgoal = DB::table('it_related_goal')->insertGetId(
                            [   'it_goal' => $itgoal, 
                                'survey' => $id
                            ]
                        );
                        if($request->get('i_itgoal_process')[$survey_purpose]){
                            foreach($request->get('i_itgoal_process')[$survey_purpose][$itgoal] as $itgoalprocess){
                                    $survey_process = DB::table('survey_process')->insertGetId(
                                        [   
                                            'it_related_goal' => $id_itgoal,
                                            'process' => $itgoalprocess,
                                            'survey' => $id,
                                            'target_level' => $request->get('i_itgoal_process_level')[$survey_purpose][$itgoal][$itgoalprocess],
                                            'target_percent' => $request->get('i_itgoal_process_percent')[$survey_purpose][$itgoal][$itgoalprocess],
                                            'status' => '1-Waiting'
                                        ]
                                    );
                            }
                        }
                    }
                }

                if($survey_pain){
                    foreach ($request->get('i_itgoal')[$survey_pain] as $itgoal){
                        $id_itgoal = DB::table('it_related_goal')->insertGetId(
                            [   'it_goal' => $itgoal, 
                                'survey' => $id
                            ]
                        );
                        if($request->get('i_itgoal_process')[$survey_pain]){
                            foreach($request->get('i_itgoal_process')[$survey_pain][$itgoal] as $itgoalprocess){
                                    $survey_process = DB::table('survey_process')->insertGetId(
                                        [   
                                            'it_related_goal' => $id_itgoal,
                                            'process' => $itgoalprocess,
                                            'survey' => $id,
                                            'target_level' => $request->get('i_itgoal_process_level')[$survey_pain][$itgoal][$itgoalprocess],
                                            'target_percent' => $request->get('i_itgoal_process_percent')[$survey_pain][$itgoal][$itgoalprocess],
                                            'status' => '1-Waiting'
                                        ]
                                    );
                            }
                        }
                    }
                }
            }

            $notification = new \App\Models\Notifications;
            $notification->notification_text = "@".Auth::user()->username." Created New Assessment : ".$request->post('i_n_name_survey');
            $notification->modul = '2-Survey';
            $notification->modul_id = $id;
            $notification->created_by = Auth::user()->id;
            $notification->notification_start = Carbon::now()->toDateTimeString();
            $notif_post = $notification->save();

            if($request->get('i_n_surveyor') && $notif_post){
                foreach ($request->get('i_n_surveyor') as $surveyor) {
                    $notificationReceivers = new \App\Models\NotificationReceivers;
                    $notificationReceivers->notification = $notification->id;
                    $notificationReceivers->receiver = $surveyor;
                    $notificationReceivers->is_read = 0;
                    $notificationReceivers->created_by = Auth::user()->id;
                    $notificationReceivers->save();

                    broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));
                }                
            }
            if($request->get('i_n_client') && $notif_post){
                foreach ($request->get('i_n_client') as $client) {
                    $notificationReceivers = new \App\Models\NotificationReceivers;
                    $notificationReceivers->notification = $notification->id;
                    $notificationReceivers->receiver = $client;
                    $notificationReceivers->is_read = 0;
                    $notificationReceivers->created_by = Auth::user()->id;
                    $notificationReceivers->save();

                    broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));
                }
            }

            $chatRoom = new \App\Models\ChatRoom;
            $chatRoom->name = $request->post('i_n_name_survey');
            $chatRoom->chat_type = '3-Survey';
            $chatRoom->survey = $id;
            $chatRoom->created_by = Auth::user()->id;
            $chatRoom_post = $chatRoom->save();

            if($chatRoom_post){
                $chatMember = new \App\Models\ChatMember;
                $chatMember->chat_room = $chatRoom->id;
                $chatMember->user = Auth::user()->id;
                $chatMember->unread_messages = 0;
                $chatMember->created_by = Auth::user()->id;
                $chatMember->save();

                if($request->get('i_n_surveyor')){
                    foreach ($request->get('i_n_surveyor') as $surveyor) {
                        $chatMember = new \App\Models\ChatMember;
                        $chatMember->chat_room = $chatRoom->id;
                        $chatMember->user = $surveyor;
                        $chatMember->unread_messages = 0;
                        $chatMember->created_by = Auth::user()->id;
                        $chatMember->save();
                    }                
                }
                if($request->get('i_n_client')){
                    foreach ($request->get('i_n_client') as $client) {
                        $chatMember = new \App\Models\ChatMember;
                        $chatMember->chat_room = $chatRoom->id;
                        $chatMember->user = $client;
                        $chatMember->unread_messages = 0;
                        $chatMember->created_by = Auth::user()->id;
                        $chatMember->save();
                    }
                }
            }

            return json_encode([
                'status' => 1,
                'messages' => '/assessment/'.$id
            ]);
        }

        return json_encode([
            'status' => 0,
            'messages' => 'Create Assessment Failed'
        ]);
    }

    public function invite($id, Request $request){
        $validator = Validator::make(
            $request->all(), [
                'inv_responden' => 'required_without:inv_surveyor',
            ],
            [
                'inv_responden.required_without' => '&#8226;The <span class="text-danger">Manager or Assessor</span> field is required',
            ]
        );

        if ($validator->fails()) {
            return json_encode([
                'status' => 0,
                'messages' => implode("<br>",$validator->messages()->all())
            ]);
        }

        $survey_name = DB::table('surveys')->select('name')->where('id','=',$id)->get()->first()->name;

        $notification = new \App\Models\Notifications;
        $notification->notification_text = "@".Auth::user()->username." Invited you to Assessment : ".$survey_name;
        $notification->modul = '2-Survey';
        $notification->modul_id = $id;
        $notification->created_by = Auth::user()->id;
        $notification->notification_start = Carbon::now()->toDateTimeString();
        $notif_post = $notification->save();

        $chat_rooms_id = DB::table('chat_rooms')->select('id')->where('survey','=',$id)->get()->first()->id;

        if($request->get('inv_surveyor')){
            foreach ($request->get('inv_surveyor') as $surveyor) {
                $surveymembers = new \App\Models\SurveyMembers;
                $surveymembers->user = $surveyor;
                $surveymembers->survey = $id;
                $surveymembers->role = "1-Manager";
                $surveymembers->save();

                $chatMember = new \App\Models\ChatMember;
                $chatMember->chat_room = $chat_rooms_id;
                $chatMember->user = $surveyor;
                $chatMember->unread_messages = 0;
                $chatMember->created_by = Auth::user()->id;
                $chatMember->save();

                if($notif_post){
                    $notificationReceivers = new \App\Models\NotificationReceivers;
                    $notificationReceivers->notification = $notification->id;
                    $notificationReceivers->receiver = $surveyor;
                    $notificationReceivers->is_read = 0;
                    $notificationReceivers->created_by = Auth::user()->id;
                    $notificationReceivers->save();

                    broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));
                }
            } 
        }               

        if($request->get('inv_responden')){
            foreach ($request->get('inv_responden') as $responden) {
                $surveymembers = new \App\Models\SurveyMembers;
                $surveymembers->user = $responden;
                $surveymembers->survey = $id;
                $surveymembers->role = "2-Assessor";
                $surveymembers->save();
                
                $chatMember = new \App\Models\ChatMember;
                $chatMember->chat_room = $chat_rooms_id;
                $chatMember->user = $responden;
                $chatMember->unread_messages = 0;
                $chatMember->created_by = Auth::user()->id;
                $chatMember->save();

                if($notif_post){
                    $notificationReceivers = new \App\Models\NotificationReceivers;
                    $notificationReceivers->notification = $notification->id;
                    $notificationReceivers->receiver = $responden;
                    $notificationReceivers->is_read = 0;
                    $notificationReceivers->created_by = Auth::user()->id;
                    $notificationReceivers->save();

                    broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));
                }
            }
        }
        
        return json_encode([
            'status' => 1,
            'messages' => '/assessment/'.$id
        ]);
    }

    public function task_store(Request $request){

        $validator = Validator::make(
            $request->all(), [
            'i_n_name_task' => 'required|unique:tasks,name|max:255',
            'i_n_priority' => 'required',
            'i_n_due_date' => 'required',
            'i_n_assignee' => 'required',
            'i_n_participant' => 'required',
            'i_n_detail' => 'required'
            ],
            [
                'i_n_name_task.required' => '&#8226;The <span class="text-danger">New Task Name</span> field is required',
                'i_n_name_task.unique' => '&#8226;The <span class="text-danger">Task Name</span> already exists',
                'i_n_priority.required' => '&#8226;The <span class="text-danger">Task Priority</span> field is required',
                'i_n_due_date.required' => '&#8226;The <span class="text-danger">Task Due Date</span> field is required',
                'i_n_assignee.required' => '&#8226;The <span class="text-danger">Task Assignee</span> field is required',
                'i_n_participant.required' => '&#8226;The <span class="text-danger">Task Participants</span> field is required',
                'i_n_detail.required' => '&#8226;The <span class="text-danger">Task Detail</span> field is required',
            ]
        );

        if ($validator->fails()) {
            return json_encode([
                'status' => 0,
                'messages' => implode("<br>",$validator->messages()->all())
            ]);
        }

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

            $survey_name = DB::table('surveys')->select('name')->where('id','=',$request->post('i_n_survey_id'))->get()->first()->name;

            $notification = new \App\Models\Notifications;
            $notification->notification_text = "@".Auth::user()->username." Added you to Task : ".$request->post('i_n_name_task')." on Survey : ".$survey_name;
            $notification->modul = '2-Survey';
            $notification->modul_id = $request->post('i_n_survey_id');
            $notification->created_by = Auth::user()->id;
            $notification->notification_start = Carbon::now()->toDateTimeString();
            $notif_post = $notification->save();

            $notificationReceivers = new \App\Models\NotificationReceivers;
            $notificationReceivers->notification = $notification->id;
            $notificationReceivers->receiver = $request->post('i_n_assignee');
            $notificationReceivers->is_read = 0;
            $notificationReceivers->created_by = Auth::user()->id;
            $notificationReceivers->save();

            broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));

            foreach ($request->get('i_n_participant') as $participant) {
                $taskparticipants = new \App\Models\TaskParticipants;
                $taskparticipants->task = $id;
                $taskparticipants->team_member = $participant;
                $taskparticipants->save();

                if($notif_post){
                    $notificationReceivers = new \App\Models\NotificationReceivers;
                    $notificationReceivers->notification = $notification->id;
                    $notificationReceivers->receiver = $participant;
                    $notificationReceivers->is_read = 0;
                    $notificationReceivers->created_by = Auth::user()->id;
                    $notificationReceivers->save();

                    broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));
                }
            }
        }

        return json_encode([
            'status' => 1,
            'messages' => '/assessment/'.$request->post('i_n_survey_id').'/task/'
        ]);
    }

    public function task_update($id,$task_id,Request $request){
        $validator = Validator::make(
            $request->all(), [
            'i_n_name_task' => 'required|max:255|unique:tasks,name,'.$task_id,
            'i_n_priority' => 'required',
            'i_n_due_date' => 'required',
            'i_n_assignee' => 'required',
            'i_n_participant' => 'required',
            'i_n_detail' => 'required'
            ],
            [
                'i_n_name_task.required' => '&#8226;The <span class="text-danger">New Task Name</span> field is required',
                'i_n_name_task.unique' => '&#8226;The <span class="text-danger">Task Name</span> already exists',
                'i_n_priority.required' => '&#8226;The <span class="text-danger">Task Priority</span> field is required',
                'i_n_due_date.required' => '&#8226;The <span class="text-danger">Task Due Date</span> field is required',
                'i_n_assignee.required' => '&#8226;The <span class="text-danger">Task Assignee</span> field is required',
                'i_n_participant.required' => '&#8226;The <span class="text-danger">Task Participants</span> field is required',
                'i_n_detail.required' => '&#8226;The <span class="text-danger">Task Detail</span> field is required',
            ]
        );

        if ($validator->fails()) {
            return json_encode([
                'status' => 0,
                'messages' => implode("<br>",$validator->messages()->all())
            ]);
        }

        $task = Task::find($task_id);

        $assignee = $task->assign;

        $task->survey       = $request->post('i_n_survey_id');
        $task->name         = $request->post('i_n_name_task');
        $task->assign       = $request->post('i_n_assignee');
        $task->due_date     = Carbon::createFromFormat('m/d/Y h:i A', $request->post('i_n_due_date'))->format('Y-m-d H:i');
        $task->detail       = $request->post('i_n_detail');
        $task->color        = $request->post('i_n_color');
        $task->progress     = $request->post('i_n_progress');
        $task->priority     = $request->post('i_n_priority');
        $task->created_by   = Auth::user()->id;
        $post               = $task->save();
        if($post){

            $survey_name = DB::table('surveys')->select('name')->where('id','=',$request->post('i_n_survey_id'))->get()->first()->name;

            if($assignee != $request->post('i_n_assignee')){
                $notification = new \App\Models\Notifications;
                $notification->notification_text = "@".Auth::user()->username." Added you to Task : ".$request->post('i_n_name_task')." on Assessment : ".$survey_name." as Assignee";
                $notification->modul = '2-Survey';
                $notification->modul_id = $request->post('i_n_survey_id');
                $notification->created_by = Auth::user()->id;
                $notification->notification_start = Carbon::now()->toDateTimeString();
                $notif_post = $notification->save();

                $notificationReceivers = new \App\Models\NotificationReceivers;
                $notificationReceivers->notification = $notification->id;
                $notificationReceivers->receiver = $request->post('i_n_assignee');
                $notificationReceivers->is_read = 0;
                $notificationReceivers->created_by = Auth::user()->id;
                $notificationReceivers->save();

                broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));
            }

            foreach ($request->get('i_n_participant') as $participant) {
                $available = \App\Models\TaskParticipants::where([
                    ['task','=',$task_id],
                    ['team_member','=',$participant]
                ]);
                if(!$available->first()){
                    $notification = new \App\Models\Notifications;
                    $notification->notification_text = "@".Auth::user()->username." Added you to Task : ".$request->post('i_n_name_task')." on Assessment : ".$survey_name." as Participant";
                    $notification->modul = '2-Survey';
                    $notification->modul_id = $request->post('i_n_survey_id');
                    $notification->created_by = Auth::user()->id;
                    $notification->notification_start = Carbon::now()->toDateTimeString();
                    $notif_post = $notification->save();

                    $notificationReceivers = new \App\Models\NotificationReceivers;
                    $notificationReceivers->notification = $notification->id;
                    $notificationReceivers->receiver = $participant;
                    $notificationReceivers->is_read = 0;
                    $notificationReceivers->created_by = Auth::user()->id;
                    $notificationReceivers->save();

                    broadcast(new NewNotification($notification, $notificationReceivers, Auth::user()));
                }
            }

            $deletedRows = \App\Models\TaskParticipants::where('task', $task_id)->delete();
            foreach ($request->get('i_n_participant') as $participant) {
                $taskparticipants = new \App\Models\TaskParticipants;
                $taskparticipants->task = $task_id;
                $taskparticipants->team_member = $participant;
                $taskparticipants->save();
            }
        }

        return json_encode([
            'status' => 1,
            'messages' => '/assessment/'.$id.'/task/'
        ]);
    }

    //AGGREGATION
    public function getData(Request $request){
        $message = "success";
        $status = "success";

        try {
            $surveyProcess = DB::table("surveys")
                ->leftJoin('survey_process','surveys.id','survey_process.survey')
                ->where('surveys.id',$request->surveyid)
                ->get();

            $surveyProcessOutcomes = SurveyProcessOutcomes::
                select('process_outcome.process','survey_process_outcomes.it_related_goal')
                ->leftJoin('process_outcome','process_outcome.id','survey_process_outcomes.process_outcome')
                ->leftJoin('outcomes','outcomes.id','process_outcome.outcome')
                ->leftJoin('process_attributes','outcomes.process_attribute','process_attributes.id')
                ->where('survey_process_outcomes.survey',$request->surveyid)
                ->groupBy('process_outcome.process','survey_process_outcomes.it_related_goal')
                ->get();

            $SurveyProcessOutcomes2 = $this->populateDetail($surveyProcessOutcomes, $request->surveyid);

            return response()->json([
                'status' => $status,
                'message' => $message,
                'surveyProcess'  => $surveyProcess,
                'surveyProcessOutcomes' => $SurveyProcessOutcomes2
            ]);
        } catch (\HttpException $e) {
            $status = "failed";
            $message = $e->getMessage();
            return response()->json([
                'status' => $status,
                'message' => $message,
                'surveyProcess'  => null,
                'surveyProcessOutcomes' => null
            ]);         
        }
    }

    function populateDetail($surveyProcessOutcomess, $surveyid){
        $surveyProcessOutcomes = array();
        foreach ($surveyProcessOutcomess as $value) {
            $surveyProcessOutcome = new surveyProcessOutcomes;
            $percent = 0;
            $name = "";
            $surveyProcessOutcome->process = $value->process;
            $surveyProcessOutcome->it_related_goal = $value->it_related_goal;
            for ($i=1; $i <= 5; $i++) { 
                # code...
                $a = SurveyProcessOutcomes::
                select('process_outcome.process','survey_process_outcomes.it_related_goal',DB::raw('avg(survey_process_outcomes.percent) as percent'))
                ->leftJoin('process_outcome','process_outcome.id','survey_process_outcomes.process_outcome')
                ->leftJoin('outcomes','outcomes.id','process_outcome.outcome')
                ->leftJoin('process_attributes','outcomes.process_attribute','process_attributes.id')
                ->where('survey_process_outcomes.survey',$surveyid)
                ->where('process_outcome.process',$value->process)
                ->where('survey_process_outcomes.it_related_goal',$value->it_related_goal)
                ->where('survey_process_outcomes.acceptance','agree')
                ->where('process_attributes.level',$i)
                ->groupBy('process_outcome.process','survey_process_outcomes.it_related_goal')
                ->first();

                if(is_null($a)){
                    $percent = 0;
                }else{
                    $percent = $a->percent;
                    $rating = Rating::
                        select('name')
                        ->where("bottom","<=",$a->percent)
                        ->where("top",">=",$a->percent)
                        ->first();
                    if(is_null($rating)){
                        $name = "-";
                    }else{
                        $name = substr($rating->name, 0,1);
                    }
                }
                // $name = $rating->name;

                switch ($i) {
                    case 1:
                        $surveyProcessOutcome->percentLevel1 = $percent;
                        $surveyProcessOutcome->ratingLevel1 = $name;
                        break;
                    case 2:
                        $surveyProcessOutcome->percentLevel2 = $percent;
                        $surveyProcessOutcome->ratingLevel2 = $name;
                        break;
                    case 3:
                        $surveyProcessOutcome->percentLevel3 = $percent;
                        $surveyProcessOutcome->ratingLevel3 = $name;
                        break;
                    case 4:
                        $surveyProcessOutcome->percentLevel4 = $percent;
                        $surveyProcessOutcome->ratingLevel4 = $name;
                        break;
                    case 5:
                        $surveyProcessOutcome->percentLevel5 = $percent;
                        $surveyProcessOutcome->ratingLevel5 = $name;
                        break;
                    default:
                        # code...
                        break;
                }
            }

            $surveyProcessOutcomes[] = $surveyProcessOutcome;

        }

        return $surveyProcessOutcomes;
    }

    public function chat($id)
    {
        $data['survey_id'] = $id;

        $data['status_ownership'] = Survey::get_status_ownership($id);

        $data_survey = DB::table('surveys')
            ->select('surveys.id','surveys.name')
            ->where('surveys.id',$id)
            ->get();
        
        $data['survey_name'] = $data_survey->first()->name;

        $data['survey_members'] = $this->ajax_get_list_user($id, 'user_survey');

        $chatRooms = ChatRoom::
        select('chat_rooms.*','chat_room_members.*','chat_rooms.updated_at as chat_room_updated_at')
        ->join('chat_room_members','chat_room_members.chat_room','chat_rooms.id')
        ->where([
            ['user',Auth::user()->id],
            ['chat_type','=','3-Survey'],
            ['survey','=',$id]
        ])
        ->orderBy('chat_rooms.updated_at','desc')
        ->get()->first();

        $data['chatRooms'] = $chatRooms;
        $data['aUser'] = auth()->user();
        
        return view('survey.chat',$data);
    }
}
