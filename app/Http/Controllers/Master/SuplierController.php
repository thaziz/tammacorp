<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Suplier;
use Yajra\Datatables\Datatables;
use Session;

class SuplierController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function suplier_proses(Request $request)
    {
        $get_limit  = $request->get('limit');

        $limit      = str_replace(',', '', $get_limit);

        $m1 = DB::table('d_supplier')->max('s_id');
    	
        $index = $m1+=1;
        
        $data = DB::table('d_supplier')
          			->insert([
      		        's_id'=>$m1,
          		    's_company'=>$request->get('perusahaan'),
      		        's_name'=>$request->get('nama'),
      		        's_address'=>$request->get('alamat'),
      		        's_phone'=>$request->get('no_hp'),
      		        's_fax'=>$request->get('fax'),
      		        's_npwp'=>$request->get('npwp'),
      		        's_email'=>$request->get('email'),
      		        's_note'=>$request->get('keterangan'),
      		        's_limit'=>$limit
          			]);
        return response()->json(['status'=>'sukses_bos']);
    }
    public function datatable_suplier()
    {
    	$data= DB::table('d_supplier')->get();
        
        
        // return $data;
        $xyzab = collect($data);

        return Datatables::of($xyzab)
                        ->addColumn('aksi', function ($xyzab) {
                          return  '<div class="btn-group">'.
                                   '<a href="suplier_edit/'.$xyzab->s_id.'" class="btn btn-warning btn-xs" title="edit">'.
                                   '<label class="fa fa-pencil"></label></a>'.
                                   '<a href="#" onclick="hapus(this)" class="btn btn-danger btn-xs" title="hapus">'.
                                   '<label class="fa fa-trash-o"></label></a>'.
                                  '</div>';
                        })
                        ->addColumn('limit', function ($xyzab) {
                          return  '<div style="float:left;">'.
                                  'Rp. '.
                                  '</div>'.
                                  '<div style="float:right;">'.number_format($xyzab->s_limit,0,'','.').'</div>';
                        })

                      ->rawColumns(['aksi', 'limit'])
                        ->make(true);
    }
    public function suplier_edit($s_id)
    {
          // return 'a';
        // $edit_suplier = Suplier::find(20)
        $edit_suplier = DB::table("d_supplier")->where("s_id", $s_id)->first();
        // return json_encode($edit_suplier); 
        json_encode($edit_suplier);
        return view('/master/datasuplier/edit_suplier', ['edit_suplier' => $edit_suplier] , compact('edit_suplier', 's_id'));       
    }
    public function suplier_edit_proses(Request $request)
    {
    	$get_limit  = $request->get('limit');

        $limit      = str_replace(',', '', $get_limit);

      // dd($request->all());
      $data = DB::table('d_supplier')
          ->where('s_id',$request->get('s_idx'))
          ->update([
          			's_company'=>$request->get('perusahaan'),
      		        's_name'=>$request->get('nama'),
      		        's_address'=>$request->get('alamat'),
      		        's_phone'=>$request->get('no_hp'),
      		        's_fax'=>$request->get('fax'),
      		        's_npwp'=>$request->get('npwp'),
      		        's_email'=>$request->get('email'),
      		        's_note'=>$request->get('keterangan'),
      		        's_limit'=>$limit
          ]);

    return response()->json(['status'=>1]);
      
    }
    public function suplier_hapus(Request $request)
    {
      $type = DB::Table('d_supplier')->where('s_id','=',$request->id)->delete();
      return response()->json(['status'=>1]);
    }	
}
