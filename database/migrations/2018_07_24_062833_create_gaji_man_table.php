<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGajiManTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_gaji_man', function (Blueprint $table) {
            $table->increments('c_id');
            $table->string('nm_gaji');
            $table->string('c_sd');
            $table->string('c_smp');
            $table->string('c_sma');
            $table->string('c_d1');
            $table->string('c_d2');
            $table->string('c_d3');
            $table->string('c_s1');
            $table->integer('c_jabatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_gaji_man');
    }
}
