<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;
use App\Model\Keuangan\d_group_akun as group_akun;
use DB;

class laporan_neraca_controller extends Controller
{
    public function index(Request $request){
    	$data = group_akun::select('*')
    			->where('type_group', 'neraca')
    			->with(['akun_neraca' => function($query){
    				$query->where('type_akun', 'DETAIL')
    						->select('id_akun', 'group_neraca', 'nama_akun')
    						->get();
    			}])
    			->select('id_group', 'nama_group', 'no_group')
    			->orderBy('id_group', 'asc')
    			->get();

    	return json_encode($data);
    	return view('keuangan.laporan_keuangan.neraca.index');
    }
}
