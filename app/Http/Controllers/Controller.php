<?php

namespace App\Http\Controllers;

use App\AppRegistrant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function registration()
    {
        $app_registrant = [
            'enterprise-client'=>'Enterprise Client',
            'community-leader'=>'Community Leader',
            'buyer'=>'Buyer'
        ];

        return view('wharf.auth.register', compact('app_registrant'));
    }
}
