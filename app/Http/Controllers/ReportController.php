<?php

namespace App\Http\Controllers;

use App\Exports\Report;
use App\MarketPlace;
use App\ReverseBidding;
use App\SpotMarket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request  $request)
    {

        $row = [];
        $start = Carbon::now()->toDateString();
        $end = Carbon::now()->toDateString();
        $type = 'spot-market';
        $status = '_all';
        if(getRoleName() == 'enterprise-client'){
            $type = 'reverse-bidding';
        }
        if($request->has('mode') && $mode = $request->get('mode')){

            $type = $request->get('type');
            $start = $request->get('start');
            $end = $request->get('end');
            $status = $request->get('status');
            if(getRoleName() == 'enterprise-client'){
                $type = 'reverse-bidding';
            }

            switch ($type){
                case 'spot-market':
                        $query = SpotMarket::query();
                    break;
                case 'market-place':
                        $query = MarketPlace::query();
                    break;
                case 'reverse-bidding':
                        $query = ReverseBidding::query();
                    break;
            }
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $start = Carbon::parse($start)->toDateString();
            $end = Carbon::parse($end)->toDateString();


            if($status == 'active'){
                $query->where('status',0);
            }elseif($status == 'expired'){
                $query->where('status', 1);
            }

            $row = $query->get();


            if($mode == 'download'){
                return Excel::download(new Report($row, $type), Carbon::parse($start)->format('Y-m-d').' to '.Carbon::parse($end)->format('Y-m-d').' '.ucfirst($type).'  Report.xlsx');
            }
        }

        return view('wharf.report.index', compact('row','start', 'end', 'type', 'status'));
    }
}
