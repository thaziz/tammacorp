<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\d_access;

use App\d_group;

use App\d_group_access;

use App\d_mem_access;

use DB;

class groupAksesController extends Controller
{


    public function indexHakAkses()
    {
    	$hakAkses=d_group::leftjoin('d_group_access','ga_group','=','g_id')
    			  ->leftjoin('d_access','a_id','=','ga_access')->groupBY('g_id')
    			  ->select(DB::raw("group_concat(a_name separator ' ,') as a_name ,g_name,g_id"))
            ->where('ga_read','Y')
            ->orWhere('ga_insert','Y')
            ->orWhere('ga_update','Y')
            ->orWhere('ga_delete','Y')
            ->get();    	    	
    			  /*dd($hakAkses);*/
        return view('/system/hakakses/akses',compact('hakAkses'));
    }

        public function tambah_akses()
    {
       /* if(Auth::user()->punyaAkses('Manajemen Hak Akses ','ma_read')){*/
        $access=d_access::get();     
        return view('/system/hakakses/tambah_akses',compact('access'));
        /*}*/
        return view('system.hakakses.errorakses');
    }

     public function simpanGroup(Request $request){     
     return DB::transaction(function () use ($request) { 

     	$g_id=d_group::max('g_id')+1;
     	d_group::create([
     		'g_id' 		=> $g_id,
     		'g_name'	=>$request->namaGroup,
     	]);
        for ($i=0; $i <count($request->id_access) ; $i++) { 
            d_group_access::create([
            'ga_group' => $g_id,
            'ga_access' => $request->id_access[$i],
            'ga_read'=>$request->view[$i],
            'ga_insert'=>$request->insert[$i],
            'ga_update'=>$request->update[$i],
            'ga_delete'=>$request->delete[$i]
                ]);
        }
        

     	$data=['status'=>'sukses','g_id'=>$g_id];
     	return json_encode($data);

     });
        
    }

    public function simpanGroupDetail(Request $request){    	
  $chek=d_group_access::where('ga_group',$request->g_id)->where('ga_access',$request->id_access);
  if($chek->first()){
  		$chek->update([
  			$request->keterangan => $request->nilai
  				]);
  }else{
    		d_group_access::create([
    				'ga_access' => $request->id_access,
    				'ga_group' => $request->g_id,
    				$request->keterangan => $request->nilai,
	    	]);
    	}

        $data=['status'=>'sukses'];
        return json_encode($data);

    }

      public function editAksesGroup($id)
    {

        return DB::transaction(function () use ($id) { 
        $group=d_group::where('g_id',$id)->first();
        $groupAccess=d_access::
                    Leftjoin('d_group_access',   function($join) use ($id){
                    $join->on('ga_access','=','a_id');
                    $join->on('ga_group','=',DB::raw("'$id'"));
                    
                  })

                        /*,'ga_access','=','a_id')*/
                  ->Leftjoin('d_group',   function($join) use ($id){
                    $join->on('ga_group','=','g_id');
                    $join->on('g_id','=',DB::raw("'$id'"));
                    
                  })

        
        ->get();
        /*dd($groupAccess);*/
        


    /*    $hakAkses=d_group::leftjoin('d_group_access','ga_group','=','g_id')
                  ->leftjoin('d_access','a_id','=','ga_access')->groupBY('g_id')
                  ->select(DB::raw("group_concat(a_name separator ' ,') as a_name ,g_name,g_id"))->get();               */
                  /*dd($hakAkses);*/
        return view('/system/hakakses/edit_akses',compact('group','groupAccess'));
      });
    }

    public function perbaruiGroup($id,Request $request){
      return DB::transaction(function () use ($id,$request) { 
      $group=d_group::where('g_id',$id);
      $group->update([
              'g_name'=>$request->namaGroup
      ]);
        for ($i=0; $i <count($request->id_access) ; $i++) { 
    $group_access=d_group_access::where('ga_group',$id)->where('ga_access','=',$request->id_access[$i]);    
    if(count($group_access->first())!=0){
              $group_access->update([            
                    'ga_read'=>$request->view[$i],
                    'ga_insert'=>$request->insert[$i],
                    'ga_update'=>$request->update[$i],
                    'ga_delete'=>$request->delete[$i]
                        ]);    
    }else{      
       d_group_access::create([
            'ga_group' => $id,
            'ga_access' => $request->id_access[$i],
            'ga_read'=>$request->view[$i],
            'ga_insert'=>$request->insert[$i],
            'ga_update'=>$request->update[$i],
            'ga_delete'=>$request->delete[$i]
                ]);
    }
    if($request->status[$i]==1){

        $mem_access=d_mem_access::where('ma_group',$id)->where('ma_type',DB::raw("'G'"))
                ->where('ma_access',$request->id_access[$i]);
        if(count($mem_access->first())!=0){
            $mem_access->update([
                             'ma_type'  =>'G',
                             'ma_read'=>$request->view[$i],
                             'ma_insert'=>$request->insert[$i],
                             'ma_update'=>$request->update[$i],
                             'ma_delete'=>$request->delete[$i],
            ]);
          }
        else{
          
            $mem_access=d_mem_access::where('ma_group',$id)->where('ma_type',DB::raw("'G'"))->groupBy('ma_mem')->           get();        

                    for ($ab=0; $ab < count($mem_access) ; $ab++) { 
 
                              d_mem_access::create([
                                  'ma_mem' =>$mem_access[0]->ma_mem,
                                  'ma_access' =>$request->id_access[$i],                                
                                  'ma_type'  =>'G',
                                  'ma_group' =>$id,
                                  'ma_read'=>$request->view[$ab],
                                  'ma_insert'=>$request->insert[$ab],
                                  'ma_update'=>$request->update[$ab],
                                  'ma_delete'=>$request->delete[$ab],
                              ]);    
                    }


        }
        
      }

        }


      $data=['status'=>'sukses'];
      return json_encode($data);
    });

    }

    public function hapusHakAkses($id){
        $mem_Acces=d_mem_access::where('ma_group',$id)->where('ma_type',DB::raw("'G'"))->delete();        
        $groupAccess=d_group_access::where('ga_group',$id)->delete();        
        $group=d_group::where('g_id',$id)->delete();        

        $data=['status'=>'sukses'];
        return json_encode($data);
    }  
}
