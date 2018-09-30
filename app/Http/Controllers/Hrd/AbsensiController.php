<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use URL;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\m_pegawai_man;
use App\m_divisi;
use App\abs_pegawai_man;

class AbsensiController extends Controller
{
    public function index(){
      $devisi = m_divisi::all();
      return view('hrd.Absensi.index', compact('devisi'));
    }

    public function table($tgl, $data){
      $d = substr($tgl,0,2);
      $y = substr($tgl, -4);
      $m = substr($tgl, -7,-5);
        $tgl = $y.'-'.$m.'-'.$d;

      $pegawai = m_pegawai_man::select(
          'm_pegawai_man.c_id as mp_id',
          'm_divisi.c_id as md_id',
          'c_nik',
          'c_nama',
          'apm_ket')
        ->join('m_divisi','m_divisi.c_id','=','c_divisi_id')
        ->leftjoin('abs_pegawai_man', function($join) use ($tgl) {
            $join->on('apm_pm', '=', 'm_pegawai_man.c_id')
              ->where('apm_date',$tgl);
          })
        ->where('m_divisi.c_id',$data)
        ->get();
      // dd($pegawai);
      return DataTables::of($pegawai)
      ->addIndexColumn()
      ->editColumn('pegawai', function ($data) {
          return "$data->c_nik - $data->c_nama" ;

      })

      ->addColumn('Alpha', function($data){
          if ($data->apm_ket == "A") {
            return '<input type="hidden"
                        name="apm_pm[]"
                        class="form-control input-sm"
                        value="'.$data->mp_id.'">
                    <input type="hidden"
                        name="apm_ket[]"
                        class="form-control input-sm"
                        id="data'.$data->mp_id.'"
                        value="'.$data->apm_ket.'">
                    <div class="text-center">
                          <div class="radio icheck-primary">
                              <input checked type="radio"
                                    id="'.$data->mp_id.'-1"
                                    name="data'.$data->mp_id.'"
                                    value="A|'.$data->mp_id.'">
                              <label for="'.$data->mp_id.'-1">
                              </label>
                          </div>
                    </div>';
          }else {
            return '<input type="hidden"
                        name="apm_pm[]"
                        class="form-control input-sm"
                        value="'.$data->mp_id.'">
                    <input type="hidden"
                        name="apm_ket[]"
                        class="form-control input-sm"
                        id="data'.$data->mp_id.'"
                        value="">
                    <div class="text-center">
                          <div class="radio icheck-primary">
                              <input type="radio"
                                    id="'.$data->mp_id.'-1"
                                    name="data'.$data->mp_id.'"
                                    value="A|'.$data->mp_id.'">
                              <label for="'.$data->mp_id.'-1">
                              </label>
                          </div>
                    </div>';
          }

      })

      ->addColumn('Izin', function($data){
          if ($data->apm_ket == "I") {
            return '<div class="text-center">
                          <div class="radio icheck-primary">
                              <input checked type="radio"
                                  id="'.$data->mp_id.'-2"
                                  name="data'.$data->mp_id.'"
                                  value="I|'.$data->mp_id.'">
                              <label for="'.$data->mp_id.'-2">
                              </label>
                          </div>
                    </div>';
          }else {
            return '<div class="text-center">
                          <div class="radio icheck-primary">
                              <input type="radio"
                                  id="'.$data->mp_id.'-2"
                                  name="data'.$data->mp_id.'"
                                  value="I|'.$data->mp_id.'">
                              <label for="'.$data->mp_id.'-2">
                              </label>
                          </div>
                    </div>';
          }

      })

      ->addColumn('Sakit', function($data){
          if ($data->apm_ket == "S") {
            return '<div class="text-center">
                          <div class="radio icheck-primary">
                              <input checked type="radio"
                                  id="'.$data->mp_id.'-3"
                                  name="data'.$data->mp_id.'"
                                  value="S|'.$data->mp_id.'">
                              <label for="'.$data->mp_id.'-3">
                              </label>
                          </div>
                    </div>';
          }else {
            return '<div class="text-center">
                          <div class="radio icheck-primary">
                              <input type="radio"
                                  id="'.$data->mp_id.'-3"
                                  name="data'.$data->mp_id.'"
                                  value="S|'.$data->mp_id.'">
                              <label for="'.$data->mp_id.'-3">
                              </label>
                          </div>
                    </div>';
          }

      })

      ->addColumn('Cuti', function($data){
        if ($data->apm_ket == "C") {
          return '<div class="text-center">
                        <div class="radio icheck-primary">
                            <input checked type="radio"
                              id="'.$data->mp_id.'-4"
                              name="data'.$data->mp_id.'"
                              value="C|'.$data->mp_id.'">
                            <label for="'.$data->mp_id.'-4">
                            </label>
                        </div>
                  </div>';
        }else{
          return '<div class="text-center">
                        <div class="radio icheck-primary">
                            <input type="radio"
                              id="'.$data->mp_id.'-4"
                              name="data'.$data->mp_id.'"
                              value="C|'.$data->mp_id.'">
                            <label for="'.$data->mp_id.'-4">
                            </label>
                        </div>
                  </div>';
        }

      })

      ->addColumn('Hadir', function($data){
        if ($data->apm_ket == "H") {
          return '<div class="text-center">
                        <div class="radio icheck-primary">
                            <input checked type="radio"
                              id="'.$data->mp_id.'-5"
                              name="data'.$data->mp_id.'"
                              value="H|'.$data->mp_id.'">
                            <label for="'.$data->mp_id.'-5">
                            </label>
                        </div>
                  </div>';
        }else {
          return '<div class="text-center">
                      <div class="radio icheck-primary">
                            <input type="radio"
                              id="'.$data->mp_id.'-5"
                              name="data'.$data->mp_id.'"
                              value="H|'.$data->mp_id.'">
                            <label for="'.$data->mp_id.'-5">
                            </label>
                      </div>
                  </div>';
        }

      })

      ->rawColumns(['pegawai',
                    'Alpha',
                    'Izin',
                    'Sakit',
                    'Cuti',
                    'Hadir'
                  ])
      ->make(true);

    }

  public function savePeg(Request $request){
    DB::beginTransaction();
      try {
    $tgl = $request->tanggal;
    $d = substr($tgl,0,2);
    $y = substr($tgl, -4);
    $m = substr($tgl, -7,-5);
      $tgl = $y.'-'.$m.'-'.$d;
        for ($i=0; $i <count($request->apm_ket) ; $i++) {
          $id = abs_pegawai_man::select('apm_id')->max('apm_id')+1;
            $cek = abs_pegawai_man::where('apm_pm',$request->apm_pm[$i])
              ->where('apm_date',$tgl)
              ->first();
              // dd($cek);
              if ($cek == null) {
                abs_pegawai_man::insert([
                  'apm_id' => $id,
                  'apm_pm' => $request->apm_pm[$i],
                  'apm_date' => $tgl,
                  'apm_ket' => $request->apm_ket[$i],
                  'apm_insert' => Carbon::now()
                ]);
              }else {
                $cek->update([
                  'apm_ket' => $request->apm_ket[$i],
                  'apm_update' => Carbon::now()
                ]);
              }
        }

    DB::commit();
    return response()->json([
        'status' => 'sukses'
      ]);
    } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
      'status' => 'gagal',
      'data' => $e
      ]);
    }
  }

  public function detAbsensi($tgl1, $tgl2, $data){
    $d = substr($tgl1,0,2);
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
      $tgl1 = $y.'-'.$m.'-'.$d;

    $d2 = substr($tgl2,0,2);
    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $pegawai = m_pegawai_man::select(
        'm_pegawai_man.c_id as mp_id',
        'm_divisi.c_id as md_id',
        'c_nik',
        'c_nama',
        'apm_pm',
        DB::raw("(SELECT count(apm_pm) as a from abs_pegawai_man as ap
        where ap.apm_pm=abs_pegawai_man.apm_pm and apm_ket='A') as Alpha"),

        DB::raw("(SELECT count(apm_pm) as a from abs_pegawai_man as ap
        where ap.apm_pm=abs_pegawai_man.apm_pm and apm_ket='I') as Izin"),

        DB::raw("(SELECT count(apm_pm) as a from abs_pegawai_man as ap
        where ap.apm_pm=abs_pegawai_man.apm_pm and apm_ket='S') as Sakit"),

        DB::raw("(SELECT count(apm_pm) as a from abs_pegawai_man as ap
        where ap.apm_pm=abs_pegawai_man.apm_pm and apm_ket='C') as Cuti"),

        DB::raw("(SELECT count(apm_pm) as a from abs_pegawai_man as ap
        where ap.apm_pm=abs_pegawai_man.apm_pm and apm_ket='H') as Hadir"))

      ->join('m_divisi','m_divisi.c_id','=','c_divisi_id')
      ->leftJoin('abs_pegawai_man','abs_pegawai_man.apm_pm','=','m_pegawai_man.c_id')
      ->where('m_divisi.c_id',$data)
      ->where('apm_date','>=', $tgl1)
      ->where('apm_date','<=', $tgl2)
      ->groupBy('m_pegawai_man.c_id')
      ->get();

      // dd($pegawai);
    return DataTables::of($pegawai)

    ->addIndexColumn()
    ->editColumn('pegawai', function ($data) {
        return "$data->c_nik - $data->c_nama" ;

    })

    ->addColumn('Alpha', function($data){
      return '<input  name="c_id[]"
                      class="form-control text-right"
                      readonly
                      value="'.$data->Alpha.'">';
    })

    ->addColumn('Izin', function($data){
      return '<input  name="c_id[]"
                      class="form-control text-right"
                      readonly
                      value="'.$data->Izin.'">';
    })

    ->addColumn('Sakit', function($data){
      return '<input  name="c_id[]"
                      class="form-control text-right"
                      readonly
                      value="'.$data->Sakit.'">';
    })

    ->addColumn('Cuti', function($data){
      return '<input  name="c_id[]"
                      class="form-control text-right"
                      readonly
                      value="'.$data->Cuti.'">';
    })

    ->addColumn('Hadir', function($data){
      return '<input  name="c_id[]"
                      class="form-control text-right"
                      readonly
                      value="'.$data->Hadir.'">';
    })
    ->rawColumns(['pegawai',
                  'Alpha',
                  'Izin',
                  'Sakit',
                  'Cuti',
                  'Hadir'
                ])
    ->make(true);

  }
}
