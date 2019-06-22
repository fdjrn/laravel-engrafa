<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\AnalisisPelaporanApi;
use Debugbar;

class AnalisisPelaporanController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Analisis Pelaporan';
        $viewData['pageTitle'] = 'Dasbor Analisis Pelaporan';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_REKAP_PELAPORAN'  => route('get-rekap-pelaporan'),
            'URI_GET_SUMBER_PELAPORAN'  => route('get-sumber-pelaporan'),
            'URI_GET_KOMPARASI_PELAPORAN'  => route('get-komparasi-pelaporan'),
            'URI_GET_WP_PELAPORAN_TIDAK_MELAPOR'  => route('get-wp-pelaporan-tidak-melapor'),
            'URI_GET_WP_PELAPORAN_FLAT'  => route('get-wp-pelaporan-flat'),
        ];

        $viewData['allYear'] = AnalisisPelaporanApi::getTahunPelaporan()->data;
        $viewData['allMonth'] = AnalisisPelaporanApi::getBulanPelaporan(date("Y"))->data;

        return view('dashboard.analisisPelaporan', $viewData);
    }

    public function getRekapPelaporan(Request $request){
        $bulan_filter = isset($request->bulan) ?(int) $request->bulan : "";
        $tahun_filter = isset($request->tahun) ?(int) $request->tahun : "";
        $resultDataResponse = AnalisisPelaporanApi::getRekapPelaporan($bulan_filter,$tahun_filter);

        return response()->json($resultDataResponse);
    }

    public function getSumberPelaporan(Request $request){
        $bulan_filter = isset($request->bulan) ?(int) $request->bulan : "";
        $tahun_filter = isset($request->tahun) ?(int) $request->tahun : "";
        $resultDataResponse = AnalisisPelaporanApi::getSumberPelaporan($bulan_filter,$tahun_filter);

        return response()->json($resultDataResponse);
    }

    public function getKomparasiPelaporan(Request $request){
        $bulan_filter = isset($request->bulan) ?(int) $request->bulan : "";
        $tahun_filter = isset($request->tahun) ?(int) $request->tahun : "";
        $resultDataResponse = AnalisisPelaporanApi::getKomparasiPelaporan($bulan_filter,$tahun_filter);

        try{
            $index = 0;
            foreach($resultDataResponse->data as $row){
                $nama_bulan[$index] = $row->nama_bulan;
                foreach($row->entries as $entries){
                    $data_pajak[$index]['kode_jenis_pajak'][] = $entries->kode_jenis_pajak; 
                    $data_pajak[$index]['nama_jenis_pajak'][] = $entries->nama_jenis_pajak; 
                    $data_pajak[$index]['pelaporan'][] = $entries->pelaporan; 
                }
                $index++;
            }

            if(count($data_pajak) > 1){
                $data = [
                    "nama_bulan" => $nama_bulan,
                    "data_pajak_before" => $data_pajak[0],
                    "data_pajak_now" => $data_pajak[1]
                ];
            }else{
                $data = [
                    "nama_bulan" => $nama_bulan,
                    "data_pajak_before" => $data_pajak[0],
                    "data_pajak_now" => []
                ];
            }

            $output = [
                'success' => $resultDataResponse->success,
                'data' => $data,
                'message' => $resultDataResponse->message
            ];
        }catch(Exception $exc){
            $output = [
                'success' => false,
                'data' => '',
                'message' => $exc->getTraceAsString()
            ];
        }

        return response()->json($output);
    }

    public function getWpPelaporanTidakMelapor(Request $request){
        $bulan_filter = isset($request->bulan) ?(int) $request->bulan : "";
        $tahun_filter = isset($request->tahun) ?(int) $request->tahun : "";
        $resultDataResponse = AnalisisPelaporanApi::getWpPelaporanTidakMelapor($bulan_filter,$tahun_filter);

        return response()->json($resultDataResponse);
    }

    public function getWpPelaporanFlat(Request $request){
        $bulan_filter = isset($request->bulan) ?(int) $request->bulan : "";
        $tahun_filter = isset($request->tahun) ?(int) $request->tahun : "";
        $resultDataResponse = AnalisisPelaporanApi::getWpPelaporanFlat($bulan_filter,$tahun_filter);

        return response()->json($resultDataResponse);
    }
}
