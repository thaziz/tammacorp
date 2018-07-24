<?php   

namespace App\Http\Controllers\Produksi;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use DataTables;
use App\d_spk;
use App\m_item;
use App\d_send_product;
use App\d_formula;
use App\spk_formula;
use App\Http\Requests;
use Illuminate\Http\Request;

class spkProductionController extends Controller
{
  public function spk()
  {
    return view('produksi.spk.index');
  }
  
  public function spkCreateId($x){
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $idSpk = d_spk::max('spk_id');
    if ($idSpk <= 0 || $idSpk <= '') {
      $idSpk  = 1;
    }else{
      $idSpk += 1;
    }                
    $idSpk = 'SPK'  . $year . $month . $date . $idSpk;
    
    $m_item = m_item::where('i_id',$x)->first();
    // dd($m_item);
    $data=[ 'status'=>'sukses',
            'id_spk'=>$idSpk,
            'i_name'=>$m_item ];

    return json_encode($data);
        
  }

  public function cariDataSpk(Request $request){
    if($request->tanggal1=='' && $request->tanggal2=='')
    {
      $request->tanggal1=='2018-04-06';
      $request->tanggal2=='2018-04-13';
    }

    $request->tanggal1=date('Y-m-d',strtotime($request->tanggal1));
    $request->tanggal2=date('Y-m-d',strtotime($request->tanggal2));
   
    $productplan=DB::table('d_productplan')
              ->join('m_item','pp_item','=','i_id')
              ->where('pp_isspk','N')
              ->where('pp_date','>=',$request->tanggal1)
              ->where('pp_date','<=',$request->tanggal2)
              ->get();    
    /*dd($productplan);*/
    return view('produksi.spk.data-plan',compact('productplan'));
  }

  public function tabelSpk()
  {
    $spk = d_spk::join('m_item','spk_item','=','i_id')
                ->join('d_productplan','pp_id','=','spk_ref')
                ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status')
                ->where('spk_status', '=', 'FN')
                ->orderBy('spk_date', 'DESC')
                ->get();
    // dd($spk);    
    return DataTables::of($spk)
    ->addIndexColumn()
    ->editColumn('status', function ($data) 
      {
      if ($data->spk_status == "FN") 
      {
        return '<span class="label label-info">Proses</span>';
      }
      elseif ($data->spk_status == "CL") 
      {
        return '<span class="label label-success">Selesai</span>';
      }
    })
    ->addColumn('action', function($data)
      {
        return '<div class="text-center">
                      <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Detail"
                          onclick=detailManSpk("'.$data->spk_id.'")><i class="fa fa-eye"></i> 
                      </a>&nbsp;
                      <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
                          onclick=ubahStatus("'.$data->spk_id.'")><i class="glyphicon glyphicon-ok"></i>
                      </a>
                  </div>'; 
      })
    ->editColumn('spk_date', function ($user) {
      return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
    })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function getSpkByTgl($tgl1,$tgl2,$stat)
  {
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
    $tanggal1 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
    $tanggal2 = $y2.'-'.$m2.'-'.$d2;
    // dd(array($tanggal1, $tanggal2));
    
    $spk = d_spk::join('m_item','spk_item','=','i_id')
                ->join('d_productplan','pp_id','=','spk_ref')
                ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status')
                ->where('spk_status', '=', $stat)
                ->where('spk_date','>=',$tanggal1)
                ->where('spk_date','<=',$tanggal2)
                ->orderBy('spk_date', 'DESC')
                ->get();    
      
    return DataTables::of($spk)
    ->addIndexColumn()
    ->editColumn('status', function ($data) 
      {
        if ($data->spk_status == "FN") 
      {
        return '<span class="label label-info">Proses</span>';
      }
      elseif ($data->spk_status == "CL") 
      {
        return '<span class="label label-success">Selesai</span>';
      }
    })
    ->addColumn('action', function($data)
      {
        return '<div class="text-center">
                  <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Detail"
                      onclick=detailManSpk("'.$data->spk_id.'")><i class="fa fa-eye"></i> 
                  </a>&nbsp;
                  <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Ubah Status"
                      onclick=ubahStatus("'.$data->spk_id.'")><i class="glyphicon glyphicon-ok"></i>
                  </a>
                </div>'; 
    })

    ->editColumn('spk_date', function ($user) {
      return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
    })

    ->rawColumns(['status', 'action'])
    
    ->make(true);   
  }

  public function simpanSpk(Request $request){
    // dd($request->all());
  DB::beginTransaction();
  try {
    $formula = $request->id_formula;
    $value = $request->id_value;
    $scale = $request->f_scale;
    $request->tgl_spk = date('Y-m-d',strtotime($request->tgl_spk));

    $spk_id = d_spk::max('spk_id')+1;
      d_spk::create([
            'spk_id' =>$spk_id,
            'spk_ref' =>$request->id_plan,
            'spk_date' =>$request->tgl_spk,
            'spk_item' =>$request->iditem,
            'spk_code' =>$request->id_spk,
            'spk_qty' =>$request->jumlah,
            'spk_status'=>$request->status,
      ]);

    $productplan=DB::table('d_productplan')->where('pp_id',$request->id_plan);
    $productplan->update([
        'pp_isspk'=>'Y'
    ]);

    for ($i=0; $i < count($formula) ; $i++) { 
      spk_formula::insert([
                    'fr_spk' => $spk_id,
                    'fr_detailid' => $i+1,
                    'fr_formula'  => $formula[$i],
                    'fr_value' => $value[$i],
                    'fr_scale' => $scale[$i]
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

  public function ubahStatusSpk($spk_id)
  {

    //get recent status SPK
    $recentStatusSpk = d_spk::all();
    $spk = d_spk::find($spk_id);
    // dd($spk);

    if ($spk->spk_status == "FN") 
    {
        //update status to CL
        $spk = d_spk::find($spk_id);
        $spk->spk_status = 'CL';
        $spk->save();
    }
    else
    {
        //update status to FN
        $spk = d_spk::find($spk_id);
        $spk->spk_status = 'FN';
        $spk->save();
    }
    
    return response()->json([
        'status' => 'sukses',
        'pesan' => 'Status SPK telah berhasil diubah',
    ]);
  }
}



