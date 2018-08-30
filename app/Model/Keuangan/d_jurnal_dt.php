<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class d_jurnal_dt extends Model
{
     protected $table = 'd_jurnal_dt';
     protected $primaryKey = ['jrdt_jurnal', 'jrdt_no'];
     public $incrementing = false;

     public $timestamps = false;

     public function jurnal(){
     	return $this->belongsTo('App\Model\Keuangan\d_jurnal', 'jrdt_jurnal', 'jurnal_id');
     }
}
