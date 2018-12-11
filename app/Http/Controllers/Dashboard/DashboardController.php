<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Auth;

class DashboardController extends Controller
{
    //
    public function index(Request $Request){
        $role   = Auth::user()->role;
        $userid = Auth::user()->id;

        $name_dashboard = DB::table('dashboards')
        ->select('dashboards.id','dashboards.name')
        ->leftJoin('dashboard_users','dashboard_users.dashboard','=','dashboards.id')
        ->where('dashboard_users.user',$userid)
        ->get();

        $data['dashboards'] = $name_dashboard->toArray();

    	return view('dashboard/dashboard')->with($data); 
    }

    public function store()
    {
        dd('test');
        $this->validate(request(), [
            'name' => 'required'
        ]);
        
        Post::create([
            'name' => request('name_dashboard')
        ]);
        
        return view('dashboard/dashboard')->with('success', 'Nama Dashboard di tambahkan');
    }
}
