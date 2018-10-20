<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\ProfilPbbApi;

class ProfilPbbController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Profil PBB';
        $viewData['pageTitle'] = 'Dasbor Profil PBB';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_PROFIL_PBB_OBJEK_TERDAFTAR'  => route('get-profil-op-pbb-objek-pbb-terdaftar'),
            'URI_GET_PROFIL_PBB_SEBARAN_OBJEK_PER_DAERAH'  => route('get-profil-op-pbb-sebaran-objek-per-daerah'),
            'URI_GET_PROFIL_PBB_OBJEK_PER_BUKU'  => route('get-profil-op-pbb-objek-pajak-per-buku'),
            'URI_GET_PROFIL_PBB_KETETAPAN_PBB'  => route('get-profil-op-pbb-ketetapan-pbb'),
            'URI_GET_PROFIL_PBB_PIUTANG_PAJAK_PBB'  => route('get-profil-op-pbb-piutang-pajak-pbb'),
            'URI_GET_PROFIL_PBB_TARGET_REALISASI_PBB'  => route('get-profil-op-pbb-target-realisasi-pbb')
        ];

        return view('dashboard.profilPbb', $viewData);
    }

    public function getProfilOpPbbObjekPbbTerdaftar(Request $request)
    {
        $resultDataResponse = ProfilPbbApi::getProfilOpPbbObjekPbbTerdaftar();

        try{
            if(!empty($resultDataResponse->data)){

                $objek_pbb_terdaftar = $resultDataResponse->data->objek_pbb_terdaftar;
                $tahun = $resultDataResponse->data->tahun;
        
                $data = [
                    "objek_pbb_terdaftar" => $objek_pbb_terdaftar,
                    "tahun" => $tahun
                ];

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        } catch (Exception $exc) {
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];

        }

        return response()->json($output);
    }

    public function getProfilOpPbbSebaranOpPbbPerDaerah(Request $request)
    {
        $resultDataResponse = ProfilPbbApi::getProfilOpPbbSebaranOpPbbPerDaerah();

        try{
            if(!empty($resultDataResponse->data)){
                
                $color = [
                    "#ffad48",
                    "#3f89df",
                    "#5bbdfb",
                    "#ffd468",
                    "#b8b8b8",
                    "#7b7b7b"
                ];

                $index = 0;
                foreach($resultDataResponse->data as $row){
                    $data [] = [
                        "y" => $row->objek_pbb_terdaftar,
                        "color" => $color[$index],
                        "name" => $row->nama_kecamatan,
                        "kode_kecamatan" => $row->kode_kecamatan
                    ];

                    $index++;
                }

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        }catch (Exception $exc) {
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];

        }

        return response()->json($output);
    }

    public function getProfilOpPbbObjekPajakPerBuku(Request $request)
    {
        $resultDataResponse = ProfilPbbApi::getProfilOpPbbObjekPajakPerBuku();

        try{
            if(!empty($resultDataResponse->data)){
                
                $color = [
                    "#7ebffc",
                    "#3f89df",
                    "#ffb55a",
                    "#fedc52",
                    "#62737c"
                ];

                $index = 0;
                foreach($resultDataResponse->data as $row){
                    $data [] = [
                        "y" => $row->objek_pbb_terdaftar,
                        "color" => $color[$index],
                        "name" => $row->nama_buku,
                        "kode_buku" => $row->kode_buku
                    ];

                    $index++;
                }

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        }catch (Exception $exc) {
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];

        }

        return response()->json($output);
    }

    public function getProfilOpPbbKetetapanPbb(Request $request)
    {
        $resultDataResponse = ProfilPbbApi::getProfilOpPbbKetetapanPbb();

        try{
            if(!empty($resultDataResponse->data)){
                
                $color = [
                    "#ffad48",
                    "#3f89df",
                    "#5bbdfb",
                    "#ffd468",
                    "#b8b8b8",
                    "#7b7b7b"
                ];

                $index = 0;
                foreach($resultDataResponse->data as $row){
                    $data [] = [
                        "y" => $row->jumlah_sppt,
                        "color" => $color[$index],
                        "name" => $row->nama_kecamatan,
                        "kode_kecamatan" => $row->kode_kecamatan
                    ];

                    $index++;
                }

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        }catch (Exception $exc) {
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];

        }

        return response()->json($output);
    }

    public function getProfilOpPbbPiutangPajakPbb(Request $request)
    {
        $resultDataResponse = ProfilPbbApi::getProfilOpPbbPiutangPajakPbb();
        
        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    $tahun[] = $row->tahun;
                    $piutang[] = $row->piutang;
                    $piutang_simplified[] = $row->piutang_simplified;
                }

                $satuan_nominal = $resultDataResponse->data[0]->satuan_nominal;

                $data = [
                    "tahun" => $tahun,
                    "piutang" => $piutang,
                    "piutang_simplified" => $piutang_simplified,
                    "satuan_nominal" => $satuan_nominal
                ];


                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        } catch (Exception $exc) {
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];

        }


        return response()->json($output);
    }

    public function getProfilOpPbbTargetDanRealisasiPbb(Request $request)
    {
        $resultDataResponse = ProfilPbbApi::getProfilOpPbbTargetDanRealisasiPbb();

        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    if($row->color=='blue'){
                        $realisasi_mencapai_target[] = $row->realisasi;
                        $realisasi_mencapai_target_simplified[] = $row->realisasi_simplified;
                        $realisasi_blm_mencapai_target[] = 0;
                        $realisasi_blm_mencapai_target_simplified[] = 0;
                    }else if($row->color=='yellow'){
                        $realisasi_mencapai_target[] = 0;
                        $realisasi_mencapai_target_simplified[] = 0;
                        $realisasi_blm_mencapai_target[] = $row->realisasi;
                        $realisasi_blm_mencapai_target_simplified[] = $row->realisasi_simplified;
                    }else{
                        $realisasi_mencapai_target[] = 0;
                        $realisasi_mencapai_target_simplified[] = 0;
                        $realisasi_blm_mencapai_target[] = 0;
                        $realisasi_blm_mencapai_target_simplified[] = 0;
                    }

                    $color[] = $row->color;
                    $tahun[] = $row->tahun;
                    $target[] = $row->target;
                    $target_simplified[] = $row->target_simplified;
                    $satuan_nominal = $row->satuan_nominal;
                }

                $data = [
                    "color" => $color,
                    "tahun" => $tahun,
                    "realisasi_mencapai_target" => $realisasi_mencapai_target,
                    "realisasi_mencapai_target_simplified" => $realisasi_mencapai_target_simplified,
                    "realisasi_blm_mencapai_target" => $realisasi_blm_mencapai_target,
                    "realisasi_blm_mencapai_target_simplified" => $realisasi_blm_mencapai_target_simplified,
                    "target" => $target,
                    "target_simplified" => $target_simplified,
                    "satuan_nominal" => $satuan_nominal
                ];


                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        } catch (Exception $exc) {
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];

        }


        return response()->json($output);
    }

}
