<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table = 'd_transaksi_keuangan';
    protected $primaryKey = 'id_transaksi';

    public function jurnal(){
    	return $this->belongsTo('App\Model\Keuangan\d_jurnal', 'no_bukti', 'jurnal_ref');
    }
}
