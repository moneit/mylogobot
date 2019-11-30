const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/conversation.js', 'public/js')
    .js('resources/js/landing.js', 'public/js')
    .js('resources/js/register.js', 'public/js')
    .js('resources/js/password_reset.js', 'public/js')
    .js('resources/js/my_account.js', 'public/js')
    .js('resources/js/editor.js', 'public/js')
    .js('resources/js/recommendations.js', 'public/js')
    .js('resources/js/packages.js', 'public/js')
    .js('resources/js/checkout.js', 'public/js')
    .js('resources/js/receipt.js', 'public/js')
    .js('resources/js/faq.js', 'public/js')
    .js('resources/js/pricing.js', 'public/js')
    .js('resources/js/dashboard.js', 'public/js')
    .js('resources/assets/js/vat_calculator.js', 'public/js')
    .js('resources/js/footer.js', 'public/js')
    .js('resources/js/login-modal.js', 'public/js')
    .extract(['vue'])

    .sass('resources/sass/pages/email_verification.scss', 'public/css')
    .sass('resources/sass/pages/conversation.scss', 'public/css')
    .sass('resources/sass/pages/landing.scss', 'public/css')
    .sass('resources/sass/pages/register.scss', 'public/css')
    .sass('resources/sass/pages/password_reset.scss', 'public/css')
    .sass('resources/sass/pages/my_account.scss', 'public/css')
    .sass('resources/sass/pages/editor.scss', 'public/css')
    .sass('resources/sass/pages/recommendations.scss', 'public/css')
    .sass('resources/sass/pages/packages.scss', 'public/css')
    .sass('resources/sass/pages/contact_us.scss', 'public/css')
    .sass('resources/sass/pages/terms_of_service.scss', 'public/css')
    .sass('resources/sass/pages/about_us.scss', 'public/css')
    .sass('resources/sass/pages/faq.scss', 'public/css')
    .sass('resources/sass/pages/pricing.scss', 'public/css')
    .sass('resources/sass/pages/privacy_policy.scss', 'public/css')
    .sass('resources/sass/pages/checkout.scss', 'public/css')
    .sass('resources/sass/pages/receipt.scss', 'public/css')
    .sass('resources/sass/pages/dashboard.scss', 'public/css')
    .copyDirectory('resources/img', 'public/img')
    .copyDirectory('resources/css/icomoon', 'public/css/icomoon');

if (mix.inProduction()) {
    mix.version();
}
