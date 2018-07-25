<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDPhkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('d_phk', function(Blueprint $table)
		{
			$table->increments('c_id');
			$table->string('c_kode');
			$table->string('c_nama');
			$table->string('c_tgl_phk');
			$table->string('c_bulan_terakhir');
			$table->integer('c_jenis');
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
		Schema::drop('d_phk');
	}

}
