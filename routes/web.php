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
    Route::get('show-fired','UserController@showFired')->name('users.showFired');
});

Route::prefix('members')->group(function(){
    Route::resource('member', 'MemberController');
    Route::get('active','MemberController@active')->name('member.active');
    Route::get('non-active','MemberController@nonActive')->name('member.nonActive');
    Route::post('active-non-active/{member}','MemberController@controlActive')->name('member.controlActive');
    route::get('search','MemberController@search')->name('member.search');
});

Route::prefix('deposits')->group(function(){
    Route::get('deposit/','DepositController@index')->name('deposit.index');
    Route::get('deposit/{id}','DepositController@show')->name('deposit.show');
    route::get('search','DepositController@search')->name('deposit.search');
    route::post('member-deposit','DepositController@deposit')->name('deposit');
    route::post('member-withdrawal','DepositController@withdrawal')->name('withdrawal');
});

Route::prefix('master-interest')->group(function(){
    Route::get('index','MasterInterestController@index')->name('masterInterest.index');
    Route::post('store','MasterInterestController@store')->name('masterInterest.store');
    Route::delete('destroy/{masterInterest}','MasterInterestController@destroy')->name('masterInterest.destroy');
    Route::post('update/{masterInterest}','MasterInterestController@update')->name('masterInterest.update');
});

Route::prefix('calculation-interest')->group(function(){
    Route::get('index','CalculationInterestController@index')->name('calculationInterest.index');
    Route::post('store','CalculationInterestController@store')->name('calculationInterest.store');
});

Route::prefix('monthly-report')->group(function(){
    Route::get('index','MonthlyReportController@index')->name('monthlyReport.index');
    Route::post('seacrh-month','MonthlyReportController@search')->name('monthlyReport.search');
});

Route::prefix('annual-report')->group(function(){
    Route::get('index','AnnualReportController@index')->name('annualReport.index');
    Route::post('seacrh-annual','AnnualReportController@search')->name('annualReport.search');
});

Route::prefix('weekly-report')->group(function(){
    Route::get('index','WeeklyReportController@index')->name('weeklyReport.index');
    Route::post('seacrh-annual','WeeklyReportController@search')->name('weeklyReport.search');
});

