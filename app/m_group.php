<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_group extends Model
{
    protected $table = 'm_group';
    protected $primaryKey = 'm_gid';
    protected $fillable = [ 'm_gid', 
                            'm_gcode', 
                            'm_gname'];

    //public $timestamps = false;
    const CREATED_AT = 'm_gcreate';
    const UPDATED_AT = 'm_gupdate';
}
