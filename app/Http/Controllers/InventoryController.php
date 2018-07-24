<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use App\d_delivery_order;
use App\d_delivery_orderdt;

class InventoryController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function suplier()
    {
        return view('inventory/p_suplier/suplier');
    }

    public function produksi()
    {
        return view('inventory/p_hasilproduksi/produksi');
    }

    public function cust()
    {
        return view('inventory/p_returncustomer/cust');
    }

    public function barang()
    {
        return view('inventory/b_digunakan/barang');
    }

    public function opname()
    {
        return view('inventory/stockopname/opname');
    }
     public function cari_nota_sup()
    {
        return view('inventory/p_suplier/cari_nota');
    }
    public function cari_nota_produksi()
    {
        return view('inventory/p_hasilproduksi/cari_nota');
    }
    public function cari_nota_cust()
    {
        return view('inventory/p_returncustomer/cari_nota');
    }
    public function tambah_barang()
    {
        return view('inventory/b_digunakan/tambah_barang');
    }
    public function tambah_opname()
    {
        return view('inventory/stockopname/tambah_opname');
    }

    public function get_data_sj(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) {
            $do = d_delivery_orderdt::select('d_delivery_order.do_nota', 'd_delivery_orderdt.dod_do', 'd_delivery_orderdt.dod_detailid')
                    ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
                    ->where('d_delivery_orderdt.dod_status', '=', 'WT')
                    ->groupBy('d_delivery_orderdt.dod_do')
                    ->get();

            foreach ($do as $val) {
                $formatted_tags[] = ['id' => $val->dod_do, 'text' => $val->do_nota];
            }
            return \Response::json($formatted_tags);
        }
        else
        {
            $do = d_delivery_orderdt::select('d_delivery_order.do_nota', 'd_delivery_orderdt.dod_do', 'd_delivery_orderdt.dod_detailid')
                    ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
                    ->where('d_delivery_order.do_nota', 'LIKE', '%'.$term.'%')
                    ->where('d_delivery_orderdt.dod_status', '=', 'WT')
                    ->groupBy('d_delivery_orderdt.dod_do')
                    ->get();

            $formatted_tags = [];

            foreach ($do as $val) {
                $formatted_tags[] = ['id' => $val->dod_do, 'text' => $val->do_nota];
            }

            return \Response::json($formatted_tags);  
        }
    }

    public function list_sj(Request $request)
    {
        $id_sj = trim($request->sj_code);
            
        return response()->json([
            'idSj' => $id_sj,
        ]);
        //return view('/inventory/p_hasilproduksi/tabel_penerimaan',compact('query'));
    }

    public function get_tabel_data($id)
    {
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
            ->where('d_delivery_order.do_nota', '=', $id)
            /*->where('d_delivery_orderdt.dod_prdt_productresult', '=', $id)
            ->where('d_delivery_orderdt.dod_prdt_detail', '=', $id)*/
            ->where('d_delivery_orderdt.dod_status', '=', 'WT')
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
        //inisisai column status agar kode html digenerate ketika ditampilkan
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

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

    public function simpan_update_data(Request $request)
    {
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
            
            $stok_akhir_gdgSending = $stok_item_gs->s_qty - $request->qtyDiterima;
            $stok_akhir_gdgProd = $stok_item_gp->s_qty - $request->qtyDiterima;

            //cek ada tidaknya record pada tabel
            $rows = DB::table('d_stock')->select('s_id')
                ->where('s_comp','2')
                ->where('s_position','2')
                ->where('s_item',$request->idItemMasuk)
                ->exists();
            // dd($rows);
            if($rows !== FALSE) //jika terdapat record, maka lakukan update
            {
                //get stock item gdg Grosir
                $stok_item_gs = DB::table('d_stock')
                ->where('s_comp','2')
                ->where('s_position','2')
                ->where('s_item',$request->idItemMasuk)
                ->first();
                $stok_akhir_gdgGrosir = $stok_item_gs->s_qty + $request->qtyDiterima;
                //update stok gudang grosir
                $update = DB::table('d_stock')
                    ->where('s_comp','2')
                    ->where('s_position','2')
                    ->where('s_item',$request->idItemMasuk)
                    ->update(['s_qty' => $stok_akhir_gdgGrosir]);
            }
            else //jika tidak ada record, maka lakukan insert
            {
                //get last id
                $id_stock = DB::table('d_stock')->max('s_id') + 1;
                //insert value ke tbl d_stock
                DB::table('d_stock')->insert([
                    's_id' => $id_stock,
                    's_comp' => '2',
                    's_position' => '2',
                    's_item' => $request->idItemMasuk,
                    's_qty' => $request->qtyDiterima,
                ]);
            }

            // $hitung = count($request->modalQtyTerimaInputRows);
            // $insert_mutasi = array();
            // for ($i=0; $i < $hitung; $i++) 
            // {
            //     //variabel u/ edit stok tiap gudang
            //     $stok_akhir_gdgGrosir = $stok_akhir_gdgGrosir + $request->modalQtyTerimaInputRows[$i];
            //     $stok_akhir_gdgProd = $stok_akhir_gdgProd - $request->modalQtyTerimaInputRows[$i];

            //     //insert mutasi gdg grosir pada tabel d_stock_mutation
            //     $insert_mutasi[$i] = DB::Table('d_stock_mutation')
            //         ->insert([
            //             'sm_stock' => $request->modalIdStockInput,
            //             'sm_comp' => $stok_item_gg->s_comp,
            //             'sm_mutcat' => 9,
            //             'sm_item' => $stok_item_gg->s_item,
            //             'sm_qty' => $request->modalQtyTerimaInputRows[$i],
            //             'sm_qty_used' => 0,
            //             'sm_qty_expired' => 0,
            //             'sm_detail' => 'penambahan',
            //             'sm_hpp' => null,
            //             'sm_sell' => null,
            //             'sm_reff' => $request->noReffRows[$i]
            //         ]);

            //     //insert mutasi gdg produksi pada tabel d_stock_mutation
            //     $insert_mutasi[$i] = DB::Table('d_stock_mutation')
            //         ->insert([
            //             'sm_stock' => $request->modalIdStockInput,
            //             'sm_comp' => $stok_item_gp->s_comp,
            //             'sm_mutcat' => 10,
            //             'sm_item' => $stok_item_gp->s_item,
            //             'sm_qty' => 0 - intval($request->modalQtyTerimaInputRows[$i]),
            //             'sm_qty_used' => 0,
            //             'sm_qty_expired' => 0,
            //             'sm_detail' => 'pengurangan',
            //             'sm_hpp' => null,
            //             'sm_sell' => null,
            //             'sm_reff' => $request->noReffRows[$i]
            //         ]);
            // }
             
            //update d_delivery_orderdt
            $date = Carbon::parse($request->tglMasuk)->format('Y-m-d');
            $time = $request->jamMasuk.":00";
            $now = Carbon::now();
            DB::table('d_delivery_orderdt')
                    ->where('dod_detailid', $request->detailId)
                    ->where('dod_do',$request->doId)
                    ->update(['dod_qty_received' => $request->qtyDiterima, 'dod_date_received' => $date, 'dod_time_received' => $time, 'dod_update' => $now]);
                        
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
                'pesan' => 'Data Telah Berhasil di Simpan'
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

            //dd($stok_akhir_gdgGrosir);

            // $hitung = count($request->modalQtyTerimaInputRows);
            // $insert_mutasi = array();
            // for ($i=0; $i < $hitung; $i++) 
            // {
            //     //variabel u/ edit stok tiap gudang
            //     $stok_akhir_gdgGrosir = $stok_akhir_gdgGrosir + $request->modalQtyTerimaInputRows[$i];
            //     $stok_akhir_gdgProd = $stok_akhir_gdgProd - $request->modalQtyTerimaInputRows[$i];

            //     //insert mutasi gdg grosir pada tabel d_stock_mutation
            //     $insert_mutasi[$i] = DB::Table('d_stock_mutation')
            //         ->insert([
            //             'sm_stock' => $request->modalIdStockInput,
            //             'sm_comp' => $stok_item_gg->s_comp,
            //             'sm_mutcat' => 9,
            //             'sm_item' => $stok_item_gg->s_item,
            //             'sm_qty' => $request->modalQtyTerimaInputRows[$i],
            //             'sm_qty_used' => 0,
            //             'sm_qty_expired' => 0,
            //             'sm_detail' => 'penambahan',
            //             'sm_hpp' => null,
            //             'sm_sell' => null,
            //             'sm_reff' => $request->noReffRows[$i]
            //         ]);

            //     //insert mutasi gdg produksi pada tabel d_stock_mutation
            //     $insert_mutasi[$i] = DB::Table('d_stock_mutation')
            //         ->insert([
            //             'sm_stock' => $request->modalIdStockInput,
            //             'sm_comp' => $stok_item_gp->s_comp,
            //             'sm_mutcat' => 10,
            //             'sm_item' => $stok_item_gp->s_item,
            //             'sm_qty' => 0 - intval($request->modalQtyTerimaInputRows[$i]),
            //             'sm_qty_used' => 0,
            //             'sm_qty_expired' => 0,
            //             'sm_detail' => 'pengurangan',
            //             'sm_hpp' => null,
            //             'sm_sell' => null,
            //             'sm_reff' => $request->noReffRows[$i]
            //         ]);
            // }
             
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

            //update gdg Produksi
            DB::table('d_stock')
                    ->where('s_item', $request->idItemMasuk)
                    ->where('s_comp','6')
                    ->where('s_position','6')
                    ->update(['s_qty' => $stok_akhir_gdgProd]);
             
            //update gdg Sending
            DB::table('d_stock')
                    ->where('s_item', $request->idItemMasuk)
                    ->where('s_comp','2')
                    ->where('s_position','5')
                    ->update(['s_qty' => $stok_akhir_gdgSending]);

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
            DB::table('d_delivery_orderdt')->where('dod_do',$dod_do)->where('dod_detailid',$dod_detailid)->update(['dod_status' => "FN"]);
        }
        else
        {
            //update status to WT
            DB::table('d_delivery_orderdt')->where('dod_do',$dod_do)->where('dod_detailid',$dod_detailid)->update(['dod_status' => "WT"]);
        }

        //get recent status Product Result
        // $recentStatusPrdt = DB::table('d_delivery_orderdt')
        //                     ->where('dod_do',$dod_do)
        //                     ->where('dod_detailid',$dod_detailid)
        //                     ->first();
        
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Status penerimaan telah berhasil diubah',
        ]);
    }

}
