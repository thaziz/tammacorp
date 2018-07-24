<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use App\d_delivery_order;
use App\d_delivery_orderdt;

class penerimaanbarang_supController extends Controller
{
	public function suplier()
	{
		$nota = DB::table('d_purchasingplan')->get();
		return view('inventory/p_suplier/suplier',compact('nota'));
	}
	public function create_suplier(Request $request)
	{
		$data_header = DB::table('d_supplier')->join('d_purchasingplan','d_purchasingplan.d_pcsp_sup','=','d_supplier.s_id')->first();
		json_encode($data_header);
		$data_seq = DB::table('d_purchasingplan_dt')->join('m_item','m_item.i_id','=','d_purchasingplan_dt.d_pcspdt_item')->leftjoin('m_price','m_price.m_pitem','=','m_item.i_id')->get();
		$comp = DB::table('d_gudangcabang')->get();
		return view('inventory/p_suplier/create_suplier',compact('data_header','data_seq','comp'));
	}

	public function datatable_pensuplier(Request $request)
	{
	  $list = DB::select("SELECT * from d_penerimaan_barang left join d_supplier on d_supplier.s_id = d_penerimaan_barang.pb_vendor");
          // return $list;
      $data = collect($list);

      for ($i=0; $i <count($data) ; $i++) { 
      	$check_data_seq = DB::table('d_penerimaan_barang_dt')->where('pbdt_code','=',$data[$i]->pb_code)->get();
      }
      
      // return $check_data_seq;
      // return $data;

      return Datatables::of($data)
        
              ->addColumn('aksi', function ($data) {
                        return  '<div class="btn-group">'.
                                 '<button type="button" onclick="edit(this)" class="btn btn-info btn-sm" title="edit">'.
                                 '<label class="fa fa-arrow-alt-circle-right"></label></button>'.
                                '</div>';
              })
              ->addColumn('detail', function ($data) {
                            
                  return '<button data-toggle="modal" onclick="detail(this)"  class="btn btn-outline-primary btn-sm">Detail</button>';
              })
              ->addColumn('status', function ($data) {
                            
                  return '<span class="badge badge-warning badge-pill">In Process</span>';
              })
              ->rawColumns(['aksi','detail','confirmed','status'])
          ->make(true);
	}
	public function save_pensuplier(Request $request)
	{
		
	 	// dd($request->all());	
       return DB::transaction(function() use ($request) {
       $tanggal = date("Y-m-d h:i:s");

       $kode = DB::table('d_penerimaan_barang')->max('pb_id');
            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }
	   $index = str_pad($kode, 3, '0', STR_PAD_LEFT);
	   $date = date('my');
	   $nota = 'PB-'.$index.'/'.''.'/'.$date;

	   // dd($nota);

	   // header
	   $data_header = DB::table('d_penerimaan_barang')->insert([
	   			'pb_id'=>$kode,
	   			'pb_code'=>$nota,
	   			'pb_vendor'=>$request->sup,
	   			'pb_delivery_order'=>$request->do,
	   			'pb_ref'=>$request->code,
	   			'pb_date'=>date('Y-m-d',strtotime($request->date)),
	   			'pb_insert'=>$tanggal,
		 		'pb_insert_by'=>'',
	 	]);
	    $kode_seq = 0;

	    // $header_po = DB::table('d_purchaseorder')
	    // 		->where('po_code','=',$request->pb_ref)
	    // 		->update(['po_status'=>'T']);


	    // sequence
	 	for ($i=0; $i <count($request->item) ; $i++) { 
	    	$kode_seq += 1;
		 	$arr1[$i] =	$request->qty_remain[$i];
		 	$arr2[$i] = $request->qty_confirm[$i];

	    	$subtracted = array_map(function ($x, $y) { return $x-$y;} , $arr1, $arr2);
			$result = array_combine(array_keys($arr1), $subtracted);

		 	$data_seq = DB::table('d_penerimaan_barang_dt')->insert([
		 		'pbdt_id'=>$kode_seq,
		 		'pbdt_code'=>$nota,
		 		'pbdt_item'=>$request->item[$i],
		 		'pbdt_qty_sent'=>$request->qty_acc[$i],
		 		'pbdt_qty_received'=>$request->qty_confirm[$i],
		 		'pbdt_qty_remains'=>$result[$i],
		 		'pbdt_insert'=>$tanggal,
		 		'pbdt_insert_by'=>'',
		 	]);

		 	// $seq_po = DB::table('d_purchaseorder_dt')
	   //  		->where('podt_code','=',$request->pb_ref)
	   //  		->update(['podt_status'=>'T']);
	 	}

	 	//----PENERIMAAN BARANG ---//




	 	//-----------STOCK---------//
	   	$kode_id = 0;
	 	for ($i=0; $i <count($request->item) ; $i++) { 
	   	$kode_id += 1;
	 	$check_stock_gudang = DB::table('d_stock')
	 						 ->where('s_id','=',$request->item[$i])
	 						 ->first();
	 	$cari = DB::table('d_stock')
    						 ->where('s_id','=',$request->item[$i])
    						 ->first();
    	

        $kode_stockm_seq = DB::table('d_stock_mutation')->where('sm_stock','=',isset($cari->s_id))->max('sm_detailid')+1;	

	 	$kode_stock_g = DB::table('d_stock')->max('s_id');
            if ($kode_stock_g == null) {
                $kode_stock_g = 1;
            }else{
                $kode_stock_g += 1;
            }
            
		 	$arr_stockm1[$i] =	$request->qty_remain[$i];
		 	$arr_stockm2[$i] = $request->qty_confirm[$i];

	    	$subtracted = array_map(function ($x, $y) { return $x-$y; } , $arr_stockm1, $arr_stockm2);
			$result_stockm = array_combine(array_keys($arr_stockm1), $subtracted);

		 	$check_gudang = DB::table('d_stock')
	    						->where('s_item','=',$request->item[$i])
	    						->first();

	    	if (isset($check_stock_gudang->s_id) != null) {
	 			$data_stock_gudang = DB::table('d_stock')
 									->where('s_id','=',$check_stock_gudang->s_id)
 									->update([
 										's_qty'=>$check_stock_gudang->s_qty+$request->qty_confirm[$i],
 										's_comp'=>$request->comp[$i],
 										's_position'=>$request->position[$i],
 										's_item'=>$request->item[$i],
 									]);
	 		}else{
 				$data_stock_gudang = DB::table('d_stock')
 									->insert([
 										's_qty'=>$request->qty_confirm[$i],
 										's_comp'=>$request->comp[$i],
 										's_position'=>$request->position[$i],
 										's_item'=>$request->item[$i],
 										's_id'=>$kode_stock_g,
 									]);
	 		}

	   		if ($check_gudang == null) {
	   			// dd('a');
	   			$data_stock_mutasi = DB::table('d_stock_mutation')
						 		->insert([
						 		'sm_stock'=>$kode_stock_g,
						 		'sm_detailid'=>$kode_stockm_seq,
						 		'sm_date'=>$tanggal,
						 		'sm_comp'=>$request->comp[$i],
						 		'sm_mutcat'=>9,
						 		'sm_item'=>$request->item[$i],
						 		'sm_qty'=>$request->qty_acc[$i],
						 		'sm_qty_used'=>0,
						 		'sm_qty_expired'=>$request->qty_confirm[$i],
						 		'sm_detail'=>'PENAMBAHAN',
						 		'sm_hpp'=>$request->hpp[$i],
						 		'sm_sell'=>$request->sell[$i],
						 		'sm_reff'=>$request->code,
						 		'sm_insert'=>$tanggal,
						 	]);
	   		}else{
	   			// dd('b');
	   			$data_stock_mutasi = DB::table('d_stock_mutation')
						 		->insert([
						 		'sm_stock'=>$kode_stock_g,
						 		'sm_detailid'=>$kode_stockm_seq,
						 		'sm_date'=>$tanggal,
						 		'sm_comp'=>$request->comp[$i],
						 		'sm_mutcat'=>9,
						 		'sm_item'=>$request->item[$i],
						 		'sm_qty'=>$request->qty_acc[$i],
						 		'sm_qty_used'=>0,
						 		'sm_qty_expired'=>$request->qty_confirm[$i],
						 		'sm_detail'=>'PENAMBAHAN',
						 		'sm_hpp'=>$request->hpp[$i],
						 		'sm_sell'=>$request->sell[$i],
						 		'sm_reff'=>$request->code,
						 		'sm_insert'=>$tanggal,
						 	]);
	   		}

			

		 	
	 	
	 		
	 	}

	 	return response()->json(['status'=>1]);
	 });
	 }
	



	public function edit_pensuplier(Request $request)
	{
		$header_penerimaan = DB::table('d_penerimaan_barang')->leftjoin('d_supplier','d_penerimaan_barang.pb_vendor','=','d_supplier.s_id')->where('pb_code','=',$request->id)->first();
	 	json_encode($header_penerimaan);
	 	$id = $request->id;
	 	$seq_penerimaan = DB::table('d_penerimaan_barang_dt')->leftjoin('m_item','m_item.i_code','=','d_penerimaan_barang_dt.pbdt_item')->where('pbdt_qty_remains','!=','0')->where('pbdt_code','=',$request->id)->get();

	 	return view('inventory/p_suplier/edit_suplier',compact("header_penerimaan",'seq_penerimaan','id'));
	}


}