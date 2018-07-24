<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use App\d_delivery_order;
use App\d_delivery_orderdt;

class stock_gudangController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function gudang()
    {
        $cabanggudang = DB::table('d_gudangcabang')->get();
        $item = DB::table('m_item')->get();
        return view('inventory/stockgudang/gudang',compact('cabanggudang','item'));
    }

    public function datatable_gudang()
    {
        $list = DB::select("SELECT * from d_stock join d_gudangcabang on d_stock.s_position = d_gudangcabang.cg_id  join m_item on  d_stock.s_item = m_item.i_id ");
        // return $list;
        $data = collect($list);
        
        // return $data;

        return Datatables::of($data)
            
                ->addColumn('aksi', function ($data) {

                         return  '<button id="edit" onclick="detail(this)" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['aksi','confirmed'])
                ->make(true);
    }
    public function cari_gudang(Request $request)
    {
        // dd($request->all());

        $cabang   = 'AND s_position = '.$request->cabang.'';
        $item     = 'AND s_item = '.$request->item.'';
        // $gudang   = 'AND s_position = '.$request->gudang.'';

        $cari_data = DB::select("SELECT * from d_stock join d_gudangcabang on d_stock.s_position = d_gudangcabang.cg_id  join m_item on  d_stock.s_item = m_item.i_id WHERE s_id is not null  ".$cabang." ".$item." ");
        return view('inventory/stockgudang/carigudang',compact('cari_data'));
    }
}
