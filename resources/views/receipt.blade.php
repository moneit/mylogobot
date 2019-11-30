@extends('layouts.page')

@section('title')
    <title>Receipt | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Here's a receipt of your logo order." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/receipt.css') }}">
@endsection

@section('google-event-snippets')
    <!-- Event snippet for Sale conversion page -->
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-736164065/0R7FCJ6PkqUBEOHxg98C',
            'value': {{ $order->package->price }},
            'currency': 'USD',
            'payment_intent_id': '{{ $order->payment_intent_id }},'
        });
    </script>
@endsection

@section('page')

    @include('components.header')

    @include('components.sidebar')

    <div id="app">
        <div class="fill-entire bot-comment py-5">
            <div class="container">
                <div class="row">
                    <div class="col-4 col-md-2 col-lg-1">
                        <img src="/img/bot.png" class="bot">
                    </div>
                    <div class="col-8 col-md-10 col-lg-11">
                        <div class="comment-container">
                            <div class="comment">
                                @if($order->status === 'succeeded')
                                    Thank you for the purchase! You can view your receipt and download your new logo below. Hope to see you soon!
                                @else
                                    Sorry but your payment is not confirmed yet. Your product will be generated as soon as it is confirmed.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($order->status === 'succeeded')
        <div class="fill-half">
            <div class="container">
                <div class="row rounded details shadow text-center mb-3">
                    <div class="col-md-6 receipt">
                        <h3 class="color-primary">Receipt</h3>
                        <div class="info-box mb-3">
                            <div class="row mb-2">
                                <div>Date</div>
                                <div>{{ $order->created_at->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-2">
                                <div>User</div>
                                <div>{{ $order->user->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div>Order ID</div>
                                <div>#{{ $order->id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div>Payment Method</div>
                                <div>{{ $order->card }}</div>
                            </div>
                            <div class="row mb-2">
                                <div>Item</div>
                                <div class="text-capitalize">{{ $order->package->name }} Package</div>
                            </div>
                            <div class="row color-secondary total">
                                <div>Total</div>
                                <div class="text-capitalize">{{ $order->currencySymbol->symbol }} {{ $order->price }}</div>
                            </div>
                        </div>
                        <p>
                            This receipt was also sent to your e-mail {{ $order->user->email }}
                        </p>
                    </div>
                    <div class="col-md-6 logo">
                        <h3 class="color-primary">Your logo</h3>
                        <div class="logo-container">
                            <div class="logo">
                                {!! $order->logo->svg !!}
                            </div>
                        </div>
                        <button class="btn btn-theme gradient-secondary-90 w-75 my-3" @click="download({{ $order->id }})">Download Package</button>
                        {{--<button class="btn btn-theme btn-outline-grey w-75 mb-3">Download Invoice</button>--}}
                        <a class="btn btn-theme btn-outline-grey w-75" href="{{ route('my_account', [ 'tab' => 'orders']) }}">View all orders</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <error-message-modal
                :open="showErrorMessageModal"
                :message="errorMessage"
                @update-open="updateShowErrorMessageModal"
        ></error-message-modal>

        <loader></loader>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/receipt.js') }}"></script>
@endsection