@extends(subdomain_name().'.master')

{{--@section('title', 'Dashboard | '.getRoleName('display_name'))--}}
@section('title', 'Dashboard')

@section('content')

    <section class="container animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <a href="{{ route('farmer-login') }}">
                    <div class="widget style1 blue-bg">
                        <div class="row">
                            <div class="col-4 text-center">
                                <i class="fa fa-list-alt fa-5x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Add Inventory </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="{{ route('farmer.index') }}">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Farmers </span>
                                <h2 class="font-bold">{{ $farmer }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="{{ route('inventory.index') }}">
                    <div class="widget style1 lazur-bg">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-th-list fa-5x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Inventories </span>
                                <h2 class="font-bold">{{ $inventory }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="{{ route('trace.index') }}">
                    <div class="widget style1 yellow-bg">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-truck fa-5x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Trace </span>
                                <h2 class="font-bold">{{ $trace }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-4">
{{--                <div class="panel panel-success">--}}
{{--                    <div class="panel-heading">--}}
{{--                        {{ $type }}--}}
{{--                    </div>--}}
{{--                    <div class="panel-body">--}}
{{--                        <h2>Head Office</h2>--}}
{{--                        <h4>subdomain: {{ $subdomain }}</h4>--}}
{{--                        <h4>domain: {{ $domain }}</h4>--}}
{{--                        <h4>domain ext: {{ config('dev.domain_ext') }}</h4>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
@endsection

@section('scripts')
    {{--{!! Html::script('') !!}--}}
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
