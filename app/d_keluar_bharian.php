<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_keluar_bharian extends Model
{
    protected $table = 'd_keluar_bharian';
    protected $primaryKey = 'd_kbh_id';
    const CREATED_AT = 'd_kbh_created';
    const UPDATED_AT = 'd_kbh_updated';
    
    protected $fillable = [
        'd_kbh_id',
        'd_kbh_code', 
        'd_kbh_date', 
        'd_kbh_staff',
        'd_kbh_totalprice',
        'd_kbh_created',
        'd_kbh_updated'
    ];
}
