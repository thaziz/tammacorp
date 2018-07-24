<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use Auth;
use App\d_purchasing;
use App\d_purchasing_dt;
use App\d_terima_pembelian;
use App\d_terima_pembelian_dt;

class PenerimaanBrgSupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function suplier()
    {
        return view('inventory/p_suplier/index');
    }


    public function getDatatableIndex()
    {
        $data = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
                ->join('d_supplier','d_terima_pembelian.d_tb_sup','=','d_supplier.s_id')
                ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
                ->select('d_terima_pembelian.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_code', 'd_purchasing.d_pcs_date_created', 'd_mem.m_name')
                ->orderBy('d_tb_created', 'DESC')
                ->get();
        //dd($data);    
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_tb_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_tb_created ? with(new Carbon($data->d_tb_created))->format('d M Y') : '';
            }
        })
        ->editColumn('hargaTotal', function ($data) 
        {
          return 'Rp. '.number_format($data->d_tb_totalnett,2,",",".");
        })
        ->addColumn('action', function($data)
        {
          
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPenerimaan("'.$data->d_pcsr_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit"
                            onclick=editPenerimaan("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePenerimaan("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>';
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function lookupDataPembelian(Request $request)

    {
        //code penerimaan
        $kode = $this->kodeOtomatis(); 
        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;

        $dataHeader = DB::table('d_purchasing')
                    ->select('d_purchasing.*', 'd_supplier.s_company', 'd_supplier.s_name', 'd_supplier.s_id')
                    ->join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                    ->where('d_pcs_id', '=', $id)
                    ->get();


            foreach ($do as $val) {
                $formatted_tags[] = ['id' => $val->dod_do, 'text' => $val->do_nota];
            }
            return \Response::json($formatted_tags);
        }
        else
        {

          $kd = "0001";
        }

        return $codeTerimaBeli = "INB-".date('myd')."-".$kd;
    }

    public function simpanPenerimaan(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //insert to table d_terimapembelian
            $dataHeader = new d_terima_pembelian;
            $dataHeader->d_tb_pid = $request->headNotaPurchase;
            $dataHeader->d_tb_sup = $request->headSupplierId;
            $dataHeader->d_tb_code = $request->headKodeTerima;
            $dataHeader->d_tb_staff = $request->headStaffId;
            $dataHeader->d_tb_date = date('Y-m-d',strtotime($request->headTglTerima));
            $dataHeader->d_tb_totalnett = $this->konvertRp($request->headTotalTerima);
            $dataHeader->d_tb_created = Carbon::now();
            $dataHeader->save();
                  
            //get last lastId then insert id to d_terimapembelian_dt
            $lastId = d_terima_pembelian::select('d_tb_id')->max('d_tb_id');
            if ($lastId == 0 || $lastId == '') 
            {
                $lastId  = 1;
            }  

            //variabel untuk hitung array field
            $hitung_field = count($request->fieldItemId);

            //update d_stock, insert d_stock_mutation & insert d_terimapembelian_dt
            for ($i=0; $i < $hitung_field; $i++) 
            {
                //variabel u/ cek primary satuan
                $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldItemId[$i])->first();
        
                //cek satuan primary, convert ke primary apabila beda satuan
                if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi1;
                }
                elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi2;
                }
                else
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi3;
                }

                $grup = $this->getGroupGudang($request->fieldItemId[$i]);
                $stokAkhir = (int)$request->fieldStokVal[$i] + (int)$hasilConvert;

                //update stock akhir d_stock
                DB::table('d_stock')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->update(['s_qty' => $stokAkhir]);

                //get id d_stock
                $dstock_id = DB::table('d_stock')
                  ->select('s_id')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->first();

                //get last id stock_mutation
                $lastIdSm = DB::select(DB::raw("SELECT EXISTS(SELECT sm_detailid FROM d_stock_mutation where sm_stock = '$dstock_id->s_id' ORDER BY sm_detailid DESC LIMIT 1) as zz"));
                //dd($lastIdSm);
              
                if ($lastIdSm[0]->zz == 0 || $lastIdSm[0]->zz = '0')
                {
                  $hasil_id = 1;
                }
                else
                {
                  $hasil_id = (int)$lastIdSm[0]->zz + 1;
                }

                //insert to d_stock_mutation
                DB::table('d_stock_mutation')->insert([
                  'sm_stock' => $dstock_id->s_id,
                  'sm_detailid' => $hasil_id,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => $grup,
                  'sm_mutcat' => '14',
                  'sm_item' => $request->fieldItemId[$i],
                  'sm_qty' => $hasilConvert,
                  'sm_qty_used' => '0',
                  'sm_qty_expired' => '0',
                  'sm_detail' => "PENAMBAHAN",
                  'sm_hpp' => $this->konvertRp($request->fieldHargaTotal[$i]),
                  'sm_sell' => '0',
                  'sm_reff' => $request->headKodeTerima,
                  'sm_insert' => Carbon::now(),
                ]);

                //insert d_terimapembelian_dt
                $dataIsi = new d_terima_pembelian_dt;
                $dataIsi->d_tbdt_idtb = $lastId;
                $dataIsi->d_tbdt_smdetail = $hasil_id;
                $dataIsi->d_tbdt_item = $request->fieldItemId[$i];
                $dataIsi->d_tbdt_sat = $request->fieldSatuanId[$i];
                $dataIsi->d_tbdt_idpcsdt = $request->fieldIdPurchaseDet[$i];
                $dataIsi->d_tbdt_qty = $request->fieldQtyterima[$i];
                $dataIsi->d_tbdt_price = $request->fieldHargaRaw[$i];
                $dataIsi->d_tbdt_pricetotal = $this->konvertRp($request->fieldHargaTotal[$i]);
                $dataIsi->d_tbdt_date_received = date('Y-m-d',strtotime($request->headTglTerima));
                $dataIsi->d_tbdt_created = Carbon::now();
                $dataIsi->save();
            }

            DB::commit();
            return response()->json([
                  'status' => 'sukses',
                  'pesan' => 'Data Penerimaan Pembelian Berhasil Disimpan'
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

    public function getStokByType($arrItemType, $arrSatuan, $counter)
    {
        foreach ($arrItemType as $val) 
        {
            if ($val->i_type == "BP") //brg produksi
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
                $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();
                  
                $stok[] = $query[0];
                $satuan[] = $satUtama->m_sname;
                $counter++;
            }
            elseif ($val->i_type == "BJ") //brg jual
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '7' AND s_position = '7' limit 1) ,'0') as qtyStok"));
                $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();


        foreach ($dataIsi as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
          //get qty purchase
          $qtyPurchase[] = $val->d_pcsdt_qtyconfirm;
          //get id purchasedt
          $idPurchaseDt[] = $val->d_pcsdt_id; 
        }

        for ($z=0; $z < count($qtyPurchase); $z++) 
        {   
            //variabel untuk menyimpan penjumlahan array qty penerimaan
            $hasil_qty_rcv = 0;
            //get data qty received
            $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as zz FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$idPurchaseDt[$z]."'"));
            
            foreach ($qtyRcv as $nilai) 
            {
                $hasil_qty_rcv = (int)$nilai->zz;
            }

            $qtyRemain[] = $qtyPurchase[$z] - $hasil_qty_rcv;
        }
        
        //variabel untuk count array
        $counter = 0;
        //ambil value stok by item type
        $dataStok = $this->getStokByType($itemType, $sat1, $counter);

        return response()->json([
            'code' => $kode,
            'staff' => $staff,
            'status' => 'sukses',
            'data_header' => $dataHeader,
            'data_qty' => $qtyRemain,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
        ]);
    }


    public function get_tabel_data($id)

    {
        $data = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
                ->join('d_supplier','d_terima_pembelian.d_tb_sup','=','d_supplier.s_id')
                ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
                ->select('d_terima_pembelian.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_code', 'd_purchasing.d_pcs_date_created', 'd_mem.m_name')
                ->orderBy('d_tb_created', 'DESC')
                ->get();
        //dd($data);    
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_tb_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_tb_created ? with(new Carbon($data->d_tb_created))->format('d M Y') : '';
            }
        })
        ->editColumn('hargaTotal', function ($data) 
        {
          return 'Rp. '.number_format($data->d_tb_totalnett,2,",",".");
        })
        ->addColumn('action', function($data)
        {
          
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPenerimaan("'.$data->d_tb_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePenerimaan("'.$data->d_tb_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>';
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function getDataDetail($id)
    {
        $dataHeader = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
            ->join('d_supplier','d_terima_pembelian.d_tb_sup','=','d_supplier.s_id')
            ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
            ->select('d_terima_pembelian.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.*', 'd_mem.m_name')
            ->where('d_terima_pembelian.d_tb_id', '=', $id)
            ->orderBy('d_tb_created', 'DESC')
            ->get();

        foreach ($dataHeader as $val) 
        {   $total_disc = (int)$val->d_pcs_discount + (int)$val->d_pcs_disc_value;
            $data = array(
                'hargaTotBeliGross' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
                'hargaTotBeliDisc' => 'Rp. '.number_format($total_disc,2,",","."),
                'hargaTotBeliTax' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
                'hargaTotBeliNett' => 'Rp. '.number_format($val->d_pcs_total_net,2,",","."),
                'hargaTotalTerimaNett' => 'Rp. '.number_format($val->d_tb_totalnett,2,",","."),
                'tanggalTerima' => date('d-m-Y',strtotime($val->d_tb_date))
            );
        }

        $dataIsi = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
                ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.m_sid')
                ->join('d_purchasing_dt', 'd_terima_pembelian_dt.d_tbdt_idpcsdt', '=', 'd_purchasing_dt.d_pcsdt_id')
                ->select('d_terima_pembelian_dt.*', 'm_item.*', 'd_terima_pembelian.d_tb_code', 'm_satuan.m_sid', 'm_satuan.m_sname', 'd_purchasing_dt.d_pcsdt_qtyconfirm')
                ->where('d_terima_pembelian_dt.d_tbdt_idtb', '=', $id)
                ->orderBy('d_terima_pembelian_dt.d_tbdt_created', 'DESC')
                ->get();
        
        //cek item type untuk hitung stok
        foreach ($dataIsi as $val) 
        {
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
        }

        //variabel untuk count array
        $counter = 0;
        //ambil value stok by item type
        $dataStok = $this->getStokByType($itemType, $sat1, $counter);

        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'header2' => $data,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
        ]);
    }

    public function lookupDataPembelian(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $purchase = DB::table('d_purchasing_dt')->join('d_purchasing', 'd_purchasing_dt.d_pcs_id', '=', 'd_purchasing.d_pcs_id')->select('d_purchasing_dt.d_pcs_id', 'd_purchasing.d_pcs_code')->where('d_pcsdt_isreceived','=','FALSE')->where('d_purchasing_dt.d_pcsdt_isconfirm','=','TRUE')->orderBy('d_pcs_code', 'DESC')->limit(5)->groupBy('d_pcs_id')->get();
            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $purchase = DB::table('d_purchasing_dt')->join('d_purchasing', 'd_purchasing_dt.d_pcs_id', '=', 'd_purchasing.d_pcs_id')->select('d_purchasing_dt.d_pcs_id', 'd_purchasing.d_pcs_code')->where('d_purchasing_dt.d_pcsdt_isreceived','=','FALSE')->where('d_purchasing.d_pcs_code', 'LIKE', '%'.$term.'%')->where('d_purchasing_dt.d_pcsdt_isconfirm','=','TRUE')->orderBy('d_purchasing.d_pcs_code', 'DESC')->limit(5)->groupBy('d_pcs_id')->get();

            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function kodeOtomatis()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_tb_code,4)) as kode_max from d_terima_pembelian WHERE DATE_FORMAT(d_tb_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
        $kd = "";

        if(count($query)>0)
        {
          foreach($query as $k)
          {
            $tmp = ((int)$k->kode_max)+1;
            $kd = sprintf("%04s", $tmp);
          }
        }
        else
        {
          $kd = "0001";
        }

        return $codeTerimaBeli = "INB-".date('myd')."-".$kd;
    }

    public function simpanPenerimaan(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //insert to table d_terimapembelian
            $dataHeader = new d_terima_pembelian;
            $dataHeader->d_tb_pid = $request->headNotaPurchase;
            $dataHeader->d_tb_sup = $request->headSupplierId;
            $dataHeader->d_tb_code = $request->headKodeTerima;
            $dataHeader->d_tb_staff = $request->headStaffId;
            $dataHeader->d_tb_date = date('Y-m-d',strtotime($request->headTglTerima));
            $dataHeader->d_tb_totalnett = $this->konvertRp($request->headTotalTerima);
            $dataHeader->d_tb_created = Carbon::now();
            $dataHeader->save();
                  
            //get last lastId then insert id to d_terimapembelian_dt
            $lastId = d_terima_pembelian::select('d_tb_id')->max('d_tb_id');
            if ($lastId == 0 || $lastId == '') 
            {
                $lastId  = 1;
            }  

            //variabel untuk hitung array field
            $hitung_field = count($request->fieldItemId);

            //update d_stock, insert d_stock_mutation & insert d_terimapembelian_dt
            for ($i=0; $i < $hitung_field; $i++) 
            {
                //variabel u/ cek primary satuan
                $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldItemId[$i])->first();
        
                //cek satuan primary, convert ke primary apabila beda satuan
                if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi1;
                }
                elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi2;
                }
                else
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi3;
                }

                $grup = $this->getGroupGudang($request->fieldItemId[$i]);
                $stokAkhir = (int)$request->fieldStokVal[$i] + (int)$hasilConvert;

                //update stock akhir d_stock
                DB::table('d_stock')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->update(['s_qty' => $stokAkhir]);

                //get id d_stock
                $dstock_id = DB::table('d_stock')
                  ->select('s_id')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->first();

                //get last id stock_mutation
                $lastIdSm = DB::select(DB::raw("SELECT IFNULL((SELECT sm_detailid FROM d_stock_mutation where sm_stock = '$dstock_id->s_id' ORDER BY sm_detailid DESC LIMIT 1) ,'0') as zz"));
                if ($lastIdSm[0]->zz == 0 || $lastIdSm[0]->zz == '0')
                {
                  $hasil_id = 1;
                }
                else
                {
                  $hasil_id = (int)$lastIdSm[0]->zz + 1;
                }

                //insert to d_stock_mutation
                DB::table('d_stock_mutation')->insert([
                  'sm_stock' => $dstock_id->s_id,
                  'sm_detailid' => $hasil_id,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => $grup,
                  'sm_mutcat' => '14',
                  'sm_item' => $request->fieldItemId[$i],
                  'sm_qty' => $hasilConvert,
                  'sm_qty_used' => '0',
                  'sm_qty_expired' => '0',
                  'sm_detail' => "PENAMBAHAN",
                  'sm_hpp' => $this->konvertRp($request->fieldHargaTotal[$i]),
                  'sm_sell' => '0',
                  'sm_reff' => $request->headKodeTerima,
                  'sm_insert' => Carbon::now(),
                ]);

                //insert d_terimapembelian_dt
                $dataIsi = new d_terima_pembelian_dt;
                $dataIsi->d_tbdt_idtb = $lastId;
                $dataIsi->d_tbdt_smdetail = $hasil_id;
                $dataIsi->d_tbdt_item = $request->fieldItemId[$i];
                $dataIsi->d_tbdt_sat = $request->fieldSatuanId[$i];
                $dataIsi->d_tbdt_idpcsdt = $request->fieldIdPurchaseDet[$i];
                $dataIsi->d_tbdt_qty = $request->fieldQtyterima[$i];
                $dataIsi->d_tbdt_price = $request->fieldHargaRaw[$i];
                $dataIsi->d_tbdt_pricetotal = $this->konvertRp($request->fieldHargaTotal[$i]);
                $dataIsi->d_tbdt_date_received = date('Y-m-d',strtotime($request->headTglTerima));
                $dataIsi->d_tbdt_created = Carbon::now();
                $dataIsi->save();

                //update isrecieved d_purchasingdt 
                //if qty purchase == qty received
                $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as aa FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$request->fieldIdPurchaseDet[$i]."'"));
                $qtyPcs = DB::select(DB::raw("SELECT IFNULL(sum(d_pcsdt_qtyconfirm), 0) as bb FROM d_purchasing_dt where d_pcsdt_id = '".$request->fieldIdPurchaseDet[$i]."'"));

                if ($qtyRcv[0]->aa == $qtyPcs[0]->bb) 
                {
                   DB::table('d_purchasing_dt')
                      ->where('d_pcsdt_id', $request->fieldIdPurchaseDet[$i])
                      ->update(['d_pcsdt_isreceived' => 'TRUE']);
                }
                
            }

            DB::commit();
            return response()->json([
                  'status' => 'sukses',
                  'pesan' => 'Data Penerimaan Pembelian Berhasil Disimpan'
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

    public function deletePenerimaan(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
          //cari item & qty d_terimapembelian_dt
          $query = DB::table('d_terima_pembelian_dt')->select('d_tbdt_item', 'd_tbdt_qty', 'd_tbdt_smdetail', 'd_tbdt_sat', 'd_tbdt_idpcsdt')->where('d_tbdt_idtb', $request->id)->get();

          foreach ($query as $value) 
          {
            //array variabel item m_item
            $item[] = $value->d_tbdt_item;
            //array variabel qty return
            $qty_terima[] = $value->d_tbdt_qty;
            //array variabel sm_detailid
            $id_smdetail[] = $value->d_tbdt_smdetail;
            //array variabel satuanid
            $id_satuan[] = $value->d_tbdt_sat;
            //array variabel id_purchasedt
            $id_purchasedt[] = $value->d_tbdt_idpcsdt;
          }

          $hitung_row = count($item);
          for ($i=0; $i < $hitung_row; $i++) 
          { 
            $grup = $this->getGroupGudang($item[$i]);
            //cari id & s_qty d_stock
            $q_dstock = DB::table('d_stock')
              ->select('s_id', 's_qty')
              ->where('s_item', $item[$i])
              ->where('s_comp', $grup)
              ->where('s_position', $grup)
              ->first();
            //array variabel id_stock (d_stock)
            $id_stock[] = $q_dstock->s_id;
            //array variabel qty_stock (d_stock)
            $qty_stock[] = $q_dstock->s_qty;
          }

          for ($i=0; $i < $hitung_row ; $i++) 
          {
            //variabel u/ cek primary satuan
            $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $item[$i])->first();
            //konversi qty
            if ($primary_sat->i_sat1 == $id_satuan[$i]) 
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi1;
            }
            elseif ($primary_sat->i_sat2 == $id_satuan[$i])
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi2;
            }
            else
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi3;
            }

            $grup2 = $this->getGroupGudang($item[$i]);
            //kembalikan stok sebelum penerimaan
            $stokAkhir = (int)$qty_stock[$i] - (int)$hasilConvert;
            // update d_stock
            DB::table('d_stock')
              ->where('s_id', $id_stock[$i])
              ->update(['s_qty' => $stokAkhir]);

            //delete row table d_stock_mutation
            DB::table('d_stock_mutation')
              ->where('sm_stock', '=', $id_stock[$i])
              ->where('sm_detailid', '=', $id_smdetail[$i])
              ->delete();

            //update status to false
            DB::table('d_purchasing_dt')
                      ->where('d_pcsdt_id', $id_purchasedt[$i])
                      ->update(['d_pcsdt_isreceived' => 'FALSE']); 
          }

          //delete row table d_terima_pembelian_dt
          d_terima_pembelian_dt::where('d_tbdt_idtb', $request->id)->delete();
          //delete row table d_terima_pembelian
          d_terima_pembelian::where('d_tb_id', $request->id)->delete();
          
          DB::commit();
          return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Penerimaan Berhasil Dihapus'
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

    public function getStokByType($arrItemType, $arrSatuan, $counter)
    {
        foreach ($arrItemType as $val) 
        {
            if ($val->i_type == "BP") //brg produksi
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
                $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();
                  
                $stok[] = $query[0];
                $satuan[] = $satUtama->m_sname;
                $counter++;
            }
            elseif ($val->i_type == "BJ") //brg jual
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '7' AND s_position = '7' limit 1) ,'0') as qtyStok"));
                $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

                $stok[] = $query[0];
                $satuan[] = $satUtama->m_sname;
                $counter++;
            }
            elseif ($val->i_type == "BB") //bahan baku
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
                $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

                $stok[] = $query[0];
                $satuan[] = $satUtama->m_sname;
                $counter++;
            }
        }

        $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
        return $data;
    }

    // ============================================================================================================== //


    public function getGroupGudang($id_item)
    {
        $typeBrg = DB::table('m_item')->select('i_type')->where('i_id','=', $id_item)->first();
        if ($typeBrg->i_type == "BB") 
        {
          $idGroupGdg = '3';
        } 
        elseif ($typeBrg->i_type == "BJ") 
        {
          $idGroupGdg = '7';
        }
        elseif ($typeBrg->i_type == "BP") 
        {
          $idGroupGdg = '6';
        }
        return $idGroupGdg;
    }

    public function konvertRp($value)
    {
        $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
        return (int)str_replace(',', '.', $value);
    }

    // ============================================================================================================== //






































    public function get_penerimaan_by_tgl($tgl1,$tgl2,$akses)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;
        //dd(array($tanggal1, $tanggal2));
        
        $query = d_delivery_orderdt::select(
                    'd_delivery_order.do_nota', 
                    'd_delivery_orderdt.dod_do',
                    'd_delivery_orderdt.dod_detailid',
                    'm_item.i_name',
                    'd_delivery_orderdt.dod_qty_send',
                    'd_delivery_orderdt.dod_qty_received',
                    'd_delivery_orderdt.dod_date_received',
                    'd_delivery_orderdt.dod_time_received',
                    'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_orderdt.dod_status', '=', 'FN')
            ->where('d_delivery_orderdt.dod_date_received','>=',$tanggal1)
            ->where('d_delivery_orderdt.dod_date_received','<=',$tanggal2)
            ->orderBy('d_delivery_orderdt.dod_update', 'desc')
            ->get();    
        if ($akses == "inventory") 
        {
            return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('tanggalTerima', function ($data) 
            {
                if ($data->dod_date_received == null) 
                {
                    return '-';
                }
                else 
                {
                    return $data->dod_date_received ? with(new Carbon($data->dod_date_received))->format('d M Y') : '';
                }
            })
            ->editColumn('jamTerima', function ($data) 
            {
                if ($data->dod_time_received == null) 
                {
                    return '-';
                }
                else 
                {
                    return $data->dod_time_received;
                }
            })
            ->editColumn('status', function ($data) 
            {
                if ($data->dod_status == "WT") 
                {
                    return '<span class="label label-info">Waiting</span>';
                }
                elseif ($data->dod_status == "FN") 
                {
                    return '<span class="label label-success">Final</span>';
                }
            })
            ->rawColumns(['status'])
            ->make(true);
        }
        else
        {
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                if ($data->dod_qty_received == '0') 
                {
                    return '<div class="text-center">
                                <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
                                    onclick=ubahStatus("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="glyphicon glyphicon-ok"></i>
                                </a>
                            </div>';
                }
                else
                {
                    return '<div class="text-center">
                                <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
                                    onclick=ubahStatus("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="glyphicon glyphicon-ok"></i>
                                </a>
                            </div>';
                }     
            })
            ->editColumn('tanggalTerima', function ($data) 
            {
                if ($data->dod_date_received == null) 
                {
                    return '-';
                }
                else 
                {
                    return $data->dod_date_received ? with(new Carbon($data->dod_date_received))->format('d M Y') : '';
                }
            })
            ->editColumn('jamTerima', function ($data) 
            {
                if ($data->dod_time_received == null) 
                {
                    return '-';
                }
                else 
                {
                    return $data->dod_time_received;
                }
            })
            ->editColumn('status', function ($data) 
            {
                if ($data->dod_status == "WT") 
                {
                    return '<span class="label label-info">Waiting</span>';
                }
                elseif ($data->dod_status == "FN") 
                {
                    return '<span class="label label-success">Final</span>';
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
              
    }

    public function get_list_waiting_by_tgl($tgl3,$tgl4)
    {
        $y = substr($tgl3, -4);
        $m = substr($tgl3, -7,-5);
        $d = substr($tgl3,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl4, -4);
        $m2 = substr($tgl4, -7,-5);
        $d2 = substr($tgl4,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;
        //dd(array($tanggal1, $tanggal2));
        
        $query = d_delivery_orderdt::select(
                    'd_delivery_order.do_nota', 
                    'd_delivery_orderdt.dod_do',
                    'd_delivery_orderdt.dod_detailid',
                    'm_item.i_name',
                    'd_delivery_orderdt.dod_qty_send',
                    'd_delivery_orderdt.dod_qty_received',
                    'd_delivery_orderdt.dod_date_received',
                    'd_delivery_orderdt.dod_time_received',
                    'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_orderdt.dod_status', '=', 'WT')
            ->where('d_delivery_orderdt.dod_date_send','>=',$tanggal1)
            ->where('d_delivery_orderdt.dod_date_send','<=',$tanggal2)
            ->orderBy('d_delivery_orderdt.dod_update', 'desc')
            ->get();    

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            if ($data->dod_qty_received == '0') 
            {
                return '<div class="text-center">
                            <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Terima"
                                onclick=terimaHasilProduksi("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="fa fa-plus"></i> 
                            </a>&nbsp;
                            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
                                onclick=ubahStatus("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="glyphicon glyphicon-ok"></i>
                            </a>
                        </div>';
            }
            else
            {
                return '<div class="text-center">
                            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit"
                                onclick=editHasilProduksi("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="fa fa-edit"></i>  
                            </a>&nbsp;
                            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
                                onclick=ubahStatus("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="glyphicon glyphicon-ok"></i>
                            </a>
                        </div>';
            }     
        })
        ->editColumn('tanggalTerima', function ($data) 
        {
            if ($data->dod_date_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->dod_date_received ? with(new Carbon($data->dod_date_received))->format('d M Y') : '';
            }
        })
        ->editColumn('jamTerima', function ($data) 
        {
            if ($data->dod_time_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->dod_time_received;
            }
        })
        ->editColumn('status', function ($data) 
        {
            if ($data->dod_status == "WT") 
            {
                return '<span class="label label-info">Waiting</span>';
            }
            elseif ($data->dod_status == "FN") 
            {
                return '<span class="label label-success">Final</span>';
            }
        })
        ->rawColumns(['status', 'action'])
        ->make(true);       
    }

    public function terima_hasil_produksi($dod_do, $dod_detailid)
    {
        $query = d_delivery_orderdt::select(
                    'd_delivery_order.do_nota', 
                    'd_delivery_orderdt.dod_do',
                    'd_delivery_orderdt.dod_detailid',
                    'd_delivery_orderdt.dod_item',
                    'd_delivery_orderdt.dod_prdt_productresult',
                    'd_delivery_orderdt.dod_prdt_detail',
                    'm_item.i_name',
                    'd_delivery_orderdt.dod_qty_send',
                    'd_delivery_orderdt.dod_qty_received',
                    'd_delivery_orderdt.dod_date_received',
                    'd_delivery_orderdt.dod_time_received',
                    'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_orderdt.dod_do', '=', $dod_do)
            ->where('d_delivery_orderdt.dod_detailid', '=', $dod_detailid)
            ->where('d_delivery_orderdt.dod_status', '=', 'WT')
            ->get();

         echo json_encode($query);
    }

    public function edit_hasil_produksi($dod_do, $dod_detailid)
    {
         $query = d_delivery_orderdt::select(
                    'd_delivery_order.do_nota', 
                    'd_delivery_orderdt.dod_do',
                    'd_delivery_orderdt.dod_detailid',
                    'd_delivery_orderdt.dod_item',
                    'd_delivery_orderdt.dod_prdt_productresult',
                    'd_delivery_orderdt.dod_prdt_detail',
                    'm_item.i_name',
                    'd_delivery_orderdt.dod_qty_send',
                    'd_delivery_orderdt.dod_qty_received',
                    'd_delivery_orderdt.dod_date_received',
                    'd_delivery_orderdt.dod_time_received',
                    'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_orderdt.dod_do', '=', $dod_do)
            ->where('d_delivery_orderdt.dod_detailid', '=', $dod_detailid)
            ->get();

         echo json_encode($query);
    }

    public function update_data(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //get stock item gdg Sending
            $stok_item_gs = DB::table('d_stock')
                ->where('s_comp','2')
                ->where('s_position','5')
                ->where('s_item',$request->idItemMasuk)
                ->first();

            //get stock item gdg Produksi
            $stok_item_gp = DB::table('d_stock')
                ->where('s_comp','6')
                ->where('s_position','6')
                ->where('s_item',$request->idItemMasuk)
                ->first();

            //get stock item gdg Grosir
            $stok_item_gg = DB::table('d_stock')
                ->where('s_comp','2')
                ->where('s_position','2')
                ->where('s_item',$request->idItemMasuk)
                ->first();
            
            //stok dikembalikan sebelum terjadinya penambahan
            $stok_prev_gdgSending = $stok_item_gs->s_qty + $request->qtyMasukPrev;
            $stok_prev_gdgProd = $stok_item_gp->s_qty + $request->qtyMasukPrev;
            $stok_prev_gdgGrosir = $stok_item_gg->s_qty - $request->qtyMasukPrev;
            //stok ditambahkan dengan inputan
            $stok_akhir_gdgSending = $stok_prev_gdgSending - $request->qtyDiterima;
            $stok_akhir_gdgProd = $stok_prev_gdgProd - $request->qtyDiterima;
            $stok_akhir_gdgGrosir = $stok_prev_gdgGrosir + $request->qtyDiterima;

            //update d_delivery_orderdt
            $date = Carbon::parse($request->tglMasuk)->format('Y-m-d');
            $time = $request->jamMasuk.":00";
            $now = Carbon::now();
            DB::table('d_delivery_orderdt')
                    ->where('dod_detailid', $request->detailId)
                    ->where('dod_do',$request->doId)
                    ->update(['dod_qty_received' => $request->qtyDiterima, 'dod_date_received' => $date, 'dod_time_received' => $time, 'dod_update' => $now]);
                        
            //update gdg Grosir
            DB::table('d_stock')
                    ->where('s_item', $request->idItemMasuk)
                    ->where('s_comp','2')
                    ->where('s_position','2')
                    ->update(['s_qty' => $stok_akhir_gdgGrosir]);
             
            //update gdg Sending
            DB::table('d_stock')
                    ->where('s_item', $request->idItemMasuk)
                    ->where('s_comp','2')
                    ->where('s_position','5')
                    ->update(['s_qty' => $stok_akhir_gdgSending]);

            //update gdg Produksi
            // DB::table('d_stock')
            //         ->where('s_item', $request->idItemMasuk)
            //         ->where('s_comp','6')
            //         ->where('s_position','6')
            //         ->update(['s_qty' => $stok_akhir_gdgProd]);

            // //cek qty mutasi
            // $total_qty_mutasi = DB::table('d_stock_mutation')
            //     ->selectRaw('sum(sm_qty) as totalMutasi')
            //     ->where('sm_stock',$request->modalIdStockInput)
            //     ->where('sm_item',$request->modalNamaItemInput)
            //     ->where('sm_comp',"2")
            //     ->first();
                
            // //jika jumlah qty pd mutasi sama dengan qty total pengiriman   
            // if ($total_qty_mutasi->totalMutasi == $request->modalTotalKirim || $total_qty_mutasi->totalMutasi < $request->modalFieldBatasAtas) 
            // {
            //     //update status to finish
            //     $update = DB::table('d_productresult')
            //         ->where('pr_id', $request->modalIdProductResultInput)
            //         ->update(['prdt_status' => "FN"]);
            // }            

            DB::commit();
            return response()->json([
                'status' => 'Sukses',
                'pesan' => 'Data Telah Berhasil di Update'
            ]);
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function ubah_status_transaksi($dod_do, $dod_detailid)
    {
        //get recent status DO
        $recentStatusDo = DB::table('d_delivery_orderdt')
                            ->where('dod_do',$dod_do)
                            ->where('dod_detailid',$dod_detailid)
                            ->first();

        if ($recentStatusDo->dod_status == "WT") 
        {
            //update status to FN
            DB::table('d_delivery_orderdt')
                ->where('dod_do',$dod_do)
                ->where('dod_detailid',$dod_detailid)
                ->update(['dod_status' => "FN"]);
        }
        else
        {
            //update status to WT
            DB::table('d_delivery_orderdt')
                ->where('dod_do',$dod_do)
                ->where('dod_detailid',$dod_detailid)
                ->update(['dod_status' => "WT"]);
        }

        //get recent status Product Result detail
        $recentStatusPrdt = DB::table('d_productresult_dt')
                                ->where('prdt_productresult',$recentStatusDo->dod_prdt_productresult)
                                ->where('prdt_detail',$recentStatusDo->dod_prdt_detail)
                                ->first();

        if ($recentStatusPrdt->prdt_status != "RC") 
        {
            //update status to RC
            DB::table('d_productresult_dt')
                ->where('prdt_productresult',$recentStatusPrdt->prdt_productresult)
                ->where('prdt_detail',$recentStatusPrdt->prdt_detail)
                ->update(['prdt_status' => "RC"]);
        }
        else
        {
            //update status to SN
            DB::table('d_productresult_dt')
                ->where('prdt_productresult',$recentStatusPrdt->prdt_productresult)
                ->where('prdt_detail',$recentStatusPrdt->prdt_detail)
                ->update(['prdt_status' => "SN"]);
        }
        
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Status penerimaan telah berhasil diubah',
        ]);
    }
}
