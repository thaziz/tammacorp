<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchasingharian extends Model
{
    protected $table = 'd_purchasingharian';
    protected $primaryKey = 'd_pcsh_id';
    const CREATED_AT = 'd_pcsh_created';
    const UPDATED_AT = 'd_pcsh_updated';
    
    protected $fillable = [
        'd_pcsh_id', 
        'd_pcsh_code', 
        'd_pcsh_date',
        'd_pcsh_noreff',
        'd_pcsh_totalprice',
        'd_pcsh_totalpaid',
        'd_pcsh_staff',
        'd_pcsh_status',
        'd_pcsh_supid',
        'd_pcsh_created',
        'd_pcsh_updated'
    ];
}
