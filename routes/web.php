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
Route::post('/login', function(){
    return view('login_folder.login');
});
Route::get('/login', function(){
    return view('login_folder.login');
});
Route::post('/reserve','ReserveController@reserve_date');
Route::get('/reserve','ReserveController@redirect_index');
Route::post('/reserve/next_reserve_date','ReserveController@next_reserve_date');
Route::get('/reserve/next_reserve_date','ReserveController@redirect_index');
Route::post('/reserve/reservation_time','ReserveController@reserve_time');
Route::get('/reserve/reservation_time','ReserveController@redirect_index');
Route::post('/reserve/infomation','ReserveController@reserve_info');
Route::get('/reserve/infomation','ReserveController@redirect_index');
Route::post('/reserve/confirm_form','ReserveController@confirm_form_data');
Route::get('/reserve/infomation','ReserveController@redirect_index');

Route::post('/reserve/complete','ReserveController@complete_reservation');
Route::get('/reserve/complete','ReserveController@redirect_index');
Route::get('/reserve/complete/display','ReserveController@complete_display');
