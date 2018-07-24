<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_payment extends Model
{
    protected $table = 'd_sales_payment';
    protected $primaryKey = 'sp_sales';
    
      protected $fillable = ['sp_sales',
      						 'sp_paymentid',
      						 'sp_method', 
      						 'sp_nominal'];
		public $timestamps = false;
}
