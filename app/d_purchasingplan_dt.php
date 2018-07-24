<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchasingplan_dt extends Model
{
    protected $table = 'd_purchasingplan_dt';
    protected $primaryKey = 'd_pcspdt_id';
    const CREATED_AT = 'd_pcspdt_created';
    const UPDATED_AT = 'd_pcspdt_updated';

    protected $fillable = [
        'd_pcspdt_id',
        'd_pcspdt_idplan',
        'd_pcspdt_item',
        'd_pcspdt_qty',
        'd_pcspdt_qtyconfirm',
        'd_pcspdt_updated'
    ];
}
