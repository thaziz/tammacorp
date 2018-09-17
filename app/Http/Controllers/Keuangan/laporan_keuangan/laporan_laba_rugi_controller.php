<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class laporan_laba_rugi_controller extends Controller
{
    public function index(){
    	return view('keuangan.laporan_keuangan.laba_rugi.index');
    }
}
