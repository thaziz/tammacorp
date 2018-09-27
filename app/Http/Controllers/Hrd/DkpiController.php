<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Hrd\d_kpi;
use App\Model\Hrd\d_kpi_dt;
use App\Model\Master\m_kpi;
use Response;
use DB;
use DataTables;
use Auth;

class DkpiController extends Controller
{
    public function index()
    {
        //dd(Auth::user());
        return view('hrd/datainputkpi/index');
    }

    public function getKpiByTgl($tgl1, $tgl2)
    {
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        $data = d_kpi::join('m_pegawai_man','d_kpi.d_kpi_pid','=','m_pegawai_man.c_id')->whereBetween('d_kpi_date', [$tanggal1, $tanggal2])->orderBy('d_kpi_created', 'DESC')->get();

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
                                onclick=detailKpi("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit"
                                onclick=editKpi("'.$data->d_kpi_id.'")><i class="fa fa-edit"></i> readonly 
                            </button>
                            <button class="btn btn-sm btn-danger" title="Hapus"
                                onclick=hapusKpi("'.$data->d_kpi_id.'")><i class="fa fa-times-circle"></i> readonly
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit"
                                onclick=editKpi("'.$data->d_kpi_id.'")><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-danger" title="Hapus"
                                onclick=hapusKpi("'.$data->d_kpi_id.'")><i class="fa fa-times-circle"></i>
                            </button>
                        </div>';
            }
            
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function lookup_divisi(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $jenis_peg = $request->jenis;
        if (empty($term)) 
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

            return Response::json($formatted_tags);
        }
        else
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

          return Response::json($formatted_tags);  
        }
    }

    public function setFieldModal()
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $data = DB::table('m_pegawai_man')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
            ->select(
                'm_pegawai_man.c_nama',
                'm_pegawai_man.c_divisi_id',
                'm_pegawai_man.c_jabatan_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('m_pegawai_man.c_id', '=', $id_peg)->first();

        $kpi = m_kpi::where('kpi_p_id', '=', $id_peg)->get();
        return response()->json([
            'status' => 'sukses',
            'id_peg' => $id_peg,
            'data' => $data,
            'kpi' => $kpi
        ]);
    }

    public function simpanData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //code penerimaan
            $kode = $this->kodeKpiAuto();
            $lastId = d_kpi::select('d_kpi_id')->max('d_kpi_id');
            if ($lastId == 0 || $lastId == '') { $lastId  = 1; } else { $lastId += 1; } 
            
            $kpi = new d_kpi;
            $kpi->d_kpi_id = $lastId;
            $kpi->d_kpi_code = $kode;
            $kpi->d_kpi_pid = $request->idpegawai;
            $kpi->d_kpi_date = date('Y-m-d',strtotime($request->tglKpi));
            $kpi->d_kpi_created = date("Y-m-d h:i:s");
            $kpi->save();

            if (isset($request->index_kpi_opsi)) 
            {
                $str_opsi = implode(",", $request->value_kpi_opsi);
                $index_opsi = $request->index_kpi_opsi[0];

                $kpi_dt = new d_kpi_dt;
                $kpi_dt->d_kpidt_dkpi_id = $lastId;
                $kpi_dt->d_kpidt_mkpi_id = $index_opsi;
                $kpi_dt->d_kpidt_value = strtoupper($str_opsi);
                $kpi_dt->d_kpidt_created = date("Y-m-d h:i:s");
                $kpi_dt->save();
            }

            for ($i=0; $i < count($request->value_kpi); $i++) 
            { 
                d_kpi_dt::insert([
                            'd_kpidt_dkpi_id' => $lastId,
                            'd_kpidt_mkpi_id' => $request->index_kpi[$i],
                            'd_kpidt_value' => strtoupper($request->value_kpi[$i]),
                            'd_kpidt_created' => date("Y-m-d h:i:s")
                        ]);
            }
                   
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data KPI Berhasil Disimpan'
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

    public function kodeKpiAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_kpi_code,4)) as kode_max from d_kpi WHERE DATE_FORMAT(d_kpi_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
        $kd = "";

        if(count($query)>0)
        {
          foreach($query as $k)
          {
            $tmp = ((int)$k->kode_max)+1;
            $kd = sprintf("%04s", $tmp);
          }
        }
        else
        {
          $kd = "0001";
        }

        return $code = "KPI-".date('ym')."-".$kd;
    }

    public function getDataEdit($id)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $pegawai = d_kpi::join('m_pegawai_man', 'd_kpi.d_kpi_pid', '=', 'm_pegawai_man.c_id')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
            ->select(
                'm_pegawai_man.c_nama',
                'm_pegawai_man.c_divisi_id',
                'm_pegawai_man.c_jabatan_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('d_kpi.d_kpi_pid', '=', $id_peg)->first();

        $data = d_kpi::join('d_kpi_dt', 'd_kpi.d_kpi_id', '=', 'd_kpi_dt.d_kpidt_dkpi_id')
                            ->join('m_kpi', 'd_kpi_dt.d_kpidt_mkpi_id', '=', 'm_kpi.kpi_id')
                            ->where('d_kpi.d_kpi_id', $id)->get();

        return response()->json([
            'status' => 'sukses',
            'id_peg' => $id_peg,
            'pegawai' => $pegawai,
            'data' => $data
        ]);
    }

    public function updateData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");

            $d_kpi = d_kpi::find($request->e_old);
            $d_kpi->d_kpi_date = date('Y-m-d',strtotime($request->eTglKpi));
            $d_kpi->d_kpi_updated = $tanggal;
            $d_kpi->save();

            if (isset($request->e_index_kpi_opsi)) 
            {
                $str_opsi = implode(",", $request->e_value_kpi_opsi);
                $index_opsi = $request->e_index_kpi_opsi[0];

                d_kpi_dt::where('d_kpidt_id','=',$request->e_index_dt_opsi[0])
                        ->update([
                            'd_kpidt_value' => strtoupper($str_opsi),
                            'd_kpidt_updated' => date("Y-m-d h:i:s")
                        ]);
            }

            for ($i=0; $i < count($request->e_value_kpi); $i++) 
            { 
                d_kpi_dt::where('d_kpidt_id','=',$request->e_index_dt[$i])
                        ->update([
                            'd_kpidt_value' => strtoupper($request->e_value_kpi[$i]),
                            'd_kpidt_updated' => date("Y-m-d h:i:s")
                        ]);
            }

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Input KPI Berhasil Diupdate'
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

    public function deleteData(Request $request)
    {
      DB::beginTransaction();
      try {
        d_kpi_dt::where('d_kpidt_dkpi_id', $request->id)->delete();
        d_kpi::where('d_kpi_id', $request->id)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Input KPI Berhasil Dihapus'
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

    // =======================================================================================================================
}
