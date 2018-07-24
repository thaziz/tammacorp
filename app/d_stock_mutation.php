<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_stock_mutation extends Model
{

	protected $table = 'd_stock_mutation';
    protected $primaryKey = ['sm_stock','sm_detailid'];
    protected $fillable = [	'sm_stock' ,
							'sm_detailid' ,
							'sm_date' ,
							'sm_comp' ,
							'sm_mutcat' ,
							'sm_item' ,
							'sm_qty' ,
							'sm_qty_used' ,
							'sm_qty_expired' ,
							'sm_detail' ,
							'sm_hpp' ,
							'sm_hpptax' ,
							'sm_hppdisc' ,
							'sm_hppnett' ,
							'sm_sell' ,
							'sm_selltax' ,
							'sm_selldisc' ,
							'sm_sellnett' ,
							'sm_reff' ,
							'sm_insert' ,
							'sm_update' ];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'sm_insert';
    const UPDATED_AT = 'sm_update';
    
    
}
