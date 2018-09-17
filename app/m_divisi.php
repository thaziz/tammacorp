<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_divisi extends Model
{
  protected $table = 'm_divisi';
  protected $primaryKey = 'd_id';
  protected $fillable = [ 'd_id',
                          'd_name'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'created_at';
  const updated_at = 'i_update';
}
