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
            'c_jenjang' => 'SD',
            'c_staf' => '520000',
            'c_leader' => '520000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '2',
            'nm_gaji' => 'Gaji Pokok',
            'c_jenjang' => 'SMP',
            'c_staf' => '780000',
            'c_leader' => '780000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '3',
            'nm_gaji' => 'Gaji Pokok',
            'c_jenjang' => 'SMA',
            'c_staf' => '1040000',
            'c_leader' => '1040000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '4',
            'nm_gaji' => 'Gaji Pokok',
            'c_jenjang' => 'D1',
            'c_staf' => '1170000',
            'c_leader' => '1170000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '5',
            'nm_gaji' => 'Gaji Pokok',
            'c_jenjang' => 'D2',
            'c_staf' => '1300000',
            'c_leader' => '1300000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '6',
            'nm_gaji' => 'Gaji Pokok',
            'c_jenjang' => 'D3',
            'c_staf' => '1430000',
            'c_leader' => '1430000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '7',
            'nm_gaji' => 'Gaji Pokok',
            'c_jenjang' => 'S1',
            'c_staf' => '1560000',
            'c_leader' => '1430000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '8',
            'nm_gaji' => 'Tunjangan Kehadiran',
            'c_jenjang' => 'SD',
            'c_staf' => '30000',
            'c_leader' => '50000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '9',
            'nm_gaji' => 'Tunjangan Kehadiran',
            'c_jenjang' => 'SMP',
            'c_staf' => '30000',
            'c_leader' => '50000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '10',
            'nm_gaji' => 'Tunjangan Kehadiran',
            'c_jenjang' => 'SMA',
            'c_staf' => '30000',
            'c_leader' => '50000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '11',
            'nm_gaji' => 'Tunjangan Kehadiran',
            'c_jenjang' => 'D1',
            'c_staf' => '30000',
            'c_leader' => '50000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '12',
            'nm_gaji' => 'Tunjangan Kehadiran',
            'c_jenjang' => 'D2',
            'c_staf' => '30000',
            'c_leader' => '50000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '13',
            'nm_gaji' => 'Tunjangan Kehadiran',
            'c_jenjang' => 'D3',
            'c_staf' => '30000',
            'c_leader' => '50000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_gaji_man')->insert([
            'c_id' => '14',
            'nm_gaji' => 'Tunjangan Kehadiran',
            'c_jenjang' => 'S1',
            'c_staf' => '30000',
            'c_leader' => '50000',
            'is_harian' => 'n',
            'status' => 'y',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
