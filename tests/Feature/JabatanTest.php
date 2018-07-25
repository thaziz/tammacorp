<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JabatanTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexJabatan(){
        $response = $this->call('GET', '/hrd/datajabatan');
        $this->assertEquals(302, $response->status());
    }
    public function testTambahJabatan(){
        $response = $this->call('POST', '/hrd/datajabatan/simpan-jabatan', 
            ['c_divisi_id' => '1', 
             'c_sub_divisi_id' => '2',
             'c_posisi' => ' General Affair'
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testUpdateJabatan(){
        $response = $this->call('PUT', '/hrd/datajabatan/update-jabatan/1', 
            ['c_divisi_id' => '1', 
             'c_sub_divisi_id' => '2',
             'c_posisi' => ' General Affair test'
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testDeleteJabatan(){
        $response = $this->call('DELETE', '/hrd/datajabatan/delete-jabatan/20');
        $this->assertEquals(302, $response->status());
    }
}
