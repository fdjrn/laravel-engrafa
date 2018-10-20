<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\AnalisisPotensiApi;

class AnalisisPotensiController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Analisis Potensi';
        $viewData['pageTitle'] = 'Dasbor Analisis Potensi';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_WP_AKTIF_PATUH_VS_TOTAL'  => route('get-wp-aktif-patuh-vs-total'),
            'URI_GET_KONTRIBUSI_PENERIMAAN'  => route('get-kontribusi-penerimaan'),
            'URI_GET_HISTORY_PENERIMAAN'  => route('get-history-penerimaan'),
            'URI_GET_LAJU_PERTUMBUHAN_PER_JENIS_PAJAK'  => route('get-laju-pertumbuhan-per-jenis-pajak'),
            'URI_GET_PROYEKSI_BERDASARKAN_LAJU_PERTUMBUHAN'  => route('get-proyeksi-berdasarkan-laju-pertumbuhan'),
            'URI_GET_ANALISIS_POTENSI_PER_OBJEK_PAJAK'  => route('get-analisis-potensi-per-objek-pajak'),
            'URI_GET_CAPAIAN_TARGET'  => route('get-capaian-target'),
            'URI_GET_HISTORY_CAPAIAN_TARGET'  => route('get-history-capaian-target'),
        ];

        $year = AnalisisPotensiApi::getTahunPotensi('');
        $viewData['all_year'] = $year->data;

        return view('dashboard.analisisPotensi', $viewData);
    }

    public function getWpAktifPatuhVsTotal(Request $request)
    {
        $search_filter = isset($request->tahun) ? (int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getWpAktifPatuhVsTotal($search_filter);

        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    $total_wp_aktif_patuh[] = $row->total_wp_aktif_patuh;
                    $color[] = $row->color;
                    $nama_jenis_pajak[] = $row->nama_jenis_pajak;
                    $tahun[] = $row->tahun;
                    $total_wp_aktif[] = $row->total_wp_aktif;
                }

                $data = [
                    "color" => $color,
                    "nama_jenis_pajak" => $nama_jenis_pajak,
                    "tahun" => $tahun,
                    "total_wp_aktif" => $total_wp_aktif,
                    "total_wp_aktif_patuh" => $total_wp_aktif_patuh,
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

    public function getKontribusiPenerimaan(Request $request)
    {
        $search_filter = isset($request->tahun) ? (int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getKontribusiPenerimaan($search_filter);

        try{
            if(!empty($resultDataResponse->data)){
                
                $color = [
                    "#a27372",
                    "#6fcc88",
                    "#f7423c",
                    "#f2b382",
                    "#fb9801",
                    "#23aae8",
                    "#5dd6e1",
                    "#9e9e9e",
                    "#ae80c4",
                    "#2b9fa4",
                    "#7376b8"
                ];

                $index = 0;
                foreach($resultDataResponse->data as $row){
                    $data [] = [
                        "y" => $row->penerimaan,
                        "color" => $color[$index],
                        "name" => $row->nama_jenis_pajak
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

    public function getHistoryPenerimaan(Request $request){
        $search_filter = isset($request->tahun) ? (int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getHistoryPenerimaan($search_filter);
        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data->entries as $row){
                    $penerimaan_official_asssessment[] = $row->penerimaan_official_assessment;
                    $penerimaan_official_assessment_simplified[] = round($row->penerimaan_official_assessment_simplified, 0, PHP_ROUND_HALF_ODD);
                    $penerimaan_self_assessment[] = $row->penerimaan_self_assessment;
                    $penerimaan_self_assessment_simplified[] = round($row->penerimaan_self_assessment_simplified, 0, PHP_ROUND_HALF_ODD);
                    $tahun[] = $row->tahun;
                    $total_penerimaan[] = $row->total_penerimaan;
                    $total_penerimaan_simplified[] = $row->total_penerimaan_simplified;
                    $satuan_nominal = $row->satuan_nominal;
                }

                $data = [
                    "penerimaan_official_asssessment" => $penerimaan_official_asssessment,
                    "penerimaan_official_assessment_simplified" => $penerimaan_official_assessment_simplified,
                    "penerimaan_self_assessment" => $penerimaan_self_assessment,
                    "penerimaan_self_assessment_simplified" => $penerimaan_self_assessment_simplified,
                    "tahun" => $tahun,
                    "total_penerimaan" => $total_penerimaan,
                    "total_penerimaan_simplified" => $total_penerimaan_simplified,
                    "satuan_nominal" => $satuan_nominal,
                    "persentase_laju_pertumbuhan" => $resultDataResponse->data->persentase_laju_petumbuhan
                ];

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];

            }
        }catch(Exception $exc){
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];
        }

        return response()->json($output);
    }

    public function getLajuPertumbuhanPerJenisPajak(Request $request){
        $search_filter = isset($request->tahun) ? (int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getLajuPertumbuhanPerJenisPajak($search_filter);

        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    $kode_jenis_pajak[] = $row->kode_jenis_pajak;
                    $nama_jenis_pajak[] = $row->nama_jenis_pajak;
                    $persentase_laju_pertumbuhan[] = $row->persentase_laju_pertumbuhan;
                }

                $data = [
                    "kode_jenis_pajak" => $kode_jenis_pajak,
                    "nama_jenis_pajak" => $nama_jenis_pajak,
                    "persentase_laju_pertumbuhan" => $persentase_laju_pertumbuhan
                ];

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        }catch(Exception $exc){
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];
        }

        return response()->json($output);
    }

    public function getProyeksiBerdasarkanLajuPertumbuhan(Request $request){
        $search_filter = isset($request->tahun) ? (int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getProyeksiBerdasarkanLajuPertumbuhan($search_filter);

        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    $kode_jenis_pajak[] = $row->kode_jenis_pajak;
                    $nama_jenis_pajak[] = $row->nama_jenis_pajak;
                    $proyeksi[] = $row->proyeksi;
                    $proyeksi_simplified[] = $row->proyeksi_simplified;
                    $satuan_nominal = $row->satuan_nominal;
                }

                $data = [
                    "kode_jenis_pajak" => $kode_jenis_pajak,
                    "nama_jenis_pajak" => $nama_jenis_pajak,
                    "proyeksi" => $proyeksi,
                    "proyeksi_simplified" => $proyeksi_simplified,
                    "satuan_nominal" => $satuan_nominal,
                ];

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        }catch(Exception $exc){
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];
        }

        return response()->json($output);
    }

    public function getAnalisisPotensiPerObjekPajak(Request $request){
        $search_filter = isset($request->tahun) ? (int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getAnalisisPotensiPerObjekPajak($search_filter);

        try{
            if(!empty($resultDataResponse->data)){

                $color = [
                    "#a27372",
                    "#6fcc88",
                    "#f7423c",
                    "#f2b382",
                    "#fb9801",
                    "#23aae8",
                    "#5dd6e1",
                    "#9e9e9e",
                    "#ae80c4",
                    "#2b9fa4",
                    "#7376b8"
                ];

                $index = 0;
                foreach($resultDataResponse->data as $row){
                    $column [] = [
                        "y" => $row->potensi_simplified,
                        "color" => $color[$index],
                        "name" => $row->nama_jenis_pajak
                    ];

                    $satuan_nominal = $row->satuan_nominal;
                    $index++;
                }

                $data = [
                    "column" => $column,
                    "satuan_nominal" => $row->satuan_nominal
                ];

                $output = [
                    'success' => $resultDataResponse->success,
                    'data' => $data,
                    'message' => $resultDataResponse->message
                ];
            }
        }catch(Exception $exc){
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];
        }

        return response()->json($output);
    }

    public function getCapaianTarget(Request $request)
    {
        $search_filter = isset($request->tahun) ?(int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getCapaianTarget($search_filter);

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
                    $nama_jenis_pajak[] = $row->nama_jenis_pajak;
                    $target[] = $row->target;
                    $target_simplified[] = $row->target_simplified;
                    $satuan_nominal = $row->satuan_nominal;
                }

                $data = [
                    "color" => $color,
                    "nama_jenis_pajak" => $nama_jenis_pajak,
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

    public function getHistoryCapaianTarget(Request $request)
    {
        $search_filter = isset($request->tahun) ? (int) $request->tahun : "";
        $resultDataResponse = AnalisisPotensiApi::getHistoryCapaianTarget($search_filter);

        try{
            if(!empty($resultDataResponse->data->entries)){

                $jumlah_rerata_capaian = 0;
                foreach($resultDataResponse->data->entries as $row){
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
                    "satuan_nominal" => $satuan_nominal,
                    "rerata_capaian_persentase" => $resultDataResponse->data->persentase_rerata_capaian
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
