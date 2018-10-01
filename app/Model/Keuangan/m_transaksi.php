<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class m_transaksi extends Model
{
    protected $table = 'm_transaksi';
    protected $primaryKey = 'id_transaksi';

    public function detail(){
    	return $this->hasMany('App\Model\Keuangan\m_transaksi_detail', 'td_transaksi', 'id_transaksi');
    }
}
