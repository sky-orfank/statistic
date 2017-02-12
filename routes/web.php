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

Auth::routes();

Route::get('/admin/login', function ()    {
    return view('auth.login');
});

Route::group(['middleware' => 'admin'], function () {
	Route::get('/admin', 'Admin\DashboardController@index');
	Route::get('/admin/statistic', 'Admin\DashboardController@index');
	Route::get('/admin/statistic/{page_id}', 'Admin\DashboardController@getPageStatistic');
});

Route::get('/', function ()    {
    return redirect()->to('/page/1');
});

Route::group(['middleware' => 'visitor'], function () {
    Route::get('/page/{id}', 'HomeController@getTestPage');    
});
