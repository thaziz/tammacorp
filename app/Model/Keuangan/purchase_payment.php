<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class purchase_payment extends Model
{
    protected $table = 'd_purchase_payment';
    protected $primaryKey = 'payment_id';

    public $timestamps = false;
}
