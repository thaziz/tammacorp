<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchasingplan extends Model
{
    protected $table = 'd_purchasingplan';
    protected $primaryKey = 'd_pcsp_id';
    const CREATED_AT = 'd_pcsp_created';
    const UPDATED_AT = 'd_pcsp_updated';
    
    protected $fillable = [
        'd_pcsp_id', 
        'd_pcsp_code', 
        'd_pcsp_sup',
        'd_pcsp_staff',
        'd_pcsp_datecreated',
        'd_pcsp_dateconfirm',
        'd_pcsp_status',
        'd_pcsp_updated',
    ];
}
