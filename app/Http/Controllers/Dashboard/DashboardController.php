<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

// insert models
use App\Models\Dashboard;
use App\Models\Dashboard_users;
use App\Models\Dashboard_charts;
use App\Models\Dashboard_survey;

use Auth;

class DashboardController extends Controller
{
    public function index(Request $Request){
        $userid = Auth::user()->id;

        // tab nama dashboard
        $name_dashboard = DB::table('dashboards')
        ->select('dashboards.id','dashboards.name')
        ->leftJoin('dashboard_users','dashboard_users.dashboard','=','dashboards.id')
        ->where('dashboard_users.user',$userid)
        ->get();

        // list survey untuk dropdown pilih survey
        $list_survey = DB::table('surveys')
        ->select('id','name')
        ->get();

        // list chart type
        $list_chart_type = DB::table('chart_type')
        ->select('chart_type','name')
        ->get();

        //test menampilkan data ke grafik
        $surveyProcess = DB::table("surveys")
        ->leftJoin('survey_process','surveys.id','survey_process.survey')
        ->where('surveys.id',1)
        ->get()->toArray();

        $arrayProcess = array();
        $arrayLevel = array();
        $arrayTarget_level = array();
        $arrayPercent = array();
        $arrayTarget_percent = array();

        if (sizeof($surveyProcess)>0) {
            for ($i=0; $i < sizeof($surveyProcess); $i++) { 
                $arrayProcess[] = $surveyProcess[$i]->process;
                $arrayLevel[] = $surveyProcess[$i]->level;
                $arrayTarget_level[] = $surveyProcess[$i]->target_level;
                $arrayPercent[] = $surveyProcess[$i]->percent;
                $arrayTarget_percent[] = $surveyProcess[$i]->target_percent;
            }
        }
        // dd($arrayProcess);
        
        $data['dashboards']    = $name_dashboard->toArray();
        $data['surveys']       = $list_survey;
        $data['chart_type']    = $list_chart_type->toArray();

        $data['labels']        = $arrayProcess;
        $data['level']         = $arrayLevel;

    	return view('dashboard/dashboard')->with($data); 
    }

    /**
     * store(Request $request)
     * deskripsi : fungsi untuk tambah dasboard, fungsi ini ng insert ke 2 tabel, yaitu tabel dashboard dan dashboard_users
     * @return $message
     */
    
    public function store(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id;

        $dashboard = Dashboard::create($input);
        if($dashboard){
            $input_dashboard_users = [
                'user' => $userid,
                'dashboard' => $dashboard->id,
            ];
            $dashboard_users = Dashboard_users::create($input_dashboard_users);
            return redirect()->route('dashboard')->with(['success'=>'true','message'=>'Dashboard berhasil ditambahkan']);
        }else{
            return redirect()->route('dashboard')->with(['success'=>'false','message'=>'Dashboard gagal di tambahkan']);
        }
    }

    public function storeCharts(Request $request)
    {
        $input = $request->all();
        
        $input_dashboard_chart = [
            'dashboard' => $input['id_dashboard'],
            'name' => $input['name'],
            'chart_type' => $input['chart']
        ];

        $userid = Auth::user()->id;

        $charts = Dashboard_charts::create($input_dashboard_chart);
        if ($charts) {
            $count_survey = count($input['survey']);
            for ($i=0; $i < $count_survey; $i++) { 
                $input_dashboard_survey = [
                    'survey' => $input['survey'][$i],
                    'chart' => $charts->id // get last insert id from charts 
                ];
                
                $dashboard_survey = Dashboard_survey::create($input_dashboard_survey);
            }

            if ($dashboard_survey) {
                return redirect()->route('dashboard')->with(['success'=>'true','message'=>'Charts berhasil ditambahkan']);
            } else {
                return redirect()->route('dashboard')->with(['success'=>'false','message'=>'Gagal input ke tabel Dashboard Survey']);
            }
        } else {
            return redirect()->route('dashboard')->with(['success'=>'false','message'=>'Gagal input ke tabel Survey']);
        }
    }

    public function ajax_get_list_user()
    {
       
       $list_user = DB::table('users')->get();
       
       echo json_encode($list_user);
    }

    public function ajax_get_dashboard(Request $request)
    {
        $userid         = Auth::user()->id;
        $dashboardid    = $request->id;

        // ambil id user yang terdaftar di dashboard
        $users_dashboard = DB::table('dashboard_users')
        ->where('dashboard', $dashboardid)
        ->where('user',$userid)->get();

        // cek jika user terdaftar di dashboard maka tampilkan dashboard dan grafik
        if ($users_dashboard) {
            $charts = DB::table("charts")
            ->where('dashboard',$dashboardid)
            ->get();

            $labels = DB::table("charts")
            ->select('charts.id as charts_id', 'surveys.name', 'surveys.id as surveys_id')
            ->leftJoin('dashboard_surveys','charts.id','dashboard_surveys.chart')
            ->leftJoin('surveys','dashboard_surveys.survey','surveys.id')
            ->where('charts.dashboard',$dashboardid)
            ->get();

            $dashboard_surveys = DB::table("charts")
            ->select('charts.id as charts_id','surveys.id as surveys_id','survey_process.process', 'survey_process.target_level', 'survey_process.level', 'survey_process.target_percent', 'survey_process.percent')
            ->leftJoin('dashboard_surveys','charts.id','dashboard_surveys.chart')
            ->leftJoin('surveys','dashboard_surveys.survey','surveys.id')
            ->leftJoin('survey_process','surveys.id','survey_process.survey')
            ->where('charts.dashboard',$dashboardid)
            ->get();
        } else {
            $charts = "";
            $labels = "";
            $dashboard_surveys = "";
        }

        $data = array (
            'charts' => $charts,
            'labels' => $labels,
            'process' => $dashboard_surveys
        );

        return response()->json($data);
    }

    public function ajax_delele_dashboard(Request $request)
    {
        $userid = Auth::user()->id;

        $delete_dashboard = DB::table('dashboards')->where('id', '=', $request->dashboard_id)->delete();
        $delete_dashboard_users = DB::table('dashboard_users')->where('dashboard', '=', $request->dashboard_id)->delete();

        if ($delete_dashboard && $delete_dashboard_users) {
            $response = 1;
        } else {
            $response = 0;
        }

        return response()->json($response);
    }

    public function ajax_share_to(Request $request) {
        $userid = Auth::user()->id;

        foreach ($request->iduser as $k => $v) {
            $input_dashboard_users = [
                'dashboard' => $request->dashboard_id,
                'user' => $v,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $insert_users_to_dashboard = DB::table('dashboard_users')->insert($input_dashboard_users);
        }

        if ($insert_users_to_dashboard) {
            $response = 1;
        } else {
            $response = 0;
        }

        return response()->json($response);
    }
}
