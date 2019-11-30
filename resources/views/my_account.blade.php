@extends('layouts.page')

@section('title')
    <title>My Account | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Edit your Account Details for the Logo Bot Platform. Find all saved logos and you order history." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/my_account.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('page')
    <div id="app">
        @include('components.header')

        @include('components.sidebar')

        @if(session('verified'))
            <div class="alert alert-success" role="alert">
                Thank you! Your Account is now verified.
            </div>
        @endif

        <div class="mobile-nav d-md-none">
            <ul class="nav nav-tabs nav-fill" id="tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if(is_null($tab) || $tab==='info')active @endif" id="info-tab" href="#info" data-toggle="tab" role="tab" aria-controls="info" aria-selected="true">My Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($tab==='logos')active @endif" id="logos-tab" href="#logos" data-toggle="tab" role="tab" aria-controls="logos" aria-selected="false">Saved Logos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($tab==='orders')active @endif" id="orders-tab" href="#orders" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">Order History</a>
                </li>
            </ul>
        </div>

        <div class="fill-half">
            <div class="container pt-md-5 pb-md-5">
                <div class="card p-3 pt-md-5 pb-md-4">
                    <div class="row">
                        <div class="col-md-3 d-none d-md-flex flex-column justify-content-between text-center pt-3 desktop-nav">
                            <ul class="nav flex-column nav-pills" id="tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if(is_null($tab) || $tab==='info')active @endif" id="info-tab" href="#info" data-toggle="tab" role="tab" aria-controls="info" aria-selected="true">My Account</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab==='logos')active @endif" id="logos-tab" href="#logos" data-toggle="tab" role="tab" aria-controls="logos" aria-selected="false">Saved Logos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab==='orders')active @endif" id="orders-tab" href="#orders" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">Order History</a>
                                </li>
                            </ul>
                            <a class="btn btn-theme ml-3 mr-3" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade @if(is_null($tab) || $tab==='info')show active @endif" id="info" role="tabpanel" aria-labelledby="home-tab">
                                    <form method="post" action="{{ route('update_account') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <h3 class="color-primary">
                                                    Personal Details
                                                </h3>
                                                <div class="row">
                                                    <form-input
                                                            class="col-md-12" field="name" type="text" label="{{ __('Your name') }}" error="{{ $errors->first('name') }}" value="{{ $user->name }}"
                                                    ></form-input>
                                                </div>
                                                <div class="row">
                                                    <form-input
                                                            class="col-md-6" field="email" type="email" label="{{ __('Your email') }}" error="{{ $errors->first('email') }}" value="{{ $user->email }}"
                                                    ></form-input>
                                                    <form-input
                                                            class="col-md-6" field="vat" type="number" label="{{ __('VAT number') }}" error="{{ $errors->first('vat') }}" value="{{ optional($user->account)->vat ?? '' }}"
                                                    ></form-input>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <h3 class="color-primary">
                                                    Change Password
                                                </h3>
                                                <div class="row">
                                                    <form-input class="col-12" field="password" type="password" label="{{ __('Your password') }}" error="{{ $errors->first('password') }}"></form-input>
                                                </div>

                                                <div class="row">
                                                    <form-input class="col-12" field="password_confirmation" type="password" label="{{ __('Confirm your password') }}"></form-input>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <h3 class="color-primary">
                                                    Location
                                                </h3>
                                                <div class="row">
                                                    <country-selector
                                                            class="col-md-5" error="{{ $errors->first('country') }}" value="{{ optional($user->account)->country->name ?? '' }}"
                                                    ></country-selector>
                                                    <form-input
                                                            class="col-md-4" field="state" type="text" label="{{ __('State / Region / Province') }}" error="{{ $errors->first('state') }}" value="{{ optional($user->account)->state ?? '' }}"
                                                    ></form-input>
                                                    <form-input
                                                            class="col-md-3" field="city" type="text" label="{{ __('City') }}" error="{{ $errors->first('city') }}" value="{{ optional($user->account)->city ?? '' }}"
                                                    ></form-input>
                                                </div>
                                                <div class="row">
                                                    <form-input
                                                            class="col-md-9" field="address" type="text" label="{{ __('Address') }}" error="{{ $errors->first('address') }}" value="{{ optional($user->account)->address ?? '' }}"
                                                    ></form-input>
                                                    <form-input
                                                            class="col-md-3" field="postal_code" type="number" label="{{ __('Zip Code') }}" error="{{ $errors->first('postal_code') }}" value="{{ optional($user->account)->postal_code ?? '' }}"
                                                    ></form-input>
                                                </div>
                                            </div>
                                            <div class="offset-md-9 col-md-3">
                                                <button class="btn btn-theme gradient-primary-90 w-100" type="submit">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade @if($tab==='logos')show active @endif" id="logos" role="tabpanel" aria-labelledby="profile-tab">
                                    <h3 class="color-primary" style="margin-bottom: 18px;">
                                        Saved Logos
                                    </h3>
                                    <div class="saved-logos-container overflow-auto">
                                        <saved-logos></saved-logos>
                                    </div>
                                    <div class="row">
                                        <div class="offset-md-9 col-md-3">
                                            <a href="{{ route('landing') }}" class="btn btn-theme gradient-primary-90 w-100 mt-3" >Make a new logo</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if($tab==='orders')show active @endif" id="orders" role="tabpanel" aria-labelledby="contact-tab">
                                    <h3 class="color-primary" style="margin-bottom: 18px;">
                                        Order History
                                    </h3>
                                    <div class="order-history-table-container overflow-auto">
                                        <div class="order-history-table">
                                            @if(count($orders))
                                                <div class="row mb-3">
                                                    <div class="col-1">#</div>
                                                    <div class="col-3">Date</div>
                                                    <div class="col-3">Item</div>
                                                    <div class="col-3">Total</div>
                                                    <div class="col-2"></div>
                                                </div>
                                                @foreach($orders as $order)
                                                    <div class="row">
                                                        <div class="col-1">{{ $order->id }}</div>
                                                        <div class="col-3">{{ $order->created_at->format('d/m/Y') }}</div>
                                                        <div class="col-3 text-capitalize">{{ $order->package->name }} Package</div>
                                                        <div class="col-3">{{ $order->currencySymbol->symbol }} {{ $order->price }}</div>
                                                        <div class="col-2 text-center">
                                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-theme btn-details d-none d-md-block">Details</a>
                                                            <a href="{{ route('order.show', $order->id) }}" class="btn-details-mobile color-primary d-md-none">
                                                                <i class="logobot-icon icon-info-o"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                You did not make any orders yet.
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-md-9 col-md-3">
                                            <a href="{{ route('landing') }}" class="btn btn-theme gradient-primary-90 w-100 mt-3" >Make a new logo</a>
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ mix('/js/my_account.js') }}"></script>
@endsection