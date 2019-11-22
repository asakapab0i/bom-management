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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    Route::get('/bom', 'Bom\BomController@index');
    Route::get('/bom/{id}', 'Bom\BomController@show');
    Route::post('/bom/{id}', 'Bom\BomController@edit');
    Route::post('/bom', 'Bom\BomController@store');

    Route::get('/hardware', 'Bom\HardwareController@index');
    Route::get('/hardware/{id}', 'Bom\HardwareController@show');
    Route::post('/hardware/{id}', 'Bom\HardwareController@edit');
    Route::post('/hardware', 'Bom\HardwareController@store');

    Route::get('/material', 'Bom\MaterialController@index');
    Route::get('/material/{id}', 'Bom\MaterialController@show');
    Route::post('/material/{id}', 'Bom\MaterialController@edit');
    Route::post('/material', 'Bom\MaterialController@store');
    Route::get('/material_categories', 'Bom\MaterialController@material_categories');
    Route::get('/hardware_categories', 'Bom\HardwareController@hardware_categories');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
