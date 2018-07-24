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

class jenis_produksiController extends Controller
{
   public function jenis()
    { 
        $data = DB::table('m_jenisproduksi')->get();
        return view('/master/datajenis/jenis',compact('data'));
    }
    public function datatable_jenis()
    {
        $list = DB::select("SELECT * from m_item where i_type = 'BP'  ");
        // return $list;
        $data = collect($list);
        
        // return $data;

        return Datatables::of($data)
            
                ->addColumn('aksi', function ($data) {

                          return  '<button id="edit" onclick="edit(this)" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="hapus(this)" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['aksi','confirmed'])
                ->make(true);
    }

    public function tambah_jenis()
    {
        $satuan  = DB::table('m_satuan')->get();
        return view('/master/datajenis/tambah_jenis',compact('satuan'));
    }
    public function simpan_jenis(Request $request)
    {
      // dd($request->all());
     $tanggal = date("Y-m-d h:i:s");

        $kode = DB::Table('m_item')->max('i_id');

        if ($kode <= 0 || $kode <= '') {
            $kode  = 1;
        }else{
            $kode += 1;
        }

        $data_item = DB::table('m_item')
                ->insert([
                    'i_id' => $kode,
                    'i_name'=>$request->nama,
                    'i_type' => 'BP',
                    'i_code'=> $kode,
                    'i_group'=> $request->group,
                    'i_code_group'=> '101',
                    'i_sat1'=>$request->satuan,
                    'i_sat_isi1'=> $request->min_stock,
                    'i_insert'=>$tanggal,
                ]);


        //------------------------//


        $kode_price = DB::Table('m_price')->max('m_pid');

        if ($kode_price <= 0 || $kode_price <= '') {
            $kode_price  = 1;
        }else{
            $kode_price += 1;
        }

        $data_price = DB::table('m_price')
                ->insert([
                    'm_pid'=>$kode_price,
                    'm_pitem'=>$kode,
                    'm_pbuy'=>$request->harga,
                ]);

      return response()->json(['status'=>1]);
    }
    public function update_jenis(Request $request)
    {
      // dd($request->all());
      $data = DB::table('m_jenisproduksi')
                  ->where('jp_code','=',$request->code_old)
                  ->update([
                    'jp_code'=>$request->id_jp,
                    'jp_name'=>$request->nama,
                    'jp_type'=>$request->jenis,
                  ]);

      return response()->json(['status'=>1]);
    }
    public function hapus_jenis(Request $request)
    {
      // dd($request->all());
      $data = DB::table('m_item')->where('i_code','=',$request->id)->delete();
      $data = DB::table('m_price')->where('m_pitem','=',$request->id)->delete();

      return response()->json(['status'=>1]);
    }

    public function edit_jenis(Request $request)
    {
      // dd($request->all());
      $data = DB::table('m_jenisproduksi')->where('jp_code','=',$request->id)->first();
      json_encode($data);
      return view('/master/datajenis/edit_jenis',compact('data'));
    }
}



