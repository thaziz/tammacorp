<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class transaksi_detail extends Model
{
    protected $table = 'd_transaksi_keuangan_detail';
    protected $primaryKey = ['tkd_transaksi', 'tkd_no'];
    public $incrementing = false;

    public $timestamps = false;
}
