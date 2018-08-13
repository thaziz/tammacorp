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

  // public function tabelSpk()
  // {
  //   $spk = d_spk::join('m_item','spk_item','=','i_id')
  //               ->join('d_productplan','pp_id','=','spk_ref')
  //               ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status')
  //               ->where('spk_status', '=', 'FN')
  //               ->orderBy('spk_date', 'DESC')
  //               ->get();
  //   // dd($spk);    
  //   return DataTables::of($spk)
  //   ->addIndexColumn()
  //   ->editColumn('status', function ($data) 
  //     {
  //     if ($data->spk_status == "FN") 
  //     {
  //       return '<span class="label label-info">Proses</span>';
  //     }
  //     elseif ($data->spk_status == "CL") 
  //     {
  //       return '<span class="label label-success">Selesai</span>';
  //     }
  //   })
  //   ->addColumn('action', function($data)
  //     {
  //       return '<div class="text-center">
  //                   <button class="btn btn-sm btn-success" 
  //                             title="Detail" 
  //                             type="button"
  //                             data-toggle="modal"
  //                             data-target="#myModalView"
  //                             onclick=detailManSpk("'.$data->spk_id.'")>
  //                             <i class="fa fa-eye"></i> 
  //                     </button> &nbsp;
  //                     <a      class="btn btn-sm btn-info" 
  //                             href="javascript:void(0)" 
  //                             title="Ubah Status"
  //                             onclick=ubahStatus("'.$data->spk_id.'")>
  //                             <i class="glyphicon glyphicon-ok"></i>
  //                     </a>
  //                 </div>'; 
  //     })
  //   ->editColumn('spk_date', function ($user) {
  //     return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
  //   })
  //   ->rawColumns(['status', 'action'])
  //   ->make(true);
  // }

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
    ->editColumn('status', function ($data) {
        if ($data->spk_status == "FN") {
        return '<span class="label label-info">Proses</span>';
      }elseif ($data->spk_status == "CL") {
        return '<span class="label label-success">Selesai</span>';
      }
    })
    ->addColumn('action', function($data){
      if ($data->spk_status == "FN") {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-success" 
                          title="Detail" 
                          type="button"
                          data-toggle="modal"
                          data-target="#myModalView"
                          onclick=detailManSpk("'.$data->spk_id.'")>
                          <i class="fa fa-eye"></i> 
                  </button>&nbsp;
                  <button class="btn btn-sm btn-info" 
                          title="Ubah Status"
                          onclick=ubahStatus("'.$data->spk_id.'")>
                          <i class="glyphicon glyphicon-ok"></i>
                  </button>
          </div>'; 
      }else{
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" 
                              title="Detail" 
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailManSpk("'.$data->spk_id.'")>
                              <i class="fa fa-eye"></i> 
                    </button>&nbsp;
                    <button class="btn btn-sm btn-info" 
                            title=Input data"
                            type="button"
                            data-toggle="modal"
                            data-target="#myModalActual"
                            onclick=imputData("'.$data->spk_id.'")>
                            <i class="fa fa-check-square-o"></i>
                    </button>
                </div>'; 
      }
    })

    ->editColumn('spk_date', function ($user) {
      return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
    })

    ->rawColumns(['status', 'action'])
    
    ->make(true);   
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

  public function lihatFormula(Request $request){
    $spk = d_spk::select( 'pp_date',
                          'i_name',
                          'pp_qty',
                          'spk_code',
                          'spk_id')
      ->where('spk_id',$request->x)
      ->join('m_item','i_id','=','spk_item')
      ->join('d_productplan','pp_id','=','spk_ref')
      ->get();
      // dd($spk);
    $formula = spk_formula::select( 'i_code',
                                    'i_name',
                                    'fr_value',
                                    'm_sname')
      ->where('fr_spk',$request->x)
      ->join('m_item','i_id','=','fr_formula')
      ->join('m_satuan','m_sid','=','fr_scale')
      ->get();

    return view('produksi.spk.detail-formula',compact('spk','formula'));

  }

  public function inputData(Request $request){
    $spk = d_spk::select( 'spk_id')
      ->where('spk_id',$request->x)
      ->first();

    return view('produksi.spk.table-inputactual',compact('spk')); 
  }
  public function print($spk_id)
  {
    $spk = d_spk::select( 'pp_date',
                          'i_name',
                          'pp_qty',
                          'spk_code')
      ->where('spk_id',$spk_id)
      ->join('m_item','i_id','=','spk_item')
      ->join('d_productplan','pp_id','=','spk_ref')
      ->get()->toArray();
      // dd($spk);
      // return $spk;
    $formula = spk_formula::select( 'i_code',
                                    'i_name',
                                    'fr_value',
                                    'm_sname')
      ->where('fr_spk',$spk_id)
      ->join('m_item','i_id','=','fr_formula')
      ->join('m_satuan','m_sid','=','fr_scale')
      ->get()->toArray();

      $formula = array_chunk($formula, 14);

      // return $formula;
    return view('produksi.spk.print', compact('spk', 'formula'));
  }
}



