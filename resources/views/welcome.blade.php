<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ subdomain_title('ucwords') }}</title>


        <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon">
        <link href="{{ asset('images/favicon.png') }}" rel="apple-touch-icon-precomposed">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*html, body {*/
                /*background-color: #fff;*/
                /*color: #636b6f;*/
                /*font-family: 'Nunito', sans-serif;*/
                /*font-weight: 200;*/
                /*height: 100vh;*/
                /*margin: 0;*/
            /*}*/

            /*.full-height {*/
                /*height: 100vh;*/
            /*}*/

            /*.flex-center {*/
                /*align-items: center;*/
                /*display: flex;*/
                /*justify-content: center;*/
            /*}*/

            /*.position-ref {*/
                /*position: relative;*/
            /*}*/

            /*.top-right {*/
                /*position: absolute;*/
                /*right: 10px;*/
                /*top: 18px;*/
            /*}*/

            /*.content {*/
                /*text-align: center;*/
            /*}*/

            /*.title {*/
                /*font-size: 84px;*/
            /*}*/

            /*.links > a {*/
                /*color: #636b6f;*/
                /*padding: 0 25px;*/
                /*font-size: 13px;*/
                /*font-weight: 600;*/
                /*letter-spacing: .1rem;*/
                /*text-decoration: none;*/
                /*text-transform: uppercase;*/
            /*}*/

            /*.m-b-md {*/
                /*margin-bottom: 30px;*/
            /*}*/
        </style>
    </head>
    <body class="m-0">
        {{--<div class="flex-center position-ref full-height">--}}
            {{--@if (Route::has('login'))--}}
                {{--<div class="top-right links">--}}
                    {{--@auth--}}
                        {{--<a href="{{ url('/home') }}">Home</a>--}}
                    {{--@else--}}
                        {{--<a href="{{ route('login') }}">Login</a>--}}

                        {{--@if (Route::has('register'))--}}
                            {{--<a href="{{ route('register') }}">Register</a>--}}
                        {{--@endif--}}
                    {{--@endauth--}}
                {{--</div>--}}
            {{--@endif--}}

            {{--<div class="content">--}}
                {{--<p>Welcome to:</p>--}}
                {{--<div class="title m-b-md">--}}
                    {{--AGRABAH TRACE--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <main class="page-welcome full-height">

            <section class="header">
                <div class="header-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid">
                </div>
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                            @else
                            <a href="{{ route('login') }}">Login</a>

{{--                        @if (Route::has('register'))--}}
{{--                            <a href="{{ route('register') }}">Register</a>--}}
{{--                        @endif--}}
                        @endauth
                    </div>
                @endif
            </section>

            <section class="section-content">
                <h3>Welcome to</h3>
                <h1 class="title">{{ subdomain_title(null) }}</h1>

                <div class="boxes">
                    <ul>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </section>

        </main>
    </body>
</html>
