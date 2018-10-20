<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function index(Request $Request){
    	return view('dashboard/dashboard');
    }
}
