<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\Inventory;
use App\ModelInfo;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('super-admin')){
            $datas = Inventory::with('product')->get();
        }else{
            $datas = Inventory::with('product')
                ->where('leader_id', Auth::user()->leader->id)
                ->get();
        }
//        return $datas;
        return view(subDomainPath('inventory.index'), compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas = Farmer::with('profile')
            ->get();
//        return $datas;
        return response()->view(subDomainPath('inventory.create'), compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Inventory();
        $data->leader_id = Auth::user()->leader->id;
        $data->farmer_id = $request->input('farmer_id');
        $data->name = $request->input('name');
        $data->details = $request->input('details');
        $data->status = 'Accepted';
        $data->remark = 'Warehouse';
        $data->user_id = Auth::user()->leader->id;
        if($data->save()){

            $modelInfo = new ModelInfo();
            $modelInfo->type = 'status';
            $modelInfo->value_0 = $data->status;
            $modelInfo->value_1 = $data->remark;
            $data->info()->save($modelInfo);

            return redirect()->route('inventory.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        $inventory = Inventory::find($inventory->id);
        return view(subDomainPath('inventory.show'), compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    public function farmerInventoryList(Request $request)
    {
//        $ids = array();
        $data = Inventory::whereNotIn('id', $request->input('ids'))
            ->where('leader_id', Auth::user()->leader->id)
            ->with('farmer', 'product')
            ->where('status', 'Accepted')
            ->get();

        return response()->json($data);
    }

    public function farmerInventoryListItem(Request $request)
    {
        $data = Inventory::whereIn('id', $request->input('ids'))
            ->with('farmer', 'product')
            ->get();

        return response()->json($data);
    }

    public function farmerInventoryListing($account)
    {
        $data = Farmer::with('listing')->where('account_id', $account)->first();

        return view(subDomainPath('inventory-listing'), compact('data'));
    }

    public function inventoryListingStore(Request $request)
    {
        $details = $request->input('details');
        $inventory = new Inventory();
        $inventory->leader_id = Auth::user()->leader->id;
        $inventory->farmer_id = $details[1];
        $inventory->product_id = $details[2];
        $inventory->quality = $details[3];
        $inventory->unit = $details[4];
        $inventory->quantity = $details[5];
        $inventory->price = $details[6];
        $inventory->total = $details[7];
        $inventory->remark = $details[8];
        $inventory->status = 'Accepted';
        if($inventory->save()){
            $inventory = Inventory::with('product')->find($inventory->id);
//            $modelInfo = new ModelInfo();
//            $modelInfo->type = 'status';
//            $modelInfo->value_0 = 'Loaded';
//            $modelInfo->value_1 = 'Waiting to travel';
//            $inventory->info()->save($modelInfo);
            return response()->json($inventory);
        }

    }

    public function inventoryListingDelete(Request $request)
    {
        Inventory::where('id', $request->input('id'))->delete();
    }
}
