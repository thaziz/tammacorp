<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_item extends Model
{
    protected $table = 'm_item';
    protected $primaryKey = 'i_id';
    protected $fillable = [ 'i_id', 
                            'i_code', 
                            'i_type', 
                            'i_code_group', 
                            'i_name', 
                            'i_sat1',
                            'i_sat2',
                            'i_sat3',
                            'i_sat_isi1',
                            'i_sat_isi2',
                            'i_sat_isi3',
                            'i_isactive',
                            'i_price'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'i_insert';
    const UPDATED_AT = 'i_update';
    
}
    