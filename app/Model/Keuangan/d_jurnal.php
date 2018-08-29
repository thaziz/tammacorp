<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class d_jurnal extends Model
{
    protected $table = 'd_jurnal';
    protected $primaryKey = 'jurnal_id';

    public $timestamps = false;

    public function detail(){
    	return $this->hasMany('App\Model\keuangan\d_jurnal_dt', 'jrdt_jurnal', 'jurnal_id');
    }
}
