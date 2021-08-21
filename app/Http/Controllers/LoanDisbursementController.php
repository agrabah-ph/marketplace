<?php

namespace App\Http\Controllers;

use App\CommunityLeader;
use App\Farmer;
use App\LoanDisbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanDisbursementController extends Controller
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
     * @param  \App\LoanDisbursement  $loanDisbursement
     * @return \Illuminate\Http\Response
     */
    public function show(LoanDisbursement $loanDisbursement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoanDisbursement  $loanDisbursement
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanDisbursement $loanDisbursement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoanDisbursement  $loanDisbursement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanDisbursement $loanDisbursement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LoanDisbursement  $loanDisbursement
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanDisbursement $loanDisbursement)
    {
        //
    }

    public function getList()
    {
        $data = null;
        $type = getRoleName('name');
        switch ($type){
            case 'community-leader':
                break;
            case 'farmer':
                $data = Auth::user()->farmer->disbursement()->exists();
                break;
            case 'borrower':
                break;
        }

        return response()->json($data);
    }

    public function storeDisbursement(Request $request)
    {
        $input = $request->input('datas');
        $data = null;
        $type = getRoleName('name');
        switch ($type){
            case 'community-leader':
                $user = CommunityLeader::find(Auth::user()->leader->id);
                break;
            case 'farmer':
                $user = Farmer::find(Auth::user()->farmer->id);
                break;
            case 'borrower':
                break;
        }

        $data = new LoanDisbursement();
        $data->account_type = $input[0];
        $data->account_name = $input[1];
        $data->account_number = $input[2];
        $user->profile()->save($data);

        return response()->json($data);
    }
}
