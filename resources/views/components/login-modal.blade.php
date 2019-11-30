<input type="checkbox" id="login-modal-toggle" @if (request('signin') === 'true' || ($errors->has('email') || $errors->has('password'))) checked @endif/>

<label for="login-modal-toggle" class="overlay"></label>

<input type="checkbox" id="reset-password-toggle" />

<!-- Login Modal -->
<div id="login-modal" class="login-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Sign In</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="row">
                        <form-input
                                class="col-12"
                                field="email"
                                type="email"
                                label="{{ __('Your email') }}"
                                error="{{ $errors->first('email') }}"
                                value="{{ old('email') }}"
                                required
                                autofocus
                        ></form-input>
                        <form-input
                                class="col-12"
                                field="password"
                                type="password"
                                label="{{ __('Your password') }}"
                                error="{{ $errors->first('password') }}"
                                required
                        ></form-input>
                        <div class="col-12">
                            <button class="btn btn-theme gradient-secondary-90">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="buttons-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <a href="{{ route('login.social', 'facebook') }}" class="btn btn-theme btn-facebook px-0">
                                    <i class="logobot-icon icon-facebook-f"></i>Use Facebook
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{--<a href="{{ route('login.social', 'google') }}" class="btn btn-theme btn-google px-0">--}}
                                {{--<i class="logobot-icon icon-google"></i>Use Google--}}
                                {{--</a>--}}
                                <a href="{{ route('login.social', 'google') }}">
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
                </div>
                <div class="pt-3 color-primary">
                    <label for="reset-password-toggle" class="link-primary">
                        <h6 style="text-decoration: underline;">I forgot my password</h6>
                    </label>
                </div>
                <div class="pt-1 color-primary">
                    <h6>
                        Not registered?&nbsp;
                        <a href="{{ route('register') }}" class="link-primary">
                            <strong>Sign up now</strong>
                        </a>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Reset Modal -->
<div id="reset-password-modal" class="reset-password-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mb-4">
                <h3>Reset Password</h3>
            </div>
            <div class="modal-body mb-4">
                <div class="color-primary mb-4">
                    Tell us your email and we will send you a reset password link
                </div>
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="row">
                        <form-input
                                id="reset-pwd-email"
                                class="col-12"
                                field="email"
                                type="email"
                                label="{{ __('Your email') }}"
                                error="{{ $errors->first('email') }}"
                                value="{{ old('email') }}"
                                required
                        ></form-input>
                        <div class="col-12">
                            <button class="btn btn-theme gradient-secondary-90"> Reset Password </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer mb-4">
                <div class="color-primary">
                    <label for="reset-password-toggle" class="link-primary">
                        <h6>
                            <i class="logobot-icon icon-angle-left"></i>
                            &nbsp;<strong>Back</strong>
                        </h6>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>