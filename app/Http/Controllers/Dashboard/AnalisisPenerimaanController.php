<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\AnalisisPenerimaanApi;

class AnalisisPenerimaanController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Analisis Penerimaan';
        $viewData['pageTitle'] = 'Dasbor Analisis Penerimaan';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_PENERIMAAN_HARI_INI'  => route('get-penerimaan-hari-ini'),
            'URI_GET_PENERIMAAN_WAKTU_PEMBAYARAN'  => route('get-penerimaan-waktu-pembayaran'),
            'URI_GET_PENERIMAAN_KECAMATAN'  => route('get-penerimaan-kecamatan'),
            'URI_GET_PENERIMAAN_BULANAN'  => route('get-penerimaan-bulanan')
        ];

        return view('dashboard.analisisPenerimaan', $viewData);
    }

    public function getPenerimaanHariIni(Request $request)
    {
        $resultDataResponse = AnalisisPenerimaanApi::getPenerimaanHariIni();
        return response()->json($resultDataResponse);
    }

    public function getPenerimaanWaktuPembayaran(Request $request)
    {
        $resultDataResponse = AnalisisPenerimaanApi::getPenerimaanWaktuPembayaran();
        return response()->json($resultDataResponse);
    }

    public function getPenerimaanKecamatan(Request $request)
    {
        $resultDataResponse = AnalisisPenerimaanApi::getPenerimaanKecamatan();
        return response()->json($resultDataResponse);
    }

    public function getPenerimaanBulanan(Request $request)
    {
        $resultDataResponse = AnalisisPenerimaanApi::getPenerimaanBulanan();
        return response()->json($resultDataResponse);
    }
}
