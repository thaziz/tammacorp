<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_terima_bharian_dt extends Model
{
    protected $table = 'd_terima_bharian_dt';
    protected $primaryKey = 'd_tbhdt_id';
    const CREATED_AT = 'd_tbhdt_created';
    const UPDATED_AT = 'd_tbhdt_updated';
    
    protected $fillable = [
        'd_tbhdt_id',
        'd_tbhdt_idtbh', 
        'd_tbhdt_smdetail', 
        'd_tbhdt_item',
        'd_tbhdt_sat',
        'd_tbhdt_idpcshdt',
        'd_tbhdt_qty',
        'd_tbhdt_price',
        'd_tbhdt_pricetotal',
        'd_tbhdt_date_received',
        'd_tbhdt_created',
        'd_tbhdt_updated'
    ];
}
