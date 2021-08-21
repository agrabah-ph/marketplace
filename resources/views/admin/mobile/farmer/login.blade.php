@extends('layouts.login')

@section('title', 'Farmers Login')

@section('content')
    <div class="ibox-content">
        <div class="text-center">
            <img src="{{ URL::to('/images/logo.png') }}" alt="agrabah-logo" class="logo img-fluid mt-3" width="250">
        </div>
    </div>

    <section class="container text-center">

{{--        <div id="app">--}}
{{--            <div id="qr-reader" style="width:400px"></div>--}}

{{--            <input type="text" id="FarmerBarcode" name="FarmerBarcode" value="" autocomplete="off" spellcheck="false" placeholder="Farmer Barcode">--}}
{{--        </div>--}}

        <div class="farmer-login mt-5">
            <form action="{!! route('farmer-login-form') !!}" method="post"> @csrf
                <div class="form-group mb-5">
{{--                    <input type="text" name="farmer-id" class="form-control text-center">--}}

                    @if($errors->has('farmer'))
                        <span class="text-danger">{{$errors->first('farmer')}}</span>
                    @endif
                    {{Form::text('farmer',null, array('class'=>'form-control numonly'))}}
                    <label><strong class="text-uppercase">Farmer ID</strong></label>
                </div>
                <button type="submit" class="btn btn-block btn-xl btn-success p-3">PROCEED</button>

                <div class="mt-1">
                    <a href="{{ route('home') }}" class="btn btn-block btn-info p-3">DASHBOARD</a>
                </div>

            </form>
        </div>
    </section>


@endsection

@section('styles')
    {{--{!! Html::style('') !!}--}}
@endsection

@section('scripts')
{{--        {!! Html::script('https://unpkg.com/vue-qrcode-reader@3.0.3/dist/VueQrcodeReader.umd.min.js') !!}--}}

{{--        <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>--}}
{{--        {!! Html::script('/js/html5-qrcode.min.js') !!}--}}
    <script>
        $(document).ready(function(){
            // function onScanSuccess(qrCodeMessage) {
            //     console.log(qrCodeMessage);
            //     var farmerBarCode = document.getElementById('FarmerBarcode');
            //     farmerBarCode.value = qrCodeMessage;
            //
            //     document.getElementById('Button6').click();
            //
            // }
            // var html5QrcodeScanner = new Html5QrcodeScanner(
            //     "qr-reader", { fps: 10, qrbox: 250 });
            // html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
@endsection
