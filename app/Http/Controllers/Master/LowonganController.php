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

// use App\mmember

class LowonganController extends Controller
{
    public function index()
    {
        return view('master.datalowongan.index');
    }

    public function tambah_data()
    {
    	
        $kode = $this->kode_lowongan();
        return view('master.datalowongan.tambah',compact('kode'));
    }

    public function simpan_data(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
        	$id = DB::table('d_lowongan')->select('l_id')->max('l_id');
        	if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            DB::table('d_lowongan')
                ->insert([
                    'l_id'=>$id,
                    'l_code' => $request->kode,
                    'l_name'=>strtoupper($request->nama),
                    'l_created'=>$tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Lowongan Berhasil Disimpan'
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

    public function kode_lowongan()
    {
        $kode = DB::select(DB::raw("SELECT MAX(RIGHT(l_code,3)) as kode_max from d_lowongan"));
        $kd = "";

        if(count($kode)>0)
        {
            foreach($kode as $k)
            {
                $tmp = ((int)$k->kode_max)+1;
                $kd = sprintf("%03s", $tmp);
            }
        }
        else
        {
            $kd = "001";
        }

        return $code = 'LWG-'.$kd;
    } 

    public function get_datatable_index()
    {
        $data = DB::table('d_lowongan')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($data) 
        {  
            if ($data->l_isactive == "Y") 
            {
                return  '<button id="edit" onclick=edit("'.$data->l_id.'") class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                      <button id="delete" onclick=gantiStatus("'.$data->l_id.'","aktif") class="btn btn-danger btn-sm" title="Nonaktifan"><i class="glyphicon glyphicon-remove"></i></button>';
            }
            else
            {
                return  '<button id="edit" onclick=edit("'.$data->l_id.'") class="btn btn-warning btn-sm disabled" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                      <button id="delete" onclick=gantiStatus("'.$data->l_id.'","nonaktif") class="btn btn-info btn-sm" title="Aktifkan"><i class="glyphicon glyphicon-ok"></i></button>';
            }
        })
        ->addColumn('status', function ($data) {
            if ($data->l_isactive == 'Y') {
            	return '<span style="color:blue">Aktif</span>';
            }else{
            	return '<span style="color:red">Nonaktif</span>';
            }
        })
        ->rawColumns(['aksi','status'])
        ->make(true);
    }

    public function ubah_status(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");
            if ($request->statusBrg == 'aktif') {
                $active = 'N';
                $pesan = 'Data Lowongan berhasil Dinonaktifkan';
            }else{
                $active = 'Y';
                $pesan = 'Data Lowongan berhasil Diaktifkan';
            }
            
            DB::table('d_lowongan')
                ->where('l_id','=',$request->id)
                ->update([
                    'l_updated' => $tanggal,
                    'l_isactive' => $active
                ]);

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

    public function edit_data(Request $request)
    {
        $data = DB::table('d_lowongan')->where('l_id','=',$request->id)->first();
        return view('master/datalowongan/edit', compact('data'));
    }

    public function update_data(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");
            DB::table('d_lowongan')
                ->where('l_id','=',$request->kode_old)
                ->update([
                    'l_name'=>strtoupper($request->nama),
                    'l_updated'=>$tanggal,
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Lowongan Berhasil Diupdate'
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