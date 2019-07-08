<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\KepatuhanApi;
use App\Http\API\Dashboard\PiutangApi;

class KepatuhanController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Kepatuhan';
        $viewData['pageTitle'] = 'Dasbor Kepatuhan';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_KEPATUHAN_PBB_BAYAR_TEPAT_WAKTU'  => route('get-kepatuhan-pbb-bayar-tepat-waktu'),
            'URI_GET_KEPATUHAN_NON_PBB_LAPOR_TEPAT_WAKTU'  => route('get-kepatuhan-non-pbb-lapor-tepat-waktu'),
            'URI_GET_KEPATUHAN_NON_PBB_BAYAR_TEPAT_WAKTU'  => route('get-kepatuhan-non-pbb-bayar-tepat-waktu'),
            'URI_GET_KEPATUHAN_BANDING_PENERIMAAN'  => route('get-kepatuhan-banding-penerimaan'),
            'URI_GET_KEPATUHAN_WAJIB_PAJAK_AKTIF_BAYAR_NON_PBB' => route('get-kepatuhan-wajib-pajak-aktif-bayar-non-pbb'),
            'URI_GET_KEPATUHAN_PENERBITAN_KURANG_BAYAR_NON_PBB' => route('get-kepatuhan-penerbitan-kurang-bayar-non-pbb'),
            'URI_GET_KEPATUHAN_WAJIB_PAJAK_AKTIF_BAYAR_TAHUNAN_NON_PBB' => route('get-kepatuhan-wajib-pajak-aktif-bayar-tahunan-non-pbb')

        ];

        $year = PiutangApi::getPiutangTahun('');
        $viewData['all_year'] = $year->data;

        // print_r($request->cookie('credential'));
        // die;

        return view('dashboard.kepatuhan', $viewData);
    }

    public function getKepatuhanPbbBayarTepatWaktu(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = KepatuhanApi::getKepatuhanPbbBayarTepatWaktu((int)$search_filter);

        

        // $total_wajib_pajak_relatif_patuh = 0;
        // $rerata = 0;
        $persen_rerata_per_tahun = 0;
        $total_persen_rerata_per_tahun = 0;
        $persen_rerata = 0;

        try{
            if(!empty($resultDataResponse->data[0]->entries)){

                foreach($resultDataResponse->data[0]->entries as $row){
                    $persen_rerata_per_tahun = 0;

                    // if($row->color=='blue'){
                    //     $total_wp_aktif_patuh[] = $row->total_wp_aktif_patuh;
                    //     $total_wp_aktif_tdk_patuh[] = 0;
                    // }else if($row->color=='yellow'){
                    //     $total_wp_aktif_patuh[] = 0;
                    //     $total_wp_aktif_tdk_patuh[] = $row->total_wp_aktif_patuh;
                    // }

                    // $color[] = $row->color;
                    // $nama_jenis_pajak[] = $row->nama_jenis_pajak;
                    $tahun[] = $row->tahun;
                    $total_wajib_pajak_aktif[] = $row->total_wajib_pajak_aktif;
                    $wajib_pajak_relatif_patuh[] = $row->wajib_pajak_relatif_patuh;
                    //$total_wajib_pajak_relatif_patuh = $total_wajib_pajak_relatif_patuh + $row->wajib_pajak_relatif_patuh;

                    $persen_rerata_per_tahun = ($row->wajib_pajak_relatif_patuh / $row->total_wajib_pajak_aktif) * 100;
                    $total_persen_rerata_per_tahun = $total_persen_rerata_per_tahun + $persen_rerata_per_tahun;
                }

                $persen_rerata = $total_persen_rerata_per_tahun / sizeof($resultDataResponse->data[0]->entries);

                $data = [
                    // "color" => $color,
                    // "nama_jenis_pajak" => $nama_jenis_pajak,
                    "tahun" => $tahun,
                    "total_wp_aktif" => $total_wajib_pajak_aktif,
                    "total_wp_relatif_patuh" => $wajib_pajak_relatif_patuh,
                    "rerata" => $persen_rerata
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

    public function getKepatuhanNonPbbLaporTepatWaktu(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = KepatuhanApi::getKepatuhanNonPbbLaporTepatWaktu((int)$search_filter);
        $persen_rerata_per_tahun = 0;
        $total_persen_rerata_per_tahun = 0;
        $persen_rerata = 0;

        try{
            if(!empty($resultDataResponse->data[0]->entries)){

                foreach($resultDataResponse->data[0]->entries as $row){
                    $persen_rerata_per_tahun = 0;

                    $tahun[] = $row->tahun;
                    $total_wajib_pajak_aktif[] = $row->total_wajib_pajak_aktif;
                    $wajib_pajak_patuh_lapor[] = $row->wajib_pajak_patuh_lapor;
                    $persen_rerata_per_tahun = ($row->wajib_pajak_patuh_lapor / $row->total_wajib_pajak_aktif) * 100;
                    $total_persen_rerata_per_tahun = $total_persen_rerata_per_tahun + $persen_rerata_per_tahun;
                }

                $persen_rerata = $total_persen_rerata_per_tahun / sizeof($resultDataResponse->data[0]->entries);

                $data = [
                    "tahun" => $tahun,
                    "total_wp_aktif" => $total_wajib_pajak_aktif,
                    "total_wp_patuh_lapor" => $wajib_pajak_patuh_lapor,
                    "rerata" => $persen_rerata
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

    public function getKepatuhanNonPbbBayarTepatWaktu(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = KepatuhanApi::getKepatuhanNonPbbBayarTepatWaktu((int)$search_filter);
        $persen_rerata_per_tahun = 0;
        $total_persen_rerata_per_tahun = 0;
        $persen_rerata = 0;

        try{
            if(!empty($resultDataResponse->data[0]->entries)){

                foreach($resultDataResponse->data[0]->entries as $row){
                    $persen_rerata_per_tahun = 0;

                    $tahun[] = $row->tahun;
                    $total_wajib_pajak_aktif[] = $row->total_wajib_pajak_aktif;
                    $wajib_pajak_relatif_patuh[] = $row->wajib_pajak_relatif_patuh;
                    $persen_rerata_per_tahun = ($row->wajib_pajak_relatif_patuh / $row->total_wajib_pajak_aktif) * 100;
                    $total_persen_rerata_per_tahun = $total_persen_rerata_per_tahun + $persen_rerata_per_tahun;
                }

                $persen_rerata = $total_persen_rerata_per_tahun / sizeof($resultDataResponse->data[0]->entries);

                $data = [
                    "tahun" => $tahun,
                    "total_wp_aktif" => $total_wajib_pajak_aktif,
                    "total_wp_relatif_patuh" => $wajib_pajak_relatif_patuh,
                    "rerata" => $persen_rerata
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

    public function getKepatuhanBandingPenerimaan(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = KepatuhanApi::getKepatuhanBandingPenerimaan((int)$search_filter);
        $max_value = 0;
        
        try{
            if(!empty($resultDataResponse->data[0]->entries)){

                foreach($resultDataResponse->data[0]->entries as $row){
                    $persen_rerata_per_tahun = 0;

                    $tahun[] = $row->tahun;
                    $total_penerimaan[] = $row->total_penerimaan;
                    $wajib_pajak_relatif_patuh[] = $row->wajib_pajak_relatif_patuh;
                    $persen_wajib_pajak_relatif_patuh[] = round(($row->wajib_pajak_relatif_patuh / $row->total_penerimaan) * 100);
                    $satuan_nominal = $row->satuan_nominal;

                    if($row->total_penerimaan >= $row->wajib_pajak_relatif_patuh){
                        if($row->total_penerimaan > $max_value){
                            $max_value = $row->total_penerimaan;
                        }    
                    }else{
                        if($row->wajib_pajak_relatif_patuh > $max_value){
                            $max_value = $row->wajib_pajak_relatif_patuh;
                        }
                    }
                }

        
                $data = [
                    "tahun" => $tahun,
                    "total_penerimaan" => $total_penerimaan,
                    "wajib_pajak_relatif_patuh" => $wajib_pajak_relatif_patuh,
                    "persen_wajib_pajak_relatif_patuh" => $persen_wajib_pajak_relatif_patuh,
                    "satuan_nominal" => $satuan_nominal,
                    "max_value" => $max_value
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

    public function getKepatuhanWajibPajakAktifBayarNonPbb(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = KepatuhanApi::getKepatuhanWajibPajakAktifBayarNonPbb((int)$search_filter);
        
        try{
            if(!empty($resultDataResponse->data[0]->entries)){

                foreach($resultDataResponse->data[0]->entries as $row){
                    //$persen_rerata_per_tahun = 0;

                    $jenis_pajak[] = $row->jenis_pajak;
                    $wajib_pajak_patuh_bayar[] = $row->wajib_pajak_patuh_bayar;
                    $wajib_pajak_tidak_patuh_bayar[] = $row->wajib_pajak_tidak_patuh_bayar;
                    //$persen_wajib_pajak_relatif_patuh[] = round(($row->wajib_pajak_relatif_patuh / $row->total_penerimaan) * 100);
                }

        
                $data = [
                    "jenis_pajak" => $jenis_pajak,
                    "wajib_pajak_patuh_bayar" => $wajib_pajak_patuh_bayar,
                    "wajib_pajak_tidak_patuh_bayar" => $wajib_pajak_tidak_patuh_bayar
                    //"persen_wajib_pajak_relatif_patuh" => $persen_wajib_pajak_relatif_patuh
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

    public function getKepatuhanPenerbitanKurangBayarNonPbb(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = KepatuhanApi::getKepatuhanPenerbitanKurangBayarNonPbb((int)$search_filter);
        $total_jumlah_skpdkb = 0;
        $rerata = 0;

        try{
            if(!empty($resultDataResponse->data[0]->entries)){

                $rerata = 0;

                $i = 0;
                foreach($resultDataResponse->data[0]->entries as $row){
                    $tahun[] = $row->tahun;
                    $jumlah_skpdkb[] = $row->jumlah_skpdkb;
                    if ($rerata == 0){
                        $rerata = $row->jumlah_skpdkb;
                    }else{
                        $rerata = ($rerata - $jumlah_skpdkb[$i]) / $jumlah_skpdkb[$i-1];
                    }
                    $i++;
                }

                $hasil_rerata = abs(($rerata/4) * 100);
        
                $data = [
                    "tahun" => $tahun,
                    "jumlah_skpdkb" => $jumlah_skpdkb,
                    "rerata" => $hasil_rerata
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

    public function getKepatuhanWajibPajakAktifBayarTahunanNonPbb(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = KepatuhanApi::getKepatuhanWajibPajakAktifBayarTahunanNonPbb((int)$search_filter);

        return response()->json($resultDataResponse);
    }

}
