<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;

class KeuanganController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function transaksi()
    {
        return view('/keuangan/p_inputtransaksi/transaksi');
    }

    public function hutang()
    {
        return view('/keuangan/l_hutangpiutang/hutang');
    }

    public function jurnal()
    {
        return view('/keuangan/l_jurnal/jurnal');
    }

    public function analisa()
    {
        return view('/keuangan/analisaprogress/analisa');
    }

    public function analisa2()
    {
        return view('/keuangan/analisaocf/analisa2');
    }

    public function analisa3()
    {
        return view('/keuangan/analisaaset/analisa3');
    }

    public function analisa4()
    {
        return view('/keuangan/analisacashflow/analisa4');
    }

    public function analisa5()
    {
        return view('/keuangan/analisaindex/analisa5');
    }

    public function analisa6()
    {
        return view('/keuangan/analisarasio/analisa6');
    }

    public function analisa7()
    {
        return view('/keuangan/analisabottom/analisa7');
    }

    public function analisa8()
    {
        return view('/keuangan/analisaroe/analisa8');
    }
    public function spk()
    {
        return view('/keuangan/spk/spk');
    }

    public function pembatalanPenerimaan()
    {
        return view('/keuangan/pembatalan_penerimaan/batal_terima');
    }

    // public function getPenerimaanByTgl($tgl1,$tgl2)
    // {
    //     $y = substr($tgl1, -4);
    //     $m = substr($tgl1, -7,-5);
    //     $d = substr($tgl1,0,2);
    //     $tanggal1 = $y.'-'.$m.'-'.$d;

    //     $y2 = substr($tgl2, -4);
    //     $m2 = substr($tgl2, -7,-5);
    //     $d2 = substr($tgl2,0,2);
    //     $tanggal2 = $y2.'-'.$m2.'-'.$d2;
    //     //dd(array($tanggal1, $tanggal2));
        
    //     $query = DB::table('d_send_product')
    //         ->select('d_send_productdt.spd_do', 
    //                  'd_send_product.sp_item',
    //                  'd_send_productdt.spd_status',
    //                  'm_item.i_name',
    //                  'd_send_productdt.spd_qty_send',
    //                  'd_send_productdt.spd_time_received',
    //                  'd_send_productdt.spd_date_received',
    //                  'd_send_productdt.spd_qty_received',
    //                  'd_send_productdt.spd_detailed',
    //                  'd_spk.spk_code')
    //         ->join('d_send_productdt', 'd_send_product.sp_id', '=', 'd_send_productdt.spd_sp')
    //         ->join('m_item', 'd_send_product.sp_item', '=', 'm_item.i_id')
    //         ->join('d_spk', 'd_send_product.sp_spk', '=', 'd_spk.spk_id')
    //         ->where('d_send_productdt.spd_status','=', 'FN')
    //         ->get();

    //     return DataTables::of($query)
    //     ->addIndexColumn() //untuk menambahkan column number
    //     ->addColumn('action', function($data)
    //     {
    //         if ($data->spd_qty_received == '0') 
    //         {
    //             return '<div class="text-center">
    //                         <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
    //                             onclick=ubahStatus("'.$data->spd_detailed.'")><i class="glyphicon glyphicon-ok"></i>
    //                         </a>
    //                     </div>';
    //         }
    //         else
    //         {
    //             return '<div class="text-center">
    //                         <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
    //                             onclick=ubahStatus("'.$data->spd_detailed.'")><i class="glyphicon glyphicon-ok"></i>
    //                         </a>
    //                     </div>';
    //         }     
    //     })
    //     ->editColumn('tanggalTerima', function ($data) 
    //     {
    //         if ($data->spd_date_received == null) 
    //         {
    //             return '-';
    //         }
    //         else 
    //         {
    //             return $data->spd_date_received ? with(new Carbon($data->spd_date_received))->format('d M Y') : '';
    //         }
    //     })
    //     ->editColumn('jamTerima', function ($data) 
    //     {
    //         if ($data->spd_time_received == null) 
    //         {
    //             return '-';
    //         }
    //         else 
    //         {
    //             return $data->spd_time_received;
    //         }
    //     })
    //     ->editColumn('status', function ($data) 
    //     {
    //         if ($data->spd_status == "WT") 
    //         {
    //             return '<span class="label label-info">Waiting</span>';
    //         }
    //         elseif ($data->spd_status == "FN") 
    //         {
    //             return '<span class="label label-success">Final</span>';
    //         }
    //     })
    //     //inisisai column status agar kode html digenerate ketika ditampilkan
    //     ->rawColumns(['status', 'action'])
    //     ->make(true);       
    // }

    public function ubahStatusTransaksi($dod_do, $dod_detailid)
    {
        //get recent status DO
        $recentStatusDo = DB::table('d_delivery_orderdt')
                            ->where('dod_do',$dod_do)
                            ->where('dod_detailid',$dod_detailid)
                            ->first();

        if ($recentStatusDo->dod_status == "WT") 
        {
            //update status to FN
            DB::table('d_delivery_orderdt')->where('dod_do',$dod_do)->where('dod_detailid',$dod_detailid)->update(['dod_status' => "FN"]);
        }
        else
        {
            //update status to WT
            DB::table('d_delivery_orderdt')->where('dod_do',$dod_do)->where('dod_detailid',$dod_detailid)->update(['dod_status' => "WT"]);
        }

        //get recent status Product Result
        // $recentStatusPrdt = DB::table('d_delivery_orderdt')
        //                     ->where('dod_do',$dod_do)
        //                     ->where('dod_detailid',$dod_detailid)
        //                     ->first();
        
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Status penerimaan telah berhasil diubah',
        ]);
    }
}
