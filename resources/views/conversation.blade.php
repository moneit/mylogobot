@extends('layouts.page')

@section('title')
    <title>Conversation | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Chat with BOT to provide the details for your company logo." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/conversation.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('page')

    @include('components.header')

    @include('components.sidebar')

    <div id="app" class="container">
        <input type="checkbox" id="back-link" class="back-link" v-model="backLink"/>
    </div>

    <div id="bot-chat-app" class="container">
        <div class="row">
            <div class="col-6 d-none d-md-flex">
                <div class="bot-container">
                    @include('components.blinking_bot')
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex">
                <div class="flex-fill d-flex flex-column justify-content-center" id="bot-ui-chat">
                    <div class="bot-ui-box">
                        <bot-ui></bot-ui>
                        {{--<conversation></conversation>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/conversation.js') }}"></script>
@endsection