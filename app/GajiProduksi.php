<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GajiProduksi extends Model
{
    protected $table = 'm_gaji_pro' ;
    
    protected $fillable = [
        'nm_gaji','c_gaji','c_lembur'
    ];
}
