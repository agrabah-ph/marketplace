<?php

namespace App\Services;


use App\Mail\BFARNotification;
use App\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function notifyBFAR($product, $to, $worth)
    {

        $data = Settings::where('name', 'bfar')->with('profile')->first();
        if($data){

            $comleader = Auth::user()->farmer->profile;
            Mail::to($data->profile->landline)->send(new BFARNotification([
                'product'=>$product,
                'to'=> $to,
                'comleader'=> Auth::user()->name,
                'number'=> $comleader->mobile,
                'worth'=> $worth,
            ]));

        }
    }
}
