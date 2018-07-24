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
            'c_id' => '21',
            'c_divisi_id' => '111',
            'c_sub_divisi_id' => '1',
            'c_posisi' => 'General Manager',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '1',
            'c_divisi_id' => '1',
            'c_sub_divisi_id' => '1',
            'c_posisi' => 'HRD dan GA',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '2',
            'c_divisi_id' => '1',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Personalia dan Perfomance Managerial',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '3',
            'c_divisi_id' => '1',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf HRD Rekrutmen dan Pelatihan',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '4',
            'c_divisi_id' => '1',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf General Affair',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '5',
            'c_divisi_id' => '1',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Office Boy',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '6',
            'c_divisi_id' => '2',
            'c_sub_divisi_id' => '1',
            'c_posisi' => 'Keuangan dan Akuntansi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '7',
            'c_divisi_id' => '2',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Akuntansi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '8',
            'c_divisi_id' => '2',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Purchasing dan Pajak',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '9',
            'c_divisi_id' => '3',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Sales dan Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '10',
            'c_divisi_id' => '3',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Sales dan Customer Service',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '11',
            'c_divisi_id' => '3',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Sales dan Pengembangan Jaringan',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '12',
            'c_divisi_id' => '3',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Digital Marketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '13',
            'c_divisi_id' => '3',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Kebab Sohib',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '14',
            'c_divisi_id' => '4',
            'c_sub_divisi_id' => '1',
            'c_posisi' => 'Supervisor Produksi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '15',
            'c_divisi_id' => '4',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Admin Produksi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '16',
            'c_divisi_id' => '4',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Operasional Produksi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '17',
            'c_divisi_id' => '5',
            'c_sub_divisi_id' => '1',
            'c_posisi' => 'Admin Gudang',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '18',
            'c_divisi_id' => '5',
            'c_sub_divisi_id' => '2',
            'c_posisi' => 'Staf Gudang dan Pengiriman',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '19',
            'c_divisi_id' => '22',
            'c_sub_divisi_id' => '3',
            'c_posisi' => 'Staf Operator Kebab Sohib',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan')->insert([
            'c_id' => '20',
            'c_divisi_id' => '42',
            'c_sub_divisi_id' => '3',
            'c_posisi' => 'Staf Produksi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
