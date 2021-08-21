<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ subdomain_title(null) }}</title>


    <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('images/favicon.png') }}" rel="apple-touch-icon-precomposed">

    {!! Html::style('/css/app.css') !!}
    {!! Html::style('/css/template/style.css') !!}
{{--    {!! Html::style('/css/styles.css') !!}--}}
    {!! Html::style('/font-awesome/css/font-awesome.css') !!}
    {!! Html::style('/css/template/animate.css') !!}
{{--    {!! Html::style('/css/template/style.css') !!}--}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body style="background: #FFFFFF">

<div id="app">

    @yield('content')

</div>


{!! Html::script('/js/app.js') !!}
{!! Html::script('/js/template/popper.min.js') !!}
{!! Html::script('/js/template/plugins/metisMenu/jquery.metisMenu.js') !!}
{!! Html::script('/js/template/plugins/slimscroll/jquery.slimscroll.min.js') !!}

@yield('scripts')

<script src="{{ URL::to('/js/template/inspinia.js') }}"></script>
<script src="{{ URL::to('/js/template/plugins/pace/pace.min.js') }}"></script>
</body>
</html>
