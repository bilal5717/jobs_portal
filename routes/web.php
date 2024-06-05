<?php
// use Auth;
use Illuminate\Support\Facades\Route;


Route::group(['middleware'=> ['auth', 'verified']],function(){
    Route::get('/', 'frontend\HomeController@index')->name('home');
    Route::get('folder/{folderid?}/{slug?}', 'frontend\HomeController@index');
    Route::get('/download/{fileid}','frontend\HomeController@download');
    Route::post('/download/multiple/files','frontend\HomeController@multiple');
    Route::get('/download/zip/{filename?}', 'frontend\HomeController@downloadzip');
    Route::post('/update_profile/{id}','frontend\HomeController@update_profile');
    Route::post('/upload_profile_image/{id}','frontend\HomeController@uploadProfileImage');
    Route::get('/account/{stepid?}', 'frontend\HomeController@account')->name('account');
    Route::post('/account/{stepid?}','frontend\HomeController@update_profile_wizard')->name('account');
    Route::get('/quiz','frontend\quiz\QuizController@index')->name('quiz');
    Route::post('/quiz','frontend\quiz\QuizController@index')->name('quiz');
    Route::get('/timesheet','frontend\timesheet\TimesheetController@index')->name('timesheet');
    Route::post('/timesheet/new','frontend\timesheet\TimesheetController@createNewTimeSheet');
    Route::post('/timesheet/edit','frontend\timesheet\TimesheetController@editTimeSheet')->name('edit_timesheet');
    Route::post('/timesheet/save','frontend\timesheet\TimesheetController@saveTimesheet')->name('save_timesheet');
    Route::post('/timesheet/submit','frontend\timesheet\TimesheetController@submitTimesheet')->name('submit_timesheet');
});

// Route::get('/logout',function(){
    
//     \Auth::logout();

// });

// Frontend auth routes
Route::get('/login','frontend\AuthController@login');
Route::get('/register','frontend\AuthController@register');
Route::get('/forgot','frontend\AuthController@forgot');
Route::post('/user/register','frontend\AuthController@createAccount')->name('user.register');
Route::post('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset','frontend\AuthController@resetForm')->name('password.request');
Route::get('password/reset/{token}','frontend\AuthController@resetForm')->name('password.reset');
Route::post('/password/reser','Auth\ResetPasswordController@reset')->name('password.update');


Auth::routes(['verify' => true]);
// Auth::routes();

Route::post('/login','Auth\LoginController@login')->name('login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');

// Route::post('/register','Auth\RegisterController@register');
// Route::get('/confirm/',function(){
//     return view('auth.passwords.reset');
// });


// ADMIN ROUTES
Route::group(['prefix' => 'app-admin', 'namespace' => 'Admin', 'as'=> 'admin.'],function(){    
    /****Admin Login Route*****/
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::get('logout', 'Auth\LoginController@logout')->name('logout');
	
	//Admin users
	Route::get('admin_users', 'AdminController@listAdmins')->name('admin_users');
	Route::get('admin_users/edit/{id}', 'AdminController@edit')->name('edit_admin');
	Route::get('admin_users/create', 'AdminController@create')->name('create_admin');
    Route::post('add_new_admin', 'AdminController@store')->name('add_new_admin');
    Route::delete('admin_delete/{id}', 'AdminController@destroy')->name('admin_delete');
    Route::post('update_admin/{id}', 'AdminController@update_profile')->name('update_admin');
    Route::post('update_profile/{id}', 'AdminController@update_profile');
	
	//Admin Roles
	Route::get('admin_roles', 'AdminController@adminsRoles')->name('admin_roles');
	Route::get('admin_roles/edit/{id}', 'AdminController@editRole')->name('edit_role');
	Route::post('update_role/{id}', 'AdminController@updateRole')->name('update_role');
	Route::get('admin_roles/create', 'AdminController@createRole')->name('create_role');
	Route::post('add_new_role', 'AdminController@addRole')->name('add_new_role');
    Route::delete('role_delete/{id}', 'AdminController@deleteRole')->name('role_delete');
	
    //Dashbord
    Route::get('dashboard', 'AdminController@index')->name('dashboard');
    // Users Management  Route 
    Route::get('user/applies', 'UserController@jobRequests');
    Route::post('user/jobaction', 'UserController@jobRequestAction');
    Route::post('user/change_status', 'UserController@updateStatus')->name('change_user_status');
    //Route::get('user/detail/{id}', 'UserController@updateStatus')->name('change_user_status');
    Route::post('users','UserController@index')->name('user_post');//For filters
    Route::post('ajax_user_search','UserController@searchUsers')->name('ajax_user_search');//For filters
    
    Route::resource('user', 'UserController');
    // Company Management Route
    Route::resource('company','CompanyController');
    // Project Management Route
    Route::resource('project','ProjectController');
    // Folder Management ROUTE
    Route::get('folders','FolderController@index')->name('folders');
    Route::post('folders','FolderController@index')->name('folders');//For filters and search
    Route::resource('folder','FolderController');

    // FILES  ROUTES
    Route::get('folder/{id?}/file','FileController@index');
    Route::get('folder/{id?}/file/upload','FileController@create');
    Route::post('file/upload','FileController@store')->name('file.store');
    Route::get('folder/{folderID?}/file/{id}/edit','FileController@edit');
    Route::post('file/update','FileController@update')->name('file.update');
    Route::get('/folder/{folderId?}/file/{fileID}/delete','FileController@destroy');
    
    // Folder  Assign to Employee
    Route::post("/folder/assign",'FolderController@assignFolder')->name('folder.assign');
    // Files Assign to Employee 
    Route::post("/file/assign",'FileController@assignFile')->name('file.assign');

    // sub folder Route

    Route::get('/subfolder/{parentID}/view','FolderController@index');
    Route::post('/subfolder/{parentID}/view','FolderController@index');//For filters and search
    Route::get('/subfolder/{parentID}/create','FolderController@create');
    Route::get('/fetch/employees/{id}','UserController@fetchEmployee');
	
	/**
	* Timesheet Routes
	*/
	Route::get('/timesheets/{status?}','Timesheet\TimesheetController@index')->name('timesheets');
	Route::post('/timesheet/status_change','Timesheet\TimesheetController@changeStatus')->name('timesheet_status_change');
	Route::get('/timesheet/open/{id?}','Timesheet\TimesheetController@openTimesheet')->name('open_timesheet');
	Route::post('/timesheet/save','Timesheet\TimesheetController@saveTimesheetAdmin')->name('save_timesheet_admin');
	Route::post('/timesheet/save-timesheet-action','Timesheet\TimesheetController@saveTimesheetAction')->name('save_timesheet_action');
	Route::resource('timesheet','Timesheet\TimesheetController');
	/**
	* Timetable Routes
	*/
	Route::get('/timetables/{status?}','Timetable\TimetableController@index')->name('timetables');
	Route::post('timetables','Timetable\TimetableController@index')->name('timetables');//For filters and search
	Route::get('/timetable/open/{id?}','Timetable\TimetableController@openTimetable')->name('open_timetable');
	Route::resource('timetable','Timetable\TimetableController');
	
	Route::post('/timetable/save','Timetable\TimetableController@saveNewTimetableAdmin')->name('save_timetable_admin');
	Route::post('/timetable/status_change','Timetable\TimetableController@changeStatus')->name('timetable_status_change');
	/*Route::post('/timetable/create','Timetable\TimetableController@changeStatus')->name('timetable_status_change');
	Route::get('/timetable/open/{id?}','Timetable\TimetableController@openTimetable')->name('open_timetable');
	
	Route::post('/timetable/save-timetable-action','Timetable\TimetableController@saveTimetableAction')->name('save_timetable_action');*/
    Route::get('duplicate_user_timetable/{id}/{date}','Timetable\TimetableController@checkDuplicateUser')->name('duplicate_user_timetable');//For filters
});


Route::get('/home',function(){
    return redirect('/');
});
Route::get('/app-admin', 'Admin\AdminController@index');
Route::get('/admin',function(){
    return redirect('/app-admin');
});
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});