<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clientController;
use App\Http\Controllers\uploadController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FullCalendarEventMasterController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ScheduleController;


use App\Http\Controllers\TaskController;




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
    return view('welcome');
});

Auth::routes();   // To make  Auth::middleware available. We still need to use  $this->middleware('auth'); in 
				  // __construct() of the corresponding controller, e.g. HomeController and ProductController
				  
Route::get('/changePassword',[ChangePasswordController::class,'index'])->name('changePassword');	


// users routes
Route::post('/createUser',[UserController::class,'create'])->name('user.create');	
Route::get('/userList',[UserController::class,'index'])->name('user.list');	
Route::get('/editUser',[UserController::class,'edit'])->name('user.edit');	
Route::post('/updateUser',[UserController::class,'update'])->name('user.update');	
		  
/*				  
 NOTE: To make a middleware applicable to all controller, specifiy this in 
      C:\xampp\htdocs\laravel\laravel_auth\app\Http\Kernel.php's 
		protected $middleware = []
	To apply a middleware on selected group, e.g. web.php or api.php, include it 
	in the corresponding protected $middlewareGroups[] in kernel.php 
*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.post');


// Requirements: name parameter is required and it can contain only alpha characters
// i.e. http://127.0.0.1:8000/users/Raja works but http://127.0.0.1:8000/users/Raja56 fails with 404 error
Route::get('/books/{name}', function($name='test'){
		return 'Hi ' . $name;
});




// Not Authorized Page
Route::get('/notAuthorized', function(){
	return view('notAuthorized');
});

// Permissions 
Route::get('/permission',[PermissionController::class,'index'])->name('permission.index');
Route::post('/permission',[PermissionController::class,'store'])->name('permission.store');  // update permissions data

Route::get('/task/create',[TaskController::class,'create'])->name('task.create');

// Schedules
Route::get('/schedule',[ScheduleController::class,'index'])->name('schedule.index');
Route::post('/scheduleEdit',[ScheduleController::class,'edit'])->name('schedule.edit');
Route::get('/scheduleEdit',[ScheduleController::class,'edit'])->name('schedule.edit');

Route::post('/createSchedule',[ScheduleController::class,'createSchedule'])->name('schedule.create');
Route::post('/userScheduleBasicData',[ScheduleController::class,'userScheduleBasicData'])->name('user.scheduleBasicData');	
Route::post('/userScheduleData',[ScheduleController::class,'userScheduleData'])->name('user.userScheduleData');	
Route::post('/updadeUserScheduleData',[ScheduleController::class,'updadeUserScheduleData'])->name('schedule.updadeUserSchedule');	
Route::post('/deleteUserScheduleData',[ScheduleController::class,'deleteUserScheduleData'])->name('schedule.userSchedule');	
Route::post('/saveAsDefaultSchedule',[ScheduleController::class,'saveAsDefaultSchedule'])->name('schedule.saveAsDefault');	



Route::post('/createEmployee',[ScheduleController::class,'createEmployee'])->name('schedule.createEmployee');	




