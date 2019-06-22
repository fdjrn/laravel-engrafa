<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\MonitoringRealApi;

class MonitoringRealController extends Controller
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
        $viewData['documentTitle'] = 'Online Transaction Monitoring - Monitoring Real';
        $viewData['pageTitle'] = 'Dasbor Monitoring Real';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_TRANSAKSI_KASIR_HARI_INI' => route('get-transaksi-kasir-hari-ini'),
            'URI_POST_ALAT_TIDAK_KIRIM_DATA' => route('get-alat-tidak-kirim-data'),
            'URI_POST_POTENSI_SINYAL_JELEK' => route('get-potensi-sinyal-jelek'),

        ];

        return view('dashboard.monitoringReal', $viewData);
    }

    public function getTransaksiKasirHariIni(Request $request)
    {
        $resultDataResponse = MonitoringRealApi::getTransaksiKasirHariIni();
        return response()->json($resultDataResponse);
    }

    public function getAlatTidakKirimData(Request $request)
    {
        $page = 1;

        $resultDataResponse = MonitoringRealApi::getAlatTidakKirimData($page);
        return response()->json($resultDataResponse);
    }

    public function getPotensiSinyalJelek(Request $request)
    {
        $page = 1;

        $resultDataResponse = MonitoringRealApi::getPotensiSinyalJelek($page);
        return response()->json($resultDataResponse);
    }
}
