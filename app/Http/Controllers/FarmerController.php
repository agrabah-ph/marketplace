<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\Inventory;
use App\CommunityLeader;
use App\Loan;
use App\LoanApplicationDetail;
use App\LoanProduct;
use App\LoanType;
use App\Product;
use App\Profile;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('super-admin')){
            $datas = Farmer::with('leader')->has('profile')->get();
        }else{
            $ids = Inventory::where('leader_id', Auth::user()->leader->id)->distinct('farmer_id')->pluck('farmer_id')->toArray();
            $datas = Farmer::with('leader')
                ->whereIn('id', $ids)
                ->get();
        }

//        return $datas;
        return response()->view(subDomainPath('farmer.index'), compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $number = str_pad(Farmer::count() + 1, 6, 0, STR_PAD_LEFT);
        $number = Farmer::count() + 1;
//        $number = Auth::user()->master->account_id.'-'.$number;
        return response()->view(subDomainPath('farmer.create'), compact( 'number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $number = str_pad(Farmer::count() + 1, 5, 0, STR_PAD_LEFT);
        $number = Farmer::count() + 1;
//        $number = Auth::user()->master->account_id.'-'.$number;
        $farmer = new Farmer();
        $farmer->account_id = $number;
//        $farmer->leader_id = Auth::user()->leader->id;
        if($farmer->save()){
            $farmer->url = route('farmer.show', array('farmer'=>$farmer));
            $farmer->save();
            QrCode::size(500)
                ->format('png')
                ->generate($farmer->url, public_path('images/farmer/'.$farmer->account_id.'.png'));
            $profile = new Profile();
            $profile->first_name = $request->input('first_name');
            $profile->middle_name = $request->input('middle_name');
            $profile->last_name = $request->input('last_name');
            $profile->mobile = $request->input('mobile');
            $profile->address = $request->input('address');
            $profile->education = $request->input('education');
            $profile->four_ps = $request->input('four_ps', 0);
            $profile->pwd = $request->input('pwd', 0);
            $profile->indigenous = $request->input('indigenous', 0);
            $profile->livelihood = $request->input('livelihood', 0);
            $profile->farm_lot = $request->input('farm_lot');
            $profile->farming_since = $request->input('farming_since');
            $profile->organization = $request->input('organization');
            $profile->qr_image = $farmer->account_id.'.png';
            $profile->qr_image_path = '/images/farmer/'.$farmer->account_id.'.png';
            if($farmer->profile()->save($profile)){
                $user = new User();
                $user->name = ucwords($profile->first_name).' '.ucwords($profile->last_name);
                $user->email = $request->input('email');
                $user->password = bcrypt($request->input('password'));
                $user->passkey = $request->input('password');
                $user->active = 1;
                if($user->save()) {
                    $user->assignRole(stringSlug('Farmer'));
                    $user->markEmailAsVerified();
                    $farmer->user_id = $user->id;
                    $farmer->save();
                    return redirect()->route('farmer.index');
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function show(Farmer $farmer)
    {
        $data = Farmer::with('inventory')->find($farmer->id);
//        return $data;
        $group = array();
        if($data->profile->four_ps == 1){
            array_push($group,'4Ps');
        }
        if($data->profile->pwd == 1){
            array_push($group,'PWD');
        }
        if($data->profile->indigenous == 1){
            array_push($group,'Indigenous');
        }
        if($data->profile->livelihood == 1){
            array_push($group,'Livelihood');
        }

        $inventories = Inventory::where('farmer_id', $farmer->id)->get();
        $host_names = explode(".", $_SERVER['HTTP_HOST']);
        $url = $host_names[count($host_names)-2] . "." . $host_names[count($host_names)-1]."/inv-listing/".$data->account_id;

//        return $group;
        return view(subDomainPath('farmer.show'), compact('data', 'group', 'inventories', 'url'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function edit(Farmer $farmer)
    {
        return view(subDomainPath('farmer.edit'), compact('farmer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farmer $farmer)
    {
        $farmer = Farmer::find($farmer->id);

        $profile = Profile::find($farmer->profile->id);
        $profile->first_name = $request->input('first_name');
        $profile->middle_name = $request->input('middle_name');
        $profile->last_name = $request->input('last_name');
        $profile->mobile = $request->input('mobile');
        $profile->address = $request->input('address');
        $profile->education = $request->input('education');

        $profile->four_ps = $request->input('four_ps', 0);
        $profile->pwd = $request->input('pwd', 0);
        $profile->indigenous = $request->input('indigenous', 0);
        $profile->livelihood = $request->input('livelihood', 0);

        $profile->farm_lot = $request->input('farm_lot');
        $profile->farming_since = $request->input('farming_since');
        $profile->organization = $request->input('organization');
        if($profile->save()){
            return redirect()->route('farmer.show', array('farmer'=>$farmer->id));
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farmer $farmer)
    {
        //
    }

    public function farmerQrPrint($account)
    {
        $data = Farmer::where('account_id', $account)->first();
        return view(subDomainPath('mobile.farmer-qr-print'), compact('data'));
    }

    public function farmerLogin()
    {
        return view(subDomainPath('mobile.farmer.login'));
    }

    public function farmerLoginForm(Request $request)
    {
//        $id = $request->input('farmer');
//        $farmer = Farmer::where('community_leader', 0)->find($id);
//
//        $rules = array(
//            'farmer' => 'required|exists:farmers,account_id'
//        );
//        $messages = [
//            'farmer'    => 'Farmer does not exists.',
//        ];
//        $validator = Validator::make($request->all(), $rules, $messages);
//        if ($validator->fails()) {
//            return redirect()
//                ->back()
//                ->withErrors($validator)
//                ->withInput();
//        }

        return redirect()->route('farmers-info', array('account'=>$request->input('farmer')));
    }

    public function farmerCheck(Request $request)
    {
        $id = $request->input('id');
        $farmer = Farmer::has('profile')
            ->where('community_leader', 0)
            ->where('account_id', $id)
            ->first();

        return $farmer;
    }

    public function farmerInfo($account)
    {
        $data = Farmer::where('account_id', $account)->first();
        return view(subDomainPath('mobile.farmer.info'), compact('data'));
    }

    public function farmerInventory(Request $request)
    {
        return view(subDomainPath('mobile.farmer.inventory'));
    }

    public function profileStore(Request $request)
    {
        $farmer = Farmer::find(Auth::user()->farmer->id);
        $farmer->url = route('farmer.show', array('farmer'=>$farmer));
        $farmer->save();
        QrCode::size(500)
            ->format('png')
            ->generate($farmer->url, public_path('images/farmer/'.$farmer->account_id.'.png'));
        $profile = new Profile();
        $profile->first_name = $request->input('first_name');
        $profile->middle_name = $request->input('middle_name');
        $profile->last_name = $request->input('last_name');
        $profile->mobile = $request->input('mobile');
        $profile->address = $request->input('address');
        $profile->education = $request->input('education');
        $profile->four_ps = $request->input('four_ps', 0);
        $profile->pwd = $request->input('pwd', 0);
        $profile->indigenous = $request->input('indigenous', 0);
        $profile->livelihood = $request->input('livelihood', 0);
        $profile->farm_lot = $request->input('farm_lot');
        $profile->farming_since = $request->input('farming_since');
        $profile->organization = $request->input('organization');
        $profile->qr_image = $farmer->account_id.'.png';
        $profile->qr_image_path = '/images/farmer/'.$farmer->account_id.'.png';
        if($farmer->profile()->save($profile)){
            $user = User::find($farmer->user_id);
            $user->name = $profile->first_name.' '.$profile->last_name;
            $user->save();
            return redirect()->route('home');
        }
    }

    public function loanProductList()
    {
        $loanTypes = LoanType::get();
        $farmer = Farmer::with('profile')->find(Auth::user()->farmer->id);
        return view(subDomainPath('farmer.loan-product-list'), compact('loanTypes', 'farmer'));
    }

    public function loanProductListGet(Request $request)
    {
        $type = $request->input('type');
        $term = $request->input('term');
        $amount = $request->input('amount');


        $is_farmer = Auth::user()->farmer;
        $removeProductWithActiveLoan = [];
        if($is_farmer){
            $removeProductWithActiveLoan = $is_farmer->activeLoans->pluck('loan_product_id')->toArray();
        }else{
            $is_leader = Auth::user()->leader;
            $removeProductWithActiveLoan = $is_leader->activeLoans->pluck('loan_product_id')->toArray();
//            $removeProductWithActiveLoan = $is_leader->activeLoans->pluck('loan_product_id')->toArray();
        }


        $loanProducts = LoanProduct::with('provider', 'type')
            ->whereNotIn('id', $removeProductWithActiveLoan)
            ->when($type, function ($query, $type) {
                return $query->where('loan_type_id', $type);
            })
            ->when($term, function ($query, $term) {
                return $query->where('duration', '<=', $term);
            })
            ->when($amount, function ($query, $amount) {
                return $query->whereBetween('amount', $amount);
            })
            ->get();
        return response()->json($loanProducts);
    }

    public function loanApply(Request $request)
    {
        $loanProduct = LoanProduct::find($request->input('id'));
        $farmer = Farmer::find(Auth::user()->farmer->id);
        $loan = new Loan();
        $loan->loan_provider_id = $loanProduct->loan_provider_id;
        $loan->loan_product_id = $loanProduct->id;
        $loan->status = 'Pending';
        if($farmer->loans()->save($loan)){
            return response()->json($loan);
        }
    }

    public function submitLoanApplication(Request $request)
    {

//        $farmer = Farmer::find(Auth::user()->farmer->id);
//        $profile = $farmer->profile;
//        $profile->first_name = $request->input('first_name');
//        $profile->middle_name = $request->input('middle_name');
//        $profile->last_name = $request->input('last_name');
//        $profile->mobile = $request->input('mobile');
//        $profile->address = $request->input('address');
//        $profile->dob = $request->input('dob');
//        $profile->pob = $request->input('pob');
//        $profile->gender = $request->input('gender');
//        $profile->civil_status = $request->input('civil_status');
//        $profile->citizenship = $request->input('citizenship');
//        $profile->gross_monthly_income = $request->input('gross_monthly_income');
//        $profile->monthly_expenses = $request->input('monthly_expenses');
//        if($profile->save()){
//            $user = User::find(Auth::user()->id);
//            $user->name = ucwords($profile->first_name).' '.ucwords($profile->last_name);
//            $user->save();
//        }

//        return response()->json($request->input('inputs'));

        $inputs = $request->input('inputs');

//        return response()->json($inputs);

        $farmer = Farmer::find(Auth::user()->farmer->id);


        $loanProduct = LoanProduct::find($inputs[0]);
        $loan = new Loan();
        $loan->loan_provider_id = $loanProduct->loan_provider_id;
        $loan->loan_product_id = $loanProduct->id;
        $loan->status = 'Pending';

        $loan->amount = $loanProduct->amount;
        $loan->duration = $loanProduct->duration;
        $loan->interest_rate = $loanProduct->interest_rate;
        $loan->timing = $loanProduct->timing;
        $loan->allowance = $loanProduct->allowance;
        $loan->first_allowance = $loanProduct->first_allowance;

        if($farmer->loans()->save($loan)){
            $details = new LoanApplicationDetail();
            $details->loan_id = $loan->id;
            $details->info_loan_detail = serialize($inputs[1]);
            $details->credit_financial_info = serialize($inputs[2]);
            $details->trade_reference_info = serialize($inputs[3]);
            $details->reference_id = serialize($inputs[4]);
            $details->save();

            $url = route('my-loans');
            return response()->json($url);
        }
    }
}
