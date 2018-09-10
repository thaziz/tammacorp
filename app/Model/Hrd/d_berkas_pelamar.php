<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_berkas_pelamar extends Model
{
    protected $table = 'd_berkas_pelamar';
    protected $primaryKey = 'bks_id';
    const CREATED_AT = 'bks_created';
    const UPDATED_AT = 'bks_updated';
    
    protected $fillable = [
        'bks_id', 
        'bks_pid',
        'bks_name',
        'bks_created',
        'bks_updated'
    ];
}
