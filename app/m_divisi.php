<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_divisi extends Model
{
  protected $table = 'm_divisi';
  protected $primaryKey = 'c_id';
  protected $fillable = [ 'c_id',
                          'c_divisi',
                          'c_divisi_akronim',
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'created_at';
  const updated_at = 'updated_at';
}
