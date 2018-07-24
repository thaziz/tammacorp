<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class JabatanProTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jabatan_pro')->insert([
            'c_id' => '4',
            'c_jabatan_pro' => 'Mandor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan_pro')->insert([
            'c_id' => '5',
            'c_jabatan_pro' => 'Ast. Mandor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan_pro')->insert([
            'c_id' => '7',
            'c_jabatan_pro' => 'Penggilles',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_jabatan_pro')->insert([
            'c_id' => '6',
            'c_jabatan_pro' => 'Mixing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
