<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pakai_barang extends Model
{
    protected $table = 'd_pakai_barang';
    protected $primaryKey = 'd_pb_id';
    const CREATED_AT = 'd_pb_created';
    const UPDATED_AT = 'd_pb_updated';
    
    protected $fillable = [
        'd_pb_id', 
        'd_pb_code', 
        'd_pb_date',
        'd_pb_peminta',
        'd_pb_keperluan',
        'd_pb_staff',
        'd_pb_gdg',
        'd_pb_created',
        'd_pb_updated'
    ];
}
