<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GajiProduksiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_gaji_pro')->insert([
            'c_id' => '1',
            'nm_gaji' => 'Kebab besar',
            'C_gaji' => '520000',
            'C_lembur' => '780000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
