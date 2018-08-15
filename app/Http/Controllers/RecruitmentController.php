<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecruitmentController extends Controller
{
    public function recruitment()
    {
        return view('hrd/recruitment/index');
    }

    public function save(Request $request)
    {
        dd($request);
    }
}
