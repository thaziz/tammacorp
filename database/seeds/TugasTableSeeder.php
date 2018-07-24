<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class TugasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '1',
            'c_id' => '0101',
            'c_posisi' => 'HRD dan GA',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '1',
            'c_id' => '0102',
            'c_posisi' => 'Staf HRD dan GA',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '2',
            'c_id' => '0201',
            'c_posisi' => 'Keuangan dan Akuntansi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '2',
            'c_id' => '0202',
            'c_posisi' => 'Staf Keuangan dan Akuntansi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '3',
            'c_id' => '0301',
            'c_posisi' => 'Sales dan Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '3',
            'c_id' => '0302',
            'c_posisi' => 'Staf Sales dan Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '4',
            'c_id' => '0404',
            'c_posisi' => 'Mandor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '4',
            'c_id' => '0405',
            'c_posisi' => 'Ast. Mandor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '4',
            'c_id' => '0406',
            'c_posisi' => 'Mixing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '4',
            'c_id' => '0407',
            'c_posisi' => 'Penggiles',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '5',
            'c_id' => '0501',
            'c_posisi' => 'Supervisor Gudang dan Pengiriman',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '5',
            'c_id' => '0502',
            'c_posisi' => 'Staf Gudang dan Pengiriman',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '22',
            'c_id' => '02203',
            'c_posisi' => 'Staf Operator Kebab Sohib',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_divisi_id' => '42',
            'c_id' => '04203',
            'c_posisi' => 'Staf Produksi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
