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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/video', 'VideosController@index');
Route::get('/video/upload', 'VideosController@create');
Route::post('/video', 'VideosController@store');
Route::put('/video/{id}', 'VideosController@update');
Route::delete('/video/{id}', 'VideosController@update');

