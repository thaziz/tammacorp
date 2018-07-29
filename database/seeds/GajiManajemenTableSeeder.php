<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GajiManajemenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_gaji_man')->insert([
            'c_id' => '1',
            'nm_gaji' => 'Gaji Pokok',
            'C_sd' => '520000',
            'C_smp' => '780000',
            'C_sma' => '1040000',
            'C_d1' => '1170000',
            'C_d2' => '1300000',
            'C_d3' => '1430000',
            'C_s1' => '1560000',
            'C_jabatan' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
