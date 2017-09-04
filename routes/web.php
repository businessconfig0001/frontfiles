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
    Route::get('/watermark', function(){

        $ffmpeg = FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]);

        $format = (new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
            ->setKiloBitrate(300);

        $video = $ffmpeg->open(public_path('userFiles/').'small.mp4');

        $video->filters()
            ->resize(new \FFMpeg\Coordinate\Dimension(550, 550))
            ->watermark(public_path('watermarks/watermark.png'), [
                'position' => 'relative',
                'top' => 10,
                'right' => 10,
            ])
            ->synchronize();

        $video->save($format, public_path('userFiles/').'processed_small.mp4');

        /*
        FFMpeg::fromDisk('local')
            ->open('small.mp4')
            ->addFilter(['-vf', 'scale=250:250'])
            ->addFilter(['-i', asset('watermarks/watermark.png'), '-filter_complex', 'overlay=main_w-overlay_w-10:10'])
            ->addFilter(['-strict', 1])
            ->export()
            ->toDisk('local')
            ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
            ->save('processed_small.mp4');

        FFMpeg::cleanupTemporaryFiles()
        */

        return 'OK!';
    });
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
 * Profile routes
 */
Route::group([
    'prefix' => 'profile',
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
    'prefix' => 'files',
    'namespace' => 'Files',
    'middleware' => 'auth',

], function () {
    Route::get('/', 'FilesController@index')->name('files');
    Route::post('/', 'FilesController@store')->name('files');
    Route::get('/upload', 'FilesController@create')->name('files.upload');
    Route::get('/{short_id}', 'FilesController@show')->name('files.show');
    Route::patch('/{file}', 'FilesController@update')->name('files.update');
    Route::delete('/{file}', 'FilesController@destroy')->name('files.delete');
});