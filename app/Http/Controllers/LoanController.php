<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanCollection;
use App\Loan;
use App\LoanPayment;
use App\LoanPaymentSchedule;
use App\Services\LoanService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
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
        $loans = Loan::where('borrower_type', 'App\Farmer')
            ->where('borrower_id', Auth::user()->farmer->id)
            ->get();
//        return $loans;

        return view(subDomainPath('farmer.loans.index'), compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {

        $filename = Storage::disk('payment_proof')->put($request->loan_id, $request->proof_of_payment);
        $url = Storage::disk('payment_proof')->url($filename);
        DB::beginTransaction();
        $loan = new LoanPayment();
        $loan->loan_id = $request->loan_id;
        $loan->payment_method = $request->payment_method;
        $loan->paid_amount = preg_replace('/,/', '', $request->paid_amount);
        $loan->paid_date = $request->paid_date;
        $loan->proof_of_payment = $url;
        $loan->reference_number = $request->reference_number;
        $loan->save();

        $paidAmounts = $loan->paid_amount;
        $paymentAmounts = [];

        $loanScheduleFirst = LoanPaymentSchedule::where('loan_id', $request->loan_id)
            ->where('status', 'unpaid')
            ->first();
        $loanAmor = $loanScheduleFirst->payable_amount;
        $loanRemainingLast = 0;
        if ($loanScheduleFirst->paid_amount > 0) {
            $loanRemainingLast = $loanScheduleFirst->payable_amount - $loanScheduleFirst->paid_amount;
        }
        do {
            if ($loanRemainingLast > 0) {
                if ($paidAmounts > $loanRemainingLast) {
                    $paymentAmounts[] = $loanRemainingLast;
                    $paidAmounts -= $loanRemainingLast;
                }
                $loanRemainingLast = 0;
            } else {
                if ($paidAmounts < $loanAmor) {
                    $paymentAmounts[] = $paidAmounts;
                } else {
                    $paymentAmounts[] = $loanAmor;
                }
                $paidAmounts -= $loanAmor;
            }
        } while ($paidAmounts > 0);

        // fully paid

        foreach ($paymentAmounts as $paymentAmount) {
            $loanSchedule = LoanPaymentSchedule::where('loan_id', $request->loan_id)
                ->whereRaw('paid_amount != payable_amount')
                ->first();
//            dd($loanSchedule);
            if($loanSchedule){
                $loanSchedule->paid_amount += $paymentAmount;
                $loanSchedule->save();
                if ($loanSchedule->paid_amount == $loanSchedule->payable_amount) {
                    $loanSchedule->status = 'paid';
                    $loanSchedule->save();
                }
            }
        }
        $fullyPaid  = LoanPaymentSchedule::where('loan_id', $request->loan_id)
                ->whereRaw('paid_amount != payable_amount')
                ->first();

        if(!$fullyPaid){
            $loan = Loan::find($loan->loan_id);
            $loan->status = 'Completed';
            $loan->save();
        }

        DB::commit();

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proofPhoto(Request $request, $id, $proof)
    {
        $url = Storage::disk('payment_proof')
            ->get($id . '/' . $proof);
        $type = $request->type;
        if ($type == 'view') {
            return response()->file(storage_path('app/payment_proof/') . $id . '/' . $proof);
        }
        if ($type == 'download') {
            return response()->download(storage_path('app/payment_proof/') . $id . '/' . $proof);
        }
        return $url;
    }

    public function getPaymentSchedule(Request  $request)
    {
        return $this->loanService->generateSchedule($request);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }

    public function verifyDisbursement(Request $request)
    {
        $error = 0;
        $now = Carbon::now();
        $loan = Loan::find($request->input('id'));
        switch($request->input('type')) {
            case 'check':
                if($loan->loan_received === null){
                    $error += 1;
                }
                break;
            case 'update':
                $loan->loan_received = $now;
                $loan->save();
                break;
        }

        return $error;
    }
}
