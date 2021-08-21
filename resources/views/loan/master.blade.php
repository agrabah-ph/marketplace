<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ subdomain_title(null) }} | @yield('title')</title>
    <title>Loan | @yield('title')</title>

    {{--    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::to('/favicon_io/apple-touch-icon.png') }}">--}}
    {{--    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/favicon_io/favicon-32x32.png') }}">--}}
    {{--    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/favicon_io/favicon-16x16.png') }}">--}}
    {{--    <link rel="manifest" href="{{ URL::to('/favicon_io/site.webmanifest') }}">--}}

    {!! Html::style('/css/app.css') !!}
    {!! Html::style('/css/styles.css') !!}
{{--    {!! Html::style('/css/template/bootstrap.min.css') !!}--}}
    {!! Html::style('/font-awesome/css/font-awesome.css') !!}
    @yield('styles')
    {!! Html::style('/css/template/animate.css') !!}
    {!! Html::style('/css/template/style.css') !!}
    <style>
        @media screen {
            #printable {
                display: none;
            }
            #wrapper {
                display: flex;
            }
        }
        @media print {
            #printable {
                display: block;
            }
            #wrapper {
                display: none;
            }
        }

    </style>

</head>

<body class="pace-done template-loan">

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">

                <li class="nav-header">
                    <div class="dropdown profile-element">
                        {{--                        <img alt="image" class="rounded-circle" src="/img/profile_small.jpg"/>--}}
                        {{--                        <img alt="image" class="rounded-circle profile-pic" src="{{ authProfilePic(Auth::user()->id) }}"/>--}}
                        {{--<img alt="image" class="rounded-circle profile-pic" src="/img/blank-profile.jpg"/>--}}
                        <img alt="image" class="img-fluid" src="{{ asset('images/logo.png') }}"/>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            {{--                            <span class="block m-t-xs font-bold">{!! Auth::user()->name !!}</span>--}}
                            {{--                            <span class="text-muted text-xs block">{{ getRoleName('display_name') }} <b class="caret"></b></span>--}}
                            {{--<span class="text-muted text-xs block"> {{ getRoleName('display_name') }} <b class="caret"></b></span>--}}
{{--                            <span class="text-muted text-xs block"> {!! Auth::user()->name !!} <b class="caret"></b></span>--}}
                            <span class="block m-t-xs font-bold">{!! Auth::user()->name !!}</span>
                            <small class="text-xs block">{{ getRoleName('display_name') }} <b class="caret"></b></small>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="{{ route('my-profile') }}">Profile</a></li>
{{--                            <li><a class="dropdown-item" href="#">Contacts</a></li>--}}
{{--                            <li><a class="dropdown-item" href="#">Mailbox</a></li>--}}
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item btn-logout" href="#" id="">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        Loan
                    </div>
                </li>

                @include(subdomain_name().'.menu')

            </ul>

        </div>
        <div class="version"><div class="long">Agrabah Finance v.01</div><div class="short">v.01</div></div>
    </nav>

    <div id="page-wrapper" class="gray-bg">

        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                    {{-- slot for search bar --}}
                    <div class="mobile-logo">
                        <img alt="image" class="img-fluid" src="{{ asset('images/logo.png') }}"/>
                    </div>

                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message"><strong class="text-mams-blue">Welcome</strong> <strong class="text-mams-gray">to</strong> <strong class="text-mams-red">{!! config('app.name') !!}</strong>.</span>
                    </li>

                    {{-- slot for mail notification --}}

                    {{-- slot for general notification --}}

                    <li>
                        <a href="#" class="btn-logout"> <i class="fa fa-sign-out"></i> <span>Log out</span> </a>
                    </li>
                </ul>

            </nav>
        </div>

        @include('flash::message')

        <div id="app">
            @yield('content')
        </div>

        <div class="footer">
            <div class="copyright">
                <p>Powered by Agrabah Ventures</p>
                <p>Powered by Agrabah Loan</p>
            </div>
        </div>

    </div>
    {{ Form::open(array('route' => 'logout', 'class' => 'sr-only', 'id' => 'form-logout')) }}
    @csrf
    {{ Form::close() }}
</div>


<div id="printable">

</div>

<!-- Mainly scripts -->
{!! Html::script('/js/app.js') !!}
{{--{!! Html::script('/js/template/jquery-3.1.1.min.js') !!}--}}
{!! Html::script('/js/template/popper.min.js') !!}
{!! Html::script('/js/template/bootstrap.js') !!}
{!! Html::script('/js/template/plugins/metisMenu/jquery.metisMenu.js') !!}
{!! Html::script('/js/template/plugins/slimscroll/jquery.slimscroll.min.js') !!}

<!-- Custom and plugin javascript -->
{!! Html::script('/js/template/inspinia.js') !!}
{!! Html::script('/js/template/plugins/pace/pace.min.js') !!}

@yield('scripts')

<script>

    $(document).on('click', '.print_trigger',function (){
        $("#printable").empty();
        var printable = $(this).data("print_target");
        printElem($(printable).clone())
    });
    // print_trigger
    // print_target
    // paymentSchedules
    function printElem(data){
        $('#printable').html(data);
        window.print();
    }
</script>


</body>
</html>
