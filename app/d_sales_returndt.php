<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_returndt extends Model
{
    protected $table = 'd_sales_returndt';
    protected $primaryKey = 'dsrdt_id';
    const CREATED_AT = 'dsrdt_created';
    const UPDATED_AT = 'dsrdt_updated';
    
	protected $fillable = [	'dsrdt_id',
							'dsrdt_idsr',
							'dsrdt_smdt', 
							'dsrdt_item',
							'dsrdt_qty',
							'dsrdt_qty_confirm',
							'dsrdt_price',
							'dsrdt_price_tot',
							'dsrdt_is_confirm'];
		public $timestamps = false;
}
