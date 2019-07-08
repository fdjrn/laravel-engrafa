<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\AnalisisPotensiKenaikanApi;

class AnalisisPotensiKenaikanController extends Controller
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
        $viewData['documentTitle'] = 'Online Transaction Monitoring - Analisis Potensi Kenaikan';
        $viewData['pageTitle'] = 'Dasbor Analisis Potensi Kenaikan';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_TOP_10_KONTRIBUTOR_OP_PBB'  => route('get-top-10-kontributor-op-pbb'),
        ];

        return view('dashboard.analisisPotensiKenaikan', $viewData);
    }

}