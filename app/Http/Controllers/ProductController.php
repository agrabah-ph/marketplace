<?php

namespace App\Http\Controllers;

use App\Product;
use App\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Product::get();
        return response()->view(subDomainPath('product.index'), compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view(subDomainPath('product.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Product();
        $data->name = stringSlug($request->input('name'));
        $data->display_name = $request->input('name');
        $data->description = $request->input('description');
        $data->save();

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = Product::with('units')->find($product->id);
//        return $data;
        if(auth()->user()->hasRole('super-admin')){
            return response()->view(subDomainPath('product.show'), compact('data'));
        }
        return response()->view(subDomainPath('product.show'), compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
//        return $product->units;
        return view(subDomainPath('product.edit'), compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function productList()
    {
        $data = Product::with('units')->get();
        return response()->json($data);
    }

    public function productUnitList(Request $request)
    {
        $data = Product::with('units')->find($request->input('id'));
        return response()->json($data->units);
    }

    public function productStore(Request $request)
    {
        $product = $request->input('product');
        $units = $request->input('unit');

        if($product[2] === 'store'){
            $data = new Product();
        }
        if($product[2] === 'update'){
            $data = Product::find($product[3]);
            $data->units()->delete();
        }

        $data->name = stringSlug($product[0]);
        $data->display_name = $product[0];
        $data->description = $product[1];
        if($data->save()){
            foreach ($units as $unitData){
                $unit = new Unit();
                $unit->name = $unitData[0];
                $unit->abbr = $unitData[1];
                $data->units()->save($unit);
            }

            $url = route('product.show', array('product'=>$data));
            return response()->json($url);

        }
    }
}
