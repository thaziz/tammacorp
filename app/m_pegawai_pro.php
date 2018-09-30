<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_pegawai_pro extends Model
{
  protected $table = 'm_pegawai_pro';
  protected $primaryKey = 'd_hg_id';
  protected $fillable = [ 'd_hg_id',
                          'd_hg_pid',
                          'd_hg_tgl',
                          'd_hg_jumbo_r',
                          'd_hg_jumbo_l',
                          'd_hg_tb_r',
                          'd_hg_tb_l',
                          'd_hg_ts_r',
                          'd_hg_ts_l',
                          'd_hg_tm_r',
                          'd_hg_tm_l',
                          'd_hg_tc_r',
                          'd_hg_tc_l'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'd_hg_created';
  const UPDATED_AT = 'd_hg_updated';
}
`d_hg_id` INT(11) NOT NULL AUTO_INCREMENT,
`d_hg_pid` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'id pegawai produksi',
`d_hg_tgl` DATE NULL DEFAULT NULL,
`d_hg_jumbo_r` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_jumbo_l` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_tb_r` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_tb_l` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_ts_r` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_ts_l` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_tm_r` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_tm_l` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_tc_r` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_tc_l` DECIMAL(10,2) NULL DEFAULT '0.00',
`d_hg_created` DATETIME NOT NULL,
`d_hg_updated` DATETIME NULL DEFAULT NULL,
