@extends('layouts.app')

@section('content')

    <main class="page-forms">
        <div class="row no-gutters sign-in">
            <div class="col-12 col-lg-4 left d-none d-lg-flex" style="background-image: url({{ asset('images/loan/bg-img-3.png') }})">
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
                </div>

                {{--                <a href="{{ asset('/') }}" class="link">Back to homepage</a>--}}
                <div class="copyright">Powered by Agrabah Ventures</div>

            </div>
            <div class="col-12 col-lg-8 right d-flex align-items-center justify-content-center">
                <div class="content w-100">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid d-block mx-auto logo mb-5 d-block d-lg-none">
                    <h1 class="title">Trace Login</h1>
                    <small>Log on using your login and password or use social media login to enter</small>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="">Please type your email address</label>
                            <input id="email" type="email" name="email" placeholder="yourname@domain.com" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">and your password</label>
                            <div class="group">
                                <input id="password" type="password" name="password" placeholder="*****" class=" @error('password') is-invalid @enderror" required autocomplete="current-password">
                                <i class="far fa-eye-slash eye"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {{--<div class="form-check">--}}
                            {{--<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

                            {{--<label class="form-check-label" for="remember">--}}
                            {{--{{ __('Remember Me') }}--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            <div class="check-group">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember"><span>{{ __('Remember Me') }}</span></label>
                            </div>
                        </div>

                        {{--<div class="line"><small>or</small></div>--}}

                        {{--<small class="d-flex justify-content-center">Log in with</small>--}}

                        {{--<div class="social-container">--}}
                        {{--<a href=""><img src="img/icon-google.png" alt="icon-google"></a>--}}
                        {{--<a href=""><img src="img/icon-facebook.png" alt="icon-facebook"></a>--}}
                        {{--<a href=""><img src="img/icon-twitter.png" alt="icon-twitter"></a>--}}
                        {{--</div>--}}

                        <button type="submit" class="btn-submit">Login</button>

                        {{--<a href="" class="link d-flex justify-content-center">Forgot password?</a>--}}

{{--                        <div class="register-text text-center">Not registered yet? <a href="/registration">Sign up</a> now!</div>--}}
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div class="container d-none">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    {{--                                @if (Route::has('password.request'))--}}
                                    {{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                    {{--                                        {{ __('Forgot Your Password?') }}--}}
                                    {{--                                    </a>--}}
                                    {{--                                @endif--}}

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
