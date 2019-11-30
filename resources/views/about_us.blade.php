@extends('layouts.page')

@section('title')
    <title>About | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Find more about the Logo Bot tool and the reasons of its creation." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/about_us.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('content')
    <div class="container content">

        <h1>About Us</h1>

        <div class="row">
            <div class="col-md-4 offset-md-4">
                <img src="/img/about-bot.png" class="about-us-bot"/>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="motif">
                    What?
                </div>
                <div>
                    <p>
                        <a href="{{ route('landing') }}" class="color-primary font-weight-bold">Logo.Bot</a> is a web tool developed with the ambition of providing a glimpse of what Artificial Intelligence can bring to B2B tasks that currently cost hundreds if not thousands of dollars
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="motif">
                    Why?
                </div>
                <div>
                    <p>
                        In specific, our aim is to <strong>simplify the logo making process.</strong> There are other tools available online but we felt these missed the spirit and the enchantment of what AI should be.
                    </p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-8 offset-md-2">
                <div class="motif">
                    How?
                </div>
                <div>
                    <p>
                        With <a href="{{ route('landing') }}" class="color-primary font-weight-bold">Logo.Bot</a> you can have a conversation with our charming BOT and see his recommendations for your company logo.
                    </p>
                    <p>
                        Unlike other design systems, our BOT will learn through time and better understand your desire when building a logo.  Therefore, if you didn’t find a logo that you’re passionate with today, make sure you retry in a few weeks as the BOT will have processed much more data.
                    </p>
                    <p>
                        If you want to change your logo after the conversation is done, you can do it through our versatile editor. You can also reach our staff through the <a href="{{ route('contact_us') }}" class="color-secondary" style="text-decoration: underline;">contact form</a> and we’ll be glad to further assist you with any details on your logo.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="motif">
                    Who?
                </div>
                <p>
                    We are a start-up with headquarters in Estonia, Europe. Here’s our small but growing team:
                </p>
                <div class="text-center">
                    <div class="mb-3">
                        <div class="name">
                            Muhammad Satar
                        </div>
                        <div class="description">
                            CEO
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="name">
                            Miguel Sousa
                        </div>
                        <div class="description">
                            Project Manager & Marketing Specialist
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="name">
                            Tauan Vivekananda
                        </div>
                        <div class="description">
                            UX/UI Designer
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="name">
                            Rasim Davis
                        </div>
                        <div class="description">
                            Super-Hero-Full-Stack Developer
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="name">
                            BOT
                        </div>
                        <div class="description">
                            Always Learning Assistant
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection