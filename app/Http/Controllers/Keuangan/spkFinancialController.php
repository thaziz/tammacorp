<?php   

namespace App\Http\Controllers\Keuangan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\d_formula;
use App\d_formula_result;
use App\m_item;
use DataTables;
use App\d_spk;

class spkFinancialController extends Controller
{

  public function spk()
  {
    return view('/keuangan/spk/index');
  }

  public function getDataTabelIndex()
  {
    $productplan =DB::table('d_productplan')
                  ->join('m_item','pp_item','=','i_id')
                  ->where('pp_isspk','N')
                  ->get();
    // dd($spk);    
    json_encode($productplan);
    return DataTables::of($productplan)
    ->addIndexColumn()
    ->addColumn('action', function($data){
        return '<div class="text-center">
                  <button class="btn btn-warning btn-sm" title="Buat SPK" onclick=BuatSpk("'.$data->pp_id.'","'.date('d-m-Y',strtotime($data->pp_date)).'","'.$data->pp_qty.'","'.$data->pp_item.'")>
                    <i class="fa fa-plus"></i>
                  </button>
              </div>';
    })

    ->editColumn('pp_date', function ($user) {
      return $user->pp_date ? with(new Carbon($user->pp_date))->format('d M Y') : '';
    })

    ->rawColumns(['action'])
    ->make(true);
  }

  public function getDataTabelSpk($tgl1,$tgl2,$tampil="semua")
  {
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
     $tanggal1 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

    if ($tampil == 'semua') {
      $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status')
                  ->whereBetween('spk_date', [$tanggal1, $tanggal2])
                  ->orderBy('spk_date', 'DESC')
                  ->get();
    }elseif ($tampil == 'progress') {
      $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status')
                  ->where('spk_status', '=', 'FN')
                  ->whereBetween('spk_date', [$tanggal1, $tanggal2])
                  ->orderBy('spk_date', 'DESC')
                  ->get();
    }else{
      $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status')
                  ->where('spk_status', '=', 'CL')
                  ->whereBetween('spk_date', [$tanggal1, $tanggal2])
                  ->orderBy('spk_date', 'DESC')
                  ->get();
    }
    
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
        if ($data->spk_status == 'FN') 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailManSpk("'.$data->spk_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      &nbsp;
                      <button class="btn btn-sm btn-info" title="Ubah Status"
                          onclick=ubahStatus("'.$data->spk_id.'")><i class="glyphicon glyphicon-ok"></i>
                      </button>
                      &nbsp;
                      <button class="btn btn-sm btn-warning" title="Edit Bahan"
                          onclick=editSpk("'.$data->spk_id.'")><i class="glyphicon glyphicon-edit"></i>
                      </button>
                  </div>';
        }
        else 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailManSpk("'.$data->spk_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      &nbsp;
                      <button class="btn btn-sm btn-info" title="Ubah Status"
                          onclick=ubahStatus("'.$data->spk_id.'")><i class="glyphicon glyphicon-ok"></i>
                      </button>
                      &nbsp;
                      <button class="btn btn-sm btn-warning" title="Edit Bahan"
                          onclick=editSpk("'.$data->spk_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
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

  public function getDataSpkById($idSpk)
  {
    //$spk = d_spk::find($spk_id);
    $spk = d_spk::join('m_item','spk_item','=','i_id')
                ->join('d_productplan','pp_id','=','spk_ref')
                ->select('pp_date', 'spk_ref', 'spk_item', 'i_name', 'pp_qty','spk_code', 'spk_date')
                ->get();           

    return response()->json([
        'status' => 'sukses',
        'data' => $spk,
    ]);
  }

  public function spkCreateId()
  {
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

    $data=['status'=>'sukses','id_spk'=>$idSpk];
     return json_encode($data);
  }

  public function simpanSpk(Request $request){
    $request->tgl_spk=date('Y-m-d',strtotime($request->tgl_spk));
    $spk_id=d_spk::max('spk_id')+1;
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

    $data=['status'=>'sukses'];
    return json_encode($data);
  }

  public function ubahStatusSpk($spk_id)
  {
    //get recent status SPK
    $recentStatusSpk = d_spk::all();
    $spk = d_spk::find($spk_id);

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

  public function tabelFormula( $id, $qty){

    $hasil = d_formula_result::
        where('fr_adonan',$id)
        ->first();
    if ($hasil == null) {
      $formula = d_formula::
        select( 'i_id',
                'i_name',
                'f_bb',
                'f_value')
                // 'f_scale', DB::raw('(f_value * '.$butuh.') as butuh'))
        ->join('m_item','m_item.i_id','=','d_formula.f_bb')
        ->join('d_formula_result','d_formula_result.fr_id','=','f_id')
        ->where('fr_adonan','=',$id)
        ->get();

      return DataTables::of($formula)
      ->editColumn('f_bb', function ($data) {
        return '<input readonly class="form-control" value="'.$data->i_name.'">
                <input name="id_formula[]" class="form-control hidden" value="'.$data->f_bb.'">';
      })

      ->editColumn('f_value', function ($data) {
        return '<input name="id_value[]" readonly class="form-control" value="0">';
      })

      ->addColumn('-', function($data){
          return ''; 
      })

      ->addColumn('-', function($data){
          return '0'; 
      })
      ->addIndexColumn()
      ->rawColumns(['f_bb','f_value','-'])
      ->make(true);
    }
    $x = $hasil->fr_result;

    $butuh = $qty / $x;

    $formula = d_formula::
        select( 'i_id',
                'i_name',
                'f_bb',
                'f_value',
                'f_scale', DB::raw('(f_value * '.$butuh.') as butuh'))
        ->join('m_item','m_item.i_id','=','d_formula.f_bb')
        ->join('d_formula_result','d_formula_result.fr_id','=','f_id')
        ->where('fr_adonan','=',$id)
        ->get();

    return DataTables::of($formula)
    ->editColumn('f_bb', function ($data) {
      return '<input readonly class="form-control" value="'.$data->i_name.'">
              <input name="id_formula[]" class="form-control hidden" value="'.$data->f_bb.'">';
    })

    ->editColumn('f_value', function ($data) {
      return '<input name="id_value[]" readonly class="form-control" value="'.number_format($data->butuh,2,',','.').'">';
    })

    ->addColumn('-', function($data){
        return ''; 
    })

    ->addColumn('-', function($data){
        return '0'; 
    })
    ->addIndexColumn()
    ->rawColumns(['f_bb','f_value','-'])
    ->make(true);
  }

}



