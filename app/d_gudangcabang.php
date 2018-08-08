<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_gudangcabang extends Model
{
    protected $table = 'd_gudangcabang';
    protected $primaryKey = 'cg_id';
    protected $fillable = [ 'cg_id', 
                            'cg_cabang', 
                            'cg_gudang', 
                            'cg_insert', 
                            'cg_update'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'cg_insert';
    const UPDATED_AT = 'cg_update';
}
