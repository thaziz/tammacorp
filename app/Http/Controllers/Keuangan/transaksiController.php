<?php

namespace App\Http\Controllers\Keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Carbon\carbon;
use Session;
use Exception;
use DataTables;

class transaksiController extends Controller
{
    public function index(){
    	$data = DB::table("d_transaksi_keuangan")->orderBy("created_at", "asc")->get();
    	return view('/master/datatransaksi/transaksi', compact("data"));
    }

    public function tambah_transaksi()
    {   
        $data = DB::table('d_akun')->where('type_akun', "detail")->orderBy("id_akun", 'asc')->select("id_akun", "nama_akun")->get();
        return view('/master/datatransaksi/tambah_transaksi', compact("data"));
    }

    public function simpan_transaksi(Request $request)
    {   
        // return $request->all();

        if(count(DB::table('d_transaksi_keuangan')->where("nomor_transaksi", $request->nomor_transaksi)->get()) != 0){
            return json_encode([
                "status"    => "exist_key"
            ]);
        }

        $data = [
            "id_transaksi"      => (DB::table("d_transaksi_keuangan")->max("id_transaksi") + 1),
            "nomor_transaksi"   => $request->nomor_transaksi,
            "nama_transaksi"    => $request->nama_transaksi,
            "tanggal_transaksi" => date("Y-m-d"),
            "keterangan"        => $request->Keterangan,
            "cash_type"         => $request->Cash_Type,
            "total_transaksi"   => str_replace('.', '', explode(',', $request->total)[0])
        ];

        // DB::table('d_transaksi_keuangan')->insert($data);

        return json_encode([
            "status"    => "sukses"
        ]);

        // return view('/master/datatransaksi/tambah_transaksi');
    }

    public function edit(Request $request){
        // return $request->all();
        $transaksi = DB::table('d_transaksi_keuangan')->where("id_transaksi", $request->id)->first();
        $data = DB::table('d_akun')->where('type_akun', "detail")->orderBy("id_akun", 'asc')->select("id_akun", "nama_akun")->get();
        return view('/master/datatransaksi/edit_transaksi', compact('data', 'transaksi'));
    }
}
