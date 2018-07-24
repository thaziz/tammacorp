<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiProTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_pegawai_pro', function (Blueprint $table) {
            $table->increments('c_id');
            $table->integer('c_id_by_production');             
            $table->string('c_code');             
            $table->string('c_nik');             
            $table->string('c_nama');                    
            $table->string('c_tahun_masuk');                    
            $table->integer('c_rumah_produksi');
            $table->unsignedInteger('c_jabatan_pro_id');
            $table->timestamps();

            $table->foreign('c_jabatan_pro_id')->references('c_id')->on('m_jabatan_pro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_pegawai_pro');
    }
}
