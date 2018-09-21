<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use Auth;

class HproduksiController extends Controller
{
    public function index()
    {
        return view('hrd/hasilproduksi/index');
    }

    public function getHasilByTgl($tgl1, $tgl2)
    {
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        $data = DB::table('d_hasil_garapan')->join('m_pegawai_pro','d_hasil_garapan.d_hg_pid','=','m_pegawai_pro.c_id')
                ->select('d_hasil_garapan.*', 'm_pegawai_pro.*')
                ->whereBetween('d_hg_tgl', [$tanggal1, $tanggal2])
                ->orderBy('d_hg_created', 'DESC')
                ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_hg_tgl == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_hg_tgl ? with(new Carbon($data->d_hg_tgl))->format('d M Y') : '';
            }
        })
        ->editColumn('qty_lembur', function ($data) 
        {
            $lembur = array($data->d_hg_jumbo_l, $data->d_hg_tb_l, $data->d_hg_ts_l, $data->d_hg_tm_l, $data->d_hg_tc_l);
            return array_sum($lembur);
            
        })
        ->editColumn('qty_reguler', function ($data) 
        {
            $reguler = array($data->d_hg_jumbo_r, $data->d_hg_tb_r, $data->d_hg_ts_r, $data->d_hg_tm_r, $data->d_hg_tc_r);
            return array_sum($reguler);
            
        })
        ->editColumn('qty_total', function ($data) 
        {
            $reguler = array($data->d_hg_jumbo_r, $data->d_hg_tb_r, $data->d_hg_ts_r, $data->d_hg_tm_r, $data->d_hg_tc_r);
            $lembur = array($data->d_hg_jumbo_l, $data->d_hg_tb_l, $data->d_hg_ts_l, $data->d_hg_tm_l, $data->d_hg_tc_l);
            
            return $qty_r = array_sum($reguler) + array_sum($lembur); 
            
        })
        ->addColumn('action', function($data)
        { 
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailHasil("'.$data->d_hg_id.'")><i class="fa fa-info"></i> 
                        </button>
                    </div>';
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function getDataDetail($id)
    {
        $data = DB::table('d_hasil_garapan')->join('m_pegawai_pro','d_hasil_garapan.d_hg_pid','=','m_pegawai_pro.c_id')
                ->select(
                    'd_hasil_garapan.*',
                    'm_pegawai_pro.*',
                    DB::raw('SUM(d_hasil_garapan.d_hg_jumbo_l + d_hasil_garapan.d_hg_tb_l + d_hasil_garapan.d_hg_ts_l + d_hasil_garapan.d_hg_tm_l + d_hasil_garapan.d_hg_tc_l) as qty_lembur'),
                    DB::raw('SUM(d_hasil_garapan.d_hg_jumbo_r + d_hasil_garapan.d_hg_tb_r + d_hasil_garapan.d_hg_ts_r + d_hasil_garapan.d_hg_tm_r + d_hasil_garapan.d_hg_tc_r) as qty_reguler')
                )
                ->where('d_hasil_garapan.d_hg_id', '=', $id)
                ->get();
        
        return response()->json([
            'status' => 'sukses',
            'data' => $data
        ]);
    }
}
