<?php

namespace App\Http\Controllers;

use App\Trace;
use Illuminate\Http\Request;

class BfarController extends Controller
{
    public function traceIndex()
    {
        $datas = Trace::get();
        return view('trace.bfar.index', compact('datas'));
    }

    public function traceShow($id)
    {
        $trace = Trace::with('inventories')->find($id);
        return view('trace.bfar.show', compact('trace'));
    }
}
