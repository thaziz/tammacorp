<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_lowongan extends Model
{
    protected $table = 'd_lowongan';
    protected $primaryKey = 'l_id';
    const CREATED_AT = 'l_created';
    const UPDATED_AT = 'l_updated';
    
    protected $fillable = [
        'l_id', 
        'l_code',
        'l_name',
        'l_isactive',
        'l_created',
        'l_updated'
    ];
}
