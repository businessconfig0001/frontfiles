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

/**
 * Homepage routes
 */
Route::group([
    'namespace' => 'Home'
], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/index', 'HomeController@main')->name('main');
});

/**
 * Auth routes
 */
Route::group([
    'namespace' => 'Auth'
], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('auth.login');
    Route::post('/login', 'LoginController@login')->name('auth.login');
    Route::post('/logout', 'LoginController@logout')->name('auth.logout');
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('auth.register');
    Route::post('/register', 'RegisterController@register')->name('auth.register');
    Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('auth.password.reset');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset.email');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('auth.password.reset.token');
});

/**
 * Files routes
 */
Route::group([
    'middleware' => 'auth',
    'prefix' => 'files',
    'namespace' => 'Files'
], function () {
    Route::get('/', 'FilesController@index')->name('files');
    Route::post('/', 'FilesController@store')->name('files');
    Route::get('/upload', 'FilesController@create')->name('files.upload');
    Route::get('/{short_id}', 'FilesController@show')->name('files.show');
    Route::patch('/{file}', 'FilesController@update')->name('files.update');
    Route::delete('/{file}', 'FilesController@destroy')->name('files.delete');
});