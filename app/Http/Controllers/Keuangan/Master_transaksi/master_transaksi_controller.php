<?php

namespace App\Http\Controllers\Keuangan\Master_transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\m_transaksi as transaksi;

use DataTables;
use DB;

class master_transaksi_controller extends Controller
{
    public function index(){
    	return view('master.datakeuangan.datatransaksi.transaksi');
    }

    public function get_transaksi(){

        $list = DB::table("m_transaksi")->select("*")->orderBy("id_transaksi", "asc")->get();
        // return $list;
        $data = collect($list);
        
        // return $data;

        return Datatables::of($data)
				->editColumn('type_transaksi', function($data) {

				  if($data->type_transaksi == 'KK')
				  	return 'kas Keluar';
				  else if($data->type_transaksi == 'BM')
				  	return 'Bank Masuk';
				  else if($data->type_transaksi == 'BK')
				  	return 'Bank Keluar';
				  else if($data->type_transaksi == 'MM')
				  	return 'Memorial';

				  	return 'Kas Masuk';

				})
				->editColumn('cashflow', function($data) {

				  if($data->cashflow == 'O')
				  	return 'Operating Cashflow';
				  else if($data->cashflow == 'F')
				  	return 'Financial Cashflow';
				  else if($data->cashflow == 'I')
				  	return 'Investing Cashflow';

				  	return 'Tidak Termasuk Cashflow';

				})
                ->addColumn('action', function ($data) {
                    return  '<button id="edit" class="btn btn-warning btn-sm" title="Edit" onclick="edit(\''.$data->id_transaksi.'\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['action','confirmed'])
                ->make(true);
    }

    public function form_resource(){
    	$data = DB::table('d_akun')->select('id_akun', 'nama_akun')->where('type_akun', 'DETAIl')->orderBy('id_akun')->get();

    	return json_encode($data);
    }

    public function get_data_transaksi(Request $request){
    	$data = transaksi::where('id_transaksi', $request->ids)->with('detail')->first();

    	return json_encode($data);
    }

    public function add(){
    	return view('master.datakeuangan.datatransaksi.tambah_transaksi');
    }

    public function save(Request $request){
    	// return json_encode($request->all());

    	$id = (transaksi::max('id_transaksi')) ? (transaksi::max('id_transaksi') + 1) : 1;

    	transaksi::insert([
    		'id_transaksi'		=> $id,
    		'nama_transaksi'	=> $request->nama,
    		'type_transaksi'	=> $request->type,
    		'cashflow'			=> $request->cash_flow,
    	]);

    	foreach ($request->akun_ as $key => $akun) {
    		DB::table('m_transaksi_detail')->insert([
    			'td_transaksi'	=> $id,
    			'td_no'			=> ($key + 1),
    			'td_acc'		=> $akun,
    			'td_posisi'		=> $request->akun_dka[$key]
    		]);
    	}

    	return json_encode([
    		'status'	=> 'berhasil',
    		'content'	=> null
    	]);
    }

    public function edit(Request $request){
    	return view('master.datakeuangan.datatransaksi.edit_transaksi');
    }

    public function update(Request $request){
    	$transaksi = transaksi::where('id_transaksi', $request->id);

    	if(!$transaksi->first()){
    		return json_encode([
	    		'status'	=> 'not_exist',
	    		'content'	=> null
	    	]);
    	}

    	$transaksi->update([
    		'nama_transaksi'	=> $request->nama,
    		'type_transaksi'	=> $request->type,
    		'cashflow'			=> $request->cash_flow,

    	]);

    	DB::table('m_transaksi_detail')->where('td_transaksi', $request->id)->delete();

    	foreach ($request->akun_ as $key => $akun) {
    		DB::table('m_transaksi_detail')->insert([
    			'td_transaksi'	=> $request->id,
    			'td_no'			=> ($key + 1),
    			'td_acc'		=> $akun,
    			'td_posisi'		=> $request->akun_dka[$key]
    		]);
    	}

    	return json_encode([
    		'status'	=> 'berhasil',
    		'content'	=> null
    	]);
    }
}
