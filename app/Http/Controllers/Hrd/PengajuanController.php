<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use DataTables;
use URL;
use App\m_jabatan;
use App\m_pegawai_man;
use App\f_pelatihan;
use App\fp_detail;
use Auth;

class PengajuanController extends Controller
{
    public function index(){
      $jabatan = m_jabatan::select('c_id',
        'c_posisi')
        ->get();
      $staf = m_pegawai_man::select('m_pegawai_man.c_id as mp_id',
          'c_nama')
        ->join('m_jabatan','m_jabatan.c_id','=','c_jabatan_id')
        ->where('c_sub_divisi_id',2)
        ->get();
      // dd($staf);
      $staff['nama'] = Auth::user()->m_name;
      $staff['id'] = Auth::User()->m_id;

      return view('hrd.Pengajuan.index', compact('staff','jabatan','staf'));
    }

    public function tablePengajuan(){
      $data = f_pelatihan::select('fp_soal')
        ->join('fp_detail','fp_detail.fpd_fp','=','fp_id')
        ->get();

      dd($data);
    }
}
