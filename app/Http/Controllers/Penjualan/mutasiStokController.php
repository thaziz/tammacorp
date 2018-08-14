<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\d_stock_mutation;

class mutasiStokController extends Controller
{
    public function tableGrosirRetail()
    {
        $data = d_stock_mutation::select('sm_date',
            'i_code',
            'i_name',
            'cg_cabang',
            'smc_note',
            'sm_qty',
            'sm_qty_used',
            'sm_qty_sisa',
            'sm_detail',
            'sm_reff')
            ->join('m_item', 'i_id', '=', 'sm_item')
            ->join('d_gudangcabang','cg_id','=','sm_position')
            ->join('d_stock_mutcat','smc_id','=','sm_mutcat')
            ->where('sm_comp', '2')
            ->orderBy('i_name','asc')
            ->get();

        return DataTables::of($data)
            ->editColumn('sm_date', function ($data) {
                return date('d M Y H:i', strtotime($data->sm_date));
            })
            ->make(true);

    }

    /**
     * @return mixed
     */
    public function tablePenjualanRetail()
    {
        $data = d_stock_mutation::select('sm_date',
            'i_code',
            'i_name',
            'cg_cabang',
            'smc_note',
            'sm_qty',
            'sm_qty_used',
            'sm_qty_sisa',
            'sm_detail',
            'sm_reff')
            ->join('m_item', 'i_id', '=', 'sm_item')
            ->join('d_gudangcabang','cg_id','=','sm_position')
            ->join('d_stock_mutcat','smc_id','=','sm_mutcat')
            ->where('sm_comp', '1')
            ->orderBy('i_name','asc')
            ->get();

        return DataTables::of($data)
            ->editColumn('sm_date', function ($data) {
                return date('d M Y H:i', strtotime($data->sm_date));
            })
            ->make(true);

    }
}
