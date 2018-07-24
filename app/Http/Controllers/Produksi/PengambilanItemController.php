<?php

namespace App\Http\Controllers\Produksi;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\d_productresult_dt;
use App\d_delivery_order;
use App\d_delivery_orderdt;
use App\d_stock;
use DB;
use DataTables;
use App\Http\Controllers\Controller;

class PengambilanItemController extends Controller
{
  public function SuratJalan(){


  return view('produksi.PemSuratJalan.index');
  }

  public function tabelDelivery(Request $request){
    $data = d_productresult_dt::select( 'm_item.i_code',
                                        'm_item.i_name',
                                        'd_productresult_dt.prdt_qty',
                                        'd_productresult_dt.prdt_productresult',
                                        'd_productresult_dt.prdt_detail',
                                        'd_productresult_dt.prdt_item')
    ->join('d_productresult','d_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
    ->join('d_spk', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
    ->join('m_item', 'd_productresult.pr_item', '=', 'm_item.i_id')
    ->where('prdt_status','PR')
    ->get();
    // dd($data);

  return DataTables::of($data) 
  ->addColumn('action', function ($data) {
      return '<div class="text-center" data-toggle="buttons">
                <label class="btn btn-default">
                  <input id="something" type="checkbox" name="delivery[]" value="'.$data->prdt_productresult.'|'.$data->prdt_detail.'|'.$data->prdt_item.'|'.$data->prdt_qty.'">
                  <span class="glyphicon glyphicon-ok"></span>
                </label>
              </div>';

    })
  ->addIndexColumn()  

  ->make(true);
  }

  function store(Request $request){
  DB::beginTransaction();
      try {  
    $dt = Carbon::now('Asia/Jakarta');
    // nota do
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $maxiddo = d_delivery_order::select('do_id')->max('do_id');

    if ($maxiddo <= 0 || $maxiddo <= '') {
      $maxiddo  = 1;
    }else{
      $maxiddo += 1;
    }

    $nota_do = 'DO' . $year . $month . $date .'-' . '000' . '-' . $maxiddo;
    // end nota do
    $maxid = d_delivery_order::select('do_id')->max('do_id');
     if ($maxid <= 0 || $maxid <= '') {
        $maxid  = 1;
      }else{
        $maxid += 1;
      }

    d_delivery_order::
      insert([
        'do_id' => $maxid,
        'do_nota' => $nota_do,
        'do_date_send' => date('Y-m-d',strtotime($request->TanggalKirim)),
        'do_time' => $dt->toTimeString(),
        'do_insert' => $dt
      ]);
    
    $dodt = [];
    for ($i=0; $i < count($request->delivery); $i++) { 
      $data = explode("|",$request->delivery[$i]);
      $temp = array(
        //d_delivery_orderdt
        'dod_do' => $maxid,
        'dod_detailid' => $i + 1,
        'dod_prdt_productresult' => $data[0],
        'dod_prdt_detail' => $data[1],
        'dod_item' => $data[2],
        'dod_qty_send' => $data[3],
        'dod_date_send' => date('Y-m-d',strtotime($request->TanggalKirim)),
        'dod_time_send' => $dt->toTimeString(),
        'dod_status' => 'WT',
        'dod_insert' => $dt
      );
      array_push($dodt, $temp);

    d_productresult_dt::
        where('prdt_productresult',$data[0])
      ->where('prdt_detail',$data[1])
      ->update([
        'prdt_status' => 'FN'
      ]);

    $stokProduksi = d_stock::
        where('s_comp','6')
      ->where('s_position','6')
      ->where('s_item',$data[2])
      ->first();

    $stokBaru = $stokProduksi->s_qty - $data[3];

    $maxidd_stock = d_stock::select('s_id')->max('s_id');

    if ($maxidd_stock <= 0 || $maxidd_stock <= '') {
      $maxidd_stock  = 1;
    }else{
      $maxidd_stock += 1;
    }
    //end add id d_stock
    d_stock::
        insert([
          's_id' => $maxidd_stock,
          's_comp' => 2,
          's_position' => 5,
          's_item' => $data[2],
          's_qty' => $data[3]
        ]);

    d_stock::
          where('s_comp','6')
        ->where('s_position','6')
        ->where('s_item',$data[2])
        ->update([
          's_qty' => $stokBaru 
        ]);
    }
    
    d_delivery_orderdt::insert($dodt);

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

  public function tabelKirim($tgl1, $tgl2){
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
    $tgl1 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
    $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $data = d_delivery_order::
        where('do_date_send','>=',$tgl1)
        ->where('do_date_send','<=',$tgl2)
        ->get();

    return DataTables::of($data) 
    ->addColumn('action', function ($data) {
        return '<div class="text-center" data-toggle="buttons">
                <button style="margin-left:5px;" 
                          title="Lihat Detail" 
                          type="button"
                          onclick="lihatItem('.$data->do_id.')"
                          data-toggle="modal"
                          data-target="#modalDetailProduksi" 
                          class="btn btn-info fa fa-eye btn-sm"
                  </button>
                </div>';

      })
    ->editColumn('do_date_send', function ($user) {
        return $user->do_date_send ? with(new Carbon($user->do_date_send))->format('d M Y') : '';
      })
    ->make(true);
  }

  public function cariTabelKirim($tgl1, $tgl2){
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
    $tgl1 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
    $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $data = d_delivery_order::
        where('do_date_send','>=',$tgl1)
        ->where('do_date_send','<=',$tgl2)
        ->get();

    return DataTables::of($data) 
    ->addColumn('action', function ($data) {
        return '<div class="text-center" data-toggle="buttons">
                <button style="margin-left:5px;" 
                          title="Lihat Detail" 
                          type="button"
                          data-toggle="modal"
                          data-target="#modalDetailProduksi" 
                          class="btn btn-info fa fa-eye btn-sm"
                  </button>
                </div>';

      })
    ->editColumn('do_date_send', function ($user) {
        return $user->do_date_send ? with(new Carbon($user->do_date_send))->format('d M Y') : '';
      })
    ->make(true);
  }

  public function itemTabelKirim($id){
    $data = d_delivery_orderdt::
        where('dod_do','=',$id)
        ->get();
     
    return DataTables::of($data)
    ->editColumn('dod_status', function ($inquiry) {
        if ($inquiry->dod_status == 'WT') 
          return 'Belum di Terima';
        if ($inquiry->dod_status == 'FN') 
          return 'Sudah di Terima';
      })

    ->addIndexColumn() 

    ->make(true);
  }

  public function orderId(Request $request){
    $data = d_delivery_order::
        select('do_id')
        ->where('do_id','=',$request->x)
        ->first();

    return view('produksi.PemSuratJalan.tabelItem',compact('data'));
  }
}
