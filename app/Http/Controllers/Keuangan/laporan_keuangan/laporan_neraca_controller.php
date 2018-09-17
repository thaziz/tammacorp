<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class laporan_neraca_controller extends Controller
{
    public function index(Request $request){
    	return view('keuangan.laporan_keuangan.neraca.index');
    }
}
