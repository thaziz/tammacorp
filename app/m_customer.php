<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_customer extends Model
{
	protected $table = 'm_customer';
    protected $primaryKey = 'c_id';
    protected $fillable = [	'c_id', 
    						'c_code', 
    						'c_name', 
    						'c_birthday',
                            'c_email', 
    						'c_hp', 
                            'c_address',
                            'c_class',
                            'c_type'];
                            
    //public $timestamps = false;
    const CREATED_AT = 'c_insert';
    const UPDATED_AT = 'c_update';
}
