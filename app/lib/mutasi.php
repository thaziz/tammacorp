<?php
namespace App\Lib;

use App\d_stock_mutation;

use App\d_stock;

use DB;

class mutasi{
	public static function mutasiStok($item,$totalPermintaan,$comp,$position,$flag,$sm_reff){	
        return DB::transaction(function () use ($item,$totalPermintaan,$comp,$position,$flag,$sm_reff) {   
			$updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);			
			if($updateStock->first()->s_qty>=$totalPermintaan){
				$qty=$updateStock->first()->s_qty-$totalPermintaan;				
				$updateStock->update([
						's_qty'=>$qty
					]);				
			}else{				
				DB::rollback();
				return false;
			}


		 	$getBarang=d_stock_mutation::where('sm_qty_sisa','>',0)->where('sm_item',$item)->where('sm_comp',$comp)
		 			   ->where('sm_position',$position)->get();		 	

            /*$totalPermintaan = 35;*/
            $newMutasi=[];
            $updateMutasi=[];

                       
                    for ($k = 0; $k < count($getBarang); $k++) {
                    	$sm_detailidInsert=d_stock_mutation::where('sm_item',$item)->where('sm_comp',$comp)
		 			   ->where('sm_position',$position)->max('sm_detailid')+$k+1;

                        $totalQty = $getBarang[$k]->sm_qty_sisa;                                  
                        if ($totalPermintaan <= $totalQty) {
                        	$qty_used=$getBarang[$k]->sm_qty_used+$totalPermintaan;
                        	$qty_sisa = $getBarang[$k]->sm_qty_sisa-$totalPermintaan;


                        	$sm_stock=$getBarang[$k]->sm_stock;
                            $sm_detailid = $getBarang[$k]->sm_detailid;


                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$sm_stock)
                                          ->where('sm_detailid',$sm_detailid);   


                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$qty_used,
                                'sm_qty_sisa'=>$qty_sisa
                            ]);






                        	$newMutasi[$k]['sm_stock']=$getBarang[$k]->sm_stock;
                            $newMutasi[$k]['sm_detailid'] = $sm_detailidInsert;
                            $newMutasi[$k]['sm_date'] = date('Y-m-d');
                            $newMutasi[$k]['sm_comp'] = $comp;
                            $newMutasi[$k]['sm_position'] = $position;
                            $newMutasi[$k]['sm_item'] = $item;
                            $newMutasi[$k]['sm_qty'] = -$totalPermintaan;
                            $newMutasi[$k]['sm_hpp'] = $getBarang[$k]->sm_hpp;
                            $newMutasi[$k]['sm_detail'] = 'Penjualan Toko';
                            $newMutasi[$k]['sm_reff'] = $sm_reff;               
                            $k = count($getBarang);
                        } elseif ($totalPermintaan > $totalQty) {
                        	$qty_used=$getBarang[$k]->sm_qty_used+$totalQty;
                        	$qty_sisa =$getBarang[$k]->sm_qty_sisa-$totalQty;                        	
                        	$sm_stock=$getBarang[$k]->sm_stock;
                            $sm_detailid = $getBarang[$k]->sm_detailid;
                            

                              $updateStokMutasi=d_stock_mutation::where('sm_stock',$sm_stock)
                                          ->where('sm_detailid',$sm_detailid);   


                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$qty_used,
                                'sm_qty_sisa'=>$qty_sisa
                            ]);

                        	$newMutasi[$k]['sm_stock']=$getBarang[$k]->sm_stock;
                            $newMutasi[$k]['sm_detailid'] = $sm_detailidInsert;
                            $newMutasi[$k]['sm_date'] = date('Y-m-d');
                            $newMutasi[$k]['sm_comp'] = $comp;
                            $newMutasi[$k]['sm_position'] = $position;
                            $newMutasi[$k]['sm_item'] = $item;
                            $newMutasi[$k]['sm_qty'] = -$totalQty;
                            $newMutasi[$k]['sm_hpp'] = $getBarang[$k]->sm_hpp;
                            $newMutasi[$k]['sm_detail'] = 'Penjualan Toko';
                            $newMutasi[$k]['sm_reff'] = $sm_reff; 
                            $totalPermintaan = $totalPermintaan - $totalQty;
                        }
                    }

                    DB::table('d_stock_mutation')->insert($newMutasi);

                 
                    return true;
                });
	}

    public static function updateMutasi($item,$totalPermintaan,$comp,$position,$flag='',$sm_reff=''){
        return DB::transaction(function () use ($item,$totalPermintaan,$comp,$position,$flag,$sm_reff) {   

        if ($totalPermintaan>0) {            
            
             $mutasiStok=new mutasi;
             return $mutasiStok->mutasiStok($item,$totalPermintaan,$comp,$position,$flag,$sm_reff);
        }else{               
            
            $getBarang=d_stock_mutation::where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->where('sm_reff',$sm_reff)
                       ->orderBy('sm_detailid','DESC')->get();
            //mencari harga sebelum di hapus
            $sm_hpp=[];
            $awaltotalPermintaan=abs($totalPermintaan);
            $totalPermintaan=abs($awaltotalPermintaan);
            for ($k = 0; $k < count($getBarang); $k++) {                
                $totalQty=abs($getBarang[$k]->sm_qty);                
                    if ($totalPermintaan <= $totalQty) {

                            $hapusMutasi[$k]['sm_stock']    =$getBarang[$k]->sm_stock;
                            $hapusMutasi[$k]['sm_detailid'] = $getBarang[$k]->sm_detailid;
                            $hapusMutasi[$k]['sm_qty'] =-(abs($getBarang[$k]->sm_qty)-$totalPermintaan);

                            $sm_hpp[$k]=$getBarang[$k]->sm_hpp;
                            $k = count($getBarang);
                        }
                        elseif ($totalPermintaan  > $totalQty) {
                            $hapusMutasi[$k]['sm_stock']    =$getBarang[$k]->sm_stock;
                            $hapusMutasi[$k]['sm_detailid'] = $getBarang[$k]->sm_detailid;
                            $hapusMutasi[$k]['sm_qty'] =abs($getBarang[$k]->sm_qty)-$totalQty;                            
                            $sm_hpp[$k]=$getBarang[$k]->sm_hpp;
                            $totalPermintaan = $totalPermintaan - $totalQty;
                        }
            }
         $getBarangx=d_stock_mutation::where('sm_qty_used','>',0)->where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->whereIn('sm_hpp',$sm_hpp)
                       ->orderBy('sm_detailid','DESC')->get();

        
$totalPermintaan=abs($awaltotalPermintaan);
                          for ($k = 0; $k < count($getBarangx); $k++) {
                            $totalQty=abs($getBarangx[$k]->sm_qty_used);  
                            if ($totalPermintaan <= $totalQty) {

                           
                            $qty_used=$getBarangx[$k]->sm_qty_used-$totalPermintaan;
                            $qty_sisa =$getBarangx[$k]->sm_qty_sisa- $totalPermintaan;

                                $updateMutasi[$k]['sm_stock']    =$getBarangx[$k]->sm_stock;
                                $updateMutasi[$k]['sm_detailid'] = $getBarangx[$k]->sm_detailid;
                                $updateMutasi[$k]['sm_qty_used'] =$getBarangx[$k]->sm_qty_used-$totalPermintaan;
                                $updateMutasi[$k]['sm_qty_sisa'] =$totalPermintaan+$getBarangx[$k]->sm_qty_sisa;                                
                                $updateMutasi[$k]['sm'] =$totalPermintaan; 
                                $updateMutasi[$k]['s'] ='x'; 

                            $k = count($getBarangx);
                            }
                            elseif ($totalPermintaan > $totalQty) {
                                $updateMutasi[$k]['sm_stock']    =$getBarangx[$k]->sm_stock;
                                $updateMutasi[$k]['sm_detailid'] = $getBarangx[$k]->sm_detailid;
                                $updateMutasi[$k]['sm_qty_used'] =0;
                                $updateMutasi[$k]['sm_qty_sisa'] =$getBarangx[$k]->sm_qty_sisa+$getBarangx[$k]->sm_qty_used;
                                $updateMutasi[$k]['sm'] =$totalPermintaan+$getBarangx[$k]->sm_qty_used; 
                                $updateMutasi[$k]['s'] ='c2'; 

                                $totalPermintaan = $totalPermintaan - $totalQty;


                            }
                          }



            for ($sm=0; $sm <count($hapusMutasi); $sm++) { 
                    if($hapusMutasi[$sm]['sm_qty']==0){
                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$hapusMutasi[$sm]['sm_stock'])
                                          ->where('sm_detailid',$hapusMutasi[$sm]['sm_detailid'])->delete(); 
                    }
                    else{                        
                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$hapusMutasi[$sm]['sm_stock'])
                                          ->where('sm_detailid',$hapusMutasi[$sm]['sm_detailid']); 
                        $updateStokMutasi->update([                                                             
                                'sm_qty'=>$hapusMutasi[$sm]['sm_qty'],                                
                            ]);
                    }
            }



            for ($sm=0; $sm <count($updateMutasi); $sm++) { 
                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$updateMutasi[$sm]['sm_stock'])
                                          ->where('sm_detailid',$updateMutasi[$sm]['sm_detailid']); 
                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$updateMutasi[$sm]['sm_qty_used'],
                                'sm_qty_sisa'=>$updateMutasi[$sm]['sm_qty_sisa']
                            ]);
            }

            $updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);          
            $qty=$updateStock->first()->s_qty+$awaltotalPermintaan; 

            $updateStock->update([
                    's_qty'=>$qty
                ]);

                       
            return true;
        }
    });

    }
    public static function u(){
        $m=new mutasi;

        return $m->v();
    }
     public function v(){
        return 'f';
    }

    public static function deleteMutasi($item,$totalPermintaan,$comp,$position,$flag='',$sm_reff=''){

          $getBarang=d_stock_mutation::where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->where('sm_reff',$sm_reff)
                       ->orderBy('sm_detailid','DESC')->get();
            
            


    }
}