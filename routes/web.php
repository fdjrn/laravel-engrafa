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

	Route::get('/', 'Homepage\HomepageController@index');
	Route::get('/dashboard','Dashboard\DashboardController@index')->name('dashboard');

	// index & file explorer
    Route::get('/homepage','Homepage\HomepageController@index')->name('homepage');
    Route::get('/homepage/list-all','Homepage\HomepageController@listAll')->name('homepage.listall');
    Route::post('/homepage/create-new-folder','Homepage\HomepageController@createNewFolder');
    Route::post('/homepage/upload-files','Homepage\HomepageController@uploadFiles');

    Route::get('/index','Index\IndexController@index')->name('index');
    Route::post('/index','Index\IndexController@index')->name('index2');
	Route::get('/index/detail','Index\IndexDetailController@index')->name('index.detail');
    Route::get('/index/list-all','Index\IndexController@getListAll');
    Route::get('/index/list-all/{id}','Index\IndexController@getListDetail');
    Route::get('/index/list-all-previous/{id}','Index\IndexController@getListAllPrevious');
    Route::get('/index/list-folder','Index\IndexController@getListFolder');
    Route::get('/index/list-folder/{id}','Index\IndexController@getListFolderDetail');
    Route::get('/index/list-folder-previous/{id}','Index\IndexController@getListPreviousFolder');
    Route::post('/index/create-new-folder/{id}','Index\IndexController@createNewFolder');
    Route::post('/index/upload-files','Index\IndexController@uploadFiles');

	/*Route::get('/fileexplorer','FileExplorer\FileExplorerController@index');*/

	// chat
	Route::get('/chat','Chat\ChatController@index');
	Route::get('/chat/invite','Chat\ChatController@invite');

	// survey
	Route::get('/survey','Survey\SurveyController@index')->name('survey');
	Route::get('/survey/add/question','Survey\SurveyController@addQuestion')->name('survey.add.question');
	Route::get('/survey/add/question/test','Survey\SurveyController@test');
	Route::get('/survey/choose/answer', 'Survey\SurveyController@chooseAnswer')->name('survey.choose.answer');
	Route::get('/survey/ajax_get_list_user', 'Survey\SurveyController@ajax_get_list_user');
	Route::get('/survey/task','Survey\SurveyController@task')->name('survey.task');
	Route::post('/survey/task','Survey\SurveyController@task_store')->name('survey.task.store');
	Route::resource('surveyrs', 'Survey\SurveyController');

	//setting
	Route::get('/setting', 'Setting\SettingController@index')->name('setting');
	Route::get('/setting/users', 'Setting\SettingController@users')->name('setting.users');
	Route::post('/setting/users','Setting\SettingController@create_user')->name('setting.create_user');
});

//DocumentViewer Library
Route::any('ViewerJS/{all?}', function(){

    return View::make('ViewerJS.index');
});
