<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\d_hasil_garapan;
use App\m_produksi;
use App\m_gaji_pro;
use App\m_jabatan_pro;
use DataTables;
use URL;

class PayrollProduksiController extends Controller
{
    public function index(){
      $produksi = m_produksi::all();
      $m_gaji_pro = m_gaji_pro::select('c_id',
        'nm_gaji')
        ->get();
      $c_jabatan_pro = m_jabatan_pro::all();
      return view('hrd.payroll-produksi.index',compact('produksi','m_gaji_pro','c_jabatan_pro'));
    }

    public function tableDataGarapan($rumah, $jabatan, $tgl1, $tgl2){
      $d = substr($tgl1,0,2);
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
        $tgl1 = $y.'-'.$m.'-'.$d;

      $d = substr($tgl2,0,2);
      $y = substr($tgl2, -4);
      $m = substr($tgl2, -7,-5);
        $tgl2 = $y.'-'.$m.'-'.$d;

      $garapan = d_hasil_garapan::select(
        'm_pegawai_pro.c_id as id_p',
        'c_code',
        'c_nik',
        'c_nama',
        'c_nik',
        'c_nama',
        DB::raw("SUM(d_hg_gaji) as dataGaji"),
        DB::raw("SUM(d_hg_lembur) as dataLembur")
        )

      ->leftJoin('m_pegawai_pro', function($join) use ($tgl1, $tgl2) {
          $join->on('m_pegawai_pro.c_id', '=', 'd_hasil_garapan.d_hg_pid')
              ->where('d_hg_tgl','>=',$tgl1)
              ->where('d_hg_tgl','<=',$tgl2);
        })

      ->leftJoin('m_jabatan_pro','m_jabatan_pro.c_id','=','c_jabatan_pro_id')
      ->where('c_jabatan_pro_id',$jabatan)
      ->where('c_rumah_produksi',$rumah)
      ->groupBy('m_pegawai_pro.c_id')
      ->get();
      // dd($garapan);
      return DataTables::of($garapan)
      ->addIndexColumn()
      ->editColumn('kode', function ($data) {
          return "$data->c_code" ;

      })

      ->editColumn('pegawai', function ($data) {
          return  "$data->c_nik - $data->c_nama";

      })

      ->editColumn('gaji', function ($data)use($tgl1, $tgl2) {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success"
                              title="Detail"
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailGaji('.$data->id_p.')>
                              <i class="fa fa-eye"></i>
                      </button>
                  </div>';

      })

      ->rawColumns(['kode',
                    'pegawai',
                    'gaji'
                  ])
      ->make(true);
    }

    public function lihatGaji($id, $tgl1, $tgl2){
      // dd($id);
      $d = substr($tgl1,0,2);
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
        $tgl1 = $y.'-'.$m.'-'.$d;

      $d = substr($tgl2,0,2);
      $y = substr($tgl2, -4);
      $m = substr($tgl2, -7,-5);
        $tgl2 = $y.'-'.$m.'-'.$d;

      $garapan = d_hasil_garapan::select(
        'c_nama',
        'c_jabatan_pro',
        'm_gaji_pro.c_id as item_id',
        'nm_gaji',
        'd_hg_pid',
        'c_gaji',
        'c_lembur',
        DB::raw("SUM(d_hg_gaji) as dataGaji"),
        DB::raw("SUM(d_hg_lembur) as dataLembur")
        )
        ->rightJoin('m_gaji_pro', function($join) use ($id, $tgl1, $tgl2) {
            $join->on('m_gaji_pro.c_id', '=', 'd_hasil_garapan.d_hg_cid')
                ->where('d_hg_pid',$id)
                ->where('d_hg_tgl','>=',$tgl1)
                ->where('d_hg_tgl','<=',$tgl2);
        })
        ->join('m_pegawai_pro','m_pegawai_pro.c_id','=','d_hg_pid')
        ->join('m_jabatan_pro','m_jabatan_pro.c_id','=','c_jabatan_pro_id')
        ->groupBy('m_gaji_pro.c_id')
        ->get();
        // dd($garapan);
        $d_gaji = 0;
        $d_lembur = 0;
        foreach ($garapan as $hasil) {
          $d_gaji += ($hasil->dataGaji + $hasil->dataLembur) * $hasil->c_gaji;
          $d_lembur += $hasil->dataLembur * $hasil->c_lembur;
        }
        $total = $d_gaji + $d_lembur;

      return view('hrd.payroll-produksi.view-payroll',compact('garapan','total'));
    }
}
