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
        $app_registrant = AppRegistrant::where('app', subdomain_name())->get();

        return view(subdomain_name().'.auth.register', compact('app_registrant'));
    }
}
