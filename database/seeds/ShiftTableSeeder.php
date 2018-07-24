<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_shift')->insert([
            'c_name' => 'shift 1',
            'c_start' => '07:00',
            'c_end' => '16:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
