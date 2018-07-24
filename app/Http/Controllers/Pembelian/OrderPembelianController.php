<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use App\d_purchasing;
use App\d_purchasing_dt;

class OrderPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function order()
    {
        return view('purchasing/orderpembelian/index');
    }

    public function tambah_order()
    {
      //code order
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcs_code,4)) as kode_max from d_purchasing WHERE DATE_FORMAT(d_pcs_date_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
      $kd = "";

      if(count($query)>0)
      {
        foreach($query as $k)
        {
          $tmp = ((int)$k->kode_max)+1;
          $kd = sprintf("%05s", $tmp);
        }
      }
      else
      {
        $kd = "00001";
      }

      $codePO = "PO-".date('myd')."-".$kd;
      $namaStaff = 'Jamilah';
      return view ('/purchasing/orderpembelian/tambah_order',compact('codePO', 'namaStaff'));
    }

    public function getSupplier(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) {
            $sup = DB::table('d_supplier')->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $sup = DB::table('d_supplier')->where('s_company', 'LIKE', '%'.$term.'%')->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
            }

            return Response::json($formatted_tags);  
        }
    }

    public function getDataRencanaBeli(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) {
            $sup = DB::table('d_purchasingplan_dt')
                     ->select('d_purchasingplan.d_pcsp_code', 'd_purchasingplan_dt.d_pcspdt_idplan')
                     ->join('d_purchasingplan','d_purchasingplan_dt.d_pcspdt_idplan','=','d_purchasingplan.d_pcsp_id')
                     ->where('d_purchasingplan_dt.d_pcspdt_isconfirm', '=', "TRUE")
                     ->where('d_purchasingplan_dt.d_pcspdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchasingplan_dt.d_pcspdt_idplan')
                     ->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->d_pcspdt_idplan, 'text' => $val->d_pcsp_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $sup = DB::table('d_purchasingplan_dt')
                     ->select('d_purchasingplan.d_pcsp_code', 'd_purchasingplan_dt.d_pcspdt_idplan')
                     ->join('d_purchasingplan','d_purchasingplan_dt.d_pcspdt_idplan','=','d_purchasingplan.d_pcsp_id')
                     ->where('d_purchasingplan.d_pcsp_code', 'LIKE', '%'.$term.'%')
                     ->where('d_purchasingplan_dt.d_pcspdt_isconfirm', '=', "TRUE")
                     ->where('d_purchasingplan_dt.d_pcspdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchasingplan_dt.d_pcspdt_idplan')
                     ->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->d_pcspdt_idplan, 'text' => $val->d_pcsp_code];
            }

            return Response::json($formatted_tags);  
        }
    }

    public function getDataTabelIndex()
    {
        $data = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->select('d_pcs_date_created','d_pcs_id', 'd_pcsp_id','d_pcs_code','s_company','d_pcs_staff','d_pcs_method','d_pcs_total_net','d_pcs_date_received','d_pcs_status')
                //->where('d_pcs_status', '=', 'FN')
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();
        //dd($data);    
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
        {
          if ($data->d_pcs_status == "WT") 
          {
            return '<span class="label label-info">Waiting</span>';
          }
          elseif ($data->d_pcs_status == "CF") 
          {
            return '<span class="label label-success">Disetujui</span>';
          }
          elseif ($data->d_pcs_status == "DE") 
          {
            return '<span class="label label-warning">Dapat Diedit</span>';
          }
        })
        ->editColumn('tglOrder', function ($data) 
        {
            if ($data->d_pcs_date_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pcs_date_created ? with(new Carbon($data->d_pcs_date_created))->format('d M Y') : '';
            }
        })
        ->editColumn('hargaTotalNet', function ($data) 
        {
          return 'Rp. '.number_format($data->d_pcs_total_net,0,",",".");
        })
        ->editColumn('tglMasuk', function ($data) 
        {
          if ($data->d_pcs_date_received == null) 
          {
              return '-';
          }
          else 
          {
              return $data->d_pcs_date_received ? with(new Carbon($data->d_pcs_date_received))->format('d M Y') : '';
          }
        })
        ->addColumn('action', function($data)
          {
            if ($data->d_pcs_status == "WT") 
            {
              return '<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail"
                              onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-eye"></i> 
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit"
                              onclick=editOrder("'.$data->d_pcs_id.'")><i class="glyphicon glyphicon-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Delete"
                              onclick=deleteOrder("'.$data->d_pcs_id.'")><i class="glyphicon glyphicon-trash"></i>
                          </button>
                      </div>'; 
            }
            elseif ($data->d_pcs_status == "DE") 
            {
              return '<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail"
                              onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-eye"></i> 
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit"
                              onclick=editOrder("'.$data->d_pcs_id.'")><i class="glyphicon glyphicon-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Delete"
                              onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                          </button>
                      </div>'; 
            }
            else
            {
              return '<div class="text-center">
                          <button class="btn btn-sm btn-success" title="Detail"
                              onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-eye"></i> 
                          </button>
                          <button class="btn btn-sm btn-warning" title="Edit"
                              onclick=editOrder("'.$data->d_pcs_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger" title="Delete"
                              onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                          </button>
                      </div>'; 
            }
            
          })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function getDataDetail($id)
    {
        $dataHeader = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->select('d_purchasing.*', 'd_supplier.s_company', 'd_supplier.s_name')
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();

        $statusLabel = $dataHeader[0]->d_pcs_status;
        if ($statusLabel == "WT") 
        {
            $spanTxt = 'Waiting';
            $spanClass = 'label-info';
        }
        elseif ($statusLabel == "DE")
        {
            $spanTxt = 'Dapat Diedit';
            $spanClass = 'label-warning';
        }
        else
        {
            $spanTxt = 'Di setujui';
            $spanClass = 'label-success';
        }

        foreach ($dataHeader as $val) 
        {
            $data = array(
                'hargaBruto' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
                'nilaiDiskon' => 'Rp. '.number_format($val->d_pcs_discount + $val->d_pcs_disc_value,2,",","."),
                'nilaiPajak' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
                'hargaNet' => 'Rp. '.number_format($val->d_pcs_total_net,2,",",".")
            );
        }

        $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->select('d_purchasing_dt.d_pcsdt_id',
                         'd_purchasing_dt.d_pcs_id',
                         'd_purchasing_dt.i_id',
                         'm_item.i_name',
                         'm_item.i_code',
                         'm_item.i_sat1',
                         'd_purchasing_dt.d_pcsdt_prevcost',
                         'd_purchasing_dt.d_pcsdt_qty',
                         'd_purchasing_dt.d_pcsdt_price',
                         'd_purchasing_dt.d_pcsdt_total'
                )
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get();

        foreach ($dataIsi as $val) 
        {
            //cek item type
            $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
        }

        //ambil value stok by item type
        foreach ($itemType as $val) 
        { 
          if ($val->i_type == "BP") //brg produksi
          {
              $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
              $stok[] = $query[0];
          }
          elseif ($val->i_type == "BJ") //brg jual
          {
              $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '7' AND s_position = '7' limit 1) ,'0') as qtyStok"));
              $stok[] = $query[0];
          }
          elseif ($val->i_type == "BB") //bahan baku
          {
              $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
              $stok[] = $query[0];
          }
        }
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'header2' => $data,
            'data_isi' => $dataIsi,
            'data_stok' => $stok,
            'spanTxt' => $spanTxt,
            'spanClass' => $spanClass,
        ]);
    }

    public function getEditOrder($id)
    {
      $dataHeader = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->select('d_purchasing.*', 'd_supplier.s_company', 'd_supplier.s_name')
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();

      $statusLabel = $dataHeader[0]->d_pcs_status;
      if ($statusLabel == "WT") 
      {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
      }
      elseif ($statusLabel == "DE")
      {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
      }
      elseif ($statusLabel == "CF")
      {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
      }
      else
      {
        $spanTxt = 'Barang telah diterima';
        $spanClass = 'label-success';
      }

      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->select('d_purchasing_dt.*', 'm_item.*')
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get();

      foreach ($dataIsi as $val) 
      {
        //cek item type
        $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
      }

      //ambil value stok by item type
      foreach ($itemType as $val) 
      { 
        if ($val->i_type == "BP") //brg produksi
        {
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
          $stok[] = $query[0];
        }
        elseif ($val->i_type == "BJ") //brg jual
        {
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '7' AND s_position = '7' limit 1) ,'0') as qtyStok"));
          $stok[] = $query[0];
        }
        elseif ($val->i_type == "BB") //bahan baku
        {
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
          $stok[] = $query[0];
        }
      }
      
      return response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        'data_stok' => $stok,
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass
      ]);
    }

    public function getDataForm($id)
    {
      $dataIsi = DB::table('d_purchasingplan_dt')
            ->select('d_purchasingplan_dt.*', 'm_item.i_name', 'm_item.i_code', 'm_item.i_sat1', 'm_item.i_id')
            ->leftJoin('m_item','d_purchasingplan_dt.d_pcspdt_item','=','m_item.i_id')
            ->where('d_purchasingplan_dt.d_pcspdt_idplan', '=', $id)
            ->where('d_purchasingplan_dt.d_pcspdt_ispo', '=', "FALSE")
            ->where('d_purchasingplan_dt.d_pcspdt_isconfirm', '=', "TRUE")
            ->get();

        foreach ($dataIsi as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
        }

        //ambil value stok by item type
        foreach ($itemType as $val) 
        { 
            if ($val->i_type == "BP") //brg produksi
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
                $stok[] = $query[0];
            }
            elseif ($val->i_type == "BJ") //brg jual
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '7' AND s_position = '7' limit 1) ,'0') as qtyStok"));
                $stok[] = $query[0];
            }
            elseif ($val->i_type == "BB") //bahan baku
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
                $stok[] = $query[0];
            }
        }

        return response()->json([
            'status' => 'sukses',
            'data_isi' => $dataIsi,
            'data_stok' => $stok,
        ]);
    }

    public function simpanPo(Request $request)
    {
      //dd($request->all());
      $totalGross = $this->konvertRp($request->totalGross);
      $replaceCharDisc = (int)str_replace("%","",$request->diskonHarga);
      $replaceCharPPN = (int)str_replace("%","",$request->ppnHarga);
      $diskonPotHarga = $this->konvertRp($request->potonganHarga);
      $discValue = $totalGross * $replaceCharDisc / 100;

      DB::beginTransaction();
      try {
        if (isset($request->apdTgl)) 
        {
          //insert to table d_purchasing
          $dataHeader = new d_purchasing;
          $dataHeader->d_pcsp_id = $request->cariKodePlan;
          $dataHeader->s_id = $request->cariSup;
          $dataHeader->d_pcs_code = $request->kodePo;
          $dataHeader->d_pcs_staff = $request->namaStaff;
          $dataHeader->d_pcs_method = $request->methodBayar;
          $dataHeader->d_pcs_total_gross = $totalGross;
          $dataHeader->d_pcs_discount = $diskonPotHarga;
          $dataHeader->d_pcs_disc_percent = $replaceCharDisc;
          $dataHeader->d_pcs_disc_value = $discValue;
          $dataHeader->d_pcs_tax_percent = $replaceCharPPN;
          $dataHeader->d_pcs_duedate = date('Y-m-d',strtotime($request->apdTgl));
          $dataHeader->d_pcs_tax_value = ($totalGross - $diskonPotHarga - $discValue) * $replaceCharPPN / 100;
          $dataHeader->d_pcs_total_net = $this->konvertRp($request->totalNett);
          $dataHeader->d_pcs_date_created = date('Y-m-d',strtotime($request->tanggal));
          $dataHeader->save(); 
        }
        else
        {
          //insert to table d_purchasing
          $dataHeader = new d_purchasing;
          $dataHeader->d_pcsp_id = $request->cariKodePlan;
          $dataHeader->s_id = $request->cariSup;
          $dataHeader->d_pcs_code = $request->kodePo;
          $dataHeader->d_pcs_staff = $request->namaStaff;
          $dataHeader->d_pcs_method = $request->methodBayar;
          $dataHeader->d_pcs_total_gross = $totalGross;
          $dataHeader->d_pcs_discount = $diskonPotHarga;
          $dataHeader->d_pcs_disc_percent = $replaceCharDisc;
          $dataHeader->d_pcs_disc_value = $discValue;
          $dataHeader->d_pcs_tax_percent = $replaceCharPPN;
          $dataHeader->d_pcs_tax_value = ($totalGross - $diskonPotHarga - $discValue) * $replaceCharPPN / 100;
          $dataHeader->d_pcs_total_net = $this->konvertRp($request->totalNett);
          $dataHeader->d_pcs_date_created = date('Y-m-d',strtotime($request->tanggal));
          $dataHeader->save(); 
        }
        
        //get last lastId then insert id to d_purchasing_dt
        $lastId = d_purchasing::select('d_pcs_id')->max('d_pcs_id');
        if ($lastId == 0 || $lastId == '') 
        {
          $lastId  = 1;
        }  

        //variabel untuk hitung array field
        $hitung_field = count($request->fieldItemId);

        //update pada tabel d_purchasingplan_dt column
        for ($i=0; $i < $hitung_field; $i++) 
        { 
          DB::table('d_purchasingplan_dt')
          ->where('d_pcspdt_id', $request->fieldidPlanDt[$i])
          ->update(['d_pcspdt_ispo' => 'TRUE', 'd_pcspdt_poid' => $lastId]);
        }

        //insert data isi
        for ($i=0; $i < $hitung_field; $i++) 
        {
          $dataIsi = new d_purchasing_dt;
          $dataIsi->d_pcs_id = $lastId;
          $dataIsi->i_id = $request->fieldItemId[$i];
          $dataIsi->d_pcsdt_idpdt = $request->fieldidPlanDt[$i];
          $dataIsi->d_pcsdt_qty = $request->fieldQty[$i];
          $dataIsi->d_pcsdt_price = $this->konvertRp($request->fieldHarga[$i]);
          $dataIsi->d_pcsdt_prevcost = $this->konvertRp($request->fieldHargaPrev[$i]);
          $dataIsi->d_pcsdt_total = $this->konvertRp($request->fieldHargaTotal[$i]);
          $dataIsi->d_pcsdt_created = Carbon::now();
          $dataIsi->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Rencana Order Berhasil Disimpan'
        ]);
      } 
      catch (\Exception $e) 
      {
        //dd($e);
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
      }
    }

    public function updateDataOrder(Request $request)
    {
      //dd($request->all());
      $totalGross = $this->konvertRp($request->totalGrossEdit);
      $replaceCharDisc = (int)str_replace("%","",$request->diskonHargaEdit);
      $replaceCharPPN = (int)str_replace("%","",$request->ppnHargaEdit);
      $diskonPotHarga = $this->konvertRp($request->potonganHargaEdit);
      $discValue = $totalGross * $replaceCharDisc / 100;
      DB::beginTransaction();
      try {
        //update to table d_purchasing
        $purchasing = d_purchasing::find($request->idPurchaseEdit);
        $purchasing->d_pcs_total_gross = $totalGross;
        $purchasing->d_pcs_discount = $diskonPotHarga;
        $purchasing->d_pcs_disc_percent = $replaceCharDisc;
        $purchasing->d_pcs_disc_value = $discValue;
        $purchasing->d_pcs_tax_percent = $replaceCharPPN;
        $purchasing->d_pcs_tax_value = ($totalGross - $diskonPotHarga - $discValue) * $replaceCharPPN / 100;
        $purchasing->d_pcs_total_net = $this->konvertRp($request->totalNettEdit);
        $purchasing->d_pcs_updated = Carbon::now();
        $purchasing->save();
        
        //update to table d_purchasing_dt
        $hitung_field_edit = count($request->fieldIdPurchaseDt);
        for ($i=0; $i < $hitung_field_edit; $i++) 
        {
          $purchasingdt = d_purchasing_dt::find($request->fieldIdPurchaseDt[$i]);
          $purchasingdt->d_pcsdt_price = $this->konvertRp($request->fieldHarga[$i]);
          $purchasingdt->d_pcsdt_total = $this->konvertRp($request->fieldHargaTotal[$i]);
          $purchasingdt->d_pcsdt_updated = Carbon::now();
          $purchasingdt->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Rencana PO Berhasil Diupdate'
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

    public function deleteDataOrder(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //update d_purchasingplan_dt ispo
        DB::table('d_purchasingplan_dt')
            ->where('d_pcspdt_poid', $request->idPo)
            ->where('d_pcspdt_ispo', "TRUE")
            ->update(['d_pcspdt_ispo' => "FALSE", 'd_pcspdt_poid' => "0"]);

        //delete row table d_purchasing_dt
        $deleteOrderDt = d_purchasing_dt::where('d_pcs_id', $request->idPo)->delete();
        //delete row table d_purchasing
        $deleteOrder = d_purchasing::where('d_pcs_id', $request->idPo)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Rencana Order Berhasil Dihapus'
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

    public function konvertRp($value)
    {
        $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
        return (int)str_replace(',', '.', $value);
    }
}
