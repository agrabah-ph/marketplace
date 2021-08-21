<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Trace | @yield('title')</title>
{{--    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">--}}
{{--    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">--}}
{{--    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">--}}
{{--    <link rel="manifest" href="/favicon_io/site.webmanifest">--}}

    {!! Html::style('/css/app.css') !!}
    {!! Html::style('/font-awesome/css/font-awesome.css') !!}
    {!! Html::style('/css/template/animate.css') !!}
    {!! Html::style('/css/template/style.css') !!}

    @yield('styles')
</head>

<body class="gray-bg">

<div id="app">

    @yield('content')

</div>


<!-- Mainly scripts -->
{!! Html::script('/js/app.js') !!}
{!! Html::script('/js/template/popper.min.js') !!}
{!! Html::script('/js/template/plugins/metisMenu/jquery.metisMenu.js') !!}
{!! Html::script('/js/template/plugins/slimscroll/jquery.slimscroll.min.js') !!}

@yield('scripts')
<!-- Custom and plugin javascript -->
{!! Html::script('/js/template/inspinia.js') !!}
{!! Html::script('/js/template/plugins/pace/pace.min.js') !!}
</body>

</html>
