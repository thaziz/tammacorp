<?php

namespace App\Http\Controllers\Inventory;

use App\m_item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\d_gudangcabang;
use App\d_stock;
use App\d_opname;
use App\d_opnamedt;
use Auth;
use DataTables;
use URL;

class stockOpnameController extends Controller
{
    public function index()
    {
        $data = d_gudangcabang::all();
        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
        return view('inventory.stockopname.index', compact('data','staff'));
    }

    public function tableOpname($comp, $position)
    {
        $data = d_stock::select(
            'i_id',
            'i_code',
            'i_name',
            'i_type',
            's_qty',
            'm_sname')
            ->where('s_comp', $comp)
            ->where('s_position', $position)
            ->where('i_isactive','TRUE')
            ->join('m_item', 'i_id', '=', 's_item')
            ->join('m_satuan', 'm_sid', '=', 'i_sat1')
            ->get();
        // dd($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('s_qty', function ($data) {
                return '<div>
                            <input type="text"
                                class="form-control text-right input-real[]"
                                name="od_qty_sistem[]"
                                readonly
                                value="'. number_format($data->s_qty, 0, ',', '.') .'">
                        </div>';
            })

            ->editColumn('item', function ($data) {
                return '<div>
                          '.$data->i_code. ' - ' .$data->i_name.'
                          <input type="hidden"
                                  class="form-control input-real[]"
                                  name="od_item[]"
                                  value="'.$data->i_id.'">
                        </div>';
            })

            ->editColumn('real', function ($data) {
                return '<input  type="number"
                                class="form-control text-right"
                                name="od_qty_real[]"
                                value=" ">';
            })

            ->editColumn('ket', function ($data) {
                return '<input  type="text"
                                class="form-control"
                                name="od_ket[]"
                                value=" ">';
            })

            ->rawColumns(['item','s_qty','real','ket'])
            ->make(true);

    }

    function saveOpname(Request $request){
      // dd($request->all());
      DB::beginTransaction();
        try {
      $o_id = d_opname::max('o_id') + 1;
      //nota
      $year = carbon::now()->format('y');
      $month = carbon::now()->format('m');
      $date = carbon::now()->format('d');
      $nota = 'OD'  . $year . $month . $date . $o_id;
      //end Nota
      d_opname::insert([
          'o_id' => $o_id,
          'o_nota' => $nota,
          'o_staff' => $request->o_staff,
          'o_time' => Carbon::now(),
          'o_date' => Carbon::now(),
          'o_comp' => $request->o_comp,
          'o_position' => $request->o_position,
          'o_status' => 'WT',
          'o_insert' => Carbon::now()
      ]);

      for ($i=0; $i < count($request->od_qty_real); $i++) {
        if($request->od_qty_real[$i]!=''){
          $od_idodt=d_opnamedt::where('od_ido',$o_id)->max('od_idodt')+1;
            d_opnamedt::insert([
              'od_ido' => $o_id,
              'od_idodt' => $od_idodt,
              'od_item' => $request->od_item[$i],
              'od_qty_real' => $request->od_qty_real[$i],
              'od_ket' => $request->od_ket[$i]
            ]);
        }
      }

      $nota = d_opname::where('o_id',$o_id)
          ->first();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'nota' => $nota
          ]);
        } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal',
          'data' => $e
          ]);
        }
    }
}
