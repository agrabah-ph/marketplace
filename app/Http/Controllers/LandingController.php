<?php

namespace App\Http\Controllers;

use App\Mail\LandingMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LandingController extends Controller
{
    //
    public function index(){
        return view('landing.index');
    }

    public function page_about(){
        return view('landing.about');
    }

    public function page_contacts(){
        return view('landing.contact');
    }

    public function page_terms(){
        return view('landing.terms');
    }

    public function page_privacy(){
        return view('landing.privacy');
    }

    public function post_mail(Request $request){
//        return $request;

        try {
            Mail::to('agrabah@aim.edu')->bcc('anbelen.official@gmail.com')->send(new LandingMail($request) );

            Log::info("Email Template sent: {}");

            return redirect()->back()->with('success', 'Email Sent Successfully.');

        } catch (\Exception $e) {
//            return $e;
            Log::debug("Error sending Message Email: {$e}");
            return redirect()->back()->with('error', 'Error. Please try again');
        }

    }
}
