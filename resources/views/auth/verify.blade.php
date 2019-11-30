@extends('layouts.page')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/email_verification.css') }}">
@endsection

@section('page')
    <div id="app">
        <div class="fill-entire">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 pt-5 pb-4 text-center">
                        <img src="/img/logo_reversed.svg" class="logo pt-5 pb-4" alt="LogoBot" />
                    </div>
                </div>
            </div>
        </div>
        <div class="fill-half">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center color-primary">
                                <h3>
                                    {{ __('Verify Your Email Address') }}
                                </h3>
                            </div>

                            <div class="card-body text-center">
                                <p>
                                    {{ __('Before proceeding, please check your email for a verification link.') }}
                                </p>
                                @if (session('resent'))
                                    <p>
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                                <p>
                                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection