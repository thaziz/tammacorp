<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_pegawai', function (Blueprint $table) {
            $table->increments('c_id');
            $table->integer('c_id_by_production');
            $table->string('c_code');             
            $table->string('c_nik');             
            $table->string('c_nama');            
            $table->string('c_hari_kerja');            
            $table->string('c_ktp');            
            $table->string('c_ktp_alamat');            
            $table->string('c_alamat');            
            $table->string('c_lahir');            
            $table->string('c_pendidikan');            
            $table->string('c_email');            
            $table->string('c_hp');            
            $table->string('c_agama');            
            $table->string('c_nikah');            
            $table->string('c_pasangan');            
            $table->integer('c_anak');            
            $table->string('c_bank');            
            $table->string('c_rekening');      
            $table->string('c_sertification');            
            $table->string('c_sertif_tahun');            
            $table->string('c_sertif_tempat');            
            $table->date('c_tahun_masuk');              
            $table->unsignedInteger('c_divisi_id');                    
            $table->unsignedInteger('c_jabatan_id');                    
            $table->unsignedInteger('c_shift_id');                    
            $table->integer('c_production');
            $table->timestamps();

            $table->foreign('c_divisi_id')->references('c_id')->on('m_divisi');
            $table->foreign('c_shift_id')->references('c_id')->on('m_shift');
            $table->foreign('c_jabatan_id')->references('c_id')->on('m_jabatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_pegawai');
    }
}
