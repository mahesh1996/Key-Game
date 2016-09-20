<?php
use App\User;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'auth'], function() {
	Route::get('/home', 'UserController@homePage')->name('home');
	Route::get('/getData', 'UserController@prepareData')->name('getdata');
	Route::get('/clock', 'UserController@prepareClock');
	Route::get('/status', 'UserController@getUserStatus');
	Route::get('/wpmStartTime', 'UserController@getWpmStartTime');
	Route::get('/finish', 'UserController@finish');
	Route::get('/setStarted', function(){
		$user = Auth::User();
		$user->started = true;
		$user->save();
		return response()->json(['status' => 1]);
	});

});
Route::get('/',function() {
	return view('welcome');
})->name('keygame');

Route::get('/logout', 'HomeController@logout')->name('logout');
Route::get('/score', 'HomeController@score')->name('score');
Route::get('/updateScores', 'HomeController@updateScore');
Route::get('/login', 'HomeController@login')->name('login');

Route::post('/login', 'HomeController@doLogin');
Route::get('/test',function(){
	return json_encode(Carbon::now('Asia/Kolkata'));
});