<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DivisiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_divisi')->insert([
            'c_id' => '1',
            'c_divisi' => 'HRD dan General Affair',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_divisi')->insert([
            'c_id' => '2',
            'c_divisi' => 'Keuangan dan Akuntansi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_divisi')->insert([
            'c_id' => '3',
            'c_divisi' => 'Sales dan Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_divisi')->insert([
            'c_id' => '4',
            'c_divisi' => 'Produksi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_divisi')->insert([
            'c_id' => '5',
            'c_divisi' => 'Gudang dan Pengiriman',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_divisi')->insert([
            'c_id' => '22',
            'c_divisi' => 'Kebab Sohib',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_divisi')->insert([
            'c_id' => '42',
            'c_divisi' => 'Operator',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
