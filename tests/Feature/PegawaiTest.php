<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PegawaiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexPegawai(){
        $response = $this->call('GET', '/master/datapegawai/pegawai');
        $this->assertEquals(302, $response->status());
    }
    public function testTambahPegawaiMan(){
        $response = $this->call('POST', '/master/datapegawai/simpan-pegawai', [
            'c_id_by_production' => '1',
            'c_code' => 'PG-001',
            'c_nik' => '8101982098',
            'C_nama' => 'test',
            'C_hari_kerja' => 'Senin - Sabtu',
            'C_ktp' => '10981098',
            'C_ktp_alamat' => 'Kediri',
            'C_alamat' => 'nganjuk',
            'C_lahir' => 'Nganjuk, 1997-01-01',
            'C_email' => 'test@mail.com',
            'C_hp' => '08109192898',
            'C_agama' => 'Islam',
            'C_nikah' => 'Belum menikah',
            'C_pasangan' => '-',
            'C_anak' => '-',
            'C_bank' => '-',
            'C_rekening' => '-',
            'C_sertification' => '-',
            'C_sertif_tahun' => '-',
            'C_sertif_tempat' => '-',
            'c_tahun_masuk' => '2018-01-01',
            'c_divisi_id' => '1',
            'c_jabatan_id' => '1',
            'c_shift_id' => '3'
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testUpdatePegawaiMan(){
        $response = $this->call('PUT', '/master/datapegawai/update-pegawai/1', [
            'c_id' => '1',
            'c_id_by_production' => '1',
            'c_code' => 'PG-001',
            'c_nik' => '8101982098',
            'C_nama' => 'test',
            'C_hari_kerja' => 'Senin - Sabtu',
            'C_ktp' => '10981098',
            'C_ktp_alamat' => 'Kediri',
            'C_alamat' => 'nganjuk',
            'C_lahir' => 'Nganjuk, 1997-01-01',
            'C_email' => 'test@mail.com',
            'C_hp' => '08109192898',
            'C_agama' => 'Islam',
            'C_nikah' => 'Belum menikah',
            'C_pasangan' => '-',
            'C_anak' => '-',
            'C_bank' => '-',
            'C_rekening' => '-',
            'C_sertification' => '-',
            'C_sertif_tahun' => '-',
            'C_sertif_tempat' => '-',
            'c_tahun_masuk' => '2018-01-01',
            'c_divisi_id' => '1',
            'c_jabatan_id' => '1',
            'c_shift_id' => '3'
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testDeletePegawaiMan(){
        $response = $this->call('DELETE', '/master/datapegawai/delete-pegawai/1');
        $this->assertEquals(302, $response->status());
    }
    public function testTambahGajiPro(){
        $response = $this->call('POST', '/master/datapegawai/simpan-pegawai-pro', [
            'c_id' => '1',
            'c_id_by_production' => '1',
            'c_code' => 'PG-001',
            'c_nik' => '8101982098',
            'C_nama' => 'test',
            'c_tahun_masuk' => '2018-01-01',
            'c_rumah_produksi' => '1',
            'c_jabatan_id' => '1',
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testUpdateGajiPro(){
        $response = $this->call('PUT', '/master/datapegawai/update-pegawai-pro/1', [
            'c_id' => '1',
            'c_id_by_production' => '1',
            'c_code' => 'PG-001',
            'c_nik' => '8101982098',
            'C_nama' => 'test',
            'c_tahun_masuk' => '2018-01-01',
            'c_rumah_produksi' => '1',
            'c_jabatan_id' => '1',
            ]);
        $this->assertEquals(302, $response->status());
    }
    public function testDeleteGajiPro(){
        $response = $this->call('DELETE', '/master/datapegawai/delete-pegawai-pro/1');
        $this->assertEquals(302, $response->status());
    }
}
