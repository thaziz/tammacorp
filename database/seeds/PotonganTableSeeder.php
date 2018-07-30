<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class PotonganTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_potongan')->insert([
            'c_id' => '1',
            'c_nama' => 'Kasbon',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_potongan')->insert([
            'c_id' => '2',
            'c_nama' => 'Terlambat',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_potongan')->insert([
            'c_id' => '3',
            'c_nama' => 'Izin dengan keterangan < 3 hari',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_potongan')->insert([
            'c_id' => '4',
            'c_nama' => 'Izin dengan keterngan > 3 hari',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_potongan')->insert([
            'c_id' => '5',
            'c_nama' => 'Alpha tanpa keterangan',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_potongan')->insert([
            'c_id' => '6',
            'c_nama' => 'Uang makan yang sudah diambil',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
