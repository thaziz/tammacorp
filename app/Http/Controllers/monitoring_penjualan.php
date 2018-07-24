<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use carbon\Carbon;
use Auth;
use Yajra\Datatables\Datatables;
use DB;
use Redirect;

ini_set('max_execution_time', 120);
class monitoring_penjualan extends Controller
{
	public function progress()
    {
    	$bulan = carbon::now();
    	$bulan = $bulan->subDay(30)->format('m-Y');
    	$bulan = explode('-', $bulan);
    	$high = DB::select("SELECT * FROM m_item
    						INNER JOIN (SELECT sd_item, sum(sd_qty) as sd_qty 
    									FROM d_sales 
    									INNER JOIN d_sales_dt
    									ON sd_sales = s_id 
    									WHERE MONTH(s_date) = '$bulan[0]'
    									AND YEAR(s_date) = '$bulan[1]'
    									AND s_status = 'FN'
    									GROUP BY sd_item) as r1
    						ON i_id = r1.sd_item
    						LEFT JOIN (SELECT sd_item, sum(sd_total) as sd_price 
    									FROM d_sales 
    									INNER JOIN d_sales_dt
    									ON sd_sales = s_id 
    									WHERE MONTH(s_date) = '$bulan[0]'
    									AND YEAR(s_date) = '$bulan[1]'
    									AND s_status = 'FN'
    									GROUP BY sd_item) as r2
    						ON i_id = r2.sd_item
    						ORDER BY r1.sd_qty DESC
    						LIMIT 3");
        return view('/penjualan/monitorprogress/index',compact('high'));
    }

    public function datatable_progress(request $req)
    {
    	// dd($req->all());
    	$bulan = explode('-', $req->bulan);
 
    	$id = DB::table('d_rencana_penjualan')
    			->where('rp_bulan',$req->bulan)
    			->first();
    	if ($id != null) {
    		$data = DB::select("SELECT  rpd_item , i_name , r1.sd_qty , r2.sd_price , rpd_target_qty,rpd_target_value 
    						FROM d_rencana_penjualan_dt 
    						LEFT JOIN (SELECT sd_item, sum(sd_qty) as sd_qty 
    									FROM d_sales 
    									INNER JOIN d_sales_dt
    									ON sd_sales = s_id 
    									WHERE MONTH(s_date) = '$bulan[0]'
    									AND YEAR(s_date) = '$bulan[1]'
    									AND s_status = 'FN'
    									GROUP BY sd_item) as r1
    						ON r1.sd_item = rpd_item
    						LEFT JOIN (SELECT sd_item, sum(sd_total) as sd_price 
    									FROM d_sales 
    									INNER JOIN d_sales_dt
    									ON sd_sales = s_id 
    									WHERE MONTH(s_date) = '$bulan[0]'
    									AND YEAR(s_date) = '$bulan[1]'
    									AND s_status = 'FN'
    									GROUP BY sd_item) as r2
    						ON r2.sd_item = rpd_item
    						INNER JOIN m_item
    						ON i_id = rpd_item
    						WHERE rpd_id = '$id->rp_id'
    						ORDER BY r1.sd_qty DESC");

    		for ($i=0; $i < count($data); $i++) { 
	    		if ($data[$i]->sd_qty == null) {
	    			$data[$i]->sd_qty = 0;
	    		}
	    	}
    	}else{
    		$data = [];
    	}
    	

    	
      
	    // return $data;
	    $data = collect($data);
	    // return $data;
	    return Datatables::of($data)
	                    ->addColumn('sisa_target', function ($data) {
	                    	
	                    	$sisa =  $data->rpd_target_qty - $data->sd_qty;

	                    	if ($sisa < 0) {
	                    		$sisa = 0;
	                    	}
	                    	return $sisa;
	                    })
	                    ->addColumn('pendapatan', function ($data) {
	                    	
	                    	return 'Rp. ' . number_format($data->sd_price, 2, ",", ".") ;
	                    })
	                    ->addColumn('target_pendapatan', function ($data) {
	                    	
	                    	return 'Rp. ' . number_format($data->rpd_target_value, 2, ",", ".") ;
	                    })
	                    ->rawColumns(['sisa_target','pendapatan'])
	                    ->addIndexColumn()
	                    ->make(true);
	}

	public function datatable_progress1(request $req)
    {
    	// dd($req->all());
    	$data = DB::table('d_sales')
    			  ->join('m_customer','c_id','=','s_customer')
    			  ->orderBy('s_insert','DESC')
    			  ->get();
    	

    	
      
	    // return $data;
	    $data = collect($data);
	    // return $data;
	    return Datatables::of($data)
	                    ->addColumn('barang', function ($data) {
	                    	
	                    	$dt = DB::table('d_sales_dt')
	                    			->join('m_item','i_id','=','sd_item')
	                    			->where('sd_sales',$data->s_id)
	                    			->orderBy('sd_detailid','ASC')
	                    			->get();
	                    	$ul   = '<ul class="ul_progress" style="list-style-type: none;">';
	                    	$ul1  = '</ul>';
	                    	$temp = [];
	                    	for ($i=0; $i < count($dt); $i++) { 
	                    		$temp[$i] = '<li>'.$dt[$i]->i_name.'</li>';
	                    	}
	                    	$temp = implode("", $temp);
	                    	return $ul . $temp . $ul1;
	                    })
	                    ->addColumn('qty', function ($data) {
	                    	
	                    	$dt = DB::table('d_sales_dt')
	                    			->join('m_item','i_id','=','sd_item')
	                    			->where('sd_sales',$data->s_id)
	                    			->orderBy('sd_detailid','ASC')
	                    			->get();

	                    	$ul   = '<ul class="ul_progress" style="list-style-type: none;">';
	                    	$ul1  = '</ul>';
	                    	$temp = [];
	                    	for ($i=0; $i < count($dt); $i++) { 
	                    		$temp[$i] = '<li>'.$dt[$i]->sd_qty.'</li>';
	                    	}
	                    	$temp = implode("", $temp);
	                    	return $ul . $temp . $ul1;
	                    })
	                    ->addColumn('total_harga', function ($data) {
	                    	
	                    	$dt = DB::table('d_sales_dt')
	                    			->join('m_item','i_id','=','sd_item')
	                    			->where('sd_sales',$data->s_id)
	                    			->orderBy('sd_detailid','ASC')
	                    			->get();

	                    	$ul   = '<ul class="ul_progress" style="list-style-type: none;">';
	                    	$ul1  = '</ul>';
	                    	$temp = [];
	                    	for ($i=0; $i < count($dt); $i++) { 
	                    		$temp[$i] = '<li>'.'Rp. ' . number_format($dt[$i]->sd_total, 2, ",", ".").'</li>';
	                    	}
	                    	$temp = implode("", $temp);
	                    	return $ul . $temp . $ul1;
	                    })
	                    ->addColumn('tgl', function ($data) {
	                    	
	                    	return carbon::parse($data->s_insert)->format('d/m/Y H:I:s');
	                    })
	                    ->rawColumns(['barang','total_harga','qty'])
	                    ->addIndexColumn()
	                    ->make(true);
	}
}
