<?php

namespace App\Http\Controllers;

use App\Loan;
use App\LoanPaymentSchedule;
use App\LoanProvider;
use App\Profile;
use App\Services\LoanService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanProviderController extends Controller
{
    /**
     * @var LoanService
     */
    private $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = LoanProvider::has('profile')->get();

//        return $datas;
        return response()->view(subDomainPath('loan-provider.index'), compact('datas'));

//        $data = LoanProvider::get();
//        return response()->json($data);
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
     * @param  \App\LoanProvider  $loanProvider
     * @return \Illuminate\Http\Response
     */
    public function show(LoanProvider $loanProvider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoanProvider  $loanProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanProvider $loanProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoanProvider  $loanProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanProvider $loanProvider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LoanProvider  $loanProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanProvider $loanProvider)
    {
        //
    }

    public function profileStore(Request $request)
    {
        $provider = LoanProvider::find(Auth::user()->loan_provider->id);
        $profile = new Profile();
        $profile->first_name = $request->input('first_name');
        $profile->middle_name = $request->input('middle_name');
        $profile->last_name = $request->input('last_name');
        $profile->designation = $request->input('designation');
        $profile->mobile = $request->input('mobile');
        $profile->landline = $request->input('landline');
        $profile->bank_name = $request->input('bank_name');
        $profile->branch_name = $request->input('branch_name');
        $profile->branch_code = $request->input('branch_code');
        $profile->branch_address = $request->input('branch_address');
        $profile->contact_person = $request->input('contact_person');
        $profile->contact_designation = $request->input('contact_designation');
        $profile->contact_number = $request->input('contact_number');
        if($provider->profile()->save($profile)){
            $user = User::find($provider->user_id);
            $user->name = $profile->first_name.' '.$profile->last_name;
            $user->save();
            return redirect()->route('home');
        }


    }

    public function loanApplicant()
    {

        if(Auth::user()->loan_provider){
            $loans = Loan::with('product', 'provider')
                ->where('accept', 1)
                ->where('loan_provider_id', Auth::user()->loan_provider->id)
                ->get();
//        return $loans;

            return view(subDomainPath('loan-provider.loans.index'), compact('loans'));
        }

        $loans = Loan::with('product', 'provider')
//            ->where('loan_provider_id', Auth::user()->loan_provider->id)
            ->get();
//        return $loans;

        return view(subDomainPath('loans.index'), compact('loans'));
    }

    public function loanUpdateStatus(Request $request)
    {
        $action = $request->input('action');
        switch ($action){
            case 'decline':
                $data = Loan::find($request->input('id'));
                $data->status = 'Declined';
                $data->save();
                break;
            case 'accept':
                $data = Loan::find($request->input('id'));
                $data->accept = 1;
                $data->save();
                break;
            case 'show':
                $data = Loan::with('borrower', 'details')
                    ->find($request->input('id'));
                return response()->json($data);
                break;
            case 'pre-approve':
                $data = Loan::with('product')->find($request->input('id'));
                return response()->json($data);
                break;
            case 'approve':
                DB::beginTransaction();
                $data = Loan::find($request->input('id'));
                if($data->status == 'Active'){
                    return null;
                }
                $data->amount = floatval(preg_replace('/,/','', $request->input('amount')));
                $data->duration = $request->input('duration');
                $data->interest_rate = $request->input('interest_rate');
                $data->timing = $request->input('timing');
                $data->allowance = $request->input('allowance');
                $data->first_allowance = $request->input('first_allowance');
                $data->status = 'Active';
                $data->start_date = Carbon::now()->toDateString();
                $endDate = null;
                if($data->save()){
//                    $products = $data->product;
                    if($data->timing == 'custom'){
                        $paymentSchedules = $request->input('schedules');
                        $amortization = computeAmortization($data->amount, $data->duration, $data->interest_rate);
                        foreach($paymentSchedules as $paymentSchedule){
                            $loanPaymentSchedules = new LoanPaymentSchedule();
                            $loanPaymentSchedules->loan_id = $data->id;
                            $loanPaymentSchedules->due_date = Carbon::createFromFormat('M j, Y', $paymentSchedule)->toDateString();
                            $loanPaymentSchedules->payable_amount = $amortization;
                            $loanPaymentSchedules->status = 'unpaid';
                            $loanPaymentSchedules->save();
                            $endDate = $loanPaymentSchedules->due_date;
                        }
                    }else{
                        $paymentSchedules =  $this->loanService->generateSchedule($data);
                        foreach($paymentSchedules as $paymentSchedule){
                            $loanPaymentSchedules = new LoanPaymentSchedule();
                            $loanPaymentSchedules->loan_id = $data->id;
                            $loanPaymentSchedules->due_date = Carbon::createFromFormat('M j, Y', $paymentSchedule['date'])->toDateString();
                            $loanPaymentSchedules->payable_amount = $paymentSchedule['amount'];
                            $loanPaymentSchedules->status = 'unpaid';
                            $loanPaymentSchedules->save();
                            $endDate = $loanPaymentSchedules->due_date;
                        }

                    }
                }
                $data->end_date = $endDate;
                $data->save();
                DB::commit();
                break;
        }
    }

    public function customForms()
    {

        return view(subDomainPath('settings.forms.application-form'));
    }

    public function customFormStore(Request $request)
    {
        $loanProvider = LoanProvider::find(Auth::user()->loan_provider->user_id);
        return '';
    }
}
