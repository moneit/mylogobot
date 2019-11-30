@extends('layouts.page')

@section('title')
    <title>Pricing | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Select between the FREE, Premium and Enterprise packages." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/pricing.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('content')
    <div id="pricing-app" class="container content">

        <h1>Pricing</h1>

        <div class="mobile-nav d-md-none">
            <div>
                <div>
                    <input type="radio" name="tab" id="free" value="free" v-model="activeTab">
                    <label for="free">Free</label>
                </div>
                <div>
                    <input type="radio" name="tab" id="premium" value="premium" v-model="activeTab">
                    <label for="premium">Premium</label>
                </div>
                <div>
                    <input type="radio" name="tab" id="enterprise" value="enterprise" v-model="activeTab">
                    <label for="enterprise">Enterprise</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container mb-3">
                <div class="row rounded shadow text-center overflow-hidden">
                    <div class="col-md-4 product-container" v-show="isDesktop || activeTab === 'free'">
                        <div class="image-container">
                            <img src="/img/hot-dog.png" />
                        </div>
                        <h3>Basic</h3>
                        <h5>For small business or for inspiration to your designer</h5>
                        <div class="details">
                            <div>
                                <p>JPG and PNG file</p>
                                <p>High resolution</p>
                                {{--<h3>Free</h3>--}}
                                {{--<button class="btn btn-theme gradient-secondary-90 w-75" @click="selectPackage('basic')">Download</button>--}}
                            </div>
                            <div>
                                <h3>Free</h3>
                                <button class="btn btn-theme gradient-secondary-90 w-75" @click="selectPackage('basic')">Buy Basic</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 product-container" v-show="isDesktop || activeTab === 'premium'">
                        <div class="image-container">
                            <img src="/img/trophy.png" />
                        </div>
                        <h3>Premium</h3>
                        <h5>For those who needs a full package of hi-res assets</h5>
                        <div class="details">
                            <div>
                                <p>Everything from Basic Package</p>
                                <p>+ Vector files for printing</p>
                                <p>(SVG, EPS & PDF)</p>
                                <p>+ Font Pairing</p>
                            </div>
                            <div>
                                <h3>$ 19</h3>
                                <button class="btn btn-theme gradient-secondary-90 w-75" @click="selectPackage('premium')">Buy Premium</button>
                            </div>
                        </div>
                        <div class="ribbon">
                            Popular Choice
                        </div>
                    </div>
                    <div class="col-md-4 product-container" v-show="isDesktop || activeTab === 'enterprise'">
                        <div class="image-container">
                            <img src="/img/skyscrapper.png" />
                        </div>
                        <h3>Enterprise</h3>
                        <h5>For companies who need more than just a simple logo</h5>
                        <div class="details">
                            <div>
                                <p>Everything in Premium package</p>
                                <p>+ Brand Guide</p>
                                <p>Social Media pack</p>
                            </div>
                            <div>
                                <h3>$ 49</h3>
                                <button class="btn btn-theme gradient-secondary-90 w-75" @click="selectPackage('enterprise')">Buy Enterprise</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <start-modal
                :open="showStartModal"
                @update-open="updateShowStartModal"
        ></start-modal>
    </div>
@endsection

@section('page-scripts')
    <script src='{{ mix('/js/pricing.js') }}'></script>
@endsection