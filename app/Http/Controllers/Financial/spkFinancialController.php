<?php   

namespace App\Http\Controllers\Financial;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\d_spk;

class spkFinancialController extends Controller
{
  public function spk(){
    $productplan =DB::table('d_productplan')
                  ->join('m_item','pp_item','=','i_id')
                  ->where('pp_isspk','N')
                  ->get();

    $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_date','i_name','pp_qty','spk_code')
                  ->get();              

    return view('/keuangan/spk/spk',compact('productplan','spk'));
  }

  public function spkCreateId(){

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

  public function cariDataSpk(Request $request){                      
       if($request->tanggal1=='' && $request->tanggal2==''){
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
    return view('keuangan.spk.data-plan',compact('productplan'));    
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
}



