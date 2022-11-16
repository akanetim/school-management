<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Setup\StudentClassController;

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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

// logout route
Route::get('/admin/logout',[AdminController::class,'logout'])->name('admin.logout');

//user management all routes
Route::prefix('users')->group(function(){
    Route::get('/view', [UserController::class,'UserView'])->name('user.view');
    Route::get('/add', [UserController::class, 'UserAdd'])->name('users.add');
    Route::post('/store', [UserController::class, 'UserStore'])->name('users.store');
    Route::get('/edit/{id}', [UserController::class,'UserEdit'])->name('users.edit');
    Route::get('/delete/{id}',[UserController::class, 'UserDelete'])->name('users.delete');
    Route::post('/update/{id}',[UserController::class, 'UserUpdate'])->name('users.update');
});

//user profile and change password route
Route::prefix('profile')->group(function(){
  Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');
  Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
  Route::post('/store',[ProfileController::class, 'ProfileStore'])->name('profile.store');
  Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
  Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
});

//setup management
Route::prefix('setups')->group(function(){
    Route::get('student/class/view', [StudentClassController::class,'ViewStudent'])
    ->name('student.class.view');
    Route::get('student/class/add', [StudentClassController::class,'StudentClassAdd'])
    ->name('student.class.add');
    Route::post('student/class/store',[StudentClassController::class,'StudentClassstore'])
    ->name('store.student.class');
    Route::get('student/class/edit/{id}',[StudentClassController::class,'StudentClassEdit'])
    ->name('student.class.edit');
    Route::post('student/class/update/{id}',[StudentClassController::class,'StudentClassUpdate'])
    ->name('update.student.class');
    Route::get('student/class/delete/{id}', [StudentClassController::class,'StudentClassDelete'])
    ->name('student.class.delete');
});
