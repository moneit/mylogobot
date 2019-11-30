<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.'], function (){

//    Route::get('/user', function (Request $request) { return $request->user(); });

    Route::group(['prefix' => '/countries', 'as' => 'countries.'], function () {
        Route::get('/',             ['as' => 'list',                'uses' => 'API\CountriesController@index']);
        Route::get('/names',        ['as' => 'names',               'uses' => 'API\CountriesController@getNames']);
    });

    Route::group(['prefix' => '/color', 'as' => 'color.'], function () {
        Route::get('/list',         ['as' => 'list',                'uses' => 'API\ColorController@index']);
        Route::get('/palette',      ['as' => 'palette',             'uses' => 'API\ColorController@palette']);
        Route::get('/categories',   ['as' => 'colorCategories',     'uses' => 'API\ColorController@getCategories']);
    });

    Route::group(['prefix' => '/recommendations', 'as' => 'recommendations.'], function () {
        Route::post('/',            ['as' => 'get',                 'uses' => 'API\RecommendationController@getLogos']);
    });

    Route::group(['prefix' => '/recommendation-tracks', 'as' => 'recommendationTracks.'], function () {
        Route::get('/',            ['as' => 'get',                 'uses' => 'API\RecommendationTrackController@get']);
    });

    Route::group(['prefix' => '/font', 'as' => 'font.'], function () {
        Route::get('/paths',        ['as' => 'paths',               'uses' => 'API\FontController@paths']);
        Route::get('/bounds',       ['as' => 'bounds',              'uses' => 'API\FontController@bounds']);
        Route::get('/horiz-adv-x',  ['as' => 'horizAdvX',           'uses' => 'API\FontController@horizAdvX']);
        Route::get('/list',         ['as' => 'list',                'uses' => 'API\FontController@index']);
    });

    Route::group(['prefix' => '/icon', 'as' => 'icon.'], function () {
        Route::post('/list',        ['as' => 'list',                'uses' => 'API\IconController@index']);
        Route::get('/paths',        ['as' => 'paths',               'uses' => 'API\IconController@getImagePaths']);
    });

    Route::group(['prefix' => '/container', 'as' => 'container.'], function () {
        Route::get('/list',         ['as' => 'list',                'uses' => 'API\ContainerController@index']);
        Route::get('/data',         ['as' => 'data',                'uses' => 'API\ContainerController@data']);
    });

    Route::group(['middleware' => 'auth:api'], function() {

        Route::group(['prefix' => '/logo', 'as' => 'logo.'], function () {
            Route::get('/',             ['as' => 'get',                 'uses' => 'API\LogoController@get']);
            Route::post('/',            ['as' => 'store',               'uses' => 'API\LogoController@store']);
            Route::get('/saved',        ['as' => 'saved',               'uses' => 'API\LogoController@listByUser']);
            Route::get('/{logo}/settings', ['as' => 'saved',            'uses' => 'API\LogoController@getSettings']);
        });

        Route::group(['prefix' => '/packages', 'as' => 'packages.'], function () {
            Route::get('/',             ['as' => 'get',                 'uses' => 'API\PackagesController@get']);
            Route::get('/names',        ['as' => 'names',               'uses' => 'API\PackagesController@getNames']);
        });

        Route::group(['prefix' => '/account', 'as' => 'account.'], function () {
            Route::get('/',             ['as' => 'get',                 'uses' => 'API\AccountController@get']);
        });

        Route::group(['prefix' => '/payment', 'as' => 'payment.'], function () {
            Route::post('/intent',      ['as' => 'intent',              'uses' => 'API\PaymentController@intent']);
            Route::post('/confirm',     ['as' => 'confirm',             'uses' => 'API\PaymentController@confirm']);
            Route::post('/verify-paypal-transaction', ['as' => 'verify-paypal', 'uses' => 'API\PaymentController@verifyPalpalTransaction']);
        });

        Route::group(['prefix' => '/coupon', 'as' => 'coupon.'], function () {
            Route::post('/apply',       ['as' => 'apply',               'uses' => 'API\CouponController@apply']);
        });

        Route::group(['prefix' => '/free-downloads', 'as' => 'freeDownloads.'], function () {
            Route::post('/',            ['as' => 'create',              'uses' => 'API\FreeDownloadController@create']);
        });

        Route::group(['prefix' => '/orders', 'as' => 'orders.'], function () {
            Route::get('/',             ['as' => 'list',                'uses' => 'API\OrderController@get']);
            Route::get('/details',      ['as' => 'get',                 'uses' => 'API\OrderController@getDetails']); // todo: update by show
            Route::post('/',            ['as' => 'create',              'uses' => 'API\OrderController@create']);
            Route::post('{order}/link',  ['as' => 'product.link', 'uses' => 'API\OrderController@getGenDownloadLink']);
            Route::post('{order}/resend',['as' => 'product.resend', 'uses' => 'API\OrderController@resend']);
        });

        Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
            Route::get('/',             ['as' => 'list',                'uses' => 'API\UserController@get']);
            Route::get('/emails',       ['as' => 'emails.get',          'uses' => 'API\UserController@getEmailList']);
            Route::get('/names',        ['as' => 'names.get',           'uses' => 'API\UserController@getNameList']);
            Route::get('/details',      ['as' => 'names.get',           'uses' => 'API\UserController@getDetails']);
        });

        Route::group(['prefix' => '/palettes', 'as' => 'palettes.'], function () {
            Route::post('/',            ['as' => 'store',               'uses' => 'API\PaletteController@store']);
        });

        Route::group(['prefix' => '/color-palette', 'as' => 'colorPalette.'], function () {
            Route::post('/',            ['as' => 'store',               'uses' => 'API\ColorPaletteController@store']);
        });

        Route::group(['prefix' => '/color-category-palette', 'as' => 'colorCategoryPalette.'], function () {
            Route::post('/',            ['as' => 'store',               'uses' => 'API\ColorCategoryPaletteController@store']);
        });

        Route::group(['prefix' => '/font-recommendations-icon-logo', 'as' => 'fontRecommendationsIconLogo.'], function () {
            Route::post('/',            ['as' => 'store',               'uses' => 'API\FontRecommendationsIconLogoController@store']);
        });

        Route::group(['prefix' => '/font-recommendations-initials-logo', 'as' => 'fontRecommendationsInitialsLogo.'], function () {
            Route::post('/',            ['as' => 'store',               'uses' => 'API\FontRecommendationsInitialsLogoController@store']);
        });

        Route::group(['prefix' => '/font-recommendations-typography-logo', 'as' => 'fontRecommendationsTypographyLogo.'], function () {
            Route::post('/',            ['as' => 'store',               'uses' => 'API\FontRecommendationsTypographyLogoController@store']);
        });
    });
});