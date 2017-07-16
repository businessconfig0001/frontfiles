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

Route::get('/files', 'FilesController@index');
Route::get('/files/upload', 'FilesController@create');
Route::post('/files', 'FilesController@store');
Route::get('/files/{short_id}', 'FilesController@show');
Route::patch('/files/{file}', 'FilesController@update');
Route::delete('/files/{file}', 'FilesController@destroy');