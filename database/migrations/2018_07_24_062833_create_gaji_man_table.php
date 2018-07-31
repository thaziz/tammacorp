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
            $table->string('c_jenjang');
            $table->string('c_leader');
            $table->string('c_staf');
            $table->string('is_harian');
            $table->string('status');
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
