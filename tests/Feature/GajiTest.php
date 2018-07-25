<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GajiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexGaji(){
        $response = $this->call('GET', '/hrd/payroll/setting-gaji');
        $this->assertEquals(302, $response->status());
    }
    public function testTambahGajiMan(){
        $response = $this->call('POST', '/hrd/payroll/simpan-gaji-man', [
            'c_id' => '2',
            'nm_gaji' => 'Gaji Pokok',
            'C_sd' => '520000',
            'C_smp' => '780000',
            'C_sma' => '1040000',
            'C_d1' => '1170000',
            'C_d2' => '1300000',
            'C_d3' => '1430000',
            'C_s1' => '1560000',
            'C_jabatan' => '3'
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testUpdateGajiMan(){
        $response = $this->call('PUT', '/hrd/payroll/update-gaji-man/1', [
            'c_id' => '2',
            'nm_gaji' => 'Gaji Pokok Test',
            'C_sd' => '520000',
            'C_smp' => '780000',
            'C_sma' => '1040000',
            'C_d1' => '1170000',
            'C_d2' => '1300000',
            'C_d3' => '1430000',
            'C_s1' => '1560000',
            'C_jabatan' => '3',
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testDeleteGajiMan(){
        $response = $this->call('DELETE', '/hrd/payroll/delete-gaji-man/1');
        $this->assertEquals(302, $response->status());
    }
    public function testTambahGajiPro(){
        $response = $this->call('POST', '/hrd/payroll/simpan-gaji-pro', [
            'c_id' => '1',
            'nm_gaji' => 'Kebab besar',
            'C_gaji' => '520000',
            'C_lembur' => '780000',
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testUpdateGajiPro(){
        $response = $this->call('PUT', '/hrd/payroll/update-gaji-pro/1', [
            'c_id' => '1',
            'nm_gaji' => 'Kebab besar',
            'C_gaji' => '520000',
            'C_lembur' => '780000',
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testDeleteGajiPro(){
        $response = $this->call('DELETE', '/hrd/payroll/delete-gaji-pro/1');
        $this->assertEquals(302, $response->status());
    }
}
