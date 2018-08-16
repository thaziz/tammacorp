<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RecruitmentController extends Controller
{
    public function recruitment()
    {
        return view('hrd/recruitment/index');
    }

    public function save(Request $request)
    {
        //dd($request);
        DB::beginTransaction();
        try {
            $id = DB::table('d_pelamar')
                ->max('p_id');
            ++$id;

            $birth = $request->tahun . '-' . $request->bulan . '-' . $request->tanggal;
            $status = null;

            if ($request->status == 'menikah'){
                $status = 'M';
            } else {
                $status = 'N';
            }

            DB::table('d_pelamar')
                ->insert([
                    'p_id' => $id,
                    'p_date' => Carbon::now('Asia/Jakarta'),
                    'p_name' => $request->nama,
                    'p_nip' => $request->noktp,
                    'p_address' => $request->alamat,
                    'p_address_now' => $request->alamatnow,
                    'p_birth_place' => $request->tempatlahir,
                    'p_birthday' => $birth,
                    'p_education' => $request->pendidikanterakhir,
                    'p_tlp' => $request->notlp,
                    'p_religion' => $request->agama,
                    'p_status' => $status,
                    'p_child' => $request->anak,
                    'p_wife_name' => $request->suami,
                    'p_insert' => Carbon::now('Asia/Jakarta')
                ]);


            DB::commit();
            return redirect('/recruitment#apply')->with(['sukses' => 'Data berhasil disimpan']);

        } catch (\Exception $e){
            return redirect('/recruitment#apply')->with(['gagal' => 'Data berhasil disimpan, Ulangi sekali lagi']);
        }
    }
}
