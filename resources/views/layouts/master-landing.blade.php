<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('og')

    <title>{{ subdomain_title(null) }}</title>
    <link href="{{ asset('images/landing/favicon.png') }}"  type="image/png" rel="shortcut icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">


    <!-- Styles -->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body>

@include('landing.inc.navbar')

@yield ('content')


@include('landing.inc.footer')

</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<script src="{{ asset('js/landing.js') }}" defer></script>



@yield('scripts')
</html>
