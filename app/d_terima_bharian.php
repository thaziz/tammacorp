<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_terima_bharian extends Model
{
    protected $table = 'd_terima_bharian';
    protected $primaryKey = 'd_tbh_id';
    const CREATED_AT = 'd_tbh_created';
    const UPDATED_AT = 'd_tbh_updated';
    
    protected $fillable = [
        'd_tbh_id', 
        'd_tbh_phid', 
        'd_tbh_sup',
        'd_tbh_code',
        'd_tbh_staff',
        'd_tbh_noreff',
        'd_tbh_totalnett',
        'd_tbh_totalpaid',
        'd_tbh_date',
        'd_tbh_datepaid',
        'd_tbh_created',
        'd_tbh_updated'
    ];
}
