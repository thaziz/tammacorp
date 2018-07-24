<?php

namespace App\Http\Controllers\master;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;

// use App\mmember

class groupController extends Controller
{
    public function group()
    { 
        $data = DB::table('m_group')->get();
        return view('/master/datagroup/group',compact('data'));
    }
    public function datatable_group()
    {
        $list = DB::select("SELECT * from m_group");
        // return $list;
        $data = collect($list);
        
        // return $data;

        return Datatables::of($data)
            
                ->addColumn('aksi', function ($data) {
              return  
              '<button id="edit" onclick="edit(this)" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.
              '<button id="delete" onclick="hapus(this)" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['aksi','confirmed'])
                ->make(true);
    }
    public function tambah_group(Request $request)
    {
        $kode = DB::table('m_group')->max('m_gid');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $tanggal = date("ym");

        $kode = str_pad($kode, 3, '0', STR_PAD_LEFT);

        $nota = $kode;
        $item = DB::table('m_item')->get();
        return view('/master/datagroup/tambah_group',compact('nota','item'));
    }
    public function simpan_group(Request $request)
    {
        $kode = DB::table('m_group')->max('m_gid');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $kode = DB::table('m_group')
                  ->insert([
                      'm_gid'=>$kode,
                      'm_gcode'=>$request->id,
                      'm_gname'=>$request->nama,
                      'm_gitem'=>$request->item,
                      'm_gtype'=>$request->type,
                    ]);
    }
    public function hapus_group(Request $request)
    {
      $data = DB::table('m_group')->where('m_gcode','=',$request->id)->delete();
      return response()->json(['status'=>1]);
    }
    public function edit_group(Request $request)
    {
      $data = DB::table('m_group')->where('m_gcode','=',$request->id)->first();
      json_encode($data);
      $item = DB::table('m_item')->get();
      return view('master/datagroup/edit_group',compact('data','item'));
    }
    public function update_group(Request $request)
    {
      $tanggal = date("Y-m-d h:i:s");

      $kode = DB::table('m_group')
                  ->where('m_gcode','=',$request->id)
                  ->update([
                      'm_gname'=>$request->nama,
                      'm_gitem'=>$request->item,
                      'm_gupdate'=>$tanggal,
                      'm_gtype'=>$request->type,
                    ]);
      return response()->json(['status'=>1]);
    }


}



