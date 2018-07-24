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

class barangController extends Controller
{

    public function barang()
    {
        return view('master.databarang.barang');
    }

    public function datatable_barang()
    {
        $list = DB::table('m_item')
                ->join('m_price','m_item.i_id','=','m_price.m_pitem')
                ->join('m_group','m_item.i_code_group','=','m_group.m_gcode')
                ->join('m_satuan','m_item.i_sat1','=','m_satuan.m_sid')
                ->select('m_item.*', 'm_price.*', 'm_group.*', 'm_satuan.*')
                ->where('m_item.i_isactive', '=', 'TRUE')
                ->orderBy('m_item.i_id', 'DESC')
                ->get();
        // return $list;
        $data = collect($list);
        
        // return $data;

        return Datatables::of($data)
                //->addIndexColumn()
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

    public function tambah_barang()
    {
        
        $satuan  = DB::table('m_satuan')->get();
        $group  = DB::table('m_group')->get();
        return view('master.databarang.tambah_barang',compact('kode','group','satuan'));
    }

    public function kode_barang(Request $request)
    {
        $group = DB::Table('m_group')->where('m_gcode','=',$request->id)->first();
        $kode = DB::select(DB::raw("SELECT MAX(RIGHT(i_code,6)) as kode_max from m_item WHERE i_code_group ='$request->id'"));
        $kd = "";

        if(count($kode)>0)
        {
            foreach($kode as $k)
            {
                $tmp = ((int)$k->kode_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }
        else
        {
            $kd = "000001";
        }

        $code = $group->m_gcode.$kd;

        return response()->json([$code]);
    }

    public function simpan_barang(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $tanggal = date("Y-m-d h:i:s");
            $data_item = DB::table('m_item')
                        ->insert([
                            'i_code'=>$request->kode_barang,
                            'i_type' => $request->type,
                            'i_code_group'=> $request->code_group,
                            'i_name'=> $request->nama,
                            'i_sat1'=>$request->satuan1,
                            'i_sat_isi1'=> $request->isi_sat1,
                            'i_sat2'=>$request->satuan2,
                            'i_sat_isi2'=> $request->isi_sat2,
                            'i_sat3'=>$request->satuan3,
                            'i_sat_isi3'=> $request->isi_sat3,
                            'i_det'=>$request->detail,
                            'i_insert'=>$tanggal
                        ]);


            //-----insert m_price------//
            $get_itemid = DB::table('m_item')->select('i_id')->where('i_code','=', $request->kode_barang)->first();
            $data_price = DB::table('m_price')
                            ->insert([
                                'm_pitem' => $get_itemid->i_id,
                                'm_pbuy1' => $this->konvertRp($request->hargaBeli1),
                                'm_pbuy2' => $this->konvertRp($request->hargaBeli2),
                                'm_pbuy3' => $this->konvertRp($request->hargaBeli3),
                                'm_pcreated' => $tanggal
                            ]);

            //-----update/insert d_stock------//
            //cek grup item
            if ($request->type == "BP") //brg produksi
            {
                $s_comp = '6';
                $s_position = '6';
                //cek ada tidaknya record pada tabel
                $rows = DB::table('d_stock')->select('s_id')
                    ->where('s_comp','6')
                    ->where('s_position','6')
                    ->where('s_item',$get_itemid->i_id)
                    ->exists();
            }
            elseif ($request->type == "BJ") //brg jual
            {
                $s_comp = '7';
                $s_position = '7';
                //cek ada tidaknya record pada tabel
                $rows = DB::table('d_stock')->select('s_id')
                    ->where('s_comp','7')
                    ->where('s_position','7')
                    ->where('s_item',$get_itemid->i_id)
                    ->exists();
            }
            elseif ($request->type == "BB") //bahan baku
            {
                $s_comp = '3';
                $s_position = '3';
                //cek ada tidaknya record pada tabel
                $rows = DB::table('d_stock')->select('s_id')
                    ->where('s_comp','3')
                    ->where('s_position','3')
                    ->where('s_item',$get_itemid->i_id)
                    ->exists();
            }
       
            // dd($rows);
            if($rows !== FALSE) //jika terdapat record, maka lakukan update
            {
                //update stok minimum
                $update = DB::table('d_stock')
                    ->where('s_comp', $s_comp)
                    ->where('s_position', $s_position)
                    ->where('s_item', $get_itemid->i_id)
                    ->update(['s_qty_min' => $request->min_stock]);
            }
            else //jika tidak ada record, maka lakukan insert
            {
                //get last id
                $id_stock = DB::table('d_stock')->max('s_id') + 1;
                //insert value ke tbl d_stock
                DB::table('d_stock')->insert([
                    's_id' => $id_stock,
                    's_comp' => $s_comp,
                    's_position' => $s_position,
                    's_item' => $get_itemid->i_id,
                    's_qty' => '0',
                    's_qty_min' => $request->min_stock,
                ]);
            } 
        
            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Barang Berhasil Disimpan'
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

    public function hapus_barang(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try 
        {
            $tanggal = date("Y-m-d h:i:s");
            //update m_item
            DB::table('m_item')
                ->where('i_id','=',$request->id)
                ->update([
                    'i_update' => $tanggal,
                    'i_isactive' => 'FALSE'
                ]);

            //update m_price
            DB::table('m_price')
                ->where('m_pitem','=',$request->id)
                ->update([
                    'm_pupdated' => $tanggal,
                    'm_pisactive' => 'FALSE'
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Barang Berhasil Dinonaktifkan'
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

    public function edit_barang(Request $request)
    {
        $satuan  = DB::table('m_satuan')->get();
        $data_item = DB::table('m_item')->where('i_id','=',$request->id)->first();
        $data_price = DB::table('m_price')->where('m_pitem','=',$request->id)->first();

        $min_stock = $this->getMinStock($request->id);
        $group  = DB::table('m_group')->get();
        return view('master/databarang/edit_barang',compact('data_item','data_price','satuan','group', 'min_stock'));
    }

    public function update_barang(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");
            //update m_item
            DB::table('m_item')
                ->where('i_id','=',$request->kode_old)
                ->update([
                    'i_name'=>$request->nama,
                    'i_sat1'=>$request->satuan1,
                    'i_sat_isi1'=> $request->isi_sat1,
                    'i_sat2'=>$request->satuan2,
                    'i_sat_isi2'=> $request->isi_sat2,
                    'i_sat3'=>$request->satuan3,
                    'i_sat_isi3'=> $request->isi_sat3,
                    'i_update'=>$tanggal,
                    'i_det'=>$request->detail
                ]);

            //----update m_price-----//

            DB::table('m_price')
                ->where('m_pitem','=',$request->kode_old)                
                ->update([
                    'm_pbuy1'=>$this->konvertRp($request->hargaBeli1),
                    'm_pbuy2'=>$this->konvertRp($request->hargaBeli2),
                    'm_pbuy3'=>$this->konvertRp($request->hargaBeli3),
                    'm_pupdated'=>$tanggal,
                ]);

            //-------update stok minimum d_stock---------
            //cek grup item
            if ($request->type == "BP") //brg produksi
            {
                $s_comp = '6';
                $s_position = '6';
                //cek ada tidaknya record pada tabel
                $rows = DB::table('d_stock')->select('s_id')
                    ->where('s_comp','6')
                    ->where('s_position','6')
                    ->where('s_item',$request->kode_old)
                    ->exists();
            }
            elseif ($request->type == "BJ") //brg jual
            {
                $s_comp = '7';
                $s_position = '7';
                //cek ada tidaknya record pada tabel
                $rows = DB::table('d_stock')->select('s_id')
                    ->where('s_comp','7')
                    ->where('s_position','7')
                    ->where('s_item',$request->kode_old)
                    ->exists();
            }
            elseif ($request->type == "BB") //bahan baku
            {
                $s_comp = '3';
                $s_position = '3';
                //cek ada tidaknya record pada tabel
                $rows = DB::table('d_stock')->select('s_id')
                    ->where('s_comp','3')
                    ->where('s_position','3')
                    ->where('s_item',$request->kode_old)
                    ->exists();
            }

            //update stok minimum
            $update = DB::table('d_stock')
                ->where('s_comp', $s_comp)
                ->where('s_position', $s_position)
                ->where('s_item', $request->kode_old)
                ->update(['s_qty_min' => $request->min_stock, 's_update' => $tanggal]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Barang Berhasil Diupdate'
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

    public function cari_group_barang(Request $request)
    {
      $data = DB::table('m_group')->where('m_gtype','=',$request->id)->get();
    
      return response()->json($data);
    }

    public function konvertRp($value)
    {
        $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
        return (int)str_replace(',', '.', $value);
    }

    public function getMinStock($id_item)
    {
        $typeBrg = DB::table('m_item')->select('i_type')->where('i_id','=', $id_item)->first();
        if ($typeBrg->i_type == "BB") 
        {
          //$idGroupGdg = '3';
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty_min FROM d_stock where s_item = '$id_item' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStokMin"));
          $stok = $query[0];
        } 
        elseif ($typeBrg->i_type == "BJ") 
        {
          //$idGroupGdg = '7';
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty_min FROM d_stock where s_item = '$id_item' AND s_comp = '7' AND s_position = '7' limit 1) ,'0') as qtyStokMin"));
          $stok = $query[0];
        }
        elseif ($typeBrg->i_type == "BP") 
        {
          //$idGroupGdg = '6';
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty_min FROM d_stock where s_item = '$id_item' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStokMin"));
          $stok = $query[0];
        }

        return $stok;
    }

}