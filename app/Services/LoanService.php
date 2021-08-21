<?php

namespace App\Services;


use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanService
{

    public function generateSchedule($request)
    {
//        dd($request->all());
        if($request->duration && $request->interest_rate && $request->amount && $request->timing && $request->allowance && $request->first_allowance != null){

            $duration = (int)$request->duration;
            $allowance = (int)$request->allowance;
            $first_allowance = (int)$request->first_allowance;
            $interest_rate = (float)$request->interest_rate;
            $timing = $request->timing;
            $amount = floatval(preg_replace('/,/', '',$request->amount));

            $returnArray = [];
            $date = Carbon::now();
            if($first_allowance > 0){
                if($timing == 'monthly'){
                    $date->addMonths($first_allowance);
                }
                if($timing == 'day'){
                    $date->addDays($first_allowance);
                }
                if($timing == 'week'){
                    $date->addDays($first_allowance);
                }
            }
            $amortization = computeAmortization($amount, $duration, $interest_rate);
            foreach(range(1, $duration) as $counter){
                $array = [];

                if($timing == 'monthly'){
                    $date->addMonths($allowance);
                }
                if($timing == 'day'){
                    $date->addDays($allowance);
                }
                if($timing == 'week'){
                    $date->addWeeks($allowance);
                }
                $array['date'] = $date->copy()->toFormattedDateString();
                $array['amount'] = $amortization;
                $returnArray[] = $array;
            }
            return $returnArray;
        }else{
            dd($request->all());
        }
    }
}
