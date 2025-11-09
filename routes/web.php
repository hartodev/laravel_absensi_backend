<?php

use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Admin\AdminDashboardController;
use App\Http\Controllers\Backend\Admin\CompanyController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\Company\CompanyDashboardController;
use App\Http\Controllers\Backend\User\UserDashboardController;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('pages.auth.auth-login');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('home', function () {

        
//         return view('pages.dashboard', ['type_menu' => 'home']);
//     })->name('home');

//     // users
//     Route::resource('users', UserController::class);

//     Route::resource('companies', CompanyController::class);
//     Route::resource('attendances', AttendanceController::class);
//     Route::resource('permissions', PermissionController::class);
// });


// // role admin
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('users', UserController::class);

//     Route::resource('companies', CompanyController::class);
//     Route::resource('attendances', AttendanceController::class);

// });

// // role company
// Route::middleware(['auth', 'role:company'])->group(function () {
//     Route::resource('attendances', AttendanceController::class);
// }); 

// // role user
// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::resource('attendances', AttendanceController::class);
// });

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard per role
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/companies', CompanyController::class);
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});