<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payroll_man';
    protected $fillable = [	
        'c_code', 'c_tangggal', 'c_status'
    ];
}
