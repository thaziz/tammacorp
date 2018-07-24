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

class bahan_bakuController extends Controller
{
   public function baku()
    { 
      $data = DB::table('m_bahanbaku')->get();
        return view('/master/databaku/baku',compact('data'));
    }
    public function datatable_baku()
    {
        $list = DB::select("SELECT * from m_item where i_type = 'BB'  ");
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
    public function tambah_baku()
    {
        $satuan  = DB::table('m_satuan')->get();
        return view('/master/databaku/tambah_baku',compact('satuan'));
    }
    public function simpan_baku(Request $request)
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
                    'i_type' => 'BB',
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
    public function update_baku(Request $request)
    {
      // dd($request->all());
      $data = DB::table('m_bahanbaku')
                  ->where('bb_code','=',$request->code_old)
                  ->update([
                    'bb_name'=>$request->nama,
                    'bb_total'=>$request->jumlah,
                    'bb_unit'=>$request->satuan,
                    'bb_price'=>$request->harga,
                  ]);

      return response()->json(['status'=>1]);
    }
    public function hapus_baku(Request $request)
    {
      // dd($request->all());
      $data_item = DB::table('m_item')->where('i_code','=',$request->id)->delete();
      $data_price = DB::table('m_price')->where('m_pitem','=',$request->id)->delete();

      return response()->json(['status'=>1]);
    }
    public function edit_baku(Request $request)
    {
      $data_item = DB::table('m_item')->where('i_code','=',$request->id)->delete();
      $data_price = DB::table('m_price')->where('m_pitem','=',$request->id)->delete();
      json_encode($data_item);
      json_encode($data_price);

      return view('master/databaku/edit_baku',compact('data_item','data_price'));
    }
}


