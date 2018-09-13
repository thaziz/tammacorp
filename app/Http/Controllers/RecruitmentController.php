<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use DataTables;
use Auth;
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

    public function process_rekrut($id)
    {
        $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->join('d_lowongan','d_pelamar.p_vacancyid','=','d_lowongan.l_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_lowongan.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_id', $id)
                ->first();

        $approve1 = DB::table('d_pelamar_status')->join('d_pelamar_statusdt', 'd_pelamar_status.p_st_id', '=', 'd_pelamar_statusdt.p_stdt_sid')->where('d_pelamar_status.p_st_id', '2')->get();
        $approve2 = DB::table('d_pelamar_status')->join('d_pelamar_statusdt', 'd_pelamar_status.p_st_id', '=', 'd_pelamar_statusdt.p_stdt_sid')->where('d_pelamar_status.p_st_id', '3')->get();
        $approve3 = DB::table('d_pelamar_status')->join('d_pelamar_statusdt', 'd_pelamar_status.p_st_id', '=', 'd_pelamar_statusdt.p_stdt_sid')->where('d_pelamar_status.p_st_id', '4')->get();

        $cek1 = DB::table('d_apply')->where('ap_pid', $id)->where('ap_stid', '2')->first();
        $cek2 = DB::table('d_apply')->where('ap_pid', $id)->where('ap_stid', '3')->first();
        $cek3 = DB::table('d_apply')->where('ap_pid', $id)->where('ap_stid', '4')->first();

        if (count($cek1) > 0 ) { $cek_app1 = $cek1->ap_stdt_id; } else { $cek_app1 = '1'; }
        if (count($cek2) > 0 ) { $cek_app2 = $cek2->ap_stdt_id; } else { $cek_app2 = '1'; }
        if (count($cek3) > 0 ) { $cek_app3 = $cek3->ap_stdt_id; } else { $cek_app3 = '1'; }

        return view('hrd/recruitment/process_rekrut', compact('data', 'approve1', 'approve2', 'approve3', 'cek_app1', 'cek_app2', 'cek_app3'));
    }

    public function preview_rekrut($id)
    {
        $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->join('d_lowongan','d_pelamar.p_vacancyid','=','d_lowongan.l_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_lowongan.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_id', $id)
                ->first();

        $cv = d_cv_pelamar::where('d_cv_pid', $id)->get();
        if (count($cv) == 1) {
            $cv1 = d_cv_pelamar::where('d_cv_pid', $id)->orderBy('d_cv_id', 'ASC')->limit(1)->get()->toArray();
            $cv2[] = array('d_cv_pid' => '', 'd_cv_company' => '', 'd_cv_thnmasuk' => '', 'd_cv_thnkeluar' => '', 'd_cv_jobdesc' => '', 'd_cv_created' => '', 'd_cv_updated' => '');
        }elseif (count($cv) == 2){
            $cv1 = d_cv_pelamar::where('d_cv_pid', $id)->orderBy('d_cv_id', 'ASC')->limit(1)->get()->toArray();
            $cv2 = d_cv_pelamar::where('d_cv_pid', $id)->orderBy('d_cv_id', 'DESC')->limit(1)->get()->toArray();
        }else{
            $cv1[] = array('d_cv_pid' => '', 'd_cv_company' => '', 'd_cv_thnmasuk' => '', 'd_cv_thnkeluar' => '', 'd_cv_jobdesc' => '', 'd_cv_created' => '', 'd_cv_updated' => '');
            $cv2[] = array('d_cv_pid' => '', 'd_cv_company' => '', 'd_cv_thnmasuk' => '', 'd_cv_thnkeluar' => '', 'd_cv_jobdesc' => '', 'd_cv_created' => '', 'd_cv_updated' => '');
        }

        //berkas
        $berkas = d_berkas_pelamar::where('bks_pid', $id)->where('bks_type', 'D')->get();
        if (count($berkas) == 0) {
            $ijasah[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
            $serti[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
            $lain[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
        }elseif (count($berkas) == 1) {
            $ijasah = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'IJ')->limit(1)->get()->toArray();
            $serti[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
            $lain[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
        }elseif (count($berkas) == 2){
            $ijasah = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'IJ')->limit(1)->get()->toArray();
            $serti = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'ST')->limit(1)->get()->toArray();
            $lain[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
        }elseif (count($berkas) == 3){
            $ijasah = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'IJ')->limit(1)->get()->toArray();
            $serti = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'ST')->limit(1)->get()->toArray();
            $lain = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'LL')->limit(1)->get()->toArray();
        }
        return view('hrd/recruitment/preview_rekrut', compact('data', 'cv1', 'cv2', 'ijasah', 'serti', 'lain'));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            //set rules form name
            'kdlowong' => 'required|min:7',
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
            'sertifikat' => "mimes:pdf|max:5000",
            'ijazah' => "mimes:pdf|max:5000",
            'file_lain_lain' => "mimes:pdf|max:5000",
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ],[
            'kdlowong.required' => ' Kode Lowongan Tidak Boleh Kosong',
            'kdlowong.min' => ' Kode Lowongan Minimal 7 Karakter',
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
            'image.required' => ' Anda Wajib Upload data Foto',
        ]);

        $id = d_pelamar::select('p_id')->max('p_id');
        if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

        $birth = $request->tahun . '-' . $request->bulan . '-' . $request->tanggal;
        $status = null;

        if ($request->status == 'menikah') { $status = 'M'; } else { $status = 'S'; }

        $dataLowongan = DB::table('d_lowongan')->select('l_id')->where('l_code', strtoupper($request->kdlowong))->first();
        if (count($dataLowongan) == 0) 
        {
            // return redirect('/recruitment#apply')->with(['gagal' => 'Kode Posisi Anda Salah, mohon periksa/hubungi kami untuk konfirmasi kode']);
            $request->session()->flash('gagal', 'Kode Posisi Anda Salah, mohon periksa/hubungi kami untuk konfirmasi kode');
            return redirect('/recruitment#apply');
        }
        else
        {
            //d_pelamar
            $data = new d_pelamar;
                $data->p_id = $id;
                $data->p_date = date('Y-m-d');
                $data->p_vacancyid = $dataLowongan->l_id;
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
                $filename = time().'foto' . '.' . $image->getClientOriginalExtension();
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
                $filename = time().'_sertifikat' . '.' . $sertifikat->getClientOriginalExtension();
                $sertifikat->move($path, $filename);
                // set field to table
                $berkas->bks_name = $filename;
                $berkas->bks_type = 'D';
                $berkas->bks_dtype = 'ST';
                $berkas->bks_pid = $id;
                $savedSertifikat = $berkas->save();
            }

            if($request->hasFile('ijazah')) 
            {
                $berkas = new d_berkas_pelamar;
                $ijazah = $request->file('ijazah');
                $path = public_path(). '/assets/berkas/dokumen-pelamar';
                $filename = time().'_ijazah' . '.' . $ijazah->getClientOriginalExtension();
                $ijazah->move($path, $filename);
                // set field to table
                $berkas->bks_name = $filename;
                $berkas->bks_type = 'D';
                $berkas->bks_dtype = 'IJ';
                $berkas->bks_pid = $id;
                $savedIjazah = $berkas->save();
            }

            if($request->hasFile('file_lain_lain')) 
            {
                $berkas = new d_berkas_pelamar;
                $file_lain_lain = $request->file('file_lain_lain');
                $path = public_path(). '/assets/berkas/dokumen-pelamar';
                $filename = time().'_lain' . '.' . $file_lain_lain->getClientOriginalExtension();
                $file_lain_lain->move($path, $filename);
                // set field to table
                $berkas->bks_name = $filename;
                $berkas->bks_type = 'D';
                $berkas->bks_dtype = 'LL';
                $berkas->bks_pid = $id;
                $savedIjazah = $berkas->save();
            }

            DB::commit();
            // return redirect('/recruitment#apply')->with(['sukses' => 'Data berhasil disimpan, Anda Akan dihubungi apabila lolos administrasi. Terima Kasih']);
            $request->session()->flash('sukses', 'Data berhasil disimpan, Anda Akan dihubungi apabila lolos administrasi. Terima Kasih');
            return redirect('/recruitment#apply');
        }
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

    public function getDataHrd(Request $request)
    {
        //dd($request->all());
        $y = substr($request->tgl1, -4);
        $m = substr($request->tgl1, -7, -5);
        $d = substr($request->tgl1, 0, 2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $yy = substr($request->tgl2, -4);
        $mm = substr($request->tgl2, -7, -5);
        $dd = substr($request->tgl2, 0, 2);
        $tanggal2 = $yy.'-'.$mm.'-'.$dd;

        if($request->status == 'semua' && $request->grade == 'semua'){
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }elseif ($request->grade == 'semua') {
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_apply_status', $request->status)
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }elseif($request->status == 'semua'){
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_education', $request->grade)
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }else{
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_education', $request->grade)
                ->where('d_pelamar.p_apply_status', $request->status)
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('tglBuat', function ($data) 
            {
                if ($data->p_created == null) {
                    return '-';
                } else {
                    return $data->p_created ? with(new Carbon($data->p_created))->format('d M Y') : '';
                }
            })
            ->editColumn('status', function ($data) 
            {
                if ($data->p_apply_status == 1) {
                    return '<span style="color:#e557d0">'.$data->p_st_name.'</span>';
                }else{
                    return '<span>'.$data->p_st_name.'</span>';
                }
            })
            ->editColumn('statusdt', function ($data) 
            {
                if ($data->p_apply_statusdt == 1) {
                    return '-';
                }elseif ($data->p_apply_statusdt == 9) {
                    return '<span style="color:blue">'.$data->p_stdt_name.'</span>';
                }elseif ($data->p_apply_statusdt == 2 || $data->p_apply_statusdt == 5 || $data->p_apply_statusdt == 8) {
                    return '<span style="color:red">'.$data->p_stdt_name.'</span>';
                }else{
                    return $data->p_stdt_name;
                }
            })
            ->addColumn('action', function($data)
            {
                return '<div class="text-center">
                            <a href="./preview_rekrut/'.$data->p_id.'" class="btn btn-sm btn-success" title="Preview">
                                <i class="glyphicon glyphicon-search"></i> 
                            </a>
                            <a href="./process_rekrut/'.$data->p_id.'" class="btn btn-sm btn-info" title="Process">
                                <i class="glyphicon glyphicon-ok"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" title="Delete" onclick=deleteDataPelamar("'.$data->p_id.'")>
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </div>';
            })
            ->rawColumns(['status', 'action', 'statusdt'])
            ->make(true);
    }

    public function approval_1(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $id = DB::table('d_apply')->select('ap_id')->max('ap_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");

            //insert d_apply
            DB::table('d_apply')
                ->insert([
                    'ap_id'=>$id,
                    'ap_pid' => $request->id,
                    'ap_stid'=> 2,
                    'ap_stdt_id'=> $request->approval_1,
                    'ap_date'=> $tgl,
                    'ap_created'=> $tanggal
                ]);

            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_status' => 2,
                    'p_apply_statusdt' => $request->approval_1,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 1 Berhasil Disimpan'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function update_approval_1(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");
            //get apply id
            $data_apply = DB::table('d_apply')->select('ap_id')->where('ap_pid', $request->id)->where('ap_stid', $request->status)->where('ap_stdt_id', $request->statusdt)->first();
            //update
            DB::table('d_apply')->where('ap_id', '=', $data_apply->ap_id)
                ->update([
                    'ap_stdt_id'=> $request->approval_1,
                    'ap_updated'=> $tanggal
                ]);
            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_statusdt' => $request->approval_1,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 1 Berhasil Diupdate'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function approval_2(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $id = DB::table('d_apply')->select('ap_id')->max('ap_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");

            //insert d_apply
            DB::table('d_apply')
                ->insert([
                    'ap_id'=>$id,
                    'ap_pid' => $request->id,
                    'ap_stid'=> 3,
                    'ap_stdt_id'=> $request->approval_2,
                    'ap_date'=> $tgl,
                    'ap_created'=> $tanggal
                ]);

            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_status' => 3,
                    'p_apply_statusdt' => $request->approval_2,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 2 Berhasil Disimpan'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function update_approval_2(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");
            //get apply id
            $data_apply = DB::table('d_apply')->select('ap_id')->where('ap_pid', $request->id)->where('ap_stid', $request->status)->where('ap_stdt_id', $request->statusdt)->first();
            //update
            DB::table('d_apply')->where('ap_id', '=', $data_apply->ap_id)
                ->update([
                    'ap_stdt_id'=> $request->approval_2,
                    'ap_updated'=> $tanggal
                ]);
            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_statusdt' => $request->approval_2,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 2 Berhasil Diupdate'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function approval_3(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            $id = DB::table('d_apply')->select('ap_id')->max('ap_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");

            //insert d_apply
            DB::table('d_apply')
                ->insert([
                    'ap_id'=>$id,
                    'ap_pid' => $request->id,
                    'ap_stid'=> 4,
                    'ap_stdt_id'=> $request->approval_3,
                    'ap_date'=> $tgl,
                    'ap_created'=> $tanggal
                ]);

            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_status' => 4,
                    'p_apply_statusdt' => $request->approval_3,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 3 Berhasil Disimpan'
            ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }
}
