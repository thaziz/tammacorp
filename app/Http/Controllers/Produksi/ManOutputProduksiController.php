<?php

namespace App\Http\Controllers\Produksi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use App\d_productresult;
use App\d_productresult_dt;
use App\d_stock;
use App\d_stock_mutation;
use App\d_send_product;
use App\d_send_productdt;
use App\d_productplan;
use App\d_spk;
use App\m_produksi;
use Response;
use DataTables;
use App\Http\Requests;
use Illuminate\Http\Request;

class ManOutputProduksiController extends Controller
{
    public function OutputProduksi()
    {
        $data = m_produksi::all();

        return view('produksi.o_produksi.index', compact('data'));
    }

    public function setCreateProduct($tgl1)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tgll = $y . '-' . $m . '-' . $d;

        return view('produksi.o_produksi.create');
    }

    public function setSpk($tgl1)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tgll = $y . '-' . $m . '-' . $d;
        $dataSpk = DB::table('d_spk')
            ->join('m_item', 'm_item.i_id', '=', 'd_spk.spk_item')
            ->join('d_productplan', 'd_productplan.pp_id', '=', 'd_spk.spk_ref')
            ->where('spk_status', 'FN')
            ->where('spk_date', '=', $tgll)
            ->get();

        $html = '<select id="cari_spk" onchange="setResultSpk()" class="form-control input-sm" style="width: 100%;">';
        $html .= '<option value="0">- Pilih Nomor SPK</option>';
        foreach ($dataSpk as $key => $spk) {
            $html .= '<option value=' . $spk->spk_id . '>' . $spk->spk_code . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    public function selectDataSpk($x)
    {
        $d_spk = d_spk::
        select('spk_id',
            'i_name',
            'i_id',
            'pp_qty',
            DB::raw("sum(prdt_qty) as prdt_qty"))
            ->join('m_item', 'm_item.i_id', '=', 'd_spk.spk_item')
            ->join('d_productplan', 'd_productplan.pp_id', '=', 'd_spk.spk_ref')
            ->leftJoin('d_productresult', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
            ->leftJoin('d_productresult_dt', 'd_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
            ->where('spk_id', '=', $x)
            ->get();

        return Response::json($d_spk);
    }


    public function tabelDetail(Request $request)
    {
        $getid = DB::table('d_productresult')
            ->select('pr_id')
            ->where('pr_id', '=', $request->x[0])
            ->get();

        return view('produksi.o_produksi.detail', compact('getid'));
    }

    public function tabelDetailKirim(Request $request)
    {

        $getid = DB::table('d_productresult')
            ->select('pr_id')
            ->where('pr_id', '=', $request->y[0])
            ->get();

        return view('produksi.o_produksi.detailKirim', compact('getid'));
    }

    public function distroy($id1, $id2)
    {
        $d_productresult_dt = d_productresult_dt::
        where('prdt_productresult', $id1)
            ->where('prdt_detail', $id2)
            ->first();

        $gudangProduksi = d_stock::
        where('s_comp', '6')
            ->where('s_position', '6')
            ->where('s_item', $d_productresult_dt->prdt_item)
            ->first();

        $gudangBaru = $gudangProduksi->s_qty - $d_productresult_dt->prdt_qty;

        d_stock::
        where('s_comp', '6')
            ->where('s_position', '6')
            ->where('s_item', $d_productresult_dt->prdt_item)
            ->update([
                's_qty' => $gudangBaru
            ]);

        d_productresult_dt::
        where('prdt_productresult', $id1)
            ->where('prdt_detail', $id2)
            ->delete();
    }

    public function edit($id1, $id2)
    {
        $data = d_productresult_dt::
        select('prdt_productresult',
            'prdt_detail',
            'i_name',
            'prdt_qty')
            ->join('m_item', 'i_id', '=', 'prdt_item')
            ->where('prdt_productresult', $id1)
            ->where('prdt_detail', $id2)
            ->first();
        // dd($data);
        return Response::json($data);
    }

    public function tabel()
    {
        $data = DB::table('d_productresult_dt')
            ->select('pr_date',
                'spk_code',
                'i_name',
                'prdt_date',
                'prdt_time',
                'prdt_qty',
                'prdt_productresult',
                'prdt_detail',
                'prdt_status',
                'mp_name',
                'prdt_produksi')
            ->join('d_productresult', 'prdt_productresult', '=', 'pr_id')
            ->join('m_item', 'i_id', '=', 'prdt_item')
            ->join('d_spk', 'pr_spk', '=', 'spk_id')
            ->join('m_produksi', 'mp_id', '=', 'prdt_produksi')
            ->orderBy('prdt_date', 'DESC')
            ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->prdt_status == 'RD') {
                    return '<div class="text-center">
                  <button style="margin-left:5px;" 
                          title="Menunggu" 
                          type="button"
                          class="btn btn-warning btn-sm">
                          <i class="fa fa-cubes" aria-hidden="true"></i>
                  </button>
                </div>';

                } else if ($data->prdt_status == 'RC') {
                    return '<div class="text-center">
                    <button id="status" 
                            class="btn btn-success btn-sm" 
                            title="Diterima">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                    </button>
                  </div>';
                } else {
                    return '<div class="text-center">
                    <button id="status" 
                            class="btn btn-primary btn-sm" 
                            title="Dikirim">
                            <i class="fa fa-car" aria-hidden="true"></i>
                    </button>
                  </div>';
                }

            })
            ->editColumn('pr_date', function ($user) {
                return $user->pr_date ? with(new Carbon($user->pr_date))->format('d M Y') : '';
            })
            ->editColumn('prdt_date', function ($user) {
                return date('d M Y', strtotime($user->prdt_date)) . ', ' . $user->prdt_time;
            })
            ->editColumn('prdt_status', function ($inquiry) {
                if ($inquiry->prdt_status == 'RD')
                    return '<div class="text-center">
                    <span class="label label-red">Digudang</span>
                  </div>';
                if ($inquiry->prdt_status == 'FN')
                    return '<div class="text-center">
                    <span class="label label-yellow">Dikirim</span>
                  </div>';
                if ($inquiry->prdt_status == 'RC')
                    return '<div class="text-center">
                    <span class="label label-success">Diterima</span>
                  </div>';
            })
            ->rawColumns(['prdt_status',
                'action'
            ])
            ->make(true);

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $cek = DB::table('d_productresult')
                ->where('pr_spk', $request->spk_id)
                ->get();
            d_productplan::where('pp_id', $request->spk_id)
                ->update([
                    'pp_isspk' => 'P'
                ]);

            $nota = d_spk::select('spk_code')
                ->where('spk_id', $request->spk_id)
                ->first();

            $maxid1 = DB::Table('d_productresult_dt')->select('prdt_detail')->max('prdt_detail');
            if ($maxid1 <= 0 || $maxid1 == '') {
                $maxid1 = 1;
            } else {
                $maxid1 += 1;
            }
            // dd($cek);
            $maxid = DB::Table('d_productresult')->select('pr_id')->max('pr_id');
            if ($maxid <= 0 || $maxid == '') {
                $maxid = 1;
            } else {
                $maxid += 1;
            }

            if (count($cek) == 0) {

                d_productresult::insert([
                    'pr_id' => $maxid,
                    'pr_spk' => $request->spk_id,
                    'pr_date' => Carbon::createFromFormat('d-m-Y', $request->tgl)->format('Y-m-d'),
                    'pr_item' => $request->spk_item
                ]);

                d_productresult_dt::insert([
                    'prdt_productresult' => $maxid,
                    'prdt_detail' => $maxid1,
                    'prdt_item' => $request->spk_item,
                    'prdt_qty' => $request->spk_qty,
                    'prdt_produksi' => $request->prdt_produksi,
                    'prdt_status' => 'RD',
                    'prdt_date' => Carbon::createFromFormat('d-m-Y', $request->tgl)->format('Y-m-d'),
                    'prdt_time' => $request->time

                ]);

            } else {

                $pr = d_productresult::where('pr_spk', $request->spk_id)
                    ->get();

                $prdt = d_productresult_dt::where('prdt_productresult', $pr[0]->pr_id)
                    ->where('prdt_status', 'RD')
                    ->first();
                // dd($prdt);
                if ($prdt != null) {

                    $hasil = $prdt->prdt_qty + $request->spk_qty;

                    d_productresult_dt::where('prdt_productresult', $pr[0]->pr_id)
                        ->where('prdt_status', 'RD')
                        ->update([
                            'prdt_qty' => $hasil,
                        ]);

                } else {

                    d_productresult_dt::insert([
                        'prdt_productresult' => $pr[0]->pr_id,
                        'prdt_detail' => $maxid1,
                        'prdt_item' => $request->spk_item,
                        'prdt_qty' => $request->spk_qty,
                        'prdt_produksi' => $request->prdt_produksi,
                        'prdt_status' => 'RD',
                        'prdt_date' => Carbon::createFromFormat('d-m-Y', $request->tgl)->format('Y-m-d'),
                        'prdt_time' => $request->time

                    ]);
                }

            }

            $stockProduksi = d_stock::where('s_comp', '6')
                ->where('s_position', '6')
                ->where('s_item', $request->spk_item)
                ->first();

            if ($stockProduksi == null) {
                $maxid = DB::Table('d_stock')->select('s_id')->max('s_id');
                if ($maxid <= 0 || $maxid == '') {
                    $maxid = 1;
                } else {
                    $maxid += 1;
                }

                d_stock::insert([
                    's_id' => $maxid,
                    's_comp' => 6,
                    's_position' => 6,
                    's_item' => $request->spk_item,
                    's_qty' => $request->spk_qty,
                    's_insert' => Carbon::now()
                ]);

                d_stock_mutation::create([
                    'sm_stock' => $maxid,
                    'sm_detailid' => 1,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 6,
                    'sm_position' => 6,
                    'sm_mutcat' => 9,
                    'sm_item' => $request->spk_item,
                    'sm_qty' => $request->spk_qty,
                    'sm_qty_used' => 0,
                    'sm_qty_sisa' => $request->spk_qty,
                    'sm_qty_expired' => 0,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $nota->spk_code,
                    'sm_insert' => Carbon::now()
                ]);

            } else {

                $sm_detailid = d_stock_mutation::select('sm_detailid')
                        ->where('sm_item', $request->spk_item)
                        ->where('sm_comp', '6')
                        ->where('sm_position', '6')
                        ->max('sm_detailid') + 1;

                $stokBaru = $stockProduksi->s_qty + $request->spk_qty;
                $stokProduksi = d_stock::where('s_comp', '6')
                    ->where('s_position', '6')
                    ->where('s_id', $stockProduksi->s_id)
                    ->update(['s_qty' => $stokBaru]);

                d_stock_mutation::create([
                    'sm_stock' => $stockProduksi->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 6,
                    'sm_position' => 6,
                    'sm_mutcat' => 9,
                    'sm_item' => $request->spk_item,
                    'sm_qty' => $request->spk_qty,
                    'sm_qty_used' => 0,
                    'sm_qty_sisa' => $request->spk_qty,
                    'sm_qty_expired' => 0,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $nota->spk_code,
                    'sm_insert' => Carbon::now()
                ]);

            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function saveActual(Request $request)
    {
        dd($request->all());
    }

}