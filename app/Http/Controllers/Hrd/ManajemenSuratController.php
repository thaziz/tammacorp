<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;
class ManajemenSuratController extends Controller
{
    public function index(){
        return view('hrd/manajemensurat/index');
    }
    public function indexPhk(){
        $maxid = DB::Table('d_phk')->select('c_id')->max('c_id');
        // untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
        if ($maxid <= 0 || $maxid <= '') {
            $maxid  = 1;
        }else{
            $maxid += 1;
        }
        $tahun = Carbon::now()->format('Y');
        $bulan = Carbon::now()->format('m');
        switch ($bulan) {
            case "01":
                $bulan = "I";
                break;
            case "02":
                $bulan =  "II";
                break;
            case "03":
                $bulan =  "III";
                break;
            case "04":
                $bulan =  "IV";
                break;
            case "05":
                $bulan =  "V";
                break;
            case "06":
                $bulan =  "vI";
                break;
            case "07":
                $bulan =  "VII";
                break;
            case "08":
                $bulan =  "VIII";
                break;
            case "09":
                $bulan =  "IX";
                break;
            case "10":
                $bulan =  "x";
                break;
            case "11":
                $bulan =  "XI";
                break;
            case "12":
                $bulan =  "XII";
                break;
            default:
                echo "masukan format bulan dengan benar";
        }
        $kode = str_pad($maxid, 3, '0', STR_PAD_LEFT)."/PHK/HRD/TRI/".$bulan."/".$tahun;
        // dd($kode);
        return view('hrd/manajemensurat/surat_phk',['kode' => $kode]);
    }
    public function phkData(){
        $list = DB::table('d_phk')
                ->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="edit('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="hapus('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('kode', function ($data) {
                    return  str_pad($data->c_id, 3, '0', STR_PAD_LEFT);
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->addColumn('status', function ($data) {
                    if($data->c_jenis == 1){
                        $status = 'Pengurangan pegawai';
                    }else{
                        $status = 'Kesalahan berat';
                    }
                    return $status;
                })
                ->rawColumns(['action','confirmed'])
                ->make(true);
    }
    public function simpanPhk(Request $request){
        $input = $request->except('_token');
        if($input['c_bulan_terakhir'] == null){
            $input['c_bulan_terakhir'] = "-"; 
        }
        DB::table('d_phk')->insert($input);

        return redirect('/hrd/manajemensurat/surat-phk');
    }
    public function editPhk($id){
        $phk = DB::table('d_phk')->first();

        return view('hrd/manajemensurat/edit_phk',['phk' => $phk]);
    }
    public function updatePhk(Request $request, $id){
        $input = $request->except('_token','_method');
        $data = DB::table('d_phk')->where('c_id', $id)->update($input);

        return redirect('/hrd/manajemensurat/surat-phk');
    }
    public function deletePhk($id){
        $data = DB::table('d_phk')->where('c_id', $id)->delete();

        return redirect('/hrd/manajemensurat/surat-phk');
    }
}
