@extends('layouts.page')


@section('title')
    <title>#1 Free Logo Maker with AI | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Make a logo, 100% Free with the only Logo Maker available online that is powered by Google's AI. Download the files for free." />
    <meta name="google-signin-client_id" content="1062982315474-3rdar0umrmd1navl5h8e1hkmg91epahh.apps.googleusercontent.com" />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/landing.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('content')
    <div id="landing-app">

        <!-- Top Section -->
        <section class="section-top">
            <div class="container">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-3 d-md-none"></div>
                    <div class="col-6 order-md-last d-flex align-items-center">
                        <div class="bot-container w-100">
                            <div class="bot">
                                @include('components.blinking_bot')
                            </div>
                        </div>
                    </div>
                    <div class="col-3 d-md-none"></div>

                    <div class="col-md-6 start-form-container">
                        <form id="company-name-form" class="company-name-form">
                            <h1>The Only Free Online Logo Maker</h1>
                            <h2>Build your logo with assistance from our robot</h2>
                            <div class="row form-group mb-0">
                                <div class="col-lg-8 mb-3 form-input" :class="inputClass">
                                    <i class="logobot-icon icon-play"></i>
                                    <input class="input-theme" placeholder="What's your company name?" v-model="companyName" ref="input"/>
                                </div>
                                <div class="col-lg-8 mb-3 order-lg-last input-helper">Please, input with your company name before we get started</div>
                                <div class="col-lg-4 mb-3 form-input">
                                    <button class="btn btn-theme gradient-secondary-90" @click.prevent="startConversation">Make my logo!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials">
            <div class="testimonials-desktop d-none d-md-block">
                <div class=" container">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Over 200+ satisfied customers</h2>
                            <div class="separator background-secondary"></div>
                        </div>
                        <div class="col-md-8">
                            <div class="testimonials-container">
                                <carousel :items="testimonials"></carousel>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonials-mobile d-md-none">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Over 200+ satisfied customers</h2>
                            <div class="separator background-secondary"></div>
                        </div>
                        <div class="col-md-8">
                            <div class="testimonials-container">
                                <carousel :items="testimonials"></carousel>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="samples" class="py-5 text-center">
            <h2 class="color-primary">
                Get Inspired!
            </h2>
            <h3>
                These are the best rated logos made with Logo.Bot
            </h3>
            <div class="separator background-secondary my-3"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3" v-for="(path, idx) in goodLogoPaths" :key="idx" @click="openGoodLogoModal(path)">
                        <div class="sample-logo" :style="`background-image: url(${path})`"></div>
                    </div>
                </div>
            </div>
            <good-logos-modal
                    :open="showGoodLogoModal"
                    :img-path="selectedLogoPath"
                    @update-open="updateShowGoodLogoModal"
            ></good-logos-modal>
        </section>

        <section id="steps" class="p-5 text-center">
            <h2 class="color-primary">
                The Online Logo Maker that actually works
            </h2>
            <h3>
                Build your Logo by feeding some details to our BOT
            </h3>
            <div class="separator background-secondary my-3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <picture>
                            <source srcset="/img/landing/step1.webp" type="image/webp">
                            <source srcset="/img/landing/step1.png" type="image/png">
                            <img src="/img/landing/step1.png" alt="">
                        </picture>
                        <h4 class="color-primary">
                            Step 1
                        </h4>
                        <p>
                            Give our bot some information about your company and your personal preferences
                        </p>
                    </div>
                    <div class="col-md-4">
                        <picture>
                            <source srcset="/img/landing/step2.webp" type="image/webp">
                            <source srcset="/img/landing/step2.png" type="image/png">
                            <img src="/img/landing/step2.png" alt="">
                        </picture>
                        <h4 class="color-primary">
                            Step 2
                        </h4>
                        <p>
                            Let our bot create a few logos based on your given information. You can edit one of them if you want.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <picture>
                            <source srcset="/img/landing/step3.webp" type="image/webp">
                            <source srcset="/img/landing/step3.png" type="image/png">
                            <img src="/img/landing/step3.png" alt="">
                        </picture>
                        <h4 class="color-primary">
                            Step 3
                        </h4>
                        <p>
                            Select your desired package and download your brand new logo!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="delivered" class="background-primary p-5 color-white text-center">
            <h2>
                10.275
            </h2>
            <h3>
                Logos delivered
            </h3>
            <div class="separator background-secondary my-3"></div>
            <p>
                We deliver much more than what a logo designer would
            </p>
        </section>

        <section id="mockup">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 order-md-last">
                        <h2 class="color-primary">
                            Let’s create your brand new logo today!
                        </h2>
                        <h3>
                            What is your company name?
                        </h3>
                        <div class="row form-group mb-0">
                            <div class="col-lg-8 mb-3 form-input">
                                <input class="input-theme" placeholder="Your company name" v-model="companyName" ref="input"/>
                            </div>
                            <div class="col-lg-4 mb-3 form-input">
                                <button class="btn btn-theme gradient-secondary-90" @click.prevent="startConversation">Make my logo!</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img class="w-100" src="/img/landing/mockup.png" />
                    </div>
                </div>
            </div>
        </section>

        <section id="info" class="p-5">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4">
                        <img src="/img/landing/free-logo-maker-icon.png" />
                        <h3 class="color-primary">
                            Free Logo Maker
                        </h3>
                        <p>
                            Most designers would charge you hundreds of dollars for consulting fees. Our bot provides you logo suggestions free of charge.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/landing/hires-files-icon.png" />
                        <h3 class="color-primary">
                            High-Resolution Files
                        </h3>
                        <p>
                            All files are in high-resolution to serve any needs: websites, flyers or stickers.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/landing/full-copy-icon.png" />
                        <h3 class="color-primary">
                            Full Copyrights
                        </h3>
                        <p>
                            After the purchase, the logo is yours. You can use it for any purpose and register it commercially.
                        </p>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <img src="/img/landing/seamless-conversation-icon.png" />
                        <h3 class="color-primary">
                            Seamless Conversation
                        </h3>
                        <p>
                            You will build your logo by chatting with our Logo BOT. BOT is your friend and is here to assist you step-by-step in your logo development process.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/landing/endless-logo-icon.png" />
                        <h3 class="color-primary">
                            Endless Logo Designs
                        </h3>
                        <p>
                            You can generate endless logo designs and variations. You will only have to pay if you need to download the logo files.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/landing/social-media-icon.png" />
                        <h3 class="color-primary">
                            Social Media Kit
                        </h3>
                        <p>
                            You will receive 50 variations of your logo design for the most popular social channels.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('page-scripts')
    <script src="{{ mix('/js/landing.js') }}"></script>
@endsection