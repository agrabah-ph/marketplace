@extends('layouts.login')

@section('title', 'Blank')

@section('content')
{{--    <div class="ibox-content">--}}
{{--        <div class="text-center">--}}
{{--            <h1>AGRABAH TRACEABILITY</h1>--}}
{{--        </div>--}}
{{--    </div>--}}

    <section class="container text-center">
        <div class="farmer-id mt-5">
            <div class="div">
                <img src="{{ URL::to('/images/agrabah-logo.png') }}" alt="agrabah-logo" class="logo img-fluid mt-3">
            </div>
            <div class="div">
                <img src="{{ URL::to($data->profile->qr_image_path) }}" alt="{{ $data->profile->qr_image_path }}" class="qr img-fluid mt-3">
            </div>
            <h4>{{ $data->profile->first_name }} {{ $data->profile->last_name }}</h4>
            <h3><strong>PID:</strong> {{ $data->account_id }}</h3>
        </div>
    </section>

@endsection

@section('styles')
    {{--{!! Html::style('') !!}--}}
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    <script>
        $(document).ready(function(){
            // window.print();
        });
    </script>
@endsection
