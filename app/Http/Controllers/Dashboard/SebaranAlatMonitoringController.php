<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\PiutangApi;

class SebaranAlatMonitoringController extends Controller
{
    public function __construct(){

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $viewData = array();
        $viewData['documentTitle'] = 'Online Transaction Monitoring - Sebaran Alat Monitoring';
        $viewData['pageTitle'] = 'Dasbor Sebaran Alat Monitoring';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),

        ];

        $year = PiutangApi::getPiutangTahun('');
        $viewData['all_year'] = $year->data;

        return view('dashboard.sebaranAlatMonitoring', $viewData);
    }

    

}
