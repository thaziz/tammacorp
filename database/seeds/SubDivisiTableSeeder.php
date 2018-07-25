<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class SubDivisiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_sub_divisi')->insert([
            'c_id' => '1',
            'c_subdivisi' => 'Leader',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_sub_divisi')->insert([
            'c_id' => '2',
            'c_subdivisi' => 'Staf',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('m_sub_divisi')->insert([
            'c_id' => '3',
            'c_subdivisi' => 'Operasional',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
