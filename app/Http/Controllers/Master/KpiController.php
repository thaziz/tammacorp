<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;
use App\Model\Master\m_kpi;

// use App\mmember

class KpiController extends Controller
{
    public function index()
    {
        return view('master.datakpi.index');
    }

    public function tambah_kpi()
    {
        return view('master.datakpi.tambah');
    }

    public function get_datatable_index()
    {
        $data = m_kpi::join('m_pegawai_man', 'm_kpi.kpi_p_id', '=', 'm_pegawai_man.c_id')
                    ->join('m_divisi', 'm_kpi.kpi_div_id', '=', 'm_divisi.c_id')
                    ->join('m_jabatan', 'm_kpi.kpi_jabatan_id', '=', 'm_jabatan.c_id')
                    ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($data) 
        {  
            return  '<button id="edit" onclick=edit("'.$data->kpi_id.'") class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>'.'
                    <button id="delete" onclick=hapus("'.$data->kpi_id.'") class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-times-circle"></i>
                    </button>';
        })
        ->addColumn('opsi', function ($data) 
        {  
            if ($data->kpi_opsi != "" || $data->kpi_opsi != null ) 
            {
                //$arr = explode(',', $data->kpi_opsi);\
                return $data->kpi_opsi;
            }
            else 
            {
                return "-";
            }
        })
        ->rawColumns(['action','opsi'])
        ->make(true);
    }

    public function lookup_jabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->where('c_posisi', 'LIKE', '%'.$term.'%')->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function lookup_pegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', '=', $request->divisi)->where('c_jabatan_id', '=', $request->jabatan)->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $pegawai = DB::table('m_sub_divisi')->where('c_divisi_id', '=', $request->divisi)->where('c_jabatan_id', '=', $request->jabatan)->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) 
            {
            $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function simpan_kpi(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            $id = DB::table('m_kpi')->select('kpi_id')->max('kpi_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $str_opsi = implode(",",$request->opsi_kpi);

            $kpi = new m_kpi();
            $kpi->kpi_id = $id;
            $kpi->kpi_name = $request->nama_kpi;
            $kpi->kpi_p_id = $request->peg_kpi;
            $kpi->kpi_div_id = $request->div_kpi;
            $kpi->kpi_jabatan_id = $request->jbtn_kpi;
            if ($str_opsi == "") { $kpi->kpi_opsi = null; }else{ $kpi->kpi_opsi = $str_opsi; }
            $kpi->kpi_created = $tanggal;
            $kpi->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Disimpan'
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

    public function edit_kpi(Request $request)
    {
        $data = m_kpi::join('m_pegawai_man', 'm_kpi.kpi_p_id', '=', 'm_pegawai_man.c_id')
                    ->join('m_divisi', 'm_kpi.kpi_div_id', '=', 'm_divisi.c_id')
                    ->join('m_jabatan', 'm_kpi.kpi_jabatan_id', '=', 'm_jabatan.c_id')
                    ->where('m_kpi.kpi_id', '=', $request->id)
                    ->first();
        if ($data->kpi_opsi != null) {
            $arr_opsi = explode(',', $data->kpi_opsi);
            //rand string untuk div id html
            $rand_string = array();
            for ($i=0; $i < count($arr_opsi); $i++) { 
                $rand_string[$i] = $this->generateRandomString();
            }
        }else{
            $arr_opsi = '';
            $rand_string = '';
        }
        return view('master/datakpi/edit', compact('data', 'arr_opsi', 'rand_string'));
    }

    public function update_kpi(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");
            $str_opsi = implode(",",$request->opsi_kpi);

            $kpi = m_kpi::find($request->kode_old);
            $kpi->kpi_name = $request->nama_kpi;
            $kpi->kpi_p_id = $request->peg_kpi;
            $kpi->kpi_div_id = $request->div_kpi;
            $kpi->kpi_jabatan_id = $request->jbtn_kpi;
            if ($str_opsi == "") { $kpi->kpi_opsi = null; }else{ $kpi->kpi_opsi = $str_opsi; }
            $kpi->kpi_updated = $tanggal;
            $kpi->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Diupdate'
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

    public function delete_kpi(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            $kpi = m_kpi::find($request->id);
            $kpi->delete();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Dihapus'
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

    function generateRandomString($length = 5) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    // =======================================================================================================================
}