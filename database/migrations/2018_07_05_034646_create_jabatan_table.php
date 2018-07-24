<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_jabatan', function (Blueprint $table) {
            $table->increments('c_id');
            $table->unsignedInteger('c_divisi_id');
            $table->unsignedInteger('c_sub_divisi_id');
            $table->string('c_posisi');
            $table->timestamps();

            $table->foreign('c_divisi_id')->references('c_id')->on('m_divisi');
            $table->foreign('c_sub_divisi_id')->references('c_id')->on('m_sub_divisi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_jabatan');
    }
}
