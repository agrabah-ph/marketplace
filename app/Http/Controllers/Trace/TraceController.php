<?php

namespace App\Http\Controllers\Trace;

use App\Events\TraceCreatedEvent;
use App\Farmer;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\Mail\TraceShipped;
use App\Trace;
use App\ModelInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TraceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('super-admin')){
            $datas = Trace::get();
        }else{
            $datas = Trace::where('user_id', Auth::user()->id)->get();
        }
//        return $datas;
        return response()->view(subDomainPath('trace.index'), compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $datas = Inventory::where('status', 'Accepted')->get();
//            return $datas;
        $random = Str::random(15);

//        $host_names = explode(".", $_SERVER['HTTP_HOST']);
//        $url = $host_names[count($host_names)-2] . "." . $host_names[count($host_names)-1]."/".$random;

        $url = route('trace-info', array('code'=>$random));
        return response()->view(subDomainPath('trace.create'), compact('datas', 'random', 'url'));
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
     * @param  \App\Trace  $trace
     * @return \Illuminate\Http\Response
     */
    public function show(Trace $trace)
    {
        $trace = Trace::with('inventories')->find($trace->id);
//        $inventory = Inventory::with('farmer')->where('trace_id', $trace->id)->get();
//        return $trace;
        return view(subDomainPath('trace.show'), compact('trace'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trace  $trace
     * @return \Illuminate\Http\Response
     */
    public function edit(Trace $trace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trace  $trace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trace $trace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trace  $trace
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trace $trace)
    {
        //
    }

    public function farmerInventoryList()
    {
        $data = Inventory::where('leader_id', Auth::user()->id)
            ->where('status', 'Accepted')
            ->get();

        return response()->json($data);
    }

    public function traceStore(Request $request)
    {
        $code = Str::random(6);
        $data = $request->input('datas');
        $trace = new Trace();
        $trace->reference = $data[8];
        $trace->code = $code;
        $trace->url = route('trace-info', array('code'=>$data[8]));
        $trace->user_id = Auth::user()->id;
        if($trace->save()){
            QrCode::size(500)
                ->format('png')
                ->generate($trace->url, public_path('images/trace/'.$trace->reference.'.png'));
            $trace->image = $trace->reference.'.png';
            $trace->image_path = '/images/trace/'.$trace->reference.'.png';
            $trace->save();

            $modelInfo = new ModelInfo();
            $modelInfo->type = 'status';
            $modelInfo->value_0 = 'Loaded';
            $modelInfo->value_1 = 'Waiting to travel';
            $trace->info()->save($modelInfo);
            $url = route('trace-shipped', array('code'=>$code));
//            QrCode::size(500)
//                ->format('png')
//                ->generate($url, public_path('images/trace/'.$code.'.png'));

            $modelInfo = new ModelInfo();
            $modelInfo->type = 'receiver';
            $modelInfo->value_0 = $data[0]; // name
            $modelInfo->value_1 = $data[1]; // email
            $modelInfo->value_2 = $data[2]; // mobile
            $modelInfo->value_3 = $code;
            $modelInfo->value_4 = $code.'.png';
            $modelInfo->value_5 = '/images/trace/'.$code.'.png';
            $modelInfo->text_0 = $data[3]; // address
//            $modelInfo->text_1 = base64_encode(file_get_contents(public_path('images/trace/'.$code.'.png'))); // address
            if($trace->info()->save($modelInfo)){

                $myEmail = $data[1];

                $details = [
                    'title' => 'Agrabah Shipping details.',
                    'url' => route('trace-tracking', array('code'=>$trace->reference)),
                    'body' => '<p>Please present this CODE upon receiving your package.</p><br><table><thead><tr><th colspan="4" align="center">Dispatch Information</th></tr></thead><tbody><tr><td width="150" align="left">Driver Name</td><td align="left">'. $data[4] .'</td></tr><tr><td align="left">Mobile no.</td><td align="left">'. $data[5] .'</td></tr><tr><td align="left">Vehicle Type</td><td align="left">'. $data[6] .'</td></tr><tr><td align="left">Plate No.</td><td align="left">'. $data[7] .'</td></tr></tbody></table><br><br><br>',
                    'code' => $modelInfo->value_3,
                    'email' => $myEmail
                ];

//                event(new TraceCreatedEvent($details));
                Mail::to($myEmail)->send(new TraceShipped($details));
            }

            $modelInfo = new ModelInfo();
            $modelInfo->type = 'dispatch';
            $modelInfo->value_0 = $data[4];
            $modelInfo->value_1 = $data[5];
            $modelInfo->value_2 = $data[6];
            $modelInfo->value_3 = $data[7];
            $trace->info()->save($modelInfo);

            foreach($data[10] as $id){
                $inventory = Inventory::find($id);
                $inventory->status = 'Loaded';
                $inventory->trace_id = $trace->id;
                $inventory->save();
            }

            $url = route('trace.show', array('trace'=>$trace));
            return response()->json($url);
        }
    }

    public function traceQrPrint($reference)
    {
        $data = Trace::where('reference', $reference)->first();

        return view(subDomainPath('mobile.trace-qr-print'), compact('data'));
    }
}
