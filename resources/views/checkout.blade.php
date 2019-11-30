@extends('layouts.page')

@section('title')
    <title>Checkout | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Fill-in your details and download your logo files." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/checkout.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('page')

    @include('components.header')

    @include('components.sidebar')

    <div id="app">
        <input type="checkbox" id="back-link" class="back-link" v-model="backLink"/>

        <div class="fill-entire bot-comment">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        Checkout
                    </div>
                </div>
            </div>
        </div>

        <div v-if="isMobile">
            <div class="container">
                <checkout-mobile pk="{{ env('STRIPE_KEY') }}"></checkout-mobile>
            </div>
        </div>

        <div class="fill-half" v-else>
            <div class="container">
                <checkout pk="{{ env('STRIPE_KEY') }}"></checkout>
            </div>
        </div>

        <div class="text-center my-4">
            <img src="/img/powered_by_stripe.png" />
        </div>

        <loader></loader>
    </div>
@endsection

@section('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}"></script>
    <script src="{{ mix('/js/vat_calculator.js') }}"></script>
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/checkout.js') }}"></script>
@endsection