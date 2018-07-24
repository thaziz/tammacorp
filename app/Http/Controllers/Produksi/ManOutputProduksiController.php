<?php
  
namespace App\Http\Controllers\Produksi;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use App\d_productresult;
use App\d_productresult_dt;
use App\d_stock;
use App\d_send_product;
use App\d_send_productdt;
use App\d_productplan;
use App\d_spk;
use Response;
use DataTables;
use App\Http\Requests;
use Illuminate\Http\Request;

class ManOutputProduksiController extends Controller
{
  public function OutputProduksi(){

    return view('produksi.o_produksi.index',compact('data'));
  }

  public function setCreateProduct($tgl1){
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
    $tgll = $y.'-'.$m.'-'.$d;

      return view('produksi.o_produksi.create');
  }

  public function setSpk($tgl1){
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
    $tgll = $y.'-'.$m.'-'.$d;
    $dataSpk = DB::table('d_spk')
      ->join('m_item', 'm_item.i_id', '=', 'd_spk.spk_item')
      ->join('d_productplan','d_productplan.pp_id','=','d_spk.spk_ref')
      ->where('spk_status','FN')
      ->where('spk_date','=',$tgll)
      ->get();
  
    $html='<select id="cari_spk" onchange="setResultSpk()" class="form-control input-sm" style="width: 100%;">';
    $html.='<option value="0">- Pilih Nomor SPK</option>';    
            foreach ($dataSpk as $key => $spk) {
    $html.='<option value='.$spk->spk_id.'>'.$spk->spk_code.'</option>';        
            }
    $html.='</select>';

  return $html;
  }

  public function selectDataSpk($x){
    $d_spk = d_spk::
        select( 'spk_id',
                'i_name',
                'i_id',
                'pp_qty',
                DB::raw("sum(prdt_qty) as prdt_qty"))
      ->join('m_item', 'm_item.i_id', '=', 'd_spk.spk_item')
      ->join('d_productplan','d_productplan.pp_id','=','d_spk.spk_ref')
      ->leftJoin('d_productresult','d_productresult.pr_spk', '=', 'd_spk.spk_id')
      ->leftJoin('d_productresult_dt','d_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
      ->where('spk_id','=',$x)
      ->get();

    return Response::json($d_spk);
  }

  public function tabelHasil(){

    $data = d_productresult::
        select('d_productresult.pr_id',
               'd_productresult.pr_date', 
               'd_spk.spk_code',
               'm_item.i_name')
      ->join('d_spk', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
      ->join('m_item', 'd_productresult.pr_item', '=', 'm_item.i_id')
      ->get();

    return DataTables::of($data)

    ->addColumn('action_belum', function ($data) {
        return '<div class="text-center">
                  <button style="margin-left:5px;" 
                          title="Edit" 
                          type="button"
                          data-toggle="modal"
                          data-target="#modalDetailProduksi"
                          onclick="lihatDetail('.$data->pr_id.')" 
                          class="btn btn-info fa fa-eye btn-sm"
                  </button>
                </div>';

      })

    ->addColumn('action_sudah', function ($data) {
        return '<div class="text-center">
                  <button style="margin-left:5px;" 
                          title="Edit" 
                          type="button" 
                          data-toggle="modal"
                          data-target="#modalDetailProduksiKirim"
                          onclick="lihatDetailKirim('.$data->pr_id.')"
                          class="btn btn-success fa fa-eye btn-sm"
                  </button>
                </div>';

      })

    ->editColumn('pr_date', function ($user) {
        return $user->pr_date ? with(new Carbon($user->pr_date))->format('d M Y') : '';
      })

    ->rawColumns(['action_belum',
                  'action_sudah'
      ])

    ->make(true);
  }

  public function tabelDetail(Request $request){
    $getid = DB::table('d_productresult')
      ->select('pr_id')
      ->where('pr_id', '=', $request->x[0])
      ->get();

    return view('produksi.o_produksi.detail', compact('getid'));
   }

  public function tabelDetailKirim(Request $request){

    $getid = DB::table('d_productresult')
      ->select('pr_id')
      ->where('pr_id', '=', $request->y[0])
      ->get();

    return view('produksi.o_produksi.detailKirim', compact('getid'));
   }

  public function detail(Request $request, $x){
    $data = d_productresult_dt::
      select( 'd_productresult_dt.prdt_productresult',
              'd_productresult_dt.prdt_detail',
              'd_spk.spk_code',
              'm_item.i_name',
              'd_productresult_dt.prdt_date',
              'd_productresult_dt.prdt_time',
              'd_productresult_dt.prdt_qty',
              'd_productresult_dt.prdt_status')
      ->join('d_productresult','d_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
      ->join('d_spk', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
      ->join('m_item', 'd_productresult.pr_item', '=', 'm_item.i_id')
      ->where('prdt_status','RD')
      ->where('prdt_productresult','=', $x)
      ->get();

    return DataTables::of($data)

    ->addColumn('action', function ($data) {
        return '<div class="text-center">
                  <button style="margin-left:5px;" 
                          title="Edit" 
                          type="button"
                          onclick="edit('.$data->prdt_productresult.','.$data->prdt_detail.')"  
                          data-toggle="modal" 
                          data-target="#myModal"
                          class="btn btn-warning btn-sm">
                          <i class="fa fa-pencil"></i>
                  </button>
                  <button style="margin-left:5px;" 
                          type="button" 
                          onclick="kirim('.$data->prdt_productresult.','.$data->prdt_detail.')" 
                          class="btn btn-info btn-sm buttonKirim" 
                          title="Kirim">
                          <i class="fa fa-paper-plane" aria-hidden="true"></i>  
                  </button>
                  <button style="margin-left:5px;" 
                          type="button" 
                          onclick="hapus('.$data->prdt_productresult.','.$data->prdt_detail.')" 
                          class="btn btn-danger btn-sm" 
                          title="Hapus">
                          <i class="fa fa-trash-o"></i>
                  </button>
                </div>';

      })

    ->editColumn('prdt_date', function ($user) {
        return $user->prdt_date ? with(new Carbon($user->prdt_date))->format('d M Y') : '';
      })

    ->editColumn('prdt_status', function ($inquiry) {
        if ($inquiry->prdt_status == 'RD') 
          return 'Belum Terkirim';
      })

    ->make(true);
   }

  public function detailKirim(Request $request, $y){
    $term = $request->term;
    $data = d_productresult_dt::select('d_productresult_dt.prdt_productresult',
                                      'd_productresult_dt.prdt_detail',
                                      'd_spk.spk_code',
                                      'm_item.i_name',
                                      'd_productresult_dt.prdt_date',
                                      'd_productresult_dt.prdt_time',
                                      'd_productresult_dt.prdt_qty',
                                      'd_productresult_dt.prdt_status')
      ->join('d_productresult','d_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
      ->join('d_spk', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
      ->join('m_item', 'd_productresult.pr_item', '=', 'm_item.i_id')
 
      ->where(function ($d) use ($term) {
          $d    ->orWhere('prdt_status','PR')
                ->orWhere('prdt_status','FN')
                ->orWhere('prdt_status','RC');
      })
      ->where('prdt_productresult','=', $y)
      ->get();

    return DataTables::of($data)

    ->editColumn('prdt_date', function ($user) {
        return $user->prdt_date ? with(new Carbon($user->prdt_date))->format('d M Y') : '';
    })

    ->editColumn('prdt_status', function ($inquiry) {
        if ($inquiry->prdt_status == 'PR') 
          return 'Proses';
        if ($inquiry->prdt_status == 'FN') 
          return 'Di Kirim';
        if ($inquiry->prdt_status == 'RC') 
          return 'Di Terima';
    })

    ->make(true);
   }

  public function sending( Request $request, $id1, $id2){
  DB::beginTransaction();
        try { 
    $data = d_productresult_dt::
        where('prdt_productresult',$id1)
      ->where('prdt_detail',$id2)
      ->first();

    if ($data->prdt_status == 'RD') {

    $data2 = DB::table('d_productresult_dt')
      ->where('prdt_productresult',$id1)
      ->where('prdt_detail',$id2)
      ->update(['prdt_status' => 'PR']);

     }
     
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

  public function distroy($id1,$id2){
    $d_productresult_dt = d_productresult_dt::
        where('prdt_productresult',$id1)
      ->where('prdt_detail',$id2)
      ->first();

    $gudangProduksi = d_stock::
        where('s_comp','6') 
      ->where('s_position','6')
      ->where('s_item',$d_productresult_dt->prdt_item)
      ->first();

    $gudangBaru = $gudangProduksi->s_qty - $d_productresult_dt->prdt_qty;

    d_stock::
      where('s_comp','6') 
      ->where('s_position','6')
      ->where('s_item',$d_productresult_dt->prdt_item)
      ->update([
        's_qty' => $gudangBaru
      ]);

    d_productresult_dt::
        where('prdt_productresult',$id1)
      ->where('prdt_detail',$id2)
      ->delete();
  }

  public function edit($id1, $id2){
      $data = d_productresult_dt::
          select( 'prdt_productresult',
                  'prdt_detail',
                  'i_name',
                  'prdt_qty')
        ->join('m_item','i_id','=','prdt_item')
        ->where('prdt_productresult',$id1)
        ->where('prdt_detail',$id2)
        ->first();
      // dd($data);
      return Response::json($data);
    }

  public function editQty(Request $request){
    DB::beginTransaction();
        try {
    $d_productresult_dt = d_productresult_dt::
        where('prdt_productresult',$request->prdt_productresult)
      ->where('prdt_detail',$request->prdt_detail)
      ->first();

    $gudangProduksi = d_stock::
        where('s_comp','6') 
      ->where('s_position','6')
      ->where('s_item',$d_productresult_dt->prdt_item)
      ->first();

    $setStok = $gudangProduksi->s_qty - $d_productresult_dt->prdt_qty;

    d_productresult_dt::
        where('prdt_productresult',$request->prdt_productresult)
      ->where('prdt_detail',$request->prdt_detail)
      ->update([
        'prdt_qty' => $request->prdt_qty
      ]);

    $stokBaru = $setStok + $request->prdt_qty;

    d_stock::
        where('s_comp','6') 
      ->where('s_position','6')
      ->where('s_item',$d_productresult_dt->prdt_item)
      ->update([
        's_qty' => $request->prdt_qty
      ]);
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

  public function tabel(){
    $result = DB::table('d_productresult_dt')
      ->select('pr_date','spk_code','i_name','prdt_date','prdt_time','prdt_qty')
      ->join('d_productresult','prdt_productresult','=','pr_id')
      ->join('m_item','i_id','=','prdt_item')
      ->join('d_spk','pr_spk','=','spk_id')
      ->get();

    $dat = array();
    foreach ($result as $r) {
      $dat[] = (array) $r;
    }
    $i=0;
    $data = array();
    foreach ($dat as $key) {
        $data[$i]['pr_date'] = date('d M Y', strtotime( $key['pr_date'] ));
        $data[$i]['spk_code'] = $key['spk_code'];
        $data[$i]['i_name'] = $key['i_name'];
        $data[$i]['prdt_date'] = date('d M Y', strtotime( $key['prdt_date'] ));
        $data[$i]['prdt_time'] = $key['prdt_time'];
        $data[$i]['prdt_qty'] = $key['prdt_qty'];
        $i++;
    }
    $datax = array('data' => $data);
    echo json_encode($datax);    

  }

  public function store(Request $request){
    // dd($request->all());
  DB::beginTransaction();
        try { 
    $cek = DB::table('d_productresult')
      ->where('pr_spk',$request->spk_id)
      ->get();

    $maxid1 = DB::Table('d_productresult_dt')->select('prdt_detail')->max('prdt_detail');

    if ($maxid1 <= 0 || $maxid1 == '') {
      $maxid1  = 1;
    }else{
      $maxid1 += 1;
    }
 
    if (count($cek) == 0) {
      $maxid = DB::Table('d_productresult')->select('pr_id')->max('pr_id');
      if ($maxid <= 0 || $maxid == '') {
        $maxid  = 1;
      }else{
        $maxid += 1;
      }

      $pr = DB::Table('d_productresult')
        ->insert([
          'pr_id' => $maxid,
          'pr_spk' => $request->spk_id,
          'pr_date' => Carbon::createFromFormat('d-m-Y', $request->tgl)->format('Y-m-d'),
          'pr_item' => $request->spk_item
        ]);

      $prdt = DB::Table('d_productresult_dt')  
        ->insert([
          'prdt_productresult' => $maxid,
          'prdt_detail' => $maxid1,
          'prdt_item' => $request->spk_item,
          'prdt_qty' => $request->spk_qty,
          'prdt_status' => 'RD',
          'prdt_date' => Carbon::createFromFormat('d-m-Y', $request->tgl)->format('Y-m-d'),
          'prdt_time' => $request->time,
        ]);

    }else{

      $pr = DB::Table('d_productresult')
        ->where('pr_spk',$request->spk_id)
        ->get();

      $prdt = DB::Table('d_productresult_dt')
        ->insert([
          'prdt_productresult' => $pr[0]->pr_id,
          'prdt_detail' => $maxid1,
          'prdt_item' => $request->spk_item,
          'prdt_qty' => $request->spk_qty,
          'prdt_status' => 'RD',
          'prdt_date' => Carbon::createFromFormat('d-m-Y', $request->tgl)->format('Y-m-d'),
          'prdt_time' => $request->time,
        ]);

    }

      $stockProduksi = d_stock::where('s_comp', '6')
        ->where('s_position', '6')
        ->where('s_item', $request->spk_item)
        ->first();

      if ($stockProduksi == null) {
      $maxid = DB::Table('d_stock')->select('s_id')->max('s_id');
      if ($maxid <= 0 || $maxid == '') {
        $maxid  = 1;
      }else{
        $maxid += 1;
      }

      $pr = DB::Table('d_stock')
        ->insert([
          's_id' => $maxid,
          's_comp' => 6,
          's_position' => 6,
          's_item' => $request->spk_item,
          's_qty' => $request->spk_qty,
          's_insert' => Carbon::now()
        ]);

      }else{

      $stokBaru = $stockProduksi->s_qty + $request->spk_qty;

      $stokProduksi = d_stock::where('s_comp','6')
        ->where('s_position','6')
        ->where('s_id', $stockProduksi->s_id)
        ->update(['s_qty' => $stokBaru]);

      }
    
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

}