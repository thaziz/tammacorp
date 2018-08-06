<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_produksi extends Model
{
    protected $table = 'm_produksi';
    protected $primaryKey = 'mp_id';
    protected $fillable = [ 'm_pid', 
                            'mp_name'];
                            
    const CREATED_AT = 'mp_created';
    const UPDATED_AT = 'mp_updated';
}
