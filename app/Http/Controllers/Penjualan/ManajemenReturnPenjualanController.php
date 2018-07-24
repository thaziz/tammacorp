<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Carbon\Carbon;
use DataTables;
use Response;
use URL;
use DB;
use App\d_sales_return;
use App\d_sales_returndt;
use App\d_sales_dt;
use App\d_sales;


class ManajemenReturnPenjualanController extends Controller
{

  public function newreturn(){
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $dsr_id = d_sales_return::select('dsr_id')->max('dsr_id');

    if ($dsr_id <= 0 || $dsr_id <= '') {
      $dsr_id  = 1;
    }else{
      $dsr_id += 1;
    }

    $returnSales = 'XX'  . $year . $month . $date . $dsr_id .'-R';

    return view('penjualan.manajemenreturn.return-pembelian',compact('returnSales'));
  }

  public function tabel(){
    return 'd';
  }

  public function cariNotaSales(Request $request){
    // dd($requests->all());
  	$formatted_tags = array();
    $term = trim($request->q);
    if (empty($term)) {
      $sup = d_sales::where('s_status','=','FN')
        ->limit(50)
        ->get();
      foreach ($sup as $val) {
          $formatted_tags[] = [ 'id' => $val->s_id, 
                                'text' => $val->s_note .'-'. 
                                          $val->s_channel .'-'.
                                          date('d M Y', strtotime($val->s_date))];
      }
      return Response::json($formatted_tags);
    }
    else
    {
      $sup = d_sales::where('s_status','=','FN')
        ->where(function ($b) use ($term) {
                $b->orWhere('s_note', 'LIKE', '%'.$term.'%')
                  ->orWhere('s_channel', 'LIKE', '%'.$term.'%')
                  ->orWhere('s_date', 'LIKE', '%'.$term.'%');
            })
        ->limit(50)
        ->get();
      foreach ($sup as $val) {
          $formatted_tags[] = [ 'id' => $val->s_id, 
                                'text' => $val->s_note .'-'. 
                                          $val->s_channel .'-'.
                                          date('d M Y', strtotime($val->s_date))];
      }

      return Response::json($formatted_tags);  
    }

  }

  public function getNota($id){
    $data = d_sales::select('c_name',
                            'c_hp',
                            'c_address',
                            'c_type',
                            's_gross',
                            's_disc_percent',
                            's_disc_value',
                            's_net',
                            'pm_name')
      ->join('m_customer','c_id','=','s_customer')
      ->join('d_sales_dt','sd_sales','=','s_id')
      ->join('m_item','i_id','=','sd_item')
      ->join('d_sales_payment','sp_sales','=','s_id')
      ->join('m_paymentmethod','pm_id','=','sp_paymentid')
      ->where('s_id',$id)
      ->get();

      return Response::json($data);
  }

  public function tabelPotNota($id){
    $data = d_sales_dt::select('*')
      ->join('m_item','i_id','=','sd_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('sd_sales',$id)
      ->get();

    return DataTables::of($data)
    ->editColumn('sd_qty', function ($data) {
      return '<input  name="sd_qty[]" readonly 
                      class="form-control text-right qty-item" 
                      value="'.$data->sd_qty.'">';
    })
    ->editColumn('sd_qty_return', function ($data) {
      return '<input  name="sd_qty_return[]"  
                      class="form-control text-right qtyreturn" 
                      value="0"
                      type="text"
                      onkeyup="qtyReturn(this, event);autoJumlahNet();">
              <input  name="sd_qty-return[]"  
                      class="form-control text-right qty-return"
                      style="display:none" 
                      value="0">';
    })
    ->editColumn('sd_price', function ($data) {
      return '<input name="sd_price[]" readonly 
                    class="form-control text-right harga-item" 
                    value="Rp. '.number_format($data->sd_price,2,',','.').'">';
    })
    ->editColumn('sd_disc_percent', function ($data) {
      if ($data->sd_disc_percent == 0 && $data->sd_disc_value == 0.00) {
        return '<div class="input-group">
                <input  name="sd_disc_percent[]" 
                        class="form-control text-right dPersen-item discpercent" 
                        value="'.$data->sd_disc_percent.'" 
                        onkeyup="discpercent(this, event);autoJumlahDiskon()">
                        <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
                <input  name="value_disc_percent[]" 
                        class="form-control value-persen totalPersen" 
                        style="display:none"
                        value="0">';
      }else if ($data->sd_disc_percent == 0) {
        return '<div class="input-group">
                <input  name="sd_disc_percent[]" 
                        class="form-control text-right dPersen-item discpercent" 
                        value="'.$data->sd_disc_percent.'" 
                        readonly
                        onkeyup="discpercent(this, event);autoJumlahDiskon()">
                        <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
                <input  name="value_disc_percent[]" 
                        class="form-control value-persen totalPersen" 
                        style="display:none"
                        value="0">';
      }else{
        return '<div class="input-group">
                <input  name="sd_disc_percent[]" 
                        class="form-control text-right dPersen-item discpercent" 
                        value="'.$data->sd_disc_percent.'" 
                        onkeyup="discpercent(this, event);autoJumlahDiskon()">
                        <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
                <input  name="value_disc_percent[]" 
                        class="form-control value-persen totalPersen" 
                        style="display:none"
                        value="0">';
      }
      
    })
    ->editColumn('sd_disc_value', function ($data) {
      if ($data->sd_disc_value == 0.00 && $data->sd_disc_percent == 0) {
        return '<input  name="sd_disc_value[]" 
                      type="text"
                      class="form-control text-right field_harga discvalue dValue-item totalPersen" 
                      onkeyup="discvalue(this, event);autoJumlahDiskon()"
                      value="Rp. '.number_format($data->sd_disc_value,2,',','.').'">';

      }else if($data->sd_disc_value == 0.00 ) {
        return '<input  name="sd_disc_value[]" 
                      type="text"
                      class="form-control text-right field_harga discvalue dValue-item totalPersen" 
                      onkeyup="discvalue(this, event);autoJumlahDiskon()"
                      readonly
                      value="Rp. '.number_format($data->sd_disc_value,2,',','.').'">';

      }else{
        return '<input  name="sd_disc_value[]" 
                      type="text"
                      class="form-control text-right field_harga discvalue dValue-item totalPersen" 
                      onkeyup="discvalue(this, event);autoJumlahDiskon()"
                      value="Rp. '.number_format($data->sd_disc_value,2,',','.').'">';
      }
      
    })
    ->editColumn('sd_return', function ($data) {
      return '<input  name="sd_return[]" readonly 
                      class="form-control text-right hasilReturn" 
                      value="0">';
    })
    ->editColumn('sd_total', function ($data) {
      return '<input  name="sd_total[]" readonly 
                      class="form-control text-right totalHarga totalNet" 
                      value="Rp. '.number_format($data->sd_total,2,',','.').'">';
    })
    ->rawColumns([  'sd_qty',
                    'sd_qty_return',
                    'sd_price',
                    'sd_disc_percent',
                    'sd_disc_value',
                    'sd_return',
                    'sd_total'])
    ->make(true);
  }
}
