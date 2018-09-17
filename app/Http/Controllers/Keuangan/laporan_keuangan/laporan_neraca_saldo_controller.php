<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;

use DB;

class laporan_neraca_saldo_controller extends Controller
{
    public function index(Request $request){
    	// return json_encode($request->all());

    	$bulan = explode('-', $request->durasi_1_neraca_saldo_bulan)[1]; $tahun = explode('-', $request->durasi_1_neraca_saldo_bulan)[0];

      	$bulan_forJurnal = ($bulan < 10) ? str_replace('0', '', $bulan) : $bulan;

      	$data_date = $tahun.'-'.$bulan.'-01'; 

        $data_saldo = akun::select('id_akun', 'nama_akun', 'posisi_akun', DB::raw('coalesce(opening_balance, 0) as total'), 'opening_date')
                            ->orderBy('id_akun', 'asc')->with([
                                  'mutasi_bank_debet' => function($query) use ($data_date){
                                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                              ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                              ->where('tanggal_jurnal', '<', $data_date)
                                              ->where('tanggal_jurnal', '>', DB::raw("opening_date"))
                                              ->where("jrdt_dk", 'D')
                                              ->groupBy('jrdt_acc', 'opening_date')
                                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                  },
                                  'mutasi_bank_kredit' => function($query) use ($data_date){
                                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                              ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                              ->where('tanggal_jurnal', '<', $data_date)
                                              ->where('tanggal_jurnal', '>', DB::raw("opening_date"))
                                              ->where("jrdt_dk", 'K')
                                              ->groupBy('jrdt_acc', 'opening_date')
                                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                  },
                            ])
                            ->where('type_akun', 'DETAIL')
                            ->orderBy('id_akun', 'asc')->get();

        $data = akun::select('id_akun', 'nama_akun')->where('type_akun', 'DETAIL')->orderBy('id_akun', 'asc')->with([
                  'mutasi_bank_debet' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("month(tanggal_jurnal)"), $bulan_forJurnal)
                              ->where(DB::raw("year(tanggal_jurnal)"), $tahun)
                              ->where("jrdt_dk", 'D')
                              ->where(DB::raw('substring(no_jurnal,1,1)'), 'B')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_bank_kredit' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("month(tanggal_jurnal)"), $bulan_forJurnal)
                              ->where(DB::raw("year(tanggal_jurnal)"), $tahun)
                              ->where("jrdt_dk", 'K')
                              ->where(DB::raw('substring(no_jurnal,1,1)'), 'B')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_kas_debet' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("month(tanggal_jurnal)"), $bulan_forJurnal)
                              ->where(DB::raw("year(tanggal_jurnal)"), $tahun)
                              ->where("jrdt_dk", 'D')
                              ->where(DB::raw('substring(no_jurnal,1,1)'), 'K')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_kas_kredit' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("month(tanggal_jurnal)"), $bulan_forJurnal)
                              ->where(DB::raw("year(tanggal_jurnal)"), $tahun)
                              ->where("jrdt_dk", 'K')
                              ->where(DB::raw('substring(no_jurnal,1,1)'), 'K')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_memorial_debet' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("month(tanggal_jurnal)"), $bulan_forJurnal)
                              ->where(DB::raw("year(tanggal_jurnal)"), $tahun)
                              ->where("jrdt_dk", 'D')
                              ->where(DB::raw('substring(no_jurnal,1,1)'), 'M')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  },
                  'mutasi_memorial_kredit' => function($query) use ($bulan_forJurnal, $tahun){
                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                              ->where(DB::raw("month(tanggal_jurnal)"), $bulan_forJurnal)
                              ->where(DB::raw("year(tanggal_jurnal)"), $tahun)
                              ->where("jrdt_dk", 'K')
                              ->where(DB::raw('substring(no_jurnal,1,1)'), 'M')
                              ->groupBy('jrdt_acc')
                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                  }
            ])->get();

        // return json_encode($data_saldo);

    	return view('keuangan.laporan_keuangan.neraca_saldo.index', compact('request', 'data_saldo', 'data_date', 'data'));
    }
}
