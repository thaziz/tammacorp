<?php

namespace App\Http\Controllers\Penjualan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\d_stock_mutation;
use App\d_stock;
use App\d_sales;
use App\d_sales_payment;
use App\d_sales_dt;
use App\m_customer;
use DataTables;
use URL;

// use App\mmember

class POSRetailController extends Controller
{
  public function retail(){ 
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');
    //select max dari um_id dari table d_uangmuka
    $maxid = DB::Table('m_customer')->select('c_id')->max('c_id');
    $idfatkur = DB::Table('d_sales')->select('s_id')->max('s_id');
    $idreq = DB::table('d_transferitem')->select('ti_id')->max('ti_id');
    //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
    if ($maxid <= 0 || $maxid <= '') {
      $maxid  = 1;
    }else{
      $maxid += 1;
    }
    if ($idfatkur <= 0 || $idfatkur <= '') {
      $idfatkur  = 1;
    }else{
      $idfatkur += 1;
    }
    if ($idreq <= 0 || $idreq <= '') {
      $idreq  = 1;
    }else{
      $idreq += 1;
    }
    //jika kurang dari 100 maka maxid mimiliki 00 didepannya
    if ($maxid < 100) {
      $maxid = '00'.$maxid;
    }

    $id_cust = 'CUS' . $month . $year . '/' . 'C001' . '/' .  $maxid; 
    $fatkur = 'XX'  . $year . $month . $date . $idfatkur;
    $idreq = 'REQ'  . $year . $month . $date . $idreq;

    $stock  = DB::table('d_stock')->where('s_comp','3')->where('s_position','3')
      ->join('m_item', 'm_item.i_id', '=', 'd_stock.s_item')
      ->get();

    $dataPayment = DB::table('m_paymentmethod')->get();

    $ket = 'create';

    return view('/penjualan/POSretail/index',compact('id_cust','fatkur', 'idreq','stock','dataPayment', 'ket','idfatkur'));
  }

  public function edit_sales($id){
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    //select max dari um_id dari table d_uangmuka
    $maxid = DB::Table('m_customer')->select('c_id')->max('c_id');
    $idfatkur = DB::Table('d_sales')->select('s_id')->max('s_id');
    $idreq = DB::table('d_transferitem')->select('ti_id')->max('ti_id');
    //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 

    if ($maxid <= 0 || $maxid <= '') {
      $maxid  = 1;
    }else{
      $maxid += 1;
    }

    if ($idfatkur <= 0 || $idfatkur <= '') {
      $idfatkur  = 1;
    }else{
      $idfatkur += 1;
    }

    if ($idreq <= 0 || $idreq <= '') {
      $idreq  = 1;
    }else{
      $idreq += 1;
    }
    //jika kurang dari 100 maka maxid mimiliki 00 didepannya
    if ($maxid < 100) {
      $maxid = '00'.$maxid;
    }

    $id_cust = 'CUS' . $month . $year . '/' . 'C001' . '/' .  $maxid; 
    $fatkur = 'XX'  . $year . $month . $date . $idfatkur;
    $idreq = 'REQ'  . $year . $month . $date . $idreq;

    $edit = d_sales::select('c_name',
                            's_customer',
                            'c_address',
                            'c_hp',
                            'c_class',
                            's_note',
                            'd_sales.s_id as sales_id',
                            's_net',
                            's_gross',
                            's_disc_value',
                            'i_name',
                            'sd_sales',
                            'sd_detailid',
                            'i_id',
                            'i_name',
                            'sd_qty',
                            's_qty',
                            'i_sat1',
                            'm_psell1',
                            'm_psell2',
                            'm_psell3',
                            'sd_disc_percent',
                            'sd_disc_value',
                            'sd_total',
                            's_status',
                            'm_sname')
      ->join('m_customer', 'm_customer.c_id', '=' , 'd_sales.s_customer')
      ->join('d_sales_dt','d_sales_dt.sd_sales','=','d_sales.s_id')
      ->join('m_item','m_item.i_id','=','d_sales_dt.sd_item')
      ->join('m_price','m_price.m_pitem', '=','d_sales_dt.sd_item')
      ->join('d_stock','d_stock.s_item','=','m_item.i_id')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('s_comp','1')
      ->where('s_position','1')
      ->where('d_sales.s_id',$id)
      ->where('s_status','DR')
      ->get();

    $dataPayment = DB::table('m_paymentmethod')->get();

    $ket = 'edit';

    return view('/penjualan/POSretail/index',compact('id_cust','fatkur','idreq', 'stock','edit','dataPayment', 'ket'));
  }

  public function detail(Request $request){
    $detalis = DB::table('d_sales_dt')
      ->select( 'i_name',
                'sd_qty',
                'm_sname',
                'm_psell1',
                'm_psell2',
                'm_psell3',
                'sd_disc_percent',
                'sd_disc_value',
                'sd_total')
      ->join('d_sales', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id' )
      ->join('m_item', 'm_item.i_id', '=' , 'd_sales_dt.sd_item')
      ->join('m_price','m_price.m_pitem', '=','d_sales_dt.sd_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('sd_sales','=',$request->x)
      ->get();
    
    return view('/penjualan/POSretail/NotaPenjualan.detail',compact('detalis'));
  }

  public function autocomplete(Request $request){
    $term = $request->term;
    $results = array();
    $queries = m_customer::where('m_customer.c_name', 'LIKE', '%'.$term.'%')
      ->take(50)->get();
    
    if ($queries == null) {
      $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
    } else {
      foreach ($queries as $query) {
        $results[] = [  'id' => $query->c_id, 
                        'label' => $query->c_name .'  '.$query->c_address, 
                        'alamat' => $query->c_address.' '.$query->c_hp,
                        'c_class' => $query->c_class ];
      }
    }

    return Response::json($results);
  }

  public function autocompleteitem(Request $request, $id){
    $term = $request->term;
    $results = array();
    if ($id == 'A') {

      $queries = DB::select('select i_id, i_code,i_name,m_psell1,s_qty,m_sname 
                            from m_item left join d_stock on i_id = s_item 
                            join m_price on i_id = m_pitem 
                            join m_satuan on m_sid = i_sat1 
                            where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" ) 
                            and ( i_type = "BP" or i_type = "BJ" ) 
                            and ( s_comp = 1 and s_position = 1 or s_comp is null or s_position is null ) 
                            limit 50');

      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) {
          $results[] = [ 'id' => $query->i_id, 
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell1, 
                         'kode' => $query->i_id, 
                         'nama' => $query->i_name, 
                         'satuan' => $query->m_sname, 
                         's_qty'=>$query->s_qty 
                       ];
        }
      }

  }else if ($id == 'B') {
    $queries = DB::select('select i_id, i_code,i_name,m_psell2,s_qty,m_sname
                          from m_item left join d_stock on i_id = s_item 
                          join m_price on i_id = m_pitem 
                          join m_satuan on m_sid = i_sat1
                          where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" ) 
                          and ( i_type = "BP" or i_type = "BJ" ) 
                          and ( s_comp = 1 and s_position = 1 or s_comp is null or s_position is null ) 
                          limit 50');

      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) {
          $results[] = [ 'id' => $query->i_id, 
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell2, 
                         'kode' => $query->i_id, 
                         'nama' => $query->i_name, 
                         'satuan' => $query->m_sname, 
                         's_qty'=>$query->s_qty 
                       ];
        }
      }
  }else{
    $queries = DB::select('select i_id, i_code,i_name,m_psell3,s_qty,m_sname
                          from m_item left join d_stock on i_id = s_item 
                          join m_price on i_id = m_pitem 
                          join m_satuan on m_sid = i_sat1
                          where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" ) 
                          and ( i_type = "BP" or i_type = "BJ" ) 
                          and ( s_comp = 1 and s_position = 1 or s_comp is null or s_position is null ) 
                          limit 50');

      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) {
          $results[] = [ 'id' => $query->i_id, 
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell3, 
                         'kode' => $query->i_id, 
                         'nama' => $query->i_name, 
                         'satuan' => $query->m_sname, 
                         's_qty'=>$query->s_qty 
                       ];
        }
      }
  }

    return Response::json($results); 
  }

  public function autocompletereq(Request $request){
    $term = $request->term;

    $results = array();
    
    $queries = DB::table('m_item')

      ->leftJoin('d_stock','m_item.i_id','=', 'd_stock.s_item')

      ->where(function ($b) use ($term) {
                $b->where('s_comp','9')
                  ->where('s_position','9');
            })
      ->where(function ($d) use ($term) {
                $d->orWhere('m_item.i_type', 'LIKE', '%'.$term.'%')
                  ->orWhere('m_item.i_name', 'LIKE', '%'.$term.'%');
            })
      ->take(50)->get();
    if ($queries == null) {
      $results[] = [ 'i_id' => null, 'label' =>'tidak di temukan data terkait'];
    } else {
      foreach ($queries as $query) 
      {
        $results[] = [ 'id' => $query->i_id, 'label' => $query->i_code .' - '. $query->i_name,
                       'harga' => $query->i_price, 'kode' => $query->i_id, 'nama' => $query->i_name, 'satuan' => $query->i_unit, 'stok' => $query->s_qty ];
      }
    }
 
    return Response::json($results); 
  }

  public function store(Request $request){
    DB::beginTransaction();
    try {
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $maxid = DB::Table('m_customer')->select('c_id')->max('c_id');

     if ($maxid <= 0 || $maxid <= '') {
        $maxid  = 1;
      }else{
        $maxid += 1;
      }

    if ($maxid < 100) {
      $maxid = '00'.$maxid;
    }

    $id_cust = 'CUS' . $month . $year . '/' . 'C001' . '/' .  $maxid; 

    $customer = DB::table('m_customer')
          ->insert([
        'c_id' => $maxid,
        'c_code' => $id_cust,
        'c_name' => $request->nama_cus,
        'c_birthday' => $request->tgl_lahir,
        'c_email' => $request->email,
        'c_hp' => '+62'.$request->no_hp,
        'c_address' => $request->alamat,
        'c_class' => $request->class_cust,
        'c_type' =>'RT',
        'c_insert' => Carbon::now()
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

  public function sal_save_final(Request $request){ 
  // dd($request->all());
  DB::beginTransaction();
    try {
    $s_id = d_sales::max('s_id') + 1;
    //nota
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');
    if ($s_id <= 0 || $s_id <= '') {
      $s_id  = 1;
    }else{
      $s_id += 1;
    }
    $fatkur = 'XX'  . $year . $month . $date . $s_id;
    //end Nota
    d_sales::insert([
        's_id' => $s_id,
        's_channel' => 'RT',
        's_date' => date('Y-m-d',strtotime($request->s_date)),
        's_note' => $fatkur,
        's_staff' => $request->s_staff,
        's_customer' => $request->id_cus,
        's_disc_percent' => $request->s_disc_percent,
        's_disc_value' => ($this->konvertRp($request->totalDiscount)),
        's_gross' => ($this->konvertRp($request->s_gross)),
        's_tax' => $request->s_pajak,
        's_net' => ($this->konvertRp($request->s_net)),
        's_status' => 'FN',
        's_insert' => Carbon::now()      
      ]);

    $kodeItem = $request->kode_item;
    $qtyItem = $request->sd_qty;
    for ($i=0; $i < count($kodeItem); $i++) { 

        $stokRetail = d_stock::where('s_comp','1')
              ->where('s_position','1')
              ->where('s_item',$kodeItem[$i])
              ->first();

        $d_sales_dt = d_sales_dt::insert([
              'sd_sales' => $s_id,
              'sd_detailid' => $i + 1,
              'sd_item' => $kodeItem[$i],
              'sd_qty' => $qtyItem[$i],
              'sd_price' => ($this->konvertRp($request->harga_item[$i])),
              'sd_disc_percent' => $request->sd_disc_percent[$i],
              'sd_disc_vpercent' => $request->totalValuePercent[$i],
              'sd_disc_value' => ($this->konvertRp($request->sd_disc_value[$i])),
              'sd_total' => ($this->konvertRp($request->hasil[$i]))
            ]);

        // $getItem = d_stock::join('d_stock_mutation','sm_stock', '=', 's_id')
        //     ->select( 's_id',
        //               's_item',
        //               's_qty',
        //               'sm_detailid',
        //               'sm_date',
        //               'sm_comp',
        //               'sm_detail', DB::raw('(sm_qty - sm_qty_used) as sisa'))
        //     ->where('s_item',$kodeItem[$i])
        //     ->orderBy('sm_date')
        //     ->get();
          
        // $sisa = $qtyItem[$i];
        // for ($j=0; $j < count($getItem); $j++) {

        //   //mutasi
        //   if ($sisa <= $getItem[$j]->sisa && $getItem[$j]->s_item == $kodeItem[$i]) {
        //     d_stock_mutation::where('sm_stock', '=', $getItem[$j]->s_id)
        //       ->where('sm_detailid', '=', $getItem[$j]->sm_detailid)
        //       ->update([
        //         'sm_qty_used' => DB::raw('sm_qty_used +' . $sisa),
        //       ]);
        //     $sisa = 0; 
        //   } elseif ($sisa > $getItem[$j]->sisa && $getItem[$j]->s_item == $kodeItem[$i]) {
        //     d_stock_mutation::where('sm_stock', '=', $getItem[$j]->s_id)
        //       ->where('sm_detailid', '=', $getItem[$j]->sm_detailid)
        //       ->update([
        //         'sm_qty_used' => DB::raw('sm_qty_used +' . $getItem[$j]->sisa),
        //       ]);
        //     $sisa = $sisa - $getItem[$j]->sisa;
        //   }
        //   //end-mutasi
        // }

        // $detailId = d_stock_mutation::where('sm_item', '=', $kodeItem[$i])
        //       ->where('sm_comp','1')
        //       ->max('sm_detailid');
 
        // d_stock_mutation::where('sm_stock', '=', $kodeItem[$i])
        //       ->where('s_comp','1')
        //       ->insert([  'sm_stock' => $getItem[$i]->s_id,
        //                   'sm_detailid' => $detailId + 1,
        //                   'sm_date' => Carbon::now(),
        //                   'sm_comp' => 1,
        //                   'sm_mutcat' => 1,
        //                   'sm_item' => $kodeItem[$i],
        //                   'sm_qty' => $qtyItem[$i],
        //                   'sm_qty_used' => 0,
        //                   'sm_qty_expired' => 0,
        //                   'sm_detail' => 'PENGURANGAN',
        //                   'sm_reff' => $request->s_nota,
        //                   'sm_insert' => Carbon::now()
        //       ]);

        $stokBaru = $stokRetail->s_qty - $request->sd_qty[$i];

          d_stock::where('s_comp','1')
              ->where('s_position','1')
              ->where("s_id", $stokRetail->s_id)
              ->update(['s_qty' => $stokBaru]);
              
      }

      $sp_method = $request->sp_method;
      for ($i=0; $i < count($sp_method); $i++) {

        $d_sales_payment = d_sales_payment::insert([
                'sp_sales' => $s_id,
                'sp_paymentid' => $i+1,
                'sp_method' => $sp_method[$i],
                'sp_nominal' => ($this->konvertRp($request->sp_nominal[$i]))
            ]);
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

  public function sal_save_draft(Request $request){
    // dd($request->all());
    DB::beginTransaction();
    try {
    $s_id = d_sales::max('s_id') + 1;
    //nota
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');
    if ($s_id <= 0 || $s_id <= '') {
      $s_id  = 1;
    }else{
      $s_id += 1;
    }
    $fatkur = 'XX'  . $year . $month . $date . $s_id;
    //end Nota
    d_sales::insert([
          's_id' =>$s_id,
          's_channel' =>'RT',
          's_date' =>date('Y-m-d',strtotime($request->s_date)),
          's_note' =>$fatkur,
          's_staff' =>$request->s_staff,
          's_customer' => $request->id_cus,
          's_disc_percent' => $request->s_disc_percent,
          's_disc_value' => ($this->konvertRp($request->totalDiscount)),
          's_gross' => ($this->konvertRp($request->s_gross)),
          's_tax' => $request->s_pajak,
          's_net' => ($this->konvertRp($request->s_net)),
          's_status' => 'DR',
          's_insert' => Carbon::now()         
        ]);

      for ($i=0; $i < count($request->kode_item); $i++) { 

        d_sales_dt::insert([
              'sd_sales' => $s_id,
              'sd_detailid' => $i+1,
              'sd_item' => $request->kode_item[$i],
              'sd_qty' => $request->sd_qty[$i],
              'sd_price' => ($this->konvertRp($request->harga_item[$i])),
              'sd_disc_percent' => $request->sd_disc_percent[$i],
              'sd_disc_vpercent' => $request->totalValuePercent[$i],
              'sd_disc_value' => ($this->konvertRp($request->sd_disc_value[$i])),
              'sd_total' => ($this->konvertRp($request->hasil[$i]))
          ]);
          
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

  public function sal_save_finalUpdate(Request $request){
    // dd($request->all());
    DB::beginTransaction();
    try {
    $s_id = $request->s_id;
    $kodeItem = $request->kode_item;
    $qtyItem = $request->sd_qty;
    $m = d_sales::where('s_id',$s_id)->first();
    // dd($m->s_status);
     if ($m->s_status == 'DR') {
        d_sales::where('s_id',$s_id)
          ->update([
            's_channel' => 'RT',
            's_date' => date('Y-m-d',strtotime($request->s_date)),
            's_note' => $request->s_nota,
            's_staff' => $request->s_staff,
            's_customer' => $request->id_cus,
            's_disc_percent' => $request->s_disc_percent,
            's_disc_value' => $request->s_disc_value,
            's_gross' => ($this->konvertRp($request->s_gross)),
            's_tax' => $request->s_pajak,
            's_net' => ($this->konvertRp($request->s_net)),
            's_status' => "FN",
            's_insert' => Carbon::now(),
            's_update' => $request->s_update
          ]);

          d_sales_dt::where('sd_sales',$s_id)->delete();

          for ($i=0; $i < count($kodeItem); $i++) {

            $stokRetail = DB::table('d_stock')
              ->where('s_comp','1')
              ->where('s_position','1')
              ->where('s_item',$kodeItem[$i])->first(); 

            $d_sales_dt = d_sales_dt::insert([
              'sd_sales' => $s_id,
              'sd_detailid' => $i + 1,
              'sd_item' => $kodeItem[$i],
              'sd_qty' => $qtyItem[$i],
              'sd_price' => ($this->konvertRp($request->harga_item[$i])),
              'sd_disc_percent' => $request->sd_disc_percent[$i],
              'sd_disc_vpercent' => $request->totalValuePercent[$i],
              'sd_disc_value' => ($this->konvertRp($request->sd_disc_value[$i])),
              'sd_total' => ($this->konvertRp($request->hasil[$i]))
            ]);

          $stokBaru = $stokRetail->s_qty - $request->sd_qty[$i];

          d_stock::where('s_comp','1')
              ->where('s_position','1')
              ->where("s_id", $stokRetail->s_id)
              ->update(['s_qty' => $stokBaru]);
        }

        for ($i=0; $i < count($request->sp_method); $i++) {

          $d_sales_payment = DB::table('d_sales_payment')
              ->insert([
                  'sp_sales' => $s_id,
                  'sp_paymentid' => $i+1,
                  'sp_method' => $request->sp_method[$i],
                  'sp_nominal' => ($this->konvertRp($request->sp_nominal[$i]))
              ]);
            }
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

  public function distroy($id){
    DB::table('d_sales')
      ->where('s_id',$id)
      ->where('s_status','DR')
      ->delete();

   return redirect('/penjualan/POSretail/index');
  }
  
  public function konvertRp($value){

    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
    return str_replace(',', '.', $value);

    }

  public function getTanggal($tgl1,$tgl2,$tampil){

    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
     $tgll = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;

    if ($tampil == 'semua') {
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','RT')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'draft') {
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','RT')
        ->where('s_status','DR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }else{
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','RT')
          ->where('s_status','FN')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }
    
    return DataTables::of($detalis)
        // ->addIndexColumn()
        ->editColumn('sDate', function ($data) 
        {
            return date('d M Y', strtotime($data->s_date));
        })
        ->editColumn('sGross', function ($data) 
        {
            return '<div>Rp.
                      <span class="pull-right">
                        '.number_format( $data->s_gross ,2,',','.').'
                      </span>
                    </div>';
        })
        ->editColumn('status', function ($data)  {
            if ($data->s_status == "DR") 
            {
                return 'Draft';
            }
            elseif ($data->s_status == "FN") 
            {
                return 'Final';
            }
        })

        ->addColumn('action', function($data)
        {
          if ($data->s_status == 'FN') { $attr = 'disabled'; } else { $attr = ''; };
          $linkEdit = URL::to('/penjualan/POSretail/retail/edit_sales/'.$data->s_id);
          return  '<div class="text-center">
                      <button type="button" 
                          class="btn btn-success fa fa-eye btn-sm" 
                          title="detail" 
                          data-toggle="modal" 
                          onclick="lihatDetail('."'".$data->s_id."'".')" 
                          data-target="#myItem">
                      </button>
                      <a href="'.$linkEdit.'" 
                          class="btn btn-warning btn-sm" 
                          title="Edit" '.$attr.'>
                          <i class="fa fa-pencil"></i>
                      </a>
                      <a  onclick="distroyNota('.$data->s_id.')"
                          class="btn btn-danger btn-sm" 
                          title="Hapus" '.$attr.'>
                          <i class="fa fa-trash-o"></i></a>
                    </div>'; 
          })
        //inisisai column status agar kode html digenerate ketika ditampilkan
        ->rawColumns(['action','sGross'])
        ->make(true);
  }

  function getTanggalJual($tgl1,$tgl2)
  {
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
     $tgll = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $leagues = d_sales_dt::select('sd_item',
                                  's_date',
                                  'i_name',
                                  'm_gname',
                                  'i_type', 
                                  DB::raw("sum(sd_qty) as jumlah"))
      ->join('m_item', 'm_item.i_id', '=' , 'd_sales_dt.sd_item')
      ->join('m_group','m_group.m_gcode','=','m_item.i_code_group')
      ->join('d_sales', 'd_sales.s_id', '=' , 'd_sales_dt.sd_sales')
      ->where('s_channel','RT')
      ->where('s_status','FN')
      ->where('s_date','>=',$tgll)
      ->where('s_date','<=',$tgl2)
      ->groupBy('sd_item','i_name')
      ->get();

    return DataTables::of($leagues)
      // ->addIndexColumn()
      ->editColumn('sDate', function ($data) 
      {
        return date('d M Y', strtotime($data->s_date));
      })
      ->editColumn('type', function ($data) 
      {
          if ($data->i_type == "BJ") 
          {
              return 'Barang Jual';
          }
          elseif ($data->i_type == "BP") 
          {
              return 'Barang Produksi';
          }
      })
      
      ->make(true);
  }
      
  public function PayMethode(Request $request){
    $paymethode=DB::table('m_paymentmethod')
      ->select('pm_id','pm_name')
      //->where('pm_id','!=',$request->data0)
      ->get();
    $data = array();
    foreach ($paymethode as $value) {
      $data[] = (array) $value;
    }
    for ($j=0; $j<count($data); $j++) {
      for($i=0; $i<$request->length; $i++){
        if($data[$j]['pm_id'] == $request->{'data'.$i})
          $data[$j]['pm_id']=0;
      }
    }
    $idx=0;
    foreach ($data as $key) {
      if($key['pm_id'] == 0){
        unset($data[$idx]);
      }
      $idx++;
    } 

    $data2 = array();
    foreach ($data as $key => $value) {
      $data2[] = (array) $value;
    }
    echo json_encode($data2);
  }

  public function setBarcode(Request $request){
    $data = DB::table('m_item')
        ->select( 'i_id',
                  'i_code',
                  'i_name',
                  'm_psell1',
                  'i_sat1',
                  's_qty')
        ->join('d_stock','d_stock.s_item','=','m_item.i_id')
        ->join('m_price','m_price.m_pitem','=','m_item.i_id')
        ->where('s_comp','1')
        ->where('s_position','1')
        ->where('i_code', 'like', '%'.$request->code.'%')
        ->get();

    return Response::json($data); 
  }
  public function print($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              's_date',
                              's_note')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id',$id)
      ->first();
    // dd($sales);

    $data_chunk = DB::table('d_sales_dt')->select( 'i_code',
                                'i_name',
                                'm_sname',
                                'sd_price',
                                'sd_total',
                                'sd_disc_value',
                                'sd_qty',
                                'sd_disc_percent')
      ->join('m_item','i_id','=','sd_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('sd_sales',$id)->get()->toArray();

      $data = array_chunk($data_chunk, 12);
      // return $chunk;
      // return $data;

      $dataTotal = d_sales_dt::select(DB::raw('SUM(sd_total) as total'))
      ->join('m_item','i_id','=','sd_item')
      ->where('sd_sales',$id)->get();

  
      
      return view('penjualan.POSRetail.print_faktur', compact('data', 'dataTotal', 'sales'));
  }
  public function print_surat_jalan($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              's_date',
                              's_note')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id',$id)
      ->first();
    // dd($sales);

    $data_chunk = DB::table('d_sales_dt')->select( 'i_code',
                                'i_name',
                                'm_sname',
                                'sd_price',
                                'sd_total',
                                'sd_disc_value',
                                'sd_qty',
                                'sd_disc_percent')
      ->join('m_item','i_id','=','sd_item')
      ->join('m_satuan','m_satuan.m_sid','=','m_item.i_sat1')
      ->where('sd_sales',$id)->get()->toArray();

      $data = array_chunk($data_chunk, 12);

      $dataTotal = d_sales_dt::select(DB::raw('SUM(sd_qty) as total'))
      ->where('sd_sales',$id)->get();
      

      return view('penjualan.POSRetail.print_surat_jalan', compact('data', 'dataTotal', 'sales'));
  }
}


