<?php

namespace App\Http\Controllers;

use App\Loan;
use App\LoanProduct;
use App\LoanType;
use Illuminate\Http\Request;

class LoanProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = LoanProduct::where('loan_provider_id', auth()->user()->loan_provider->id)->get();

        return view('loan.product.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = LoanType::pluck('display_name','id');

        return view('loan.product.create', compact('types'));
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
        $loanProviderId = auth()->user()->loan_provider->id;
        $array = $request->all();
        $array['loan_provider_id'] = $loanProviderId;
        $array['loan_type_id'] = $array['type'];
        $array['amount'] = floatval(preg_replace('/,/','', $array['amount']));
        unset($array['token']);
        unset($array['type']);
        LoanProduct::create($array);


        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanProduct = LoanProduct::find($id);
        $types = LoanType::pluck('display_name','id');
        return response()->view(subDomainPath('product.edit'), compact( 'loanProduct', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanProduct $loan)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loanProduct = LoanProduct::find($id);

        $array = $request->all();
        $array['loan_type_id'] = $array['type'];
        $array['amount'] = floatval(preg_replace('/,/','', $array['amount']));
        unset($array['token']);
        unset($array['type']);
        $loanProduct->update($array);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
