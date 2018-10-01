<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_gaji_pro extends Model
{
  protected $table = 'm_gaji_pro';
  protected $primaryKey = 'c_id';
  protected $fillable = [ 'c_id',
                          'nm_gaji',
                          'i_type',
                          'c_gaji',
                          'c_lembur'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';
}
