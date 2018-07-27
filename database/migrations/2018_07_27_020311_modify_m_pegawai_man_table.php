<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMPegawaiManTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_pegawai_man', function (Blueprint $table) {
            $table->string('c_ktp_alamat')->nullable()->change();            
            $table->string('c_alamat')->nullable()->change();            
            $table->string('c_lahir')->nullable()->change();            
            $table->string('c_pendidikan')->nullable()->change();            
            $table->string('c_email')->nullable()->change();            
            $table->string('c_hp')->nullable()->change();            
            $table->string('c_agama')->nullable()->change();            
            $table->string('c_nikah')->nullable()->change();            
            $table->string('c_pasangan')->nullable()->change();            
            $table->integer('c_anak')->nullable()->change();            
            $table->string('c_bank')->nullable()->change();            
            $table->string('c_rekening')->nullable()->change();      
            $table->string('c_sertification')->nullable()->change();            
            $table->string('c_sertif_tahun')->nullable()->change();            
            $table->string('c_sertif_tempat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
