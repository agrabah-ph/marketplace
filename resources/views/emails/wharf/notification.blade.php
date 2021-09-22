<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>


    <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('images/favicon.png') }}" rel="apple-touch-icon-precomposed">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .btn{
            background-color: #548714;
            width: 9em;
            text-align: center;
            text-decoration: none;
            display: block;
            margin: auto;
            color: #fff;
            outline: none;
            border: 0;
            font-size: 1.1rem;
            padding: 0.8rem;
            border-radius: 5px;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            cursor: pointer;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="m-0">
@php
if(!isset($data)){
    $data['name'] = 'TEST PRODUCT';
    $data['price'] = 'XXXXXX';
}
@endphp
    <h1 style="color: #548714">Congratulations! You've won the bid!</h1>
    <p>Winning <b>{{$data['name']}}</b> for <b>{{$data['price']}}</b>, please go to the community leader to complete the transaction.</p>
    <p><a class="btn btn-primary" href="{{route('spot-market.my_bids')}}">Click here</a></p>
</body>
</html>
