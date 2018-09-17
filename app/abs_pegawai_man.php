<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class abs_pegawai_man extends Model
{
  protected $table = 'abs_pegawai_man';
  protected $primaryKey = 'apm_id';
  protected $fillable = [ 'apm_id',
                          'apm_pm',
                          'apm_date',
                          'apm_ket'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'apm_insert';
  const UPDATED_AT = 'apm_update';
}
