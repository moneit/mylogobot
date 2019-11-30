@extends('layouts.page')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/password_reset.css') }}">
@endsection

@section('page')
    <div id="app">
        <div class="fill-entire">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 pt-5 pb-4 text-center">
                        <img src="{{ mix('/img/logo_reversed.svg') }}" class="logo pt-5 pb-4" alt="LogoBot" />
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
                                    {{ __('Reset Password') }}
                                </h3>
                            </div>

                            <div class="card-body mt-n3">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="row">
                                        <form-input class="col-12" field="email" type="text" label="{{ __('Your email') }}" error="{{ $errors->first('email') }}" value="{{ old('email') }}" required></form-input>
                                    </div>

                                    <div class="row">
                                        <form-input class="col-12" field="password" type="password" label="{{ __('Your password') }}" error="{{ $errors->first('password') }}" required></form-input>
                                    </div>

                                    <div class="row">
                                        <form-input class="col-12" field="password_confirmation" type="password" label="{{ __('Confirm your password') }}" required></form-input>
                                    </div>


                                    <div class="row mb-0">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-theme gradient-primary-90">
                                                {{ __('Reset Password') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/password_reset.js') }}"></script>
@endsection
