@extends('layouts.app')

@section('content')

    <main class="page-forms">
        <div class="row no-gutters sign-in">
            <div class="col-12 col-lg-4 left d-none d-lg-flex" style="background-image: url({{ asset('images/loan/bg-img-5.png') }})">
                <div>
                    <a href="{{ asset('/') }}">
                        <img src="{{ asset('images/agrabah-logo.png') }}" alt="logo" class="img-fluid d-block mx-auto logo">
                    </a>
                    {{--<div class="content">--}}
                    {{--<h2>{{ config('app.name', 'Laravel') }}</h2>--}}

                    {{--<ul>--}}
                    {{--<li>Easy To Use</li>--}}
                    {{--<li>Report Generator</li>--}}
                    {{--<li>Join us now</li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}

                    <div class="copyright">Powered by Agrabah Ventures</div>
                </div>

                {{--                <a href="{{ asset('/') }}" class="link">Back to homepage</a>--}}

            </div>
            <div class="col-12 col-lg-8 right d-flex align-items-center justify-content-center">
                <div class="content w-100">
                    <img src="{{ asset('/images/logo.png') }}" alt="logo" class="img-fluid d-block mx-auto logo mb-5 d-block d-lg-none">
                    <h1 class="title"><span class="text-primary">Agrabah Wharf</span> Registration</h1>
{{--                    <small>Log on using your login and password or use social media login to enter</small>--}}


                    {!! Form::open(array('route'=>array('wharf-user-registration-store'))) !!}
                    <div class="form-group">
                        <label>User type</label>
                        <select name="type" class="form-control" style="height: 48px !important;">
                            <option value="">Select</option>
                            @foreach($app_registrant as $role)
                            <option value="{{$role->role->name}}">{{$role->role->display_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('type'))
                            <span class="text-danger">{{$errors->first('type')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Please type your email address</label>
                        {{Form::email('email',null, array('class'=>'form-control', 'placeholder'=>'yourname@domain.com', 'autocomplete'=>'off', 'required', 'autofocus'))}}
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        {{Form::password('password', array('class'=>'form-control password-field', 'placeholder'=>'*****'))}}
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Repeat Password</label>
                        {{Form::password('repeat-password', array('class'=>'form-control password-field', 'placeholder'=>'*****'))}}
                        @if($errors->has('repeat-password'))
                            <span class="text-danger">{{$errors->first('repeat-password')}}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">Register</button>

                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </main>

@endsection
