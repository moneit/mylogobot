@extends('layouts.page')

@section('title')
    <title>Packages | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="You can download your logo for free or get one of our Premium & Enterprise plans." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/packages.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('page')

    @include('components.header')

    @include('components.sidebar')

    <div id="app">
        <input type="checkbox" id="back-link" class="back-link" v-model="backLink"/>

        <div class="container mt-60">
            <div class="row">
                <div class="col-lg-4 d-flex flex-column">

                    <div class="bot-comment">
                        <div class="row">
                            <div class="col-3 d-flex flex-column justify-content-end">
                                <div class="d-lg-none">
                                    <img src="img/bot-head-mobile.svg" />
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="comment-container">
                                    <div class="comment color-primary">
                                        Here is your new logo! Now select your desired package and I will prepare it for you!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-none d-lg-block w-75">
                        @include('components.blinking_bot')
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 d-flex flex-column">
                            <div class="product-shadow-box">
                                <div class="product-container premium-product-container">
                                    <div class="d-flex flex-row">
                                        <div class="d-flex flex-column justify-content-between mr-20">
                                            <img src="/img/trophy.png" style="width: 50px;"/>
                                            <div class="color-primary fs-24 fw-bold">
                                                <span>$</span>&nbsp;<span>19</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="plan-name">Premium</div>
                                            <ul class="pl-20">
                                                <li>
                                                    High Resolution <span class="font-weight-bold">JPG</span> and <span class="font-weight-bold">PNG</span>
                                                </li>
                                                <li>
                                                    <span class="font-weight-bold">EPS</span>, <span class="font-weight-bold">PDF</span> and <span class="font-weight-bold">SVG</span> Vector Files
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-end mt-auto">
                                                <button class="btn btn-theme gradient-secondary-90 w-75" @click="selectPackage('premium')" id="btn-premium">Buy Premium</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ribbon">
                                        Popular Choice
                                    </div>
                                </div>
                            </div>
                            <div class="download-sample">
                                <a href="/download/0/premium_sample.zip">Download Premium sample file</a>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex flex-column">
                            <div class="product-shadow-box">
                                <div class="product-container enterprise-product-container">
                                    <div class="d-flex flex-row">
                                        <div class="d-flex flex-column justify-content-between mr-20">
                                            <img src="/img/skyscrapper.png" style="width: 50px;"/>
                                            <div class="color-primary fs-24 fw-bold">
                                                <span>$</span>&nbsp;<span>49</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="plan-name">Enterprise</div>
                                            <ul class="pl-20">
                                                <li>
                                                    High Resolution <span class="font-weight-bold">JPG</span> and <span class="font-weight-bold">PNG</span>
                                                </li>
                                                <li>
                                                    <span class="font-weight-bold">EPS</span>, <span class="font-weight-bold">PDF</span> and <span class="font-weight-bold">SVG</span> Vector Files
                                                </li>
                                                <li>
                                                    <span class="font-weight-bold">Social Media</span> pack
                                                </li>
                                                <li>
                                                    <span class="font-weight-bold">Professional Advice</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-end mt-auto">
                                                <button class="btn btn-theme gradient-secondary-90 w-75" @click="selectPackage('enterprise')" id="btn-enterprise">Buy Enterprise</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="download-sample">
                                <a href="/download/0/enterprise_sample.zip">Download Enterprise sample file</a>
                            </div>
                        </div>
                        <div class="col-12 mb-30">
                            <div class="product-shadow-box">
                                <div class="product-container basic-product-container">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <img class="w-100" v-if="jpgLink" :src="jpgLink" />
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="mt-20 mb-10 color-primary fs-24 fw-bold" style="line-height: 29px;">Review your logo</div>
                                            <div class="color-grey-light fw-300">Right click on the image and save or <span @click="selectPackage('basic')"  id="freedownload" class="pointer underlined">click here</span> to download the Free JPG demo file.</div>
                                            <div class="mt-60">
                                                <a class="btn btn-theme" href="{{ route('editor') }}"
                                                   @click="goToEditorPage">
                                                    Edit Logo
                                                </a>
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

        <loader></loader>

        <error-message-modal :open="showErrorMessageModal" :message="errorMessage" @update-open="updateShowErrorMessageModal"></error-message-modal>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/packages.js') }}"></script>
@endsection