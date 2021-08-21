<?php

namespace App\Http\Controllers;

use App\MasterFarmer;
use App\Profile;
use App\PurchaseOrder;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = PurchaseOrder::get();
//        return $datas;
        return response()->view(subDomainPath('purchase-order.index'), compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view(subDomainPath('purchase-order.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
//        $number = str_pad(MasterFarmer::count() + 1, 5, 0, STR_PAD_LEFT);
//        $master = new MasterFarmer();
//        $master->account_id = $number;
//        if($master->save()){
//            $profile = new Profile();
//            $profile->first_name = $request->input('first-name');
//            $profile->middle_name = $request->input('middle-name');
//            $profile->last_name = $request->input('last-name');
//            if($master->profile()->save($profile)){
//                $user = new User();
//                $user->name = $profile->first_name.' '.$profile->last_name;
//                $user->email = $request->input('email');
//                $user->password = bcrypt($request->input('password'));
//                $user->passkey = $request->input('password');
//                $user->active = 1;
//                if($user->save()) {
//                    $user->assignRole(stringSlug('master-farmer'));
//                    $user->markEmailAsVerified();
//                    $master->user_id = $user->id;
//                    $master->save();
//                    return redirect()->route('master-farmer.index');
//                }
//            }
//        }

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MasterFarmer  $masterFarmer
     * @return \Illuminate\Http\Response
     */
    public function show(MasterFarmer $masterFarmer)
    {
        $data = MasterFarmer::find($masterFarmer->id);

//        return $data;
        return response()->view(subDomainPath('master-farmer.show'), compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterFarmer  $masterFarmer
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterFarmer $masterFarmer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterFarmer  $masterFarmer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterFarmer $masterFarmer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterFarmer  $masterFarmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterFarmer $masterFarmer)
    {
        //
    }
}
