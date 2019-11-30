@extends('layouts.page')

@section('title')
    <title>Recommendations | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Here is a list of all of our logo recommendations." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/recommendations.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('page')

    <div id="app">
        <template v-show="showLogos">
            @include('components.header')

            @include('components.sidebar')

            <input type="checkbox" id="back-link" class="back-link" v-model="backLink"/>

            <recommendations-mobile
                    v-if="isMobile"
                    class="blurable"
                    v-on:set-preview-settings="setPreviewSettings"
                    v-on:store-history-data="storeHistoryData"
            ></recommendations-mobile>

            <recommendations
                    v-else
                    class="blurable"
                    v-on:set-preview-settings="setPreviewSettings"
                    v-on:store-history-data="storeHistoryData"
            ></recommendations>

            @if (!Auth::check())

                <transparent-signup-modal-overlay
                        :open="showTransparentSignupForm"
                        v-on:update-open="updateShowTransparentSignupForm"
                >
                    <div class="row text-left rounded overflow-hidden">
                        <div class="col-lg-6 p-3" style="background-color: white;">
                            <div class="signup-form-container p-3">
                                <div class="row">
                                    <form action="{{ route('register') }}" method="post">
                                        @csrf
                                        <div class="col-12 fs-24 mb-30 color-primary">
                                            Before anything...
                                        </div>
                                        <div class="col-12 mb-60">
                                            Could you tell me <span class="font-weight-bold">to what email</span> should I send the logo files?
                                        </div>
                                        <form-input
                                                class="col-12" field="email" type="email" label="{{ __('Your email address') }}" error="{{ $errors->first('email') }}" value="{{ old('email') }}" required
                                        ></form-input>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-theme gradient-secondary-90 text-capitalize" type="submit">{{ __('submit') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <a href="{{ route('login.social', 'facebook') }}" class="btn btn-theme btn-facebook px-0">
                                                <i class="logobot-icon icon-facebook-f"></i>Use Facebook
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        {{--<a href="{{ route('login.social', 'google') }}" class="btn btn-theme btn-google px-0">--}}
                                        {{--<i class="logobot-icon icon-google"></i>Use Google--}}
                                        {{--</a>--}}
                                        <div class="form-group">
                                            <a href="{{ route('login.social', 'google') }}" class="google-login-link">
                                                <div style="height:47px;width:100%;" class="abcRioButton abcRioButtonLightBlue">
                                                    <div class="abcRioButtonContentWrapper">
                                                        <div class="abcRioButtonIcon" style="padding:14px">
                                                            <div style="width:18px;height:18px;" class="abcRioButtonSvgImageWithFallback abcRioButtonIconImage abcRioButtonIconImage18">
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg">
                                                                    <g>
                                                                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                                                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                                                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                                                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                                                        <path fill="none" d="M0 0h48v48H0z"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <span style="font-size:15px;line-height:45px;" class="abcRioButtonContents">
                                                    <span id="not_signed_inwhj0s3ttqd7" style="">Sign in with Google</span>
                                                </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-1 text-center">
                                    <h6>
                                        By proceeding you accept our <a href="{{ route('terms_of_service') }}" class="p-0">Terms of Use</a> and <a class="p-0" href="{{ route('privacy_policy') }}">Privacy Policy</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex">
                            <div class="bot-background-container" style="flex: 1;"></div>
                        </div>
                    </div>
                </transparent-signup-modal-overlay>
            @endif

            <recommendations-failure-modal
                    :open='showRecommendationsFailureModal'
                    :message='recommendationsErrorMessage'
                    @update-open='updateShowRecommendationsFailureModal'
            ></recommendations-failure-modal>

            @include('components.logo_preview')
        </template>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/recommendations.js') }}"></script>
@endsection