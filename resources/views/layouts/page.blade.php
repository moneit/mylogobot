@extends('layouts.default')

@section('page')
    <div id="app">
        <input type="checkbox" id="sidebar-toggle" />

        <nav class="navbar navbar-top">
            <div class="container">
                @if (Auth::check())
                    <a class="d-none d-md-block btn btn-theme gradient-primary-90 mr-md-3 order-md-2 shadow-none pointer" href="/my-account">My Account</a>
                    <a class="d-md-none logobot-icon icon-user-o mr-2" href="/my-account"></a>
                @else
                    <label for="login-modal-toggle" class="d-none d-md-block btn btn-theme gradient-primary-90 mr-md-3 order-md-2 pointer">Sign In</label>
                    <label for="login-modal-toggle" class="d-md-none logobot-icon icon-user-o user-icon mr-2"></label>
                @endif
                <a class="navbar-brand ml-auto ml-md-0 mr-auto p-0 order-md-1" href="/" aria-label="myLogoBot">
                    <img src="/img/logo.svg" class="logo" alt="LogoBot" />
                </a>
                <label for="sidebar-toggle" class="sidebar-collapse order-md-3">
                    <i class="logobot-icon icon-hamburger color-primary pointer"></i>
                </label>
            </div>
        </nav>

        <nav id="sidebar" class="sidebar">
            <ul class="navbar-nav internal-links-list">
                <li class="nav-item">
                    <a href="{{ route('pricing') }}" class="navbar-text">Pricing</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faq') }}" class="navbar-text">FAQ</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about_us') }}" class="navbar-text">About</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact_us') }}" class="navbar-text">Contact Us</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="navbar-text" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
            <ul class="navbar external-links-list">
                <li class="nav-item">
                    <a href="{{ env('FACEBOOK_URL') }}" target="_blank" class="navbar-text">
                        <i class="logobot-icon icon-facebook-f"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ env('TWITTER_URL') }}" target="_blank" class="navbar-text">
                        <i class="logobot-icon icon-twitter"></i>
                    </a>
                </li>
            </ul>
        </nav>

        @yield('content')

        <!-- Footer -->
        <footer id="footer-app">
            <div class="container">
                <h1>Get Started!</h1>
                <p>
                    Fill in your company name, and get a new logo today!
                </p>
                <form>
                    <div class="row">
                        <div class="col-md-8 col-lg-4 offset-lg-3 col-sm-6 form-input form-group">
                            <input class="input-theme" placeholder="Start with your company name" v-model="companyName"/>
                        </div>
                        <div class="col-md-4 col-lg-2 col-sm-6 form-input form-group">
                            <button class="btn btn-theme gradient-secondary-90 btn-start" v-on:click.prevent="startConversation">Start Creating</button>
                        </div>
                    </div>
                </form>
            </div>
        </footer>

        <!-- Bottom Nav -->
        <nav class="navbar navbar-dark navbar-expand-md navbar-bottom">
            <a class="navbar-brand" href="/" aria-label="myLogoBot">
                <img src="/img/logo_reversed.svg" class="logo" alt="LogoBot" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ \Route::currentRouteName() === 'pricing' ? 'active' : ''}}">
                        <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
                    </li>
                    <li class="nav-item {{ \Route::currentRouteName() === 'faq' ? 'active' : ''}}">
                        <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item {{ \Route::currentRouteName() === 'about_us' ? 'active' : ''}}">
                        <a class="nav-link" href="{{ route('about_us') }}">About</a>
                    </li>
                    <li class="nav-item {{ \Route::currentRouteName() === 'contact_us' ? 'active' : ''}}">
                        <a class="nav-link" href="{{ route('contact_us') }}">Contact Us</a>
                    </li>
                    <li class="nav-item {{ \Route::currentRouteName() === 'my_account' ? 'active' : ''}}">
                        <a class="nav-link" href="{{ route('my_account') }}">My Account</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Grey Overlay element -->
        <label for="sidebar-toggle" class="overlay"></label>
    </div>

    @if (!Auth::check())
        @include('components.login-modal')
    @endif
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    @yield('page-scripts')

    <script src="{{ mix('/js/footer.js') }}"></script>
    @if (!Auth::check())
        <script src="{{ mix('/js/login-modal.js') }}"></script>
        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    @endif
@endsection