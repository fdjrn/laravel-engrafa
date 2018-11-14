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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('login','Auth\LoginController@index');
// Route::post('login','Auth\LoginController@doLogin');

// Route::get('forgot','Auth\ForgotPasswordController@index');
// Route::any('logout','Auth\LogoutController@index')->name('logout');
// Route::get('register','Auth\RegisterController@index');

Auth::routes();

Route::middleware(['auth','web'])->group(function () {
	// Route::get('/home', 'HomeController@index')->name('home');

	// Route::get('/', 'HomeController@index');
	Route::get('/','Dashboard\DashboardController@index');

	// index & file explorer
	Route::get('/index','Index\IndexController@index')->name('index');
	Route::get('/index/detail','Index\IndexDetailController@index')->name('index.detail');
	Route::get('/fileexplorer','FileExplorer\FileExplorerController@index');

	// chat
	Route::get('/chat','Chat\ChatController@index');
	Route::get('/chat/invite','Chat\ChatController@invite');

	// survey
	Route::get('/survey','Survey\SurveyController@index')->name('survey');
	Route::get('/survey/add/question','Survey\SurveyController@addQuestion')->name('survey.add.question');
	Route::get('/survey/add/question/test','Survey\SurveyController@test');
	Route::get('/survey/choose/answer', 'Survey\SurveyController@chooseAnswer')->name('survey.choose.answer');
});

//DocumentViewer Library
Route::any('ViewerJS/{all?}', function(){

    return View::make('ViewerJS.index');
});
