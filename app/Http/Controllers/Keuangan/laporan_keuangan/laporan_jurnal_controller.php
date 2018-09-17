<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_jurnal as jurnal;

use DB;
use Session;

class laporan_jurnal_controller extends Controller
{
    public function index(Request $request){
    	// return json_encode($request->all());

    	$d1 = date_format(date_create($request->durasi_1_jurnal_bulan), "Y-m-d");
        $d2 = date_format(date_create($request->durasi_2_jurnal_bulan), "Y-m-d");

        $range = 'K'; $detail = [];

    	if($request->jenis == "bank")
    		$range = 'B';
        elseif($request->jenis == "memorial")
            $range = 'M';

        $data = DB::table('d_jurnal_dt')
                    ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                    ->whereBetween("d_jurnal.tanggal_jurnal", [$d1, $d2])
                    ->where(DB::raw('substring(d_jurnal.no_jurnal,1,1)'), $range)
                    ->select("d_jurnal.*")->distinct('d_jurnal.jurnal_id')->orderBy('d_jurnal.tanggal_jurnal', 'asc')->get();

        foreach ($data as $key => $value) {
    		$detail[$value->jurnal_id] = DB::table('d_jurnal_dt')
    										->join('d_akun', 'd_akun.id_akun', '=', 'd_jurnal_dt.jrdt_acc')
    										->where("d_jurnal_dt.jrdt_jurnal", $value->jurnal_id)
    										->select("d_jurnal_dt.*", "d_akun.nama_akun")
    										->get();
    	}

        // return json_encode($detail);

    	return view('keuangan.laporan_keuangan.jurnal.index', compact("request", "detail", "data", "d1", "d2"));
    }
}
