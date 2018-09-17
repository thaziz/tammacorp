<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class m_transaksi_detail extends Model
{
    protected $table = 'm_transaksi_detail';
    protected $primaryKey = ['td_transaksi', 'td_no'];
    public $incrementing = false;

    public $timestamps = false;
}
