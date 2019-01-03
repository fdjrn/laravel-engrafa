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

/*
Route::get('/', function () {
     return view('welcome');
 });

 Route::get('login','Auth\LoginController@index');
 Route::post('login','Auth\LoginController@doLogin');

 Route::get('forgot','Auth\ForgotPasswordController@index');
 Route::any('logout','Auth\LogoutController@index')->name('logout');
 Route::get('register','Auth\RegisterController@index');
*/

Auth::routes();

Route::middleware(['auth','web'])->group(function () {


	Route::get('/', 'Homepage\HomepageController@index');

	// dashboard
	Route::get('/','Dashboard\DashboardController@index')->name('dashboard');
	Route::post('/','Dashboard\DashboardController@store')->name('dashboard.post');
	Route::post('/addChart','Dashboard\DashboardController@storeCharts')->name('dashboard.post.chart');

	Route::get('/ajax_get_list_user', 'Dashboard\DashboardController@ajax_get_list_user');
	Route::post('/ajax_delele_dashboard', 'Dashboard\DashboardController@ajax_delele_dashboard');
	Route::post('/ajax_share_to', 'Dashboard\DashboardController@ajax_share_to');
	Route::post('/ajax_get_dashboard', 'Dashboard\DashboardController@ajax_get_dashboard'); 

	// index & file explorer/homepages
    Route::get('/homepage','Homepage\HomepageController@index')->name('homepage');
    Route::get('/homepage/list-all','Homepage\HomepageController@listAll')->name('homepage.listall');
    Route::post('/homepage/create-new-folder','Homepage\HomepageController@createNewFolder');
    Route::post('/homepage/upload-files','Homepage\HomepageController@uploadFiles');

    Route::get('/index','Index\IndexController@index')->name('index');
    Route::post('/index','Index\IndexController@index')->name('index.last.folder');
    Route::get('/index/list-all/{id}','Index\IndexController@getListAll');
    Route::get('/index/list-all-previous/{id}','Index\IndexController@getListAllPrevious');
    Route::get('/index/list-folder/{id}','Index\IndexController@getListAllFolder');
    Route::get('/index/list-folder-previous/{id}','Index\IndexController@getListPreviousFolder');
    Route::post('/index/create-new-folder/{id}','Index\IndexController@createNewFolder');
    Route::post('/index/upload-files','Index\IndexController@uploadFiles');
    Route::post('/index/upload-new-version','Index\IndexController@uploadNewVersion');
    Route::post('/index/bookmark-file/{id}','Index\IndexController@bookmarkFile');
    Route::post('/index/update-file/{id}','Index\IndexController@updateFilesById');
    Route::delete('/index/delete-file/{id}','Index\IndexController@deleteFilesById');

    Route::get('/index/get-file/{id}',function ($id){
        $files = \App\Models\Files::findOrFail($id);
        return $files;
    });

    Route::get('/index/download-file/{id}',function ($id){
        $files = \App\Models\Files::find($id);

        if ($files->is_file === 1){
            if (\Illuminate\Support\Facades\Storage::exists($files->url))
                return \Illuminate\Support\Facades\Storage::download($files->url, $files->name,
                    ['Content-Type' => $files->mime_type]);
            else
                return abort(404);
        }
    });

    Route::get('/index/detail/{id}','Index\IndexDetailController@index')->name('index.detail');
    Route::get('/index/file-history/{id}','Index\IndexController@showFileHistory');


	// chat
    Route::get('/chat','Chat\ChatController@index')->name('chat');
    Route::post('/chat/invite','Chat\ChatController@invite');
    Route::post('/chat/invite/group','Chat\ChatController@inviteGroup');
    Route::get('/chat/getChatRoom/{chatRoom?}/','Chat\ChatController@getChatRoom');
    Route::get('/chat/getChatHistory/{chatRoom?}/','Chat\ChatController@getChatHistory');
    Route::get('/chat/getUserAvailable','Chat\ChatController@getUserAvailable');
    Route::get('/message', 'Chat\MessageController@index')->name('message');
    Route::post('/message', 'Chat\ChatController@store')->name('chat.store');
    Route::post('/message/read/all', 'Chat\ChatController@readAllMessages')->name('chat.read.all');

	//notification
	Route::get('/notification/getNotification/{date?}/','Notification\NotificationController@getNotifications');
	Route::get('/notification/getUnreadNotification/','Notification\NotificationController@getUnreadNotifications');
	Route::post('/notification/read','Notification\NotificationController@read');
	Route::post('/notification/read/all','Notification\NotificationController@readAll');

	// survey
	Route::get('/assessment/{id}','Survey\SurveyController@index')->where('id', '[0-9]+')->name('survey');
	// survey responden
	Route::get('/assessment/{id}/answer/{inputans}', 'Survey\SurveyController@chooseAnswer')->name('survey.answer');
	Route::post('/assessment/{id}/answer/{inputans}','Survey\SurveyController@postAnswer')->name('survey.answer.post');
	Route::post('/assessment/answer/uploadWp/{id}','Survey\SurveyController@uploadWp')->name('survey.answer.uploadWp');
	Route::get('/assessment/{id}/answer/view/{inputans}', 'Survey\SurveyController@doneView')->name('survey.answer.doneView');

	// survey creator/surveyor
	Route::get('/assessment/{id}/analyze/{inputans}', 'Survey\SurveyController@analyze')->name('survey.analyze');
	Route::post('/assessment/{id}/analyze/{inputans}', 'Survey\SurveyController@analyzePost')->name('survey.analyze.post');
	Route::get('/assessment/{id}/analyze/view/{inputans}', 'Survey\SurveyController@doneView')->name('survey.analyze.doneView');
	Route::post('/assessment/{id}/invite', 'Survey\SurveyController@invite')->name('survey.invite');
	// survey agregation
	// Route::get("/aggregation/{surveyid}","Survey\AggregationDummyController@index")->name("survey.agregation");
	Route::get("/assessment/aggregat/{surveyid}","Survey\SurveyController@getData")->name("survey.get.agregation");
	// survey common
	Route::get('/assessment/get_process_outcome_wp/{id}', 'Survey\SurveyController@get_process_outcome_wp');
	Route::get('/assessment/viewWp/{file}', 'Survey\SurveyController@viewWp')->name('survey.file.viewWp');
	Route::get('/assessment/downloadWp/{file}', 'Survey\SurveyController@downloadWp')->name('survey.file.downloadWp');

	Route::get('/assessment/{id}/ajax_get_list_user/{condition}', 'Survey\SurveyController@ajax_get_list_user');
	Route::get('/assessment/{id}/task','Survey\SurveyController@task')->where('id', '[0-9]+')->name('survey.task');
	Route::post('/assessment/{id}/task','Survey\SurveyController@task_store')->name('survey.task.store');
	Route::post('/assessment/{id}/task/update/{task_id}','Survey\SurveyController@task_update')->name('survey.task.update');
	Route::get('/assessment/{id}/task/{task_id}','Survey\SurveyController@get_task_by_id')->where('id', '[0-9]+')->name('survey.get_task_by_id');

	Route::get('/assessment/{id}/chat','Survey\SurveyController@chat')->where('id', '[0-9]+')->name('survey.chat');
	Route::resource('surveyrs', 'Survey\SurveyController');

	//setting
	Route::get('/setting', 'Setting\SettingController@index')->name('setting');
	Route::get('/setting/users', 'Setting\SettingController@users')->name('setting.users');
	Route::post('/setting/users','Setting\SettingController@create_user')->name('setting.create_user');
	Route::get('/setting/users/{id}', 'Setting\SettingController@get_user_by_id');
	Route::post('/setting/users/edit_user','Setting\SettingController@edit_user')->name('setting.edit_user');

	//calendar
	Route::get("/calendar",'Schedule\ScheduleController@index')->name("calendar");
	Route::post("/calendar",'Schedule\ScheduleController@calendar_store')->name("calendar.store");
	Route::get("/calendar/{year}/{month}",'Schedule\ScheduleController@schedules_list')->name("calendar.list");

	//bookmark
    Route::get("/bookmarks/{id}", "Bookmark\BookmarkController@getBookmarks");
    Route::get("/bookmarks/show/{id}", "Bookmark\BookmarkController@showBookmarkedFiles");
});

//DocumentViewer Library
Route::any('ViewerJS/{all?}', function(){
    return View::make('ViewerJS.index');
});