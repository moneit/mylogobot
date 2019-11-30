<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes...
//$this->get('login', 'Auth\LoginController@showLoginForm')->name('login'); // embedded in landing page
$this->post('login', 'Auth\LoginController@login')->name('login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request'); // embedded in landing page
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
$this->get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
$this->get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
$this->get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('auth/social/{provider}',['as' => 'login.social','uses' => 'Auth\SocialAuthController@redirectToProvider']);
Route::get('social/redirect/{provider}',['as' => 'redirect.social','uses' => 'Auth\SocialAuthController@handleProviderCallback']);

Route::get('/',                 function () { return view('landing'); })->name('landing');
Route::get('/pricing',          function () { return view('pricing'); })->name('pricing');
Route::get('/faq',              function () { return view('faq'); })->name('faq');
Route::get('/about-us',         function () { return view('about_us'); })->name('about_us');
Route::get('/contact-us',       function () { return view('contact_us'); })->name('contact_us');
Route::get('/terms-of-service', function () { return view('terms_of_service'); })->name('terms_of_service');
Route::get('/privacy-policy',   function () { return view('privacy_policy'); })->name('privacy_policy');
Route::get('/conversation',     function () { return view('conversation'); })->name('conversation');
Route::get('/recommendations', function () { return view('recommendations'); })->name('recommendation');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/editor', function () { return view('editor'); })->name('editor');
    Route::get('/my-account/{tab?}', ['uses' => 'AccountController@get'])->name('my_account');
    Route::post('/my-account', ['uses' => 'AccountController@update'])->name('update_account');

    Route::get('/packages', function () { return view('packages'); })->name('packages');
    Route::get('/download/{logoId}/{fileName}', ['uses' => 'ProductController@download'])->name('download');
    Route::get('/download/{fileName}', ['uses' => 'ProductController@downloadFreeJpg'])->name('free-download');
    Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
    Route::get('/order/{orderId}', ['uses' => 'OrderController@show'])->name('order.show');

    Route::group(['middleware' => 'admin'], function() {
        Route::get('/admin', ['uses' => 'AdminController@index'])->name('admin');
        Route::get('/admin/login-as/{userId}', ['uses' => 'AdminController@loginUsingId'])->name('admin_login_as');
    });
});

Route::group(['middleware' => 'verified'], function() {

});

Route::post('/support', ['uses' => 'SupportController@support'])->name('support');

Route::post(
    '/webhook/stripe',
    'StripeWebhookController@handleWebhook'
);

Route::get('/debug-sentry', function () { // sentry test
    throw new Exception('My first Sentry error!');
});

Route::get('mailable', function () {
    $user = App\User::find(1);

    return new App\Mail\VerifyEmail($user);
});