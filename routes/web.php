<?php

use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Admin\AdminDashboardController;
use App\Http\Controllers\Backend\Admin\CompanyController;
use App\Http\Controllers\Backend\Admin\AttendanceController;
use App\Http\Controllers\Backend\Admin\PayroolController;
use App\Http\Controllers\Backend\Admin\LoanController;
use App\Http\Controllers\Backend\Admin\PermissionController;
use App\Http\Controllers\Backend\Admin\PrayerController;
use App\Http\Controllers\Backend\Admin\ShiftController;
use App\Http\Controllers\Backend\Admin\ScheduleController;
use App\Http\Controllers\Backend\Admin\UserController;
Use App\Http\Controllers\Backend\Company\CompanyAttendanceController;
use App\Http\Controllers\Backend\Company\CompanyDashboardController;
use App\Http\Controllers\Backend\Company\CompanyEmployeeController;
use App\Http\Controllers\Backend\Company\CompanyPermissionController;
use App\Http\Controllers\Backend\Company\CompanyShiftController;
use App\Http\Controllers\Backend\Company\CompanyPayroolsController;
use App\Http\Controllers\Backend\Company\CompanyLoansController;
use App\Http\Controllers\Backend\User\UserAttendanceController;
use App\Http\Controllers\Backend\User\UserPermissionController;
use App\Http\Controllers\Backend\User\UserDashboardController;
use Illuminate\Support\Facades\Route;




Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard per role
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/companies', CompanyController::class);
    Route::resource('/admin/attendances', AttendanceController::class);
    Route::resource('/admin/permissions', PermissionController::class);
    Route::resource('/admin/payrools', PayroolController::class);
    Route::resource('/admin/loans', LoanController::class);
    Route::resource('/admin/shifts', ShiftController::class);
    Route::resource('/admin/schedules', ScheduleController::class);
    Route::resource('/admin/prayers', PrayerController::class);
    Route::get('/admin/reports', [App\Http\Controllers\Backend\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    
});

Route::middleware(['auth', 'role:company'])->group(function () {
    // Route::get('/company/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
       Route::get('/company/dashboard', [CompanyDashboardController::class, 'index'])
        ->name('company.dashboard');

    // Attendance Management
    Route::get('/company/attendances', [CompanyAttendanceController::class, 'index'])
        ->name('company.attendances.index');

    Route::get('/company/attendances/{id}', [CompanyAttendanceController::class, 'show'])
        ->name('company.attendances.show');

         Route::resource('/company/employees', CompanyEmployeeController::class);

         // Permission Approval
    Route::get('/company/permissions', [CompanyPermissionController::class, 'index'])
        ->name('company.permissions.index');

    Route::post('/company/permissions/{id}/approve', [CompanyPermissionController::class, 'approve'])
        ->name('company.permissions.approve');

    Route::post('/company/permissions/{id}/reject', [CompanyPermissionController::class, 'reject'])
        ->name('company.permissions.reject');

         Route::resource('/company/shifts', CompanyShiftController::class)->names('company.shifts');

          // Payroll Management
    Route::resource('/company/payrolls', CompanyPayroolsController::class)->names('company.payrolls');

    // Action: Approve / Pay
    Route::post('/company/payrolls/{id}/status', [CompanyPayroolsController::class, 'changeStatus'])
        ->name('company.payrolls.changeStatus');

        // loans
    Route::resource('/company/loans', CompanyLoansController::class)->names('company.loans');


    // Change status
    Route::post('/company/loans/{id}/status', [CompanyLoansController::class, 'changeStatus'])
        ->name('company.loans.changeStatus');

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

      // Attendance User
    Route::get('/user/attendances', [UserAttendanceController::class, 'index'])
        ->name('user.attendances.index');

        // permission User
        Route::resource('/user/permissions', UserPermissionController::class)->names('user.permissions');

});