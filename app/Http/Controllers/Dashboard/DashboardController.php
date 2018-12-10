<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

// insert models
use App\Models\Dashboard;
use App\Models\Dashboard_users;

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
        $data['surveys']       = $list_survey->toArray();
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

    public function storecharts(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id;

        $charts = Dashboard_charts::create($input);
        if($charts) {
            return redirect()->route('dashboard')->with(['success'=>'true','message'=>'Charts berhasil ditambahkan']);
        } else {
            return redirect()->route('dashboard')->with(['success'=>'false','message'=>'Charts gagal di tambahkan']);
        }
    }

    public function postStaff (StaffRequest $request)
    {
        $input = $request->all();
        $input['status_staff'] = "active";
        if(!$input['id']) {
            $staff = Staff::create($input);

            return redirect()->route('admin.staff.data')->with(['message'=>'Staff sudah ditambahkan']);
        } else {
            $staff = Staff::find($input['id']);
            $staff->update($input);

            return redirect()->route('admin.staff.data')->with(['message'=>'Staff sudah diupdate']);
        }
    }

}
