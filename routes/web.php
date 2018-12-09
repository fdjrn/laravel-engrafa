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

	// dashboard
	Route::get('/','Dashboard\DashboardController@index');
	Route::post('/','Dashboard\DashboardController@store')->name('dashboard.post');

	// index & file explorer
	Route::get('/index','Index\IndexController@index')->name('index');
	Route::get('/index/detail','Index\IndexDetailController@index')->name('index.detail');
    Route::get('/index/list-all','Index\IndexController@getListAll');
    Route::get('/index/list-all/{id}','Index\IndexController@getListDetail');
    Route::get('/index/list-all-previous/{id}','Index\IndexController@getListAllPrevious');
    Route::get('/index/list-folder','Index\IndexController@getListFolder');
    Route::get('/index/list-folder/{id}','Index\IndexController@getListFolderDetail');
    Route::get('/index/list-folder-previous/{id}','Index\IndexController@getListPreviousFolder');
    Route::post('/index/create-new-folder/{id}','Index\IndexController@createNewFolder');
    Route::post('/index/upload-files','Index\IndexController@uploadFiles');

	Route::get('/fileexplorer','FileExplorer\FileExplorerController@index');

	// chat
	Route::get('/chat','Chat\ChatController@index');
	Route::get('/chat/invite','Chat\ChatController@invite');

	// survey
	Route::get('/survey/{id}','Survey\SurveyController@index')->where('id', '[0-9]+')->name('survey');
	// survey responden
	Route::get('/survey/{id}/answer/{inputans}', 'Survey\SurveyController@chooseAnswer')->name('survey.answer');
	Route::post('/survey/{id}/answer/{inputans}','Survey\SurveyController@postAnswer')->name('survey.answer.post');
	Route::post('/survey/answer/uploadWp/{id}','Survey\SurveyController@uploadWp')->name('survey.answer.uploadWp');
	Route::get('/survey/{id}/answer/view/{inputans}', 'Survey\SurveyController@doneView')->name('survey.answer.doneView');

	// survey creator/surveyor
	Route::get('/survey/{id}/analyze/{inputans}', 'Survey\SurveyController@analyze')->name('survey.analyze');
	Route::post('/survey/{id}/analyze/{inputans}', 'Survey\SurveyController@analyzePost')->name('survey.analyze.post');
	// survey agregation
	// Route::get("/aggregation/{surveyid}","Survey\AggregationDummyController@index")->name("survey.agregation");
	Route::get("/survey/aggregat/{surveyid}","Survey\SurveyController@getData")->name("survey.get.agregation");
	// survey common
	Route::get('/survey/get_process_outcome_wp/{id}', 'Survey\SurveyController@get_process_outcome_wp');
	Route::get('/survey/viewWp/{file}', 'Survey\SurveyController@viewWp')->name('survey.file.viewWp');
	Route::get('/survey/downloadWp/{file}', 'Survey\SurveyController@downloadWp')->name('survey.file.downloadWp');

	Route::get('/survey/ajax_get_list_user/{condition}', 'Survey\SurveyController@ajax_get_list_user');
	Route::get('/survey/{id}/task','Survey\SurveyController@task')->where('id', '[0-9]+')->name('survey.task');
	Route::post('/survey/task','Survey\SurveyController@task_store')->name('survey.task.store');
	Route::resource('surveyrs', 'Survey\SurveyController');

	//setting
	Route::get('/setting', 'Setting\SettingController@index')->name('setting');
	Route::get('/setting/users', 'Setting\SettingController@users')->name('setting.users');
	Route::post('/setting/users','Setting\SettingController@create_user')->name('setting.create_user');

	//calendar
	Route::get("/calendar",'Schedule\ScheduleController@index')->name("calendar");
	Route::post("/calendar",'Schedule\ScheduleController@calendar_store')->name("calendar.store");
	Route::get("/calendar/{year}/{month}",'Schedule\ScheduleController@schedules_list')->name("calendar.list");
});

//DocumentViewer Library
Route::any('ViewerJS/{all?}', function(){

    return View::make('ViewerJS.index');
});
