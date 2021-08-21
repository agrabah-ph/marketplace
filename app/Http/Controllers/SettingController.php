<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $settings = Settings::all();

        return view('admin.settings.index', compact('settings'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $settingsOld = [];
        if ($request->has('settings')){

            $settings = $request->settings;

            foreach($settings['id'] as $id => $value){
                $checked = 0;
                if(array_key_exists('is_active', $settings)){
                    if(array_key_exists($id, $settings['is_active'])){
                        $checked = 1;
                    }
                }else{
                    $checked = 0;
                }

                $settingsOld[$id] =$checked;
                Settings::where('id', $id)->update([
                    'value' => $value,
                    'is_active' => $checked,
                ]);
            }
        }
        if ($request->has('new_entry')){
            $newEntry = $request->new_entry;
            foreach($newEntry['name'] as $index => $name){
                $checked = 0;
                if(array_key_exists('is_active', $newEntry)){
                    if(array_key_exists($index, $newEntry['is_active'])){
                        $checked = 1;
                    }
                }else{
                    $checked = 0;
                }
                Settings::create([
                    'name' => stringSlug($name),
                    'display_name' => $name,
                    'value' => $newEntry['value'][$index],
                    'is_active' => $checked,
                ]);
            }

        }
        DB::commit();
        return redirect()->back();
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
}
