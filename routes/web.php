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
	// Route::get('/home', 'HomeController@index')->name('home');

	// Route::get('/', 'HomeController@index');

	// dashboard
	Route::get('/','Dashboard\DashboardController@index')->name('dashboard');
	Route::post('/','Dashboard\DashboardController@store')->name('dashboard.post');
	Route::post('/addChart','Dashboard\DashboardController@storeCharts')->name('dashboard.post.chart');

	Route::get('/ajax_get_list_user', 'Dashboard\DashboardController@ajax_get_list_user');
	Route::post('/ajax_delele_dashboard', 'Dashboard\DashboardController@ajax_delele_dashboard');
	Route::post('/ajax_delete_survey', 'Dashboard\DashboardController@ajax_delete_survey');
	Route::post('/ajax_share_to', 'Dashboard\DashboardController@ajax_share_to');

	Route::post('/ajax_get_dashboard', 'Dashboard\DashboardController@ajax_get_dashboard');
	Route::post('/ajax_get_charts', 'Dashboard\DashboardController@ajax_get_charts');
	Route::post('/ajax_get_id_surveys', 'Dashboard\DashboardController@ajax_get_id_surveys');
	Route::post('/ajax_get_data_survey', 'Dashboard\DashboardController@ajax_get_data_survey');

	Route::get('/ajax/edit-survey/{id}', 'Dashboard\DashboardController@ajax_edit_survey');
	// index & file explorer/homepages
    Route::get('/homepage','Homepage\HomepageController@index')->name('homepage');
    Route::get('/homepage/list-all','Homepage\HomepageController@listAll')->name('homepage.listall');
    Route::post('/homepage/create-new-folder','Homepage\HomepageController@createNewFolder');
    Route::post('/homepage/upload-files','Homepage\HomepageController@uploadFiles');

    Route::get('/index','Index\IndexController@index')->name('index');
    Route::post('/index','Index\IndexController@index')->name('index.last.folder');
    Route::get('/index/list-all/{id}','Index\IndexController@getListAll');

	Route::post('/ajax_get_dashboard', 'Dashboard\DashboardController@ajax_get_dashboard'); 
	Route::get('/ajax/edit-survey/{id}', 'Dashboard\DashboardController@ajax_edit_survey');
	

	// index & file explorer
	Route::get('/index','Index\IndexController@index')->name('index');
	Route::get('/index/detail','Index\IndexDetailController@index')->name('index.detail');
    Route::get('/index/list-all','Index\IndexController@getListAll');
    Route::get('/index/list-all/{id}','Index\IndexController@getListDetail');

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


	Route::get('/fileexplorer','FileExplorer\FileExplorerController@index');

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
	Route::get('/survey/{id}','Survey\SurveyController@index')->where('id', '[0-9]+')->name('survey');
	Route::get('/survey/add/question','Survey\SurveyController@addQuestion')->name('survey.add.question');
	Route::get('/survey/add/question/test','Survey\SurveyController@test');
	Route::get('/survey/answer/{inputans}', 'Survey\SurveyController@chooseAnswer')->name('survey.answer');
	Route::post('/survey/answer/{inputans}','Survey\SurveyController@postAnswer')->name('survey.answer.post');
	Route::get('/survey/ajax_get_list_user', 'Survey\SurveyController@ajax_get_list_user');
	Route::get('/survey/get_process_outcome_wp/{id}', 'Survey\SurveyController@get_process_outcome_wp');
	Route::get('/survey/task/{id}','Survey\SurveyController@task')->where('id', '[0-9]+')->name('survey.task');
	Route::post('/survey/task','Survey\SurveyController@task_store')->name('survey.task.store');
	Route::resource('surveyrs', 'Survey\SurveyController');

	//setting
	Route::get('/setting', 'Setting\SettingController@index')->name('setting');
	Route::get('/setting/users', 'Setting\SettingController@users')->name('setting.users');
	Route::post('/setting/users','Setting\SettingController@create_user')->name('setting.create_user');
	Route::get('/setting/users/{id}', 'Setting\SettingController@get_user_by_id');
	Route::post('/setting/users/edit_user','Setting\SettingController@edit_user')->name('setting.edit_user');
	Route::get('/setting/blackwhitelist', 'Setting\SettingController@blackwhitelist')->name('setting.blackwhitelist');
	Route::post('/setting/updateblackwhitelist','Setting\SettingController@update_blackwhitelist')->name('setting.update_blackwhitelist');
	Route::get('/setting/profile', 'Setting\SettingController@profile_user')->name('setting.profile');
	Route::post('/setting/update_profile_user','Setting\SettingController@update_profile_user')->name('setting.update_profile_user');


	Route::get('/setting/backuprestore', 'Setting\SettingController@backuprestore')->name('setting.backuprestore');


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