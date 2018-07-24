<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\d_stock_mutation;

class mutasiStokController extends Controller
{
  public function tableGrosirRetail(){
  	$data = d_stock_mutation::select(	'sm_date',
  																		'i_code',
  																		'i_name',
  																		'sm_qty',
  																		'sm_reff')
  							->join('m_item','i_id','=','sm_item')
  							->where('sm_comp','1')
  							->where('sm_detail','PENAMBAHAN')
  							->get();
  	
  	return DataTables::of($data)
  	->editColumn('sm_date', function ($data) {
        return date('d M Y H:i', strtotime($data->sm_date));
    })
  	->make(true);

  }

  public function tablePenjualanRetail(){
    $data = d_stock_mutation::select( 'sm_date',
                                      'i_code',
                                      'i_name',
                                      'sm_qty',
                                      'sm_reff')
                ->join('m_item','i_id','=','sm_item')
                ->where('sm_comp','1')
                ->where('sm_detail','PENGURANGAN')
                ->get();
    
    return DataTables::of($data)
    ->editColumn('sm_date', function ($data) {
        return date('d M Y H:i', strtotime($data->sm_date));
    })
    ->make(true);

  }
}
