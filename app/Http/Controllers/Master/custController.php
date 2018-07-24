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

class custController extends Controller
{

    public function cust()
    {
        return view('master.datacust.cust');
    }

    public function datatable_cust()
    {
        $list = DB::select("SELECT * from m_customer ");
        // return $list;
        $data = collect($list);
        
        // return $data;

        return Datatables::of($data)
            
                ->addColumn('action', function ($data) {

                         return  '<button id="edit" onclick="edit(this)" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="hapus(this)" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['action','confirmed'])
                ->make(true);
    }

    public function tambah_cust()
    {
        $tanggal = date("ym");

             //select max dari um_id dari table d_uangmuka
        $maxid = DB::Table('m_customer')->select('c_id')->max('c_id');

        //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 

        if ($maxid <= 0 || $maxid <= '') {
          $maxid  = 1;
        }else{
          $maxid += 1;
        }
        $kode = str_pad($maxid, 5, '0', STR_PAD_LEFT);

        $id_cust = 'CUS-' . $tanggal . '/' .  $kode;   
        return view('/master/datacust/tambah_cust', compact('id_cust'));
    }

    public function simpan_cust(Request $request)
    {
        // dd($request->all());
        $tanggal = date("Y-m-d h:i:s");

        $kode = DB::Table('m_customer')->max('c_id');

        if ($kode <= 0 || $kode <= '') {
            $kode  = 1;
        }else{
            $kode += 1;
        }

        $data_item = DB::table('m_customer')
                ->insert([
                    'c_id' => $kode,
                    'c_code'=> $request->id_cus_ut,
                    'c_name'=>$request->nama_cus,
                    'c_type' => $request->tipe_cust,
                    'c_birthday' => date('Y-m-d',strtotime($request->tgl_lahir)),
                    'c_email' => $request->email,
                    'c_hp' => $request->no_hp,
                    'c_address' => $request->alamat,
                    'c_insert'=>$tanggal,
                ]);


        //------------------------//

    return response()->json(['status'=>1]);
    }
    public function hapus_cust(Request $request)
    {
      // dd($request->all());
      $edit_cust = DB::table('m_customer')->where('c_code','=',$request->id)->delete();

      return response()->json(['status'=>1]);
    }
    public function edit_cust(Request $request)
    {
      $edit_cust = DB::table('m_customer')->where('c_code','=',$request->id)->first();
      json_encode($edit_cust);
      return view('master/datacust/edit_cust',compact('edit_cust'));
    }
    public function update_cust(Request $request)
    {
        $tanggal = date("Y-m-d h:i:s");

        $data_item = DB::table('m_customer')
                ->where('c_id','=',$request->id_cus_ut)
                ->update([
                    'c_name'=>$request->nama_cus,
                    'c_type' => $request->tipe_cust,
                    'c_birthday' => date('Y-m-d',strtotime($request->tgl_lahir)),
                    'c_email' => $request->email,
                    'c_hp' => $request->no_hp,
                    'c_address' => $request->alamat,
                    'c_update'=>$tanggal,
                ]);


        //------------------------//
    return response()->json(['status'=>1]);
    }

    

}

