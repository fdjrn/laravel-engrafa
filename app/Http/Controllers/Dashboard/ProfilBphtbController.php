<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\PiutangApi;

class ProfilBphtbController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Profil BPHTB';
        $viewData['pageTitle'] = 'Dasbor Profil BPHTB';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),

        ];

        $year = PiutangApi::getPiutangTahun('');
        $viewData['all_year'] = $year->data;

        return view('dashboard.profilBphtb', $viewData);
    }

    

}
