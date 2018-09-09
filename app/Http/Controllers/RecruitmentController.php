<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//class untuk menangani storege file (unlink misal)
use Illuminate\Support\Facades\Storage;
//load package image resize
use Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use App\Model\Hrd\d_pelamar;
use App\Model\Hrd\d_berkas_pelamar;
use App\Model\Hrd\d_cv_pelamar;

class RecruitmentController extends Controller
{
    public function recruitment()
    {
        return view('hrd/recruitment/index');
    }

    public function save(Request $request)
    {
        //dd($request->all());
        /*DB::beginTransaction();
        try {*/

            $this->validate($request, [
                //set rules form name
                'nama' => 'required',
                'noktp' => 'required|min:16',
                'alamat' => 'required',
                'alamatnow' => 'required',
                'tempatlahir' => 'required',
                'tanggal' => 'required',
                'bulan' => 'required',
                'tahun' => 'required',
                'pendidikanterakhir' => 'required|min:2',
                // 'email' => 'required|d_pelamar|unique:email',
                'email' => 'required',
                'notlp' => 'required|min:7',
                'agama' => 'required',
                'status' => 'required',
                //'file' => "required|mimes:pdf,docx,doc|max:10000"
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],[

                'nama.required' => ' Nama tidak boleh kosong',
                'noktp.required' => ' KTP tidak boleh kosong',
                'noktp.min' => ' KTP minimal harus 16 karakter',
                'alamat.required' => ' Alamat tidak boleh kosong.',
                'alamatnow.required' => ' Alamat saat ini tidak boleh kosong',
                'tempatlahir.required' => ' Tempat Lahir tidak boleh kosong',
                'tanggal.required' => ' Wajib Memilih Tanggal Lahir',
                'bulan.required' => ' Wajib Memilih Bulan Lahir',
                'tahun.required' => ' Wajib Memilih Tahun Lahir',
                'pendidikanterakhir.required' => ' Pendidikan tidak boleh kosong',
                'pendidikanterakhir.min' => ' Pendidikan minimal harus 16 karakter',
                'email.required' => ' Email tidak boleh kosong',
                'notlp.required' => ' Nomor Telepon tidak boleh kosong',
                'notlp.min' => ' Nomor Telepon Minimal harus 7 karakter',
                'agama.required' => ' Agama tidak boleh kosong',
                'status.required' => ' Status Telepon tidak boleh kosong',
            ]);

            $id = d_pelamar::select('p_id')->max('p_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $birth = $request->tahun . '-' . $request->bulan . '-' . $request->tanggal;
            $status = null;

            if ($request->status == 'menikah') {
                $status = 'M';
            } else {
                $status = 'S';
            }

            //d_pelamar
            $data = new d_pelamar;
            $data->p_id = $id;
            $data->p_date = date('Y-m-d');
            $data->p_name = $request->nama;
            $data->p_nip = $request->noktp;
            $data->p_address = $request->alamat;
            $data->p_address_now = $request->alamatnow;
            $data->p_birth_place = $request->tempatlahir;
            $data->p_birthday = $birth;
            $data->p_education = $request->pendidikanterakhir;
            $data->p_email = $request->email;
            $data->p_tlp = $request->notlp;
            $data->p_religion = $request->agama;
            $data->p_status = $status;
            $data->p_child = $request->anak;
            $data->p_wife_name = $request->partner_name;
            $data->p_created = Carbon::now('Asia/Jakarta');
            $data->save();

            //d_cv_pelamar
            if ($request->perusahaan1 != null) 
            {
                $cv = new d_cv_pelamar;
                $cv->d_cv_pid = $id;
                $cv->d_cv_company = $request->perusahaan1;
                $cv->d_cv_thnmasuk = $request->dob_cv_awal1;
                $cv->d_cv_thnkeluar = $request->dob_cv_akhir1;
                $cv->d_cv_jobdesc = $request->jobdesc1;
                $cv->d_cv_created = Carbon::now('Asia/Jakarta');
                $cv->save();
            }

            if ($request->perusahaan2 != null) 
            {
                $cv = new d_cv_pelamar;
                $cv->d_cv_pid = $id;
                $cv->d_cv_company = $request->perusahaan2;
                $cv->d_cv_thnmasuk = $request->dob_cv_awal2;
                $cv->d_cv_thnkeluar = $request->dob_cv_akhir2;
                $cv->d_cv_jobdesc = $request->jobdesc2;
                $cv->d_cv_created = Carbon::now('Asia/Jakarta');
                $cv->save();
            }

            //d_berkas_pelamar
            if($request->hasFile('image')) 
            {
                $berkas = new d_berkas_pelamar;
                $image = $request->file('image');
                $path = public_path(). '/assets/berkas/foto-pelamar';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
                //load object dari package image resize
                Image::make($path.'/'.$filename)->resize(800, 800)->save();
                // set field to table
                $berkas->bks_name = $filename;
                $berkas->bks_type = 'I';
                $berkas->bks_pid = $id;
                $savedImg = $berkas->save();
            }

            if($request->hasFile('sertifikat')) 
            {
                $berkas = new d_berkas_pelamar;
                $sertifikat = $request->file('sertifikat');
                $path = public_path(). '/assets/berkas/dokumen-pelamar';
                $filename = time() . '.' . $sertifikat->getClientOriginalExtension();
                $sertifikat->move($path, $filename);
                // set field to table
                $berkas->bks_name = $filename;
                $berkas->bks_type = 'D';
                $berkas->bks_pid = $id;
                $savedSertifikat = $berkas->save();
            }

            if($request->hasFile('ijazah')) 
            {
                $berkas = new d_berkas_pelamar;
                $ijazah = $request->file('ijazah');
                $path = public_path(). '/assets/berkas/dokumen-pelamar';
                $filename = time() . '.' . $ijazah->getClientOriginalExtension();
                $ijazah->move($path, $filename);
                // set field to table
                $berkas->bks_name = $filename;
                $berkas->bks_type = 'D';
                $berkas->bks_pid = $id;
                $savedIjazah = $berkas->save();
            }

            if($request->hasFile('file_lain_lain')) 
            {
                $berkas = new d_berkas_pelamar;
                $file_lain_lain = $request->file('file_lain_lain');
                $path = public_path(). '/assets/berkas/dokumen-pelamar';
                $filename = time() . '.' . $file_lain_lain->getClientOriginalExtension();
                $file_lain_lain->move($path, $filename);
                // set field to table
                $berkas->bks_name = $filename;
                $berkas->bks_type = 'D';
                $berkas->bks_pid = $id;
                $savedIjazah = $berkas->save();
            }

            DB::commit();
            return redirect('/recruitment#apply')->with(['sukses' => 'Data berhasil disimpan']);
        /*} 
        catch (\Exception $e){
            DB::rollback();
            return redirect('/recruitment#apply')->with(['gagal' => 'Data berhasil disimpan, Ulangi sekali lagi']);
        }*/
    }

    public function cekEmail(Request $request)
    {
        $e = trim($request->email);
        $data = d_pelamar::select('p_email')->where('p_email', '=', $e)->first();
        if (count($data) > 0) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'Email Telah terdaftar, Mohon cek kembali email anda'
            ]);
        }elseif ($e == null) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'Mohon Input Email terlebih dahulu'
            ]);
        }
        else{
           return response()->json([
                'status' => 'sukses',
            ]); 
        }
    }

    public function cekWa(Request $request)
    {
        $e = trim($request->wa);
        $data = d_pelamar::select('p_tlp')->where('p_tlp', '=', $e)->first();
        if (count($data) > 0) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'No Telp/WA Telah terdaftar, Mohon cek kembali'
            ]);
        }
        elseif ($e == null) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'Mohon Input No Telp/WA terlebih dahulu'
            ]);
        }
        else{
           return response()->json([
                'status' => 'sukses'
            ]); 
        }
    }
}
