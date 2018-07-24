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
use DataTables;
use URL;

class POSGrosirController extends Controller
{
  public function grosir(){ 
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

      $dataPayment = DB::table('m_paymentmethod')->get();

      $ket = 'create';

    return view('/penjualan/POSgrosir/index',compact('id_cust','fatkur', 'idreq','stock','dataPayment','ket','idfatkur'));
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

      $stock  = DB::table('d_stock')->where('s_comp','3')->where('s_position','3')
        ->join('m_item', 'm_item.i_id', '=', 'd_stock.s_item')
        ->get();

      $edit = d_sales::select('c_name',
                              's_customer',
                              'c_address',
                              'c_hp',
                              'c_class',
                              's_note',
                              'd_sales.s_id as sales_id',
                              's_gross',
                              's_net',
                              's_disc_value',
                              'i_name',
                              'sd_sales',
                              'sd_detailid',
                              'i_id',
                              'i_name',
                              'i_type',
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
        ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
        ->leftjoin('d_stock',function($join){
          $join->on('i_id', '=', 's_item');        
          $join->on('s_comp', '=', 's_position');                
          $join->on('s_comp', '=',DB::raw("'2'"));           
        })
        ->where('d_sales.s_id',$id)
        ->get();

      $dataPayment = DB::table('m_paymentmethod')->get();

      $ket = 'edit';

  return view('/penjualan/POSgrosir/index',compact('id_cust','fatkur', 'idreq','stock','edit','dataPayment','ket'));
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

  return view('/penjualan/POSgrosir/NotaPenjualan.detail',compact('detalis'));
  }

  public function autocomplete(Request $request){
    $term = $request->term;

    $results = array();
    
    $queries = DB::table('m_customer')
      ->where('m_customer.c_name', 'LIKE', '%'.$term.'%')
      ->take(50)->get();
    
    if ($queries == null) {
      $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
    } else {
      foreach ($queries as $query) 
      {
        $results[] = [  'id' => $query->c_id, 
                        'label' => $query->c_name .'  '.$query->c_address, 
                        'alamat' => $query->c_address.' '.$query->c_hp ];
      }
    } 

  return Response::json($results);
  }

  public function autocompleteitem(Request $request, $id){
    $term = $request->term;
    $results = array();
    if ($id == 'A') {
      $queries = DB::select('select i_id, i_code,i_name,m_psell1,m_sname,s_qty,i_type 
                            from m_item left join d_stock on i_id = s_item 
                            join m_price on i_id = m_pitem 
                            join m_satuan on m_sid = i_sat1 
                            where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" ) 
                            and ( i_type = "BP" or i_type = "BJ" ) 
                            and ( s_comp = 2 and s_position = 2 or s_comp is null or s_position is null ) 
                            limit 50');

      if ($queries == null) {
        $results[] = [ 'i_id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) 
        {
          $results[] = [ 'id' => $query->i_id, 
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell1, 
                         'kode' => $query->i_id, 
                         'nama' => $query->i_name, 
                         'satuan' => $query->m_sname, 
                         's_qty'=>$query->s_qty,
                         'i_type'=>$query->i_type
                       ];
        }
      }
    }else if ($id == 'B') {
      $queries = DB::select('select i_id, i_code,i_name,m_psell2,m_sname,s_qty,i_type
                            from m_item left join d_stock on i_id = s_item 
                            join m_price on i_id = m_pitem 
                            join m_satuan on m_sid = i_sat1 
                            where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" ) 
                            and ( i_type = "BP" or i_type = "BJ" ) 
                            and ( s_comp = 2 and s_position = 2 or s_comp is null or s_position is null ) 
                            limit 50');

      if ($queries == null) {
        $results[] = [ 'i_id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) 
        {
          $results[] = [ 'id' => $query->i_id, 
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell2, 
                         'kode' => $query->i_id, 
                         'nama' => $query->i_name, 
                         'satuan' => $query->m_sname, 
                         's_qty'=>$query->s_qty,
                         'i_type'=>$query->i_type 
                       ];
        }
      }
    }else{
      $queries = DB::select('select i_id, i_code,i_name,m_psell3,m_sname,s_qty,i_type
                            from m_item left join d_stock on i_id = s_item 
                            join m_price on i_id = m_pitem 
                            join m_satuan on m_sid = i_sat1 
                            where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" ) 
                            and ( i_type = "BP" or i_type = "BJ" ) 
                            and ( s_comp = 2 and s_position = 2 or s_comp is null or s_position is null ) 
                            limit 50');

      if ($queries == null) {
        $results[] = [ 'i_id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) 
        {
          $results[] = [ 'id' => $query->i_id, 
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell3, 
                         'kode' => $query->i_id, 
                         'nama' => $query->i_name, 
                         'satuan' => $query->m_sname, 
                         's_qty'=>$query->s_qty,
                         'i_type'=>$query->i_type
                       ];
        }
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
            'c_birthday' =>  $request->tgl_lahir,
            'c_email' => $request->email,
            'c_hp' => '+62'.$request->no_hp,
            'c_address' => $request->alamat,
            'c_class' => $request->class_cust,
            'c_type' =>'GR',
            'c_insert' => Carbon::now(),
            'c_update' => $request->c_update
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

  public function sal_save_draft(Request $request){
    // dd($request->all());
    DB::beginTransaction();
        try {  
    $s_id = d_sales::max('s_id') + 1;
    d_sales::insert([
            's_id' =>$s_id,
            's_channel' => 'GR',
            's_date' => date('Y-m-d',strtotime($request->s_date)),
            's_note' => $request->s_nota,
            's_staff' => $request->s_staff,
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

      $d_sales_dt = d_sales_dt::insert([
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

  public function sal_save_onProgres(Request $request){
    // dd($request->all());
    DB::beginTransaction();
          try { 
    //nota fatkur
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $idfatkur = DB::Table('d_sales')->select('s_id')->max('s_id');
    
    if ($idfatkur <= 0 || $idfatkur <= '') {
      $idfatkur  = 1;
    }else{
      $idfatkur += 1;
    }

    $fatkur = 'XX'  . $year . $month . $date . $idfatkur;
    //end nota fatkur
    $customer = DB::table('d_sales')
          ->insert([
            's_id' =>$request->s_id,
            's_channel' =>'GR',
            's_date' =>date('Y-m-d',strtotime($request->s_date)),
            's_note' =>$fatkur,
            's_staff' =>$request->s_staff,
            's_customer' => $request->id_cus,
            's_disc_percent' => $request->s_disc_percent,
            's_disc_value' => $request->s_disc_value,
            's_gross' => ($this->konvertRp($request->s_gross)),
            's_tax' => $request->s_pajak,
            's_net' => ($this->konvertRp($request->s_net)),
            's_status' => 'PR',
            's_insert' => Carbon::now(),
            's_update' => $request->s_update
          
        ]);

    $s_id = DB::table('d_sales')->max('s_id');

          for ($i=0; $i < count($request->kode_item); $i++) {

    $d_sales_dt = DB::table('d_sales_dt')
          ->insert([
              'sd_sales'=>$s_id,
              'sd_detailid'=>$i+1,
              'sd_item'=>$request->kode_item[$i],
              'sd_qty'=>$request->sd_qty[$i],
              'sd_price'=>($this->konvertRp($request->harga_item[$i])),
              'sd_total'=>($this->konvertRp($request->hasil[$i])),
              'sd_disc_percent'=>$request->sd_disc_percent[$i],
              'sd_disc_vpercent' => $request->totalValuePercent[$i],
              'sd_disc_value'=> ($this->konvertRp($request->sd_disc_value[$i]))

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

  public function sal_save_final(Request $request){ 
    // dd($request->all());
    DB::beginTransaction();
            try { 
        //nota fatkur
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $idfatkur = DB::Table('d_sales')->select('s_id')->max('s_id');
    
    if ($idfatkur <= 0 || $idfatkur <= '') {
      $idfatkur  = 1;
    }else{
      $idfatkur += 1;
    }

    $fatkur = 'XX'  . $year . $month . $date . $idfatkur;
    //end nota fatkur
    $customer = DB::table('d_sales')
        ->insert([
          's_id' => $request->s_id,
          's_channel' => 'GR',
          's_date' => date('Y-m-d',strtotime($request->s_date)),
          's_note' => $fatkur,
          's_staff' => $request->s_staff,
          's_customer' => $request->id_cus,
          's_gross' => ($this->konvertRp($request->s_gross)),
          's_disc_percent' => ($this->konvertRp($request->s_disc_percent)),
          's_disc_value' => ($this->konvertRp($request->s_disc_value)),
          's_tax' => $request->s_pajak,
          's_net' => ($this->konvertRp($request->s_net)),
          's_status' => 'FN',
          's_insert' => Carbon::now(),
          's_update' => $request->s_update
        ]);

    $s_id = DB::table('d_sales')->max('s_id');

    for ($i=0; $i < count($request->kode_item); $i++) {

      $d_sales_dt = DB::table('d_sales_dt')
          ->insert([
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

        for ($i=0; $i < count($request->sp_method); $i++) {

      $d_sales_payment = DB::table('d_sales_payment')
          ->insert([
              'sp_sales' => $s_id,
              'sp_paymentid' => $i+1,
              'sp_method' => $request->sp_method[$i],
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

  public function sal_save_finalUpdate(Request $request){
    // dd($request->all());
    DB::beginTransaction();
    try {
    $s_id = $request->s_id;
    $kodeItem = $request->kode_item;
    $qtyItem = $request->sd_qty;
    $m = d_sales::where('s_id',$s_id)->first();
    // dd($m->s_status);
     if ($m->s_status == 'DR' || $m->s_status == 'PR') {
        d_sales::where('s_id',$s_id)
          ->update([
            's_channel' => 'GR',
            's_date' => date('Y-m-d',strtotime($request->s_date)),
            's_note' => $request->s_nota,
            's_staff' => $request->s_staff,
            's_customer' => $request->id_cus,
            's_disc_percent' => ($this->konvertRp($request->s_disc_percent)),
            's_disc_value' => ($this->konvertRp($request->s_disc_value)),
            's_gross' => ($this->konvertRp($request->s_gross)),
            's_tax' => $request->s_pajak,
            's_net' => ($this->konvertRp($request->s_net)),
            's_status' => "FN",
            's_insert' => Carbon::now(),
            's_update' => $request->s_update
          ]);

          d_sales_dt::where('sd_sales',$s_id)->delete();

          for ($i=0; $i < count($kodeItem); $i++) {

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

  public function sal_save_onProgresUpdate(Request $request){
    // dd($request->all());
    DB::beginTransaction();
    try { 
    $s_id = $request->s_id;
    $kodeItem = $request->kode_item;
    $qtyItem = $request->sd_qty;
    $m = d_sales::where('s_id', $s_id)->first();

      d_sales::where('s_id', $s_id)
        ->update([
          's_channel' =>'GR',
          's_date' =>date('Y-m-d',strtotime($request->s_date)),
          's_note' =>$request->s_nota,
          's_staff' =>$request->s_staff,
          's_customer' => $request->id_cus,
          's_disc_percent' => $request->s_disc_percent,
          's_disc_value' => $request->s_disc_value,
          's_gross' => ($this->konvertRp($request->s_gross)),
          's_tax' => $request->s_pajak,
          's_net' => ($this->konvertRp($request->s_net)),
          's_status' => 'PR',
          's_insert' => Carbon::now(),
          's_update' => $request->s_update
        ]);

      d_sales_dt::where('sd_sales', $s_id)->delete();

      for ($i=0; $i < count($kodeItem); $i++) {

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
       DB::table('d_sales')->where('s_id',$id)->where('s_status','DR')->delete();

     return redirect('/penjualan/POSgrosir/index');
    }

  public function konvertRp($value){
    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
    return str_replace(',', '.', $value);
  }

  public function tambahItemReq(Request $request){
      return DB::transaction(function() use ($request)
      {

      for ($i=0; $i < count($request->kodeItemReq); $i++) 
        { 
            $stokGrosir = DB::table('d_stock')
                ->where('s_comp','7')
                ->where('s_position','7')
                ->where('s_item',$request->kodeItemReq[$i])->first();

            $s_id= DB::table('d_stock')->max('s_id');

            DB::table('d_stock')
            ->insert([
                's_id'=>$s_id+1,
                's_comp'=>'9',
                's_position'=>'7',
                's_item'=>$request->kodeItemReq[$i],
                's_qty'=>$request->tambahItemReq[$i],
                // 's_insert' => $request->s_insert[$i],
                // 's_update' => $request->s_update[$i]
            ]);

            DB::table('d_transferitem_dt')
              ->update([
                    'tidt_id'=>$request->rd_request[$i],
                    'tidt_detail'=>$request->rd_detail[$i],
                    'tidt_item'=>$request->rd_item[$i],
                    'tidt_qty'=>$request->rd_qty[$i],
                    'tidt_qty_appr'=>$request->tambahItemReq[$i]
              ]);

            $stokBaru = $stokGrosir->s_qty - $request->tambahItemReq[$i];

            DB::table("d_stock")
              ->where('s_comp','7')
              ->where('s_position','7')
              ->where("s_id", $stokGrosir->s_id)
              ->update(['s_qty' => $stokBaru]);
          }
    });
    }

  function getTanggal($tgl1,$tgl2,$tampil='semua')
  {
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
        ->where('s_channel','GR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'draft') {
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','DR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'progress') {
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'final'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','FN')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }elseif ($tampil == 'packing'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','PC')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }elseif ($tampil == 'sending'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','SN')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }else{
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','RC')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }

    //return view('/penjualan/POSgrosir/NotaPenjualan.dt_notaJual',compact('detalis'));
    return DataTables::of($detalis)
      ->addIndexColumn()
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
      ->editColumn('status', function ($data) 
      {
          if ($data->s_status == "DR") { return 'Draft'; }
          elseif ($data->s_status == "WA") { return 'Waiting'; }
          elseif ($data->s_status == "PR") { return 'Progress'; }
          elseif ($data->s_status == "FN") { return 'Final'; }
          elseif ($data->s_status == "PC") { return 'Packing'; }
          elseif ($data->s_status == "SN") { return 'Sending'; }
          elseif ($data->s_status == "RC") { return 'Received'; }
      })
      ->addColumn('action', function($data)
      {
        if ($data->s_status == 'FN' || $data->s_status == 'SN' || $data->s_status == 'PC') 
        {
          return '<div class="text-center">
                    <button 
                      type="button" 
                      class="btn btn-success btn-sm glyphicon glyphicon-check" 
                      title="Ubah Status" 
                      data-toggle="modal" 
                      onclick="ubahStatus('."'".$data->s_id."'".','."'".$data->s_status."'".')" 
                      data-target="#modalStatus">
                    </button>
                  </div>'; 
        }
        else 
        {
         return '<div class="text-center">
                    <button 
                       type="button" 
                       class="btn btn-success btn-sm glyphicon glyphicon-check" 
                       title="Ubah Status" 
                       data-toggle="modal" 
                       onclick="ubahStatus('."'".$data->s_id."'".','."'".$data->s_status."'".')" 
                       data-target="#modalStatus" disabled>
                    </button>
                  </div>';
        }
      })
      ->addColumn('action2', function($data)
      {
        if ($data->s_status == 'FN') { $attr = 'disabled'; } else { $attr = ''; };
        $linkEdit = URL::to('/penjualan/POSgrosir/grosir/edit_sales/'.$data->s_id);
        
        return '<div class="text-center">
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
                  <a onclick="distroyNota('.$data->s_id.')"
                    class="btn btn-danger btn-sm" 
                    title="Hapus" '.$attr.'>
                    <i class="fa fa-trash-o"></i>
                  </a>
                </div>'; 
      })
      //inisisai column status agar kode html digenerate ketika ditampilkan
      ->rawColumns(['action', 'action2','sGross'])
      ->make(true);
  }

  function getTanggalJual($tgl1,$tgl2){
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
      ->where('s_channel','GR')
      ->where(function($status){
          $status ->orWhere('s_status','FN')
                  ->orWhere('s_status','PC')
                  ->orWhere('s_status','SN')
                  ->orWhere('s_status','RC');          
      }) 
     
      ->where('s_date','>=',$tgll)
      ->where('s_date','<=',$tgl2)
      ->groupBy('sd_item','i_name')
      ->get();

    //return view('/penjualan/POSgrosir/ItemPenjualan.Data_JualGrosir',compact('leagues'));
    return DataTables::of($leagues)
      ->addIndexColumn()
      ->editColumn('sDate', function ($data) 
        {
          return date('d M Y', strtotime($data->s_date));
        })
      ->editColumn('type', function ($data) 
        {
          if ($data->i_type == "BJ") { return 'Barang Jual'; }
          elseif ($data->i_type == "BP") { return 'Barang Produksi'; }
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
        ->where('s_comp','2')
        ->where('s_position','2')
        ->where('i_code', 'like', '%'.$request->code.'%')
        ->get();

    return Response::json($data); 
  }

  public function statusMove(Request $request){
    $sales = DB::Table('d_sales')
      ->where('s_id',$request->id)
      ->get();

    $response ='';
    if($request->status == 'SN'){
      $response = '<input type="text" class="hide" name="idSales" id="idSales" value="'.$sales[0]->s_id.'">
                    <input type="text" class="hide" name="oldStatus" id="oldStatus" value="'.$sales[0]->s_status.'">
                    <select id="setStatus" style="width: 75%; " class="pull-right">
                           <option value="RC">Received</option>
                    </select>';
    }elseif($request->status == 'PC'){
      $response = '<input type="text" class="hide" name="idSales" id="idSales" value="'.$sales[0]->s_id.'">
                    <input type="text" class="hide" name="oldStatus" id="oldStatus" value="'.$sales[0]->s_status.'">
                    <select id="setStatus" style="width: 75%; " class="pull-right">
                           <option value="SN">Sending</option>
                           <option value="RC">Received</option>
                    </select>';
    }else{
      $response = '<input type="text" class="hide" name="idSales" id="idSales" value="'.$sales[0]->s_id.'">
                    <input type="text" class="hide" name="oldStatus" id="oldStatus" value="'.$sales[0]->s_status.'">
                    <select id="setStatus" style="width: 75%; " class="pull-right">
                           <option value="PC">Packing</option>
                           <option value="SN">Sending</option>
                           <option value="RC">Received</option>
                    </select>';
    }
    return $response;
  }

  public function changeStatus(Request $request){   
      $update = DB::Table('d_sales')
        ->where('s_id',$request->id)
        ->update([
          's_status' => $request->status,
        ]);

      $salesDt = DB::Table('d_sales_dt')
        ->where('sd_sales',$request->id)
        ->get();
      if(count($salesDt) > 0){
        
        if($request->status == 'PC'){
          foreach ($salesDt as $value) {
            $updateStock = DB::Table('d_stock')
              ->where('s_item',$value->sd_item)
              ->where(function ($query){
                $query->where('s_comp',2)
                      ->where('s_position',2);
                })
              ->decrement('s_qty',$value->sd_qty);
        
            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id');
            if ($maxid <= 0 || $maxid == '') {
              $maxid  = 1;
            }else{
              $maxid += 1;
            }        

            $insertStock = DB::Table('d_stock')
              ->insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 2,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now(),
              ]);

          }
        }
        if($request->status == 'SN' && $request->oldStatus != 'PC'){
          foreach ($salesDt as $value) {
            $updateStock = DB::Table('d_stock')
              ->where('s_item',$value->sd_item)
              ->where(function ($query){
                $query->where('s_comp',4)
                      ->where('s_position',5);
                })
              ->decrement('s_qty',$value->sd_qty);
            
            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id');
            if ($maxid <= 0 || $maxid == '') {
              $maxid  = 1;
            }else{
              $maxid += 1;
            }

            $insertStock = DB::Table('d_stock')
              ->insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 5,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now(),
              ]);
          }
        }
        if($request->status == 'SN' && $request->oldStatus == 'PC'){
          foreach ($salesDt as $value) {
            $updateStock = DB::Table('d_stock')
              ->where('s_item',$value->sd_item)
              ->where(function ($query){
                $query->where('s_comp',4)
                      ->where('s_position',5);
                })
              ->update([
                's_position' => 5,
              ]);
          }
        }
        if($request->status == 'RC'  && $request->oldStatus != 'SN' && $request->oldStatus != 'PC'){
          foreach ($salesDt as $value) {
            $updateStock = DB::Table('d_stock')
              ->where('s_item',$value->sd_item)
              ->where(function ($query){
                $query->where('s_comp',2)
                      ->where('s_position',2);
                })
              ->decrement('s_qty',$value->sd_qty);

            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id');
            if ($maxid <= 0 || $maxid == '') {
              $maxid  = 1;
            }else{
              $maxid += 1;
            }

            $insertStock = DB::Table('d_stock')
              ->insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 4,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now(),
              ]);
          }
        }

        if($request->status == 'RC'  && $request->oldStatus == 'SN'){
          foreach ($salesDt as $value) {
            $updateStock = DB::Table('d_stock')
              ->where('s_item',$value->sd_item)
              ->where(function ($query){
                $query->where('s_comp',4)
                      ->where('s_position',5);
                })
              ->update([
                's_position' => 4,
              ]);
          }
        }
        if($request->status == 'RC'  && $request->oldStatus == 'PC'){
          foreach ($salesDt as $value) {
            $updateStock = DB::Table('d_stock')
              ->where('s_item',$value->sd_item)
              ->where(function ($query){
                $query->where('s_comp',4)
                      ->where('s_position',2);
                })
              ->update([
                's_position' => 4,
              ]);
          }
        }
        
      }
    
      
    return $updateStock;
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

  
      
      return view('penjualan.POSGrosir.print_faktur', compact('data', 'dataTotal', 'sales'));
  }

  public function suratjalan(){
    return view('penjualan.POSGrosir.suratjalan');
  }

  public function lpacking(){
    return view('penjualan.POSGrosir.lpacking');
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
      

      return view('penjualan.POSGrosir.print_surat_jalan', compact('data', 'dataTotal', 'sales'));
  }

  public function print_awas_barang_panas($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              'c_hp')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id',$id)
      ->first();

    
      return view('penjualan.POSretail.print_awas_barang_panas', compact('sales'));
  }
}



