<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\ProfilReklameApi;

class ProfilReklameController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Profil Objek Pajak Reklame';
        $viewData['pageTitle'] = 'Dasbor Profil Objek Pajak Reklame';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_OP_REKLAME_TERDAFTAR'  => route('get-op-reklame-terdaftar'),
        ];

        return view('dashboard.profilReklame', $viewData);
    }

    public function getOpTerdaftar(Request $request)
    {
        $resultDataResponse = ProfilReklameApi::getOpTerdaftar();
        return response()->json($resultDataResponse);
    }
}
