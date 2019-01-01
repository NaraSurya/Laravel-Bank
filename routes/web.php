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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('users')->group(function(){
    Route::get('index','UserController@index')->name('users.index');
    Route::post('register','UserController@store')->name('users.store');
    Route::get('edit','UserController@edit')->name('users.edit');
    Route::get('fired/{id}','UserController@fired')->name('users.fired');
    Route::post('update','UserController@update')->name('users.update');
});

Route::prefix('members')->group(function(){
    Route::resource('member', 'MemberController');
});

