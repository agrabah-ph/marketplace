<?php

namespace App\Http\Controllers;

use App\CommunityLeader;
use App\Farmer;
use App\Profile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function profileStore(Request $request)
    {
        $inputs = $request->input('forms');
        $type = getRoleName('name');
        if($type === 'farmer'){
            $userType = Farmer::find(Auth::user()->farmer->id);
        }
        if($type === 'community-leader'){
            $userType = Farmer::find(Auth::user()->leader->id);
        }
        $userType->url = route($type.'.show', array($type=>$userType));
        $userType->save();
        QrCode::size(500)
            ->format('png')
            ->generate($userType->url, public_path('images/'.$type.'/'.$userType->account_id.'.png'));

        $profile = new Profile();
        $profile->first_name = $inputs[0][1][2];
        $profile->middle_name = $inputs[0][2][2];
        $profile->last_name = $inputs[0][3][2];
        $profile->dob = Carbon::parse($inputs[0][4][2]);
        $profile->civil_status = $inputs[0][5][2];
        $profile->gender = $inputs[0][6][2];
        $profile->landline = $inputs[0][7][2];
        $profile->mobile = $inputs[0][8][2];
        $profile->tin = $inputs[0][9][2];
        $profile->sss_gsis = $inputs[0][10][2];
        $profile->education = $inputs[0][11][2];
        $profile->image = $inputs[0][0][2];
        $profile->secondary_info = serialize($inputs[1]);
        $profile->spouse_comaker_info = serialize($inputs[2]);
        $profile->farming_info = serialize($inputs[3]);
        $profile->employment_info = serialize($inputs[4]);
        $profile->income_asset_info = serialize($inputs[5]);

        $profile->qr_image = $userType->account_id.'.png';
        $profile->qr_image_path = '/images/'.$type.'/'.$userType->account_id.'.png';
        if($userType->profile()->save($profile)){
            $user = User::find($userType->user_id);
            $user->name = $profile->first_name.' '.$profile->last_name;
            $user->save();

            $url = route('home');
            return response()->json($url);
        }
    }

    public function myProfile()
    {
        $type = getRoleName('name');
        $profile = null;
        if($type === 'farmer'){
            $profile = Auth::user()->farmer->profile;
        }
        if($type === 'community-leader'){
            $profile = Auth::user()->leader->profile;
        }

//        return $profile;
        return view('layouts.show-profile', compact('profile'));
    }

    public function selectProfile(Request $request)
    {
        $id = $request->input('id');
        $data = Farmer::with('profile')->find($id);

        return response()->json($data);
    }

    public function getMyProfile(Request $request)
    {
        $type = getRoleName('name');
        $data = null;
        if($type === 'farmer'){
            $data = Farmer::with('profile')->find(Auth::user()->farmer->id);
        }
        if($type === 'community-leader'){
            $data = Farmer::with('profile')->find(Auth::user()->leader->id);
        }

        return response()->json($data);
    }
}
