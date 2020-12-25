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


Route::get('/{slug}', 'PostController@show')->name('post.show');
Route::get('/', 'PostController@index')->name('post.index');
Route::resource('post', 'PostController')->except(['index', 'show']);
