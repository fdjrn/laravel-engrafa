<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\ProfilObjekPajakApi;

class ProfilObjekPajakController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Profil Objek Pajak';
        $viewData['pageTitle'] = 'Dasbor Profil Objek Pajak';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_OP_TERDAFTAR'  => route('get-op-terdaftar'),
            'URI_GET_WP_TERDAFTAR'  => route('get-wp-terdaftar'),
            'URI_GET_SEBARAN_OP_KECAMATAN'  => route('get-sebaran-op-kecamatan'),
            'URI_GET_JUMLAH_OBJEK_PAJAK'  => route('get-jumlah-objek-pajak'),
            'URI_GET_SEBARAN_OP_JENIS'  => route('get-sebaran-op-jenis'),
            'URI_GET_TOP_10_KONTRIBUTOR_OP_PBB'  => route('get-top-10-kontributor-op-pbb'),
            'URI_GET_TOP_10_KONTRIBUTOR_OP_NON_PBB'  => route('get-top-10-kontributor-op-nonpbb'),
            'URI_GET_SEBARAN_OP_TABULAR' => route('get-sebaran-op-tabular')
        ];

        return view('dashboard.profilObjekPajak', $viewData);
    }

    public function getOpTerdaftar(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getOpTerdaftar();
        return response()->json($resultDataResponse);
    }

    public function getWpTerdaftar(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getWpTerdaftar();
        return response()->json($resultDataResponse);
    }

    public function getSebaranOpKecamatan(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getSebaranOpKecamatan();
        return response()->json($resultDataResponse);
    }

    public function getJumlahObjekPajak(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getJumlahObjekPajak();
        return response()->json($resultDataResponse);
    }

    public function getSebaranOpJenis(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getSebaranOpJenis();
        return response()->json($resultDataResponse);
    }

    public function getTop10KontributorOpPbb(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getTop10KontributorOpPbb();
        return response()->json($resultDataResponse);
    }

    public function getTop10KontributorOpNonPbb(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getTop10KontributorOpNonPbb();
        return response()->json($resultDataResponse);
    }

    public function getSebaranOpTabular(Request $request)
    {
        $resultDataResponse = ProfilObjekPajakApi::getSebaranOpTabular();
        return response()->json($resultDataResponse);
    }
}
