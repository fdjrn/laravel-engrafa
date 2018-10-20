<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\API\Dashboard\PiutangApi;

class PiutangController extends Controller
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
        $viewData['documentTitle'] = 'Tax Analytic - Piutang';
        $viewData['pageTitle'] = 'Dasbor Piutang';
        $viewData['var_javascript'] = [
            'URI_GET_CSRF'  => route('refresh-csrf'),
            'URI_GET_PIUTANG_BELUM_TERTAGIH_POKOK'  => route('get-piutang-belum-tertagih-pokok'),
            'URI_GET_POTENSI_DENDA'  => route('get-potensi-denda'),
            'URI_GET_PIUTANG_BELUM_TERTAGIH_PER_TAHUN_POKOK'  => route('get-piutang-belum-tertagih-per-tahun-pokok'),
            'URI_GET_PIUTANG_WAJIB_PAJAK_DENGAN_TUNGGAKAN'  => route('get-piutang-wajib-pajak-dengan-tunggakan'),
            'URI_GET_PIUTANG_PBB_PER_KECAMATAN'  => route('get-piutang-pbb-per-kecamatan')

        ];

        $year = PiutangApi::getPiutangTahun('');
        $viewData['all_year'] = $year->data;

        return view('dashboard.piutang', $viewData);
    }

    public function getPiutangBelumTertagihPokok(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = PiutangApi::getPiutangBelumTertagihPokok((int)$search_filter);

        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    $kode_jenis_pajak[] = $row->kode_jenis_pajak;
                    $nama_jenis_pajak[] = $row->nama_jenis_pajak;
                    $piutang_pokok[] = $row->piutang_pokok;
                    $piutang_pokok_simplified[] = $row->piutang_pokok_simplified;
                    $satuan_nominal = $row->satuan_nominal;
                }
        
                $data = [
                    "kode_jenis_pajak" => $kode_jenis_pajak,
                    "nama_jenis_pajak" => $nama_jenis_pajak,
                    "piutang_pokok" => $piutang_pokok,
                    "piutang_pokok_simplified" => $piutang_pokok_simplified,
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

    public function getPotensiDenda(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = PiutangApi::getPotensiDenda((int)$search_filter);

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
                        "y" => $row->potensi_denda_simplified,
                        "color" => $color[$index],
                        "name" => $row->nama_jenis_pajak,
                        "potensi_denda_simplified" => $row->potensi_denda,
                        "satuan_nominal" => $row->satuan_nominal
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

    public function getPiutangBelumTertagihPerTahunPokok(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = PiutangApi::getPiutangBelumTertagihPerTahunPokok((int)$search_filter);

        $counter = 0;
        $tahun[] = null;
        $data_hotel[] = null;
        $data_restoran[] = null;
        $data_parkir[] = null;
        $data_hiburan[] = null;
        $data_penerangan_jalan[] = null;
        $data_air_tanah[] = null;
        $data_mineral_bukan_logam_batuan[] = null;
        $data_walet[] = null;
        $data_reklame[] = null;
        $data_pbb[] = null;
        $data_bphtb[] = null;

        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    foreach($resultDataResponse->data[$counter]->entries as $rowEntries){
                        if($rowEntries->kode_jenis_pajak == '01'){
                            $data_hotel[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '02'){
                            $data_restoran[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '03'){
                            $data_parkir[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '04'){
                            $data_hiburan[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '05'){
                            $data_penerangan_jalan[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '06'){
                            $data_air_tanah[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '07'){
                            $data_mineral_bukan_logam_batuan[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '08'){
                            $data_walet[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '09'){
                            $data_reklame[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '10'){
                            $data_pbb[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        if($rowEntries->kode_jenis_pajak == '11'){
                            $data_bphtb[$counter] = $rowEntries->piutang_pokok_simplified;
                        }
                        
                        $satuan_nominal = $rowEntries->satuan_nominal;    
                    }
                    $tahun[$counter] = $row->tahun;
                    $counter++;
                }

                $data = [
                    "tahun" => $tahun,
                    "satuan_nominal" => $satuan_nominal,
                    "data_hotel" => $data_hotel,
                    "data_restoran" => $data_restoran,
                    "data_parkir" => $data_parkir,
                    "data_hiburan" => $data_hiburan,
                    "data_penerangan_jalan" => $data_penerangan_jalan,
                    "data_air_tanah" => $data_air_tanah,
                    "data_mineral_bukan_logam_batuan" => $data_mineral_bukan_logam_batuan,
                    "data_walet" => $data_walet,
                    "data_reklame" => $data_reklame,
                    "data_pbb" => $data_pbb,
                    "data_bphtb" => $data_bphtb
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

    public function getPiutangWajibPajakDenganTunggakan(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = PiutangApi::getPiutangWajibPajakDenganTunggakan((int)$search_filter);

        try{
            if(!empty($resultDataResponse->data)){

                foreach($resultDataResponse->data as $row){
                    $jumlah_wp_dengan_tunggakan[] = $row->jumlah_wp_dengan_tunggakan;
                    $kode_jenis_pajak[] = $row->kode_jenis_pajak;
                    $nama_jenis_pajak[] = $row->nama_jenis_pajak;
                }
        
                $data = [
                    "jumlah_wp_dengan_tunggakan" => $jumlah_wp_dengan_tunggakan,
                    "kode_jenis_pajak" => $kode_jenis_pajak,
                    "nama_jenis_pajak" => $nama_jenis_pajak
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

    public function getPiutangPbbPerKecamatan(Request $request)
    {
        $search_filter = isset($request->year) ? $request->year : "";
        $resultDataResponse = PiutangApi::getPiutangPbbPerKecamatan((int)$search_filter);

        try{
            if(!empty($resultDataResponse->data)){
                
                $color = [
                    "#7ebffc",
                    "#3f89df",
                    "#ffb55a",
                    "#fedc52",
                    "#62737c",
                    "#a7b3b3",
                    "#a2778b",
                    "#ae81c4",
                    "#beb1fb",
                ];

                $index = 0;
                foreach($resultDataResponse->data as $row){
                    $data [] = [
                        "y" => $row->piutang_pokok_simplified,
                        "color" => $color[$index],
                        "name" => $row->kecamatan,
                        "piutang_pokok" => $row->piutang_pokok,
                        "satuan_nominal" => $row->satuan_nominal
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

}
