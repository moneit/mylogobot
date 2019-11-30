@extends('layouts.page')

@section('title')
    <title>Contact us | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Get in touch with our team if you need any assistance with your brand-new logo." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/contact_us.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('content')
    <div class="container content">

        <h1>Contact Us</h1>

        @if (session('message'))
            <p class="mb-3 text-center text-info @if (session('status') === 'success') text-success @elseif (session('status') === 'failure') text-error @endif">
                {{ session('message') }}
            </p>
        @endif

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('support') }}" method="post" class="contact-us shadow rounded">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="contact-email">E-mail</label>
                        <input type="email" class="form-control" id="contact-email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" required></textarea>
                    </div>

                    <div class="form-group g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}" data-badge="bottomleft"></div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-theme shadow-none">Send Message</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row info">
            <div class="col-md-3 text-center">
                <img src="/img/contact.png" />
                <div class="comment">
                    <div class="comment-title">
                        Live Support
                    </div>
                    <div class="comment-body">
                        Toll Free 800-650-0537
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <img src="/img/email.png" />
                <div class="comment">
                    <div class="comment-title">
                        E-mail
                    </div>
                    <div class="comment-body">
                        support@thelogopros.com
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <img src="/img/meeting-point.png" />
                <div class="comment">
                    <div class="comment-title">
                        Address
                    </div>
                    <div class="comment-body">
                        The Logo Pros<br>
                        Gafar Trading OÜ<br>
                        Sepapaja 6<br>
                        Tallinn 15551<br>
                        Estonia
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <img src="/img/clock.png" />
                <div class="comment">
                    <div class="comment-title">
                        Working Hours
                    </div>
                    <div class="comment-body">
                        Monday-Friday: 10AM-5PM GMT
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection