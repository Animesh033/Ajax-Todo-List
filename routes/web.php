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
    return view('welcome');
});
Route::get('list', 'TodoListController@index');
Route::post('list', 'TodoListController@store');
Route::post('delete', 'TodoListController@delete');
Route::post('update', 'TodoListController@update');
Route::get('search', 'TodoListController@search');

