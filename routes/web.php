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

    /*
    Route::get('/testing', function(){
        Mail::send('emails.test', [], function($message) {
            $message
                ->from('no-reply@mailer.frontfiles.com', 'FrontFiles')
                ->to('andre@businessconfig.com', 'André Botelho')
                ->subject('From SparkPost with ❤');
        });
        return 'Worked!';
    });
    */
});

/**
 * Auth routes
 */
Route::group([
    'namespace' => 'Auth'
], function () {
    //Authentication Routes
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');

    //Registration Routes
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'RegisterController@register')->name('register');

    //Password Reset Routes
    Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.reset');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.reset.email');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.token');
});

/**
 * Profile routes
 */
Route::group([
    'prefix'    => 'profile',
    'namespace' => 'Profile',
], function () {

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/', 'ProfileController@index')->name('profile');
        Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
        Route::get('/dropbox', 'ProfileController@dropbox')->name('profile.dropbox');
        Route::get('/dropbox/callback', 'ProfileController@dropboxCallback')->name('profile.dropbox.callback');
        Route::patch('/', 'ProfileController@update')->name('profile.update');
        Route::delete('/', 'ProfileController@destroy')->name('profile.delete');
    });

    Route::get('/{slug}', 'ProfileController@show')->name('profile.show');
});

/**
 * Files routes
 */
Route::group([
    'prefix'    => 'files',
    'namespace' => 'Files',
], function () {

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/', 'FilesController@index')->name('files');
        Route::post('/', 'FilesController@store')->name('files');
        Route::get('/upload', 'FilesController@create')->name('files.upload');
        Route::patch('/{file}', 'FilesController@update')->name('files.update');
        Route::delete('/{file}', 'FilesController@destroy')->name('files.delete');
        Route::get('/download/{file}', 'FilesController@downloadFile')->name('files.download-file');
    });

    Route::get('/{short_id}', 'FilesController@show')->name('files.show');
});

/**
 * Admin routes
 */
Route::group([
    'prefix'        => 'backend',
    'namespace'     => 'Backend',
    'middleware'    => ['auth', 'admin'],
], function () {
    Route::get('/', 'BackendController@index')->name('backend');
    Route::get('/download/{file}', 'BackendController@downloadFile')->name('backend.download-file');
});