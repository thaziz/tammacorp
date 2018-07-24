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
class rencana_penjualan extends Controller
{
    public function index()
    {
        return view('/penjualan/rencanapenjualan/rencana');
    }

    public function datatable_rencana()
    {
    	$data = DB::table('d_rencana_penjualan')
    			  ->get();

      
	    // return $data;
	    $data = collect($data);
	    // return $data;
	    return Datatables::of($data)
	                    ->addColumn('aksi', function ($data) {
	                    	$a = '<button title="edit" class="btn btn-warning" onclick="edit(\''.$data->rp_id.'\')"><i class="fa fa-pencil"></i></button>';
	                    	$b = '<button title="hapus" class="btn btn-danger" onclick="hapus(\''.$data->rp_id.'\')"><i class="fa fa-trash-o"> </i></button>';
	                    	return $a . $b;
	                    })
	                    
	                    ->addColumn('harga', function ($data) {
	                    	return 'Rp. ' . number_format($data->rp_target_value, 2, ",", ".") ;
	                    })
	                    ->rawColumns(['aksi'])
	                    ->addIndexColumn()
	                    ->make(true);
	}

	public function tambah_rencana()
    {


        $id = DB::table('d_rencana_penjualan')->max('rp_id')+1;
      
        $bulan = carbon::now()->format('m-Y');
    	
        return view('/penjualan/rencanapenjualan/tambah_rencana',compact('id','bulan'));
    }

    public function datatable_rencana1()
    {
    	// $data = DB::table('m_item')
    	// 		  ->select('i_id','i_name','s_qty','i_sat1','m_psell')
    	// 		  ->leftjoin('d_stock','s_item','=','i_id')
    	// 		  ->join('m_price','m_pitem','=','i_id')
    	// 		  ->where('i_group','BARANG DAGANGAN')
    	// 		  ->orderBy('s_qty','DESC')
    	// 		  ->get();

    	$data = DB::select("SELECT  i_id , i_name , r1.s_qty , i_sat1 , m_psell 
    						FROM m_item 
    						LEFT JOIN (SELECT s_item, sum(s_qty) as s_qty 
    									FROM d_stock 
    									GROUP BY s_item) as r1
    						ON r1.s_item = i_id
    						INNER JOIN m_price on m_pitem = i_id
    						WHERE i_group = 'BARANG DAGANGAN'
    						ORDER BY s_qty DESC");

    	for ($i=0; $i < count($data); $i++) { 
    		if ($data[$i]->s_qty == null) {
    			$data[$i]->s_qty = 0;
    		}
    	}


      
	    // return $data;
	    $data = collect($data);
	    // return $data;
	    return Datatables::of($data)
	                    ->addColumn('aksi', function ($data) {
	                    	$a = '<button class="btn btn-warning" onclick="edit(\''.$data->i_id.'\')"><i class="fa fa-pencil">Edit</i></button>';
	                    	$b = '<button class="btn btn-danger" onclick="hapus(\''.$data->i_id.'\')"><i class="fa fa-pencil">Edit</i></button>';
	                    	return $a . $b;
	                    })
	                    ->addColumn('target_penjualan', function ($data) {
	                    	
	                    	$a ='<input type="text" onkeyup="target_qty(this)" value="0" class="target_qty form-control" name="target_qty">';
	                    	$b ='<input type="hidden" class="i_id form-control" name="i_id" value="'.$data->i_id.'">';
	                    	$c ='<input type="hidden" class="harga form-control" name="harga" value="'.$data->m_psell.'">';
	                    	return $a . $b . $c;
	                    })
	                    ->addColumn('target_pendapatan', function ($data) {
	                    	
	                    	return '<input readonly value="0" style="text-align:right" type="text" class="target_value form-control" name="target_value">';
	                    })
	                    ->rawColumns(['aksi','target_penjualan','target_pendapatan'])
	                    ->addIndexColumn()
	                    ->make(true);
	}

	public function datatable_rencana2(request $req)
    {
    	// $data = DB::table('m_item')
    	// 		  ->select('i_id','i_name','s_qty','i_sat1','m_psell')
    	// 		  ->leftjoin('d_stock','s_item','=','i_id')
    	// 		  ->join('m_price','m_pitem','=','i_id')
    	// 		  ->where('i_group','BARANG DAGANGAN')
    	// 		  ->orderBy('s_qty','DESC')
    	// 		  ->get();
    	// dd($req->all());
    	$data = DB::select("SELECT  i_id , i_name , r1.s_qty , i_sat1 , m_psell 
    						FROM m_item 
    						LEFT JOIN (SELECT s_item, sum(s_qty) as s_qty 
    									FROM d_stock 
    									GROUP BY s_item) as r1
    						ON r1.s_item = i_id
    						INNER JOIN m_price on m_pitem = i_id
    						WHERE i_group = 'BARANG DAGANGAN'
    						ORDER BY s_qty DESC");

    	for ($i=0; $i < count($data); $i++) { 
    		if ($data[$i]->s_qty == null) {
    			$data[$i]->s_qty = 0;
    		}
    	}


    	$rpd = DB::table('d_rencana_penjualan_dt')
    			->where('rpd_id',$req->id)
    			->get();

    	for ($i=0; $i < count($data); $i++) { 
    		for ($a=0; $a < count($rpd); $a++) { 
    			if ($data[$i]->i_id == $rpd[$a]->rpd_item) {
    				$data[$i]->s_qty 	  = $rpd[$a]->rpd_target_qty;
    				$data[$i]->pendapatan = $rpd[$a]->rpd_target_value;
    			}
    		}
    	}

    	for ($i=0; $i < count($data); $i++) { 
    		if (!isset($data[$i]->pendapatan)) {
    			$data[$i]->pendapatan = 0;
    		}
    	}


      
	    $data = collect($data);
	    // return $data;
	    return Datatables::of($data)
	                    ->addColumn('aksi', function ($data) {
	                    	$a = '<button class="btn btn-warning" onclick="edit(\''.$data->i_id.'\')"><i class="fa fa-pencil">Edit</i></button>';
	                    	$b = '<button class="btn btn-danger" onclick="hapus(\''.$data->i_id.'\')"><i class="fa fa-pencil">Edit</i></button>';
	                    	return $a . $b;
	                    })
	                    ->addColumn('target_penjualan', function ($data) {
	                    	
	                    	$a ='<input type="text" onkeyup="target_qty(this)" value="'.$data->s_qty.'" class="target_qty form-control" name="target_qty">';
	                    	$b ='<input type="hidden" class="i_id form-control" name="i_id" value="'.$data->i_id.'">';
	                    	$c ='<input type="hidden" class="harga form-control" name="harga" value="'.$data->m_psell.'">';
	                    	return $a . $b . $c;
	                    })
	                    ->addColumn('target_pendapatan', function ($data) {
	                    	
	                    	return '<input readonly value="'.number_format($data->pendapatan, 0, ",", ".").'" style="text-align:right" type="text" class="target_value form-control" name="target_value">';
	                    })
	                    ->rawColumns(['aksi','target_penjualan','target_pendapatan'])
	                    ->addIndexColumn()
	                    ->make(true);
	}

	public function save_item(request $req)
	{
    	return DB::transaction(function() use ($req) {  
			// dd($req->all());
			if (!isset($req->arr1)) {
				return response()->json(['status'=>0,'message'=>'Tidak Ada Item Yang Akan Disimpan']);
			}

			$cari_bulan = DB::table('d_rencana_penjualan')
						  ->where('rp_bulan',$req->bulan)
						  ->where('rp_id','!=',$req->id)
						  ->first();
			if ($cari_bulan != null) {
				return response()->json(['status'=>0,'message'=>'Terdapat Data Dengan Bulan Yang Sama']);
			}

			$id = $req->id;
			$cari = DB::table('d_rencana_penjualan')
					  ->where('rp_id',$id)
					  ->where('rp_bulan',$req->bulan)
					  ->first();
			if ($cari == null) {

				$cari_id = DB::table('d_rencana_penjualan')
					  ->where('rp_id',$id)
					  ->first();


				if ($cari_id !=null) {
        			$id = DB::table('d_rencana_penjualan')->max('rp_id')+1;
				}

				$save = DB::table('d_rencana_penjualan')
							  ->insert([
							  	'rp_id'				=> $id,
							  	'rp_bulan'			=> $req->bulan,
							  	'rp_periode'		=> carbon::parse($req->periode)->format('Y-m-d'),
							  	'rp_target_qty'		=> $req->total_qty,
							  	'rp_target_value'	=> filter_var($req->total_val,FILTER_SANITIZE_NUMBER_INT),
							  	'rp_created_at'		=> carbon::now(),
							  	'rp_updated_at'		=> carbon::now(),
							  	'rp_created_by'		=> Auth::user()->m_name
							  ]);

			}else{
				$save = DB::table('d_rencana_penjualan')
					  		  ->where('rp_id',$id)
							  ->update([
							  	'rp_id'				=> $id,
							  	'rp_bulan'			=> $req->bulan,
							  	'rp_periode'		=> carbon::parse($req->periode)->format('Y-m-d'),
							  	'rp_target_qty'		=> $req->total_qty,
							  	'rp_target_value'	=> filter_var($req->total_val,FILTER_SANITIZE_NUMBER_INT),
							  	'rp_updated_at'		=> carbon::now(),
							  ]);
			}


			$delete_dt = DB::table('d_rencana_penjualan_dt')->where('rpd_id',$id)->delete();

			for ($i=0; $i < count($req->arr1); $i++) { 
				$save_dt = DB::table('d_rencana_penjualan_dt')
							  ->insert([
							  	'rpd_id'			=> $id,
							  	'rpd_dt'			=> $i+1,
							  	'rpd_item'			=> $req->arr1[$i],
							  	'rpd_target_qty'	=> $req->arr2[$i],
							  	'rpd_target_value'	=> filter_var($req->arr3[$i],FILTER_SANITIZE_NUMBER_INT),
							  ]);
			}

			return response()->json(['status'=>1,'message'=>'Data Berhasil Disimpan']);

		});
	}

	public function edit_rencana($id)
	{
		

		$data = DB::table('d_rencana_penjualan')
				  ->where('rp_id',$id)
				  ->first();
				  
		$bulan = explode('-', $data->rp_bulan);

		$cari_sales = DB::table('d_sales')
						->whereRaw("MONTH(s_date) = '$bulan[0]' and YEAR(s_date) = '$bulan[1]'")
						->get();
		$cari_sales = count($cari_sales);

		if ($cari_sales == 0) {
        	return view('/penjualan/rencanapenjualan/edit_rencana',compact('id','data'));
		}else{
        	return redirect::back()->withErrors(['msg', 'The Message']);
		}

	}
	public function hapus_rencana($id)
	{
		$data = DB::table('d_rencana_penjualan')
				  ->where('rp_id',$id)
				  ->first();
				  
		$bulan = explode('-', $data->rp_bulan);
		$cari_sales = DB::table('d_sales')
						->whereRaw("MONTH(s_date) = '$bulan[0]' and YEAR(s_date) = '$bulan[1]'")
						->get();
		$cari_sales = count($cari_sales);

		if ($cari_sales == 0) {
			$delete = DB::table('d_rencana_penjualan')->where('rp_id',$id)->delete();
        	return redirect::back();
		}else{
        	return redirect::back()->withErrors(['msg', 'The Message']);
		}
	}

}
