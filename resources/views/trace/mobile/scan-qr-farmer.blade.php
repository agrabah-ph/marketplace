@extends('layouts.login')
{{--@extends('master')--}}

@section('title', 'Blank')

@section('content')
    {{--    <div class="ibox-content">--}}
    {{--        <div class="text-center">--}}
    {{--            <h1>AGRABAH TRACEABILITY</h1>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <section class="container text-center" id="app">
        <div class="farmer-id mt-5">

            <div class="div">
                <img src="{{ URL::to('/images/agrabah-logo.png') }}" alt="agrabah-logo" class="logo mt-3">
            </div>

{{--            <video id="preview"></video>--}}
            <div style="width: 500px" id="reader"></div>

        </div>
    </section>

@endsection

@section('styles')
    {{--{!! Html::style('') !!}--}}
@endsection

@section('scripts')
        {!! Html::script('/js/html5-qrcode.min.js') !!}
{{--        {!! Html::script('/js/instascan.min.js') !!}--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
{{--<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>--}}
    <script>
        $(document).ready(function(){
            // window.print();





        });
    </script>
@endsection
