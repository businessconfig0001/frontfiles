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

Route::get('/index', function () {
    return view('index');
});
Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/video', 'VideosController@index');
Route::get('/video/upload', 'VideosController@create');
Route::get('/video/{video}', 'VideosController@show');
Route::post('/video', 'VideosController@store');
Route::patch('/video/{video}', 'VideosController@update');
Route::delete('/video/{video}', 'VideosController@destroy');