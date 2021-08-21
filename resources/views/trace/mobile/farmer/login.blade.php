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
                <form action="{!! route('farmer-login-form') !!}" method="post" id="form"> @csrf
                    <div class="form-group mb-5">
    {{--                    <input type="text" name="farmer-id" class="form-control text-center">--}}
                        <div class="error-bag"></div>
                        @if($errors->has('farmer'))
                            <span class="text-danger">{{$errors->first('farmer')}}</span>
                        @endif
                        {{Form::text('farmer',null, array('class'=>'form-control numonly', 'autofocus'))}}
                        <label><strong class="text-uppercase">Farmer ID</strong></label>
                    </div>

                </form>
                <button type="button" class="btn btn-block btn-xl btn-success p-3 btn-action">PROCEED</button>

                <div class="mt-1">
                    <a href="{{ route('home') }}" class="btn btn-block btn-info p-3">DASHBOARD</a>
                </div>

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

            $('.form-control').keydown(function(event){
                if(event.keyCode === 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $(document).on('click', '.btn-action', function(){
                console.log(validateFarmer());
                if(validateFarmer()[0] > 0){
                    console.log(validateFarmer()[0]);
                    $('.error-bag').empty().append('<span class="text-danger">'+ validateFarmer()[1] +'</span>');
                    return false;
                }
                $('#form').submit();
            });

            function validateFarmer() {
                var error = 0, errorMge = null, result = new Array();
                jQuery.ajaxSetup({async: false});
                $.get('{!! route('farmer-check') !!}', {
                    id: $('input[name=farmer]').val()
                }, function(data){
                    console.log(data);
                    if(data){
                        if(data.profile === null){
                            error += 1;
                            errorMge = 'Farmer need Account setup first';
                        }
                    }else{
                        error += 1;
                        errorMge = 'Farmer not exists!';
                    }
                });
                result.push(error, errorMge);
                return result;
            }

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
