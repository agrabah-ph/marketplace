@extends('layouts.app')

@section('content')
<div class="verify-email-template">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="body">
                        <h1>{{ __('Verify Your Email Address') }}</h1>


                        <p class="text-1">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                        </p>
                        <p class="text-2">{{ __('If you did not receive the email') }},</p>

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>

                @if (session('resent'))
                    <div class="alert alert-success mt-5" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
