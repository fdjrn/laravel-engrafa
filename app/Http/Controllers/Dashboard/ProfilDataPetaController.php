<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\ProfilDataPetaApi;

class ProfilDataPetaController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Profil Data Peta';
        $viewData['pageTitle'] = 'Dasbor Profil Data Peta';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_OP_PBB_NON_PERSIL'  => route('get-op-pbb-non-persil'),
            'URI_GET_OP_NON_PBB_TANPA_PETA_LOKASI'  => route('get-op-non-pbb-tanpa-peta-lokasi'),
            'URI_GET_OP_MUTAKHIR'  => route('get-op-mutakhir'),
            'URI_GET_SEBARAN_OP_TANPA_PERSIL' => route('get-sebaran-op-pbb-tanpa-persil'),
        ];

        return view('dashboard.profilDataPeta', $viewData);
    }

    public function getOpPBBNonPersil(Request $request)
    {
        $resultDataResponse = ProfilDataPetaApi::getOpPBBNonPersil();
        return response()->json($resultDataResponse);
    }

    public function getOpNonPBBTanpaPetaLokasi(Request $request)
    {
        $resultDataResponse = ProfilDataPetaApi::getOpNonPBBTanpaPetaLokasi();
        return response()->json($resultDataResponse);
    }

    public function getOpMutakhir(Request $request)
    {
        $resultDataResponse = ProfilDataPetaApi::getOpMutakhir();
        return response()->json($resultDataResponse);
    }

    public function getSebaranOpPBBTanpaPersil(Request $request)
    {
        $resultDataResponse = ProfilDataPetaApi::getSebaranOpPBBTanpaPersil();
        return response()->json($resultDataResponse);
    }
}
