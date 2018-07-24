<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $table = 'd_supplier';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';
    protected $primaryKey = ['s_id', 's_company', 's_name', 's_address', 's_phone', 's_fax', 's_note', 's_limit'];
}
