<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollDetailManTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_detail_man', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('c_payroll_id');
            $table->unsignedInteger('c_pegawai_man_id');
            $table->unsignedInteger('c_gaji_man_id');
            $table->string('c_jumlah');
            $table->string('c_keterangan');
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
        Schema::dropIfExists('payroll_detail_man');
    }
}
