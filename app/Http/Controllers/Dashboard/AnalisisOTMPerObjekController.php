<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\AnalisisOTMPerObjekApi;

class AnalisisOTMPerObjekController extends Controller
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
        $viewData['documentTitle'] = 'Online Transaction Monitoring - Analisis per Objek';
        $viewData['pageTitle'] = 'Dasbor Analisis per Objek';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_TRANSAKSI_KASIR_HARI_INI' => route('get-transaksi-kasir-hari-ini')
        ];

        return view('dashboard.analisisOTMPerObjek', $viewData);
    }

}