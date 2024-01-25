<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DepartmentTasksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EvaluationsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('set-lang/{lang}', function($lang){
   if(in_array($lang,['en','ar'])){
   session(['locale'=> $lang]);
 }
 return back();  
});

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'dashboard']);
    
    Route::get('department-tasks/{id}', function(){ return view('dashboard-pages.department-tasks');})->middleware('can:manage-department-tasks'); ; 

    Route::get('my-department-tasks/{id}', function(){ return view('dashboard-pages.department-tasks');})->middleware(['check.dept_id']); 
    
    Route::get('my-department-users/{id}', function(){ return view('dashboard-pages.department-users');})->middleware('can:manage-his-department-users')->middleware(['check.dept_id']); 

    Route::get('profile', function(){ return view('dashboard-pages.profile');}); 
    Route::get('users', function(){ return view('dashboard-pages.users');})->middleware('can:manage-users'); ; 
    Route::get('user-details/{id}', function(){ return view('dashboard-pages.user-details');})->middleware('can:manage-users'); ; 
    Route::get('user-todo/{id}', function(){ return view('dashboard-pages.user-todo');})->middleware('can:manage-users'); ; 
    Route::get('user-inprogress/{id}', function(){ return view('dashboard-pages.user-inprogress');})->middleware('can:manage-users'); ; 
    Route::get('user-done/{id}', function(){ return view('dashboard-pages.user-done');})->middleware('can:manage-users'); ; 
    Route::get('user-task-updates/{id}', function(){ return view('dashboard-pages.user-task-updates');})->middleware('can:manage-users'); ; 
    Route::get('user-details/{id}/{user_id}', function(){ return view('dashboard-pages.department-user-details');})->middleware(['check.dept_id'])->middleware(['check.user_id'])->middleware('can:manage-his-department-users'); ; 
    Route::get('user-todo/{id}/{user_id}', function(){ return view('dashboard-pages.department-user-todo');})->middleware(['check.dept_id'])->middleware(['check.user_id'])->middleware('can:manage-his-department-users'); ; 
    Route::get('user-inprogress/{id}/{user_id}', function(){ return view('dashboard-pages.department-user-inprogress');})->middleware(['check.dept_id'])->middleware(['check.user_id'])->middleware('can:manage-his-department-users'); ; 
    Route::get('user-done/{id}/{user_id}', function(){ return view('dashboard-pages.department-user-done');})->middleware(['check.dept_id'])->middleware(['check.user_id'])->middleware('can:manage-his-department-users'); ; 
    Route::get('user-task-updates/{id}/{user_id}', function(){ return view('dashboard-pages.department-user-task-updates');})->middleware(['check.dept_id'])->middleware(['check.user_id'])->middleware('can:manage-his-department-users'); ; 
    
    Route::get('evaluations', function(){ return view('dashboard-pages.evaluations');});    
    Route::get('departments', function(){ return view('dashboard-pages.departments');})->middleware('can:manage-departments'); ;    
    Route::get('user-assigned-tasks', function(){ return view('dashboard-pages.assigned-tasks');})  ->middleware('role:Employee');    
    Route::get('roles-and-permissions', function(){ return view('dashboard-pages.roles-and-permissions');})
    ->middleware('can:manage-permissions');    

    
    
    
    
    
    
    

    
    // Route::post('ops/tasks/create', [DepartmentTasksController::class, 'createTask'])->middleware('can:manage-department-tasks');
    Route::post('ops/tasks/create', [DepartmentTasksController::class, 'createTask'])->middleware('can-manage-tasks');
    Route::post('ops/task-updates/create', [DepartmentTasksController::class, 'addTaskUpdate'])->middleware('role:Employee');
    
    
Route::get('ops/tasks/fetchTask/{id}', [DepartmentTasksController::class, 'fetchTaskData']);
Route::get('ops/tasks/fetch/{id}', [DepartmentTasksController::class, 'fetchTask']);
Route::get('ops/tasks/fetch-for-emp/{id}', [DepartmentTasksController::class, 'fetchTaskForEmp'])->middleware('role:Employee');
Route::post('ops/tasks/edit', [DepartmentTasksController::class, 'editTask']);
// Route::post('ops/tasks/delete', [DepartmentTasksController::class, 'deleteTask'])->middleware('can:manage-department-tasks');
Route::post('ops/tasks/delete', [DepartmentTasksController::class, 'deleteTask'])->middleware('can-manage-tasks');

// Route::post('ops/tasks/fetchAll', [DepartmentTasksController::class, 'fetchTasks'])->middleware('can:manage-department-tasks');
Route::post('ops/tasks/fetchAll', [DepartmentTasksController::class, 'fetchTasks'])->middleware('can-manage-tasks');;

Route::get('ops/task-updates/fetchAll/{id}', [DepartmentTasksController::class, 'fetchTaskUpdates']);
Route::post('ops/tasks/fetchMine', [DepartmentTasksController::class, 'fetchMyTasks']);
Route::post('ops/profile/edit', [UsersController::class, 'profileEdit']);
Route::post('ops/profile/editImg', [UsersController::class, 'profileEditImg']);
Route::post('ops/account/edit', [UsersController::class, 'edit'])->middleware('can:manage-users');
Route::post('ops/account/editByDM', [UsersController::class, 'edit'])->middleware('can:manage-his-department-users');
Route::post('ops/users/change-role', [UsersController::class, 'changeRole'])->middleware('can:manage-users');
Route::post('ops/roles-and-permission/change-single',[App\Http\Controllers\RolesAndPermissionsController::class  ,'linkPermissionToRole'])->middleware('can:manage-users');


Route::post('ops/evaluations/add', [EvaluationsController::class, 'add'])->middleware('can:manage-users');;
Route::post('ops/evaluations/addByDM', [EvaluationsController::class, 'add'])->middleware('can:manage-his-department-users');;


    
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
