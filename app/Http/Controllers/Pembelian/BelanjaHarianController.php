<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use App\d_purchasingharian;
use App\d_purchasingharian_dt;

class BelanjaHarianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function belanja()
    {
      return view('/purchasing/belanjaharian/index');
    }

    public function tambah_belanja()
    {
      //code order
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcsh_id,4)) as kode_max from d_purchasingharian WHERE DATE_FORMAT(d_pcsh_date, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

      $codePH = "PH-".date('myd')."-".$kd;
      $namaStaff = 'Jamilah';
      return view ('/purchasing/belanjaharian/tambah_belanja',compact('codePH', 'namaStaff'));
    }

    public function getDataTabelIndex()
    {
      $data = d_purchasingharian::join('d_supplier','d_purchasingharian.d_pcsh_supid','=','d_supplier.s_id')
              ->select('d_purchasingharian.*', 'd_supplier.s_id', 'd_supplier.s_company')
              ->orderBy('d_pcsh_created', 'DESC')
              ->get();
      //dd($data);    
      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('status', function ($data)
      {
        if ($data->d_pcsh_status == "WT") 
        {
          return '<span class="label label-info">Waiting</span>';
        }
        elseif ($data->d_pcsh_status == "CF") 
        {
          return '<span class="label label-success">Disetujui</span>';
        }
        elseif ($data->d_pcsh_status == "DE") 
        {
          return '<span class="label label-warning">Dapat Diedit</span>';
        }
      })
      ->editColumn('tglBeli', function ($data) 
      {
          if ($data->d_pcsh_date == null) 
          {
              return '-';
          }
          else 
          {
              return $data->d_pcsh_date ? with(new Carbon($data->d_pcsh_date))->format('d M Y') : '';
          }
      })
      ->editColumn('hargaTotal', function ($data) 
      {
        return 'Rp. '.number_format($data->d_pcsh_totalprice,2,",",".");
      })
      ->addColumn('action', function($data)
      {
        if ($data->d_pcsh_status == "WT") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "DE") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        else
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
    }

    public function tambahMasterSupplier(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //insert to table d_supplier
        DB::table('d_supplier')->insert([
          's_company' => $request->fNamaSupplier,
          's_name' => $request->fNamaPemilik,
          's_address' => $request->fNamaAlamat,
          's_phone' => $request->fTelp,
          's_fax' => $request->fFax,
          's_note' => $request->fKeterangan,
          's_insert' => Carbon::now()
        ]);    
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Master Supplier Berhasil Ditambahkan'
        ]);
      } 
      catch (\Exception $e) 
      {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e
        ]);
      }
    }

    public function autocompleteSupplier(Request $request)
    {
      $term = $request->term;
      $results = array();
      $queries = DB::table('d_supplier')
        ->where('s_company', 'LIKE', '%'.$term.'%')
        ->take(8)->get();
      
      if ($queries == null) 
      {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } 
      else 
      {
        foreach ($queries as $val) 
        {
          $results[] = [ 'id' => $val->s_id, 'label' => $val->s_company ];
        }
      }
    
      return Response::json($results);
    }

    public function autocompleteBarang(Request $request)
    {
      $term = $request->term;
      $results = array();
      $queries = DB::table('m_item')
        ->where('i_name', 'LIKE', '%'.$term.'%')
        ->where('i_type', '<>', 'BP')
        ->take(8)->get();
      
      if ($queries == null) 
      {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } 
      else 
      {
        foreach ($queries as $val) 
        {
          $results[] = [ 'id' => $val->i_id, 'label' => $val->i_name, 'satuan' => $val->i_sat1 ];
        }
      }
    
      return Response::json($results);
    }

    public function simpanDataBelanja(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //insert to table d_purchasingharian
        $dataHeader = new d_purchasingharian;
        $dataHeader->d_pcsh_code = $request->kodeNota;
        $dataHeader->d_pcsh_date = date('Y-m-d',strtotime($request->tanggalBeli));
        $dataHeader->d_pcsh_noreff = $request->noReff;
        $dataHeader->d_pcsh_totalprice = $this->konvertRp($request->totalBiaya);
        $dataHeader->d_pcsh_totalpaid = $this->konvertRp($request->totalBayar);
        $dataHeader->d_pcsh_staff = $request->namaStaff;
        $dataHeader->d_pcsh_supid = $request->idSupplier;
        $dataHeader->d_pcsh_updated = Carbon::now();
        $dataHeader->save();
        
        //get last lastId then insert id to d_purchasingharian_dt
        $lastId = d_purchasingharian::select('d_pcsh_id')->max('d_pcsh_id');
        if ($lastId == 0 || $lastId == '') 
        {
          $lastId  = 1;
        }  

        //variabel untuk hitung array field
        $hitung_field = count($request->fieldIpItem);

        //insert data isi
        for ($i=0; $i < $hitung_field; $i++) 
        {
          $dataIsi = new d_purchasingharian_dt;
          $dataIsi->d_pcshdt_pcshid = $lastId;
          $dataIsi->d_pcshdt_item = $request->fieldIpItem[$i];
          $dataIsi->d_pcshdt_qty = $request->fieldIpQty[$i];
          $dataIsi->d_pcshdt_price = $this->konvertRp($request->fieldIpHarga[$i]);
          $dataIsi->d_pcshdt_pricetotal = $this->konvertRp($request->fieldIpHargaTot[$i]);
          $dataIsi->d_pcshdt_created = Carbon::now();
          $dataIsi->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Belanja Berhasil Disimpan'
        ]);
      } 
      catch (\Exception $e) 
      {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e
        ]);
      }
    }

    public function getDetailBelanja($id)
    {
        $dataHeader = d_purchasingharian::join('d_supplier','d_purchasingharian.d_pcsh_supid','=','d_supplier.s_id')
                ->select('d_purchasingharian.*', 'd_supplier.s_company', 'd_supplier.s_name', 'd_supplier.s_id')
                ->where('d_pcsh_id', '=', $id)
                ->orderBy('d_pcsh_created', 'DESC')
                ->get();

        $statusLabel = $dataHeader[0]->d_pcsh_status;
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
                'hargaTotalBeli' => 'Rp. '.number_format($val->d_pcsh_totalprice,2,",","."),
                'hargaTotalBayar' => 'Rp. '.number_format($val->d_pcsh_totalpaid,2,",","."),
                'tanggalBeli' => date('Y-m-d',strtotime($val->d_pcsh_date))
            );
        }

        $dataIsi = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->select('d_purchasingharian_dt.*', 'm_item.*')
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get();
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'header2' => $data,
            'data_isi' => $dataIsi,
            'spanTxt' => $spanTxt,
            'spanClass' => $spanClass,
        ]);
    }

    public function getEditBelanja($id)
    {
      $dataHeader = d_purchasingharian::join('d_supplier','d_purchasingharian.d_pcsh_supid','=','d_supplier.s_id')
                ->select('d_purchasingharian.*', 'd_supplier.s_company', 'd_supplier.s_name', 'd_supplier.s_id')
                ->where('d_pcsh_id', '=', $id)
                ->orderBy('d_pcsh_created', 'DESC')
                ->get();

      $statusLabel = $dataHeader[0]->d_pcsh_status;
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

      $dataIsi = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->select('d_purchasingharian_dt.*', 'm_item.*')
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get();

      $fieldTanggal = date('d-m-Y',strtotime($dataHeader[0]->d_pcsh_date));

      return response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'tanggal' =>$fieldTanggal,
        'data_isi' => $dataIsi,
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass
      ]);
    }

    public function updateDataBelanja(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //update to table d_purchasingharian
        $pharian = d_purchasingharian::find($request->idBelanjaEdit);
        $pharian->d_pcsh_date = date('Y-m-d',strtotime($request->tanggalBeliEdit));
        $pharian->d_pcsh_noreff = $request->noReffEdit;
        $pharian->d_pcsh_staff = $request->namaStaffEdit;
        $pharian->d_pcsh_totalprice = $this->konvertRp($request->totalBiayaEdit);
        $pharian->d_pcsh_totalpaid = $this->konvertRp($request->totalBayarEdit);
        $pharian->d_pcsh_updated = Carbon::now();
        $pharian->save();
        
        //update to table d_purchasingharian_dt
        $hitung_field_edit = count($request->fieldIpIdDetailEdit);
        for ($i=0; $i < $hitung_field_edit; $i++) 
        {
          $phariandt = d_purchasingharian_dt::find($request->fieldIpIdDetailEdit[$i]);
          $phariandt->d_pcshdt_qty = $request->fieldIpQtyEdit[$i];
          $phariandt->d_pcshdt_price = $this->konvertRp($request->fieldIpHargaEdit[$i]);
          $phariandt->d_pcshdt_pricetotal = $this->konvertRp($request->fieldIpHargaTotalEdit[$i]);
          $phariandt->d_pcshdt_updated = Carbon::now();
          $phariandt->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Belanja Harian Berhasil Diupdate'
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

    public function deleteDataBelanja(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //delete row table d_purchasingharian_dt
        $deleteBelanjaDt = d_purchasingharian_dt::where('d_pcshdt_pcshid', $request->idBeli)->delete();
        //delete row table d_purchasingharian
        $deleteBelanja = d_purchasingharian::where('d_pcsh_id', $request->idBeli)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Belanja Harian Berhasil Dihapus'
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

    public function getBelanjaByTgl($tgl1, $tgl2)
    {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;
      
      $data = d_purchasingharian::join('d_supplier','d_purchasingharian.d_pcsh_supid','=','d_supplier.s_id')
            ->select('d_purchasingharian.*', 'd_supplier.s_id', 'd_supplier.s_company')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->orderBy('d_pcsh_created', 'DESC')
            ->get();

      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('status', function ($data)
      {
        if ($data->d_pcsh_status == "WT") 
        {
          return '<span class="label label-info">Waiting</span>';
        }
        elseif ($data->d_pcsh_status == "CF") 
        {
          return '<span class="label label-success">Disetujui</span>';
        }
        elseif ($data->d_pcsh_status == "DE") 
        {
          return '<span class="label label-warning">Dapat Diedit</span>';
        }
      })
      ->editColumn('tglBeli', function ($data) 
      {
          if ($data->d_pcsh_date == null) 
          {
              return '-';
          }
          else 
          {
              return $data->d_pcsh_date ? with(new Carbon($data->d_pcsh_date))->format('d M Y') : '';
          }
      })
      ->editColumn('hargaTotal', function ($data) 
      {
        return 'Rp. '.number_format($data->d_pcsh_totalprice,2,",",".");
      })
      ->addColumn('action', function($data)
      {
        if ($data->d_pcsh_status == "WT") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "DE") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        else
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
    }

    public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }

}
