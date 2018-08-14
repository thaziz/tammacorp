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
use DataTables;
use URL;

class stockOpnameController extends Controller
{
    public function index(){
    	
    	$data = d_gudangcabang::all();
    	return view('inventory.stockopname.index', compact('data'));
    }

    public function autoItem(Request $request)
    {
        $term = $request->term;
        $results = array();
        $queries = m_item::where('m_item.i_name', 'LIKE', '%' . $term . '%')
            ->take(15)->get();

        if ($queries == null) {
            $results[] = ['id' => null, 'label' => 'tidak di temukan data terkait'];
        } else {
            foreach ($queries as $query) {
                $results[] = ['id' => $query->i_id,
                    'label' => $query->i_code . ', ' . $query->i_name];
            }
        }
        return Response::json($results);
    }
}
