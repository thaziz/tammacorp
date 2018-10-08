<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\abs_pegawai_man;
use App\m_pegawai_man;
use App\Model\Hrd\d_payroll_man;
use App\Model\Hrd\d_lembur;
use Response;
use DB;
use DataTables;
use Auth;

class PayrollmanController extends Controller
{
    public function index()
    {
        $data = DB::table('m_divisi')->select('c_id', 'c_divisi')->get();
        return view('hrd/payrollman/index', compact('data'));
    }

    public function listGajiManajemen(Request $request)
    {
        $tanggal = $request->thn . '-' . $request->bln . '-01';
        $jml_hari = cal_days_in_month(CAL_GREGORIAN, $request->bln, $request->thn);
        //$tanggal = date('Y-m-d',strtotime($tgl1));
        
        if ($request->status == 'ALL') {
            $data = m_pegawai_man::leftjoin('d_payroll_man','m_pegawai_man.c_id','=','d_payroll_man.d_pm_pid')
                        ->where('c_divisi_id', $request->divisi)
                        // ->where('d_pm_date', $tanggal)
                        ->orderBy('d_pm_created', 'DESC')->get();
        }else{  
            $data = m_pegawai_man::leftjoin('d_payroll_man','m_pegawai_man.c_id','=','d_payroll_man.d_pm_pid')
                        ->where('d_pm_iscetak', '=', $request->status)
                        ->where('c_divisi_id', $request->divisi)
                        ->where('d_pm_date', $tanggal)
                        ->orderBy('d_pm_created', 'DESC')->get();
        }
        dd($data);
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_kpix_date == null) {
                return '-';
            } else {
                return $data->d_kpix_date ? with(new Carbon($data->d_kpix_date))->format('d M Y') : '';
            }
        })
        ->editColumn('status', function ($data) 
        {
            if ($data->d_kpix_isconfirm == 'N') {
                return '<span style="color:red;text-align:center;"> Belum Dikonfirmasi </span>';
            } else {
                return '<span style="color:blue;text-align:center;"> Sudah Dikonfirmasi </span>';
            }
        })
        ->editColumn('tglConfirm', function ($data) 
        {
            if ($data->d_kpix_dateconfirm == null) {
                return '-';
            } else {
                return $data->d_kpix_dateconfirm ? with(new Carbon($data->d_kpix_dateconfirm))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        { 
            if ($data->d_kpix_isconfirm == 'Y') {
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpix_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-info" title="Confirm"
                                onclick=confirmKpi("'.$data->d_kpix_id.'") disabled><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-danger" title="Batalkan Konfirmasi"
                                onclick=ubahStatus("'.$data->d_kpix_id.'","Y")><i class="fa fa-mail-forward"></i>
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpix_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-info" title="Confirm"
                                onclick=confirmKpi("'.$data->d_kpix_id.'")><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-default" title="Konfirmasi"
                                onclick=ubahStatus("'.$data->d_kpix_id.'","N") disabled><i class="fa fa-mail-reply"></i>
                            </button>
                        </div>';
            }  
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function lookupDivisi(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $divisi = DB::table('m_divisi')->orderBy('c_divisi', 'ASC')->limit(10)->get();
            foreach ($divisi as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {  
            $divisi = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->orderBy('c_divisi', 'ASC')->limit(10)->get();
            foreach ($divisi as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
            }
            return Response::json($formatted_tags);  
        }
    }

    public function lookupJabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', $request->divisi)->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {  
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', $request->divisi)->where('c_posisi', 'LIKE', '%'.$term.'%')->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return Response::json($formatted_tags);  
        }
    }

    public function lookupPegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', $request->divisi)->where('c_jabatan_id', $request->jabatan)->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);
        }
        else
        {  
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', $request->divisi)->where('c_jabatan_id', $request->jabatan)->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);  
        }
    }

    public function setFieldModal(Request $request)
    {
        //pertanggalan
        $tahun = date("Y");
        $tanggal_a = date('Y-m-d',strtotime($request->sDate));
        $tanggal_b = date('Y-m-d',strtotime($request->lDate));
        //tgl minggu dalam periode yang ditentukan
        $tgl_minggu = $this->cariMinggu($tanggal_a, $tanggal_b);
        //hitung jumlah lembur pada hari minggu
        $jml_lembur_minggu = 0;
        $datalembur = d_lembur::select('d_lembur_id', 'd_lembur_date')->where('d_lembur_jenispeg', 'MAN')->where('d_lembur_pid', $request->pegawai)->whereBetween('d_lembur_date', [$tanggal_a, $tanggal_b])->get();
        foreach ($datalembur as $aa) {
            for ($i=0; $i <count($tgl_minggu); $i++) {
                if ($aa->d_lembur_date != $tgl_minggu[$i]) {
                    $jml_lembur_minggu += 0; 
                } else {
                    $jml_lembur_minggu += 1; 
                }
            }
        }

        //jumlah hari periode terpilih
        //$jml_hari = (int)$this->hitungSelisihTanggal($tanggal_a, $tanggal_b);
        //data pegawai
        $d_pegawai = m_pegawai_man::select('c_anak','c_nikah','c_pendidikan')->where('c_id', $request->pegawai)->first();

        //pendidikan
        if ($d_pegawai->c_pendidikan == 'S2') {
            $akronim_title = 'c_s1';
        }else{
            $akronim_title = strtolower('c_'.$d_pegawai->c_pendidikan);
        }

        //gaji pokok
        $gj = DB::table('m_gaji_man')->select($akronim_title)->first();
        $gapok = (int)$gj->$akronim_title;

        //level pegawai
        $lp = DB::table('m_jabatan')->select('c_sub_divisi_id')->where('c_id', $request->jabatan)->where('c_divisi_id', $request->divisi)->first();
        $lvl_peg = $lp->c_sub_divisi_id;

        //kelola data absensi
        $d_absen = abs_pegawai_man::where('apm_pm', $request->pegawai)->whereBetween('apm_tanggal', [$tanggal_a, $tanggal_b])->get();

        //kelola tunjangan
        if (count($d_absen) > 0) {
            foreach ($d_absen as $val) {
                if ($val->apm_absent != null) { $alpha[] = $val->apm_absent; } else { $hadir[] = $val->apm_absent; }
                if ($val->apm_lembur != null) { $lembur[] = $val->apm_lembur; } else { $lembur[] = "00:00:00"; }
            }
        }

        //hitung lembur jam reguler
        $jam_lembur = 0;
        for ($i=0; $i < count($lembur); $i++) {
            $d_lembur = explode(':', $lembur[$i]);
            if ($d_lembur[1] <= '30') { 
                $jam_lembur += (int)$d_lembur[0];
            }else{
                $jam_lembur += ((int)$d_lembur[0] + 1);
            }
        }
        //dd($jam_lembur);
        if ($lvl_peg == '1') 
        {
            $tunjangan = DB::table('m_tunjangan_man')->where('tman_levelpeg', '!=' ,'ST')->get();
            foreach ($tunjangan as $value) 
            {
                if ($value->tman_id == '2') { 
                    //$t_kehadiran = str_replace('.', '', $value->tman_value * ($jml_hari-count($alpha)));
                    $t_kehadiran = (int)$value->tman_value * count($hadir); 
                }
                if ($value->tman_id == '4') {
                    $t_uang_makan = (int)$value->tman_value * count($hadir); 
                }
                if ($value->tman_id == '6') {
                    $t_anak = (int)$value->tman_value * $d_pegawai->c_anak; 
                }
                if ($value->tman_id == '7') {
                    if ($d_pegawai->c_nikah == 'Menikah') { $t_istri = (int)$value->tman_value; }else{ $t_istri = 0; }    
                }
                if ($value->tman_id == '8') {
                   $t_kesehatan = (int)$value->tman_value; 
                }
                if ($value->tman_id == '10') {
                   $t_transport = (int)$value->tman_value * count($hadir); 
                }
                if ($value->tman_id == '11') {
                   $t_lembur_jam = (int)$value->tman_value * $jam_lembur; 
                }
                if ($value->tman_id == '12') {
                   $t_lembur_mingguan = (int)$value->tman_value * $jml_lembur_minggu; 
                }
            }
        }
        else
        {
            $tunjangan = DB::table('m_tunjangan_man')->where('tman_levelpeg', '!=' ,'LD')->get();
            foreach ($tunjangan as $value) 
            {
                if ($value->tman_id == '3') { 
                    //$t_kehadiran = str_replace('.', '', $value->tman_value * ($jml_hari-count($alpha)));
                    $t_kehadiran = (int)$value->tman_value * count($hadir); 
                }
                if ($value->tman_id == '4') {
                    $t_uang_makan = (int)$value->tman_value * count($hadir); 
                }
                if ($value->tman_id == '6') {
                    $t_anak = (int)$value->tman_value * $d_pegawai->c_anak; 
                }
                if ($value->tman_id == '7') {
                    if ($d_pegawai->c_nikah == 'Menikah') { $t_istri = (int)$value->tman_value; }else{ $t_istri = 0; }    
                }
                if ($value->tman_id == '9') {
                   $t_kesehatan = (int)$value->tman_value; 
                }
                if ($value->tman_id == '10') {
                   $t_transport = (int)$value->tman_value * count($hadir); 
                }
                if ($value->tman_id == '11') {
                   $t_lembur_jam = (int)$value->tman_value * $jam_lembur; 
                }
                if ($value->tman_id == '13') {
                   $t_lembur_mingguan = (int)$value->tman_value * $jml_lembur_minggu; 
                }
            }
        }
        //dd($t_kehadiran);
        $arr_income = array($gapok, $t_kehadiran,$t_uang_makan ,$t_anak, $t_istri, $t_kesehatan, $t_transport, $t_lembur_jam, $t_lembur_mingguan);
        $total_income = array_sum($arr_income);
        dd($tunjangan);
        dd($gapok, $t_kehadiran,$t_uang_makan ,$t_anak, $t_istri, $t_kesehatan, $t_transport, $t_lembur_jam, $t_lembur_mingguan, $total_income);

        /*return response()->json([
            'status' => 'sukses',
            'id_peg' => $id_peg,
            'data' => $data,
            'kpi' => $kpi
        ]);*/
    }



    //=====================================================================================================================

    /*public function cariMinggu($tahun,$bulan)
    { 
        $date = "$tahun-$bulan-01";
        $first_day = date('N',strtotime($date));
        $first_day = 7 - $first_day + 1;
        $last_day =  date('t',strtotime($date));
        $days = array();
        for($i=$first_day; $i <= $last_day; $i=$i+7 )
        {
            $ymd[] = date('Y-m-d', strtotime($tahun.'-'.$bulan.'-'.$i));
        }
        return  $ymd;
    }*/

    function cariMinggu($start, $end) 
    {
        $timestamp1 = strtotime($start);
        $timestamp2 = strtotime($end);
        $sundays    = array();
        $oneDay     = 60*60*24;

        for($i = $timestamp1; $i <= $timestamp2; $i += $oneDay) {
            $day = date('N', $i);
            // If sunday
            if($day == 7) {
                // Save sunday in format YYYY-MM-DD, if you need just timestamp
                // save only $i
                $sundays[] = date('Y-m-d', $i);

                // Since we know it is sunday, we can simply skip 
                // next 6 days so we get right to next sunday
                $i += 6 * $oneDay;
            }
        }

        return $sundays;
    }

    function hitungSelisihTanggal($tgl1, $tgl2) 
    {
        $datetime1 = date_create($tgl1);
        $datetime2 = date_create($tgl2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format('%d%');
    }



    public function tambahData($id)
    {
        $id_peg = d_kpix::select('d_kpix_pid')->where('d_kpix.d_kpix_id', $id)->first();

        $data = d_kpix::join('d_kpix_dt', 'd_kpix.d_kpix_id', '=', 'd_kpix_dt.d_kpixdt_dkpix_id')
                            ->join('m_kpix', 'd_kpix_dt.d_kpixdt_mkpix_id', '=', 'm_kpix.kpix_id')
                            ->where('d_kpix.d_kpix_id', $id)->get();
        foreach ($data as $val) {
            $score[] = ((int)$val->d_kpixdt_value / (int)$val->kpix_target) * 100;
        }

        $pegawai = d_kpix::join('m_pegawai_man', 'd_kpix.d_kpix_pid', '=', 'm_pegawai_man.c_id')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
            ->select(
                'm_pegawai_man.c_nama',
                'm_pegawai_man.c_divisi_id',
                'm_pegawai_man.c_jabatan_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('d_kpix.d_kpix_pid', '=', $id_peg->d_kpix_pid)->first();

        return response()->json([
            'status' => 'sukses',
            'pegawai' => $pegawai,
            'data' => $data,
            'scoreKpi' => $score
        ]);
    }

    

    

    public function getDataEdit($id)
    {
        $id_peg = d_kpix::select('d_kpix_pid')->where('d_kpix.d_kpix_id', $id)->first();

        $data = d_kpix::join('d_kpix_dt', 'd_kpix.d_kpix_id', '=', 'd_kpix_dt.d_kpixdt_dkpix_id')
                            ->join('m_kpix', 'd_kpix_dt.d_kpixdt_mkpix_id', '=', 'm_kpix.kpix_id')
                            ->where('d_kpix.d_kpix_id', $id)->get();
        foreach ($data as $val) {
            $score[] = ((int)$val->d_kpixdt_value / (int)$val->kpix_target) * 100;
        }

        $pegawai = d_kpix::join('m_pegawai_man', 'd_kpix.d_kpix_pid', '=', 'm_pegawai_man.c_id')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
            ->select(
                'm_pegawai_man.c_nama',
                'm_pegawai_man.c_divisi_id',
                'm_pegawai_man.c_jabatan_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('d_kpix.d_kpix_pid', '=', $id_peg->d_kpix_pid)->first();

        return response()->json([
            'status' => 'sukses',
            'pegawai' => $pegawai,
            'data' => $data,
            'scoreKpi' => $score
        ]);
    }

    public function updateData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $tanggal =  Carbon::now('Asia/Jakarta');
            $totalSkor = 0;

            for ($i=0; $i < count($request->e_index_kpix); $i++) 
            { 
                $skorAkhir = floatval($request->e_score_kpix[$i]) * floatval($request->e_bobot_kpix[$i]) / 100;
                d_kpix_dt::where('d_kpixdt_id','=',$request->e_index_dt[$i])
                        ->update([
                            'd_kpixdt_value' => $request->e_value_kpix[$i],
                            'd_kpixdt_score' => $request->e_score_kpix[$i],
                            'd_kpixdt_scoreakhir' => $skorAkhir,
                            'd_kpixdt_updated' => Carbon::now('Asia/Jakarta')
                        ]);
                $totalSkor += $skorAkhir;
            }

            $d_kpix = d_kpix::find($request->e_old);
            $d_kpix->d_kpix_date = date('Y-m-d',strtotime($request->eTglKpix));
            $d_kpix->d_kpix_updated = $tanggal;
            $d_kpix->d_kpix_isconfirm = 'Y';
            $d_kpix->d_kpix_dateconfirm = $tanggal;
            $d_kpix->d_kpix_scoretotal = $totalSkor;
            $d_kpix->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data KPI Berhasil Dikonfirmasi'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function ubahStatus(Request $request)
    {
      DB::beginTransaction();
      try 
      {
        $tanggal = Carbon::now('Asia/Jakarta');
        $d_kpix = d_kpix::find($request->id);
        if ($request->status == 'Y') 
        {
            $d_kpix->d_kpix_dateconfirm = null;
            $d_kpix->d_kpix_isconfirm = 'N';
            $pesan = 'Pembatalan konfirmasi data KPI berhasil';
        }
        else
        {
            $d_kpix->d_kpix_dateconfirm = $tanggal;
            $d_kpix->d_kpix_isconfirm = 'Y';
            $pesan = 'Konfirmasi data KPI berhasil';
        }
        $d_kpix->save();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => $pesan
        ]);
      } 
      catch (\Exception $e) 
      {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
      }
    }

    public function getScoreByTgl($tgl1, $tgl2, $tampil)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        
        if ($tampil == 'ALL') {
            $data = d_kpi::join('m_pegawai_man','d_kpi.d_kpi_pid','=','m_pegawai_man.c_id')
                        ->whereBetween('d_kpi_date', [$tanggal1, $tanggal2])
                        ->orderBy('d_kpi_created', 'DESC')->get();
        }else{
            $data = d_kpi::join('m_pegawai_man','d_kpi.d_kpi_pid','=','m_pegawai_man.c_id')
                        ->where('d_kpi.d_kpi_isconfirm', '=', $tampil)
                        ->whereBetween('d_kpi_date', [$tanggal1, $tanggal2])
                        ->orderBy('d_kpi_created', 'DESC')->get();    
        }
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_kpi_date == null) {
                return '-';
            } else {
                return $data->d_kpi_date ? with(new Carbon($data->d_kpi_date))->format('d M Y') : '';
            }
        })
        ->editColumn('status', function ($data) 
        {
            if ($data->d_kpi_isconfirm == 'N') {
                return '<span style="color:red;text-align:center;"> Belum Dikonfirmasi </span>';
            } else {
                return '<span style="color:blue;text-align:center;"> Sudah Dikonfirmasi </span>';
            }
        })
        ->editColumn('tglConfirm', function ($data) 
        {
            if ($data->d_kpi_dateconfirm == null) {
                return '-';
            } else {
                return $data->d_kpi_dateconfirm ? with(new Carbon($data->d_kpi_dateconfirm))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        { 
            if ($data->d_kpi_isconfirm == 'Y') {
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailScore("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailScore("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                        </div>';
            }  
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    // =======================================================================================================================
}
