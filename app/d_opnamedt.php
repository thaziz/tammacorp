<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_opnamedt extends Model
{
  protected $table = 'd_opnamedt';
  protected $primaryKey = 'od_ido';
  protected $fillable = [ 'od_ido',
                          'od_idodt',
                          'od_item',
                          'od_qty_real',
                          'od_ket'];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
}
