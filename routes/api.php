<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\Company\CompanyProfileController;
use App\Http\Controllers\Api\Company\DashboardController;
use App\Http\Controllers\Api\Company\CompanyEmployeeController;
use App\Http\Controllers\Api\Company\CompanyAttendanceController;
use App\Http\Controllers\Api\Company\CompanyPermissionController;
use App\Http\Controllers\Api\Company\CompanyLoanController;
use App\Http\Controllers\Api\Company\CompanyPayrollController;
use App\Http\Controllers\Api\Company\CompanyShiftController;
use App\Http\Controllers\Api\Company\CompanyReportController;




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// //login
// Route::post('/login', [AuthController::class, 'login']);

// //logout
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// //company
// Route::get('/companies', [App\Http\Controllers\Api\CompanyController::class, 'show'])->middleware('auth:sanctum');

// //checkin
// Route::post('/checkin', [App\Http\Controllers\Api\AttendanceController::class, 'checkin'])->middleware('auth:sanctum');

// //checkout
// Route::post('/checkout', [App\Http\Controllers\Api\AttendanceController::class, 'checkout'])->middleware('auth:sanctum');

// //is checkin
// Route::get('/is-checkin', [App\Http\Controllers\Api\AttendanceController::class, 'isCheckedin'])->middleware('auth:sanctum');

// //update profile
// Route::post('/updateface', [App\Http\Controllers\Api\AuthController::class, 'updateProfile'])->middleware('auth:sanctum');

// //create permission
// Route::post('/api-permissions', [App\Http\Controllers\Api\PermissionController::class, 'store'])->middleware('auth:sanctum');

// //notes
// Route::post('/api-notes', [App\Http\Controllers\Api\NoteController::class,'store'])->middleware('auth:sanctum');

// //update fcm token
// Route::post('/update-fcm-token', [App\Http\Controllers\Api\AuthController::class, 'updateFcmToken'])->middleware('auth:sanctum');


// ROUTE NEWS 1 #################################################################################

// AUTH API (ALL ROLES)

// Route::prefix('auth')->group(function () {

//     // login user / company / admin
//     Route::post('/login', [AuthController::class, 'login']);

//     // route protected
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::post('/logout', [AuthController::class, 'logout']);
//         Route::get('/me', [AuthController::class, 'me']);
//         Route::post('/update-fcm-token', [AuthController::class, 'updateFcmToken']);
//         Route::post('/change-password', [AuthController::class, 'changePassword']);
//     });
// });

// //  USER API


// Route::prefix('user')
//     ->middleware(['auth:sanctum', 'role:user'])
//     ->group(function () {

//         // // profile
//         Route::get('/profile', [AuthController::class, 'show']);
//         Route::post('/profile', [AuthController::class, 'update']);

//         // // attendance
//         Route::get('/attendances', [AttendanceController::class, 'index']);
//         Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn']);
//         Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut']);
//         Route::get('/attendances/is-checkin', [AttendanceController::class, 'isCheckedIn']);

//         // // permissions (izin / cuti)
//         Route::get('/permissions', [PermissionController::class, 'index']);
//         Route::post('/permissions', [PermissionController::class, 'store']);
//         Route::get('/permissions/{id}', [PermissionController::class, 'show']);

//         // // notes
//         Route::apiResource('/notes', NoteController::class);

//         // // schedules
//         Route::apiResource('/schedules', ScheduleController::class);
//         // update status
//         Route::post('/schedules/{id}/status', [ScheduleController::class, 'updateStatus']);

//         // // payrolls (read only)
//         Route::get('/payrolls', [PayrollController::class, 'index']);
//         Route::get('/payrolls/{id}', [PayrollController::class, 'show']);

//         // // loans (kasbon)
//         Route::get('/loans', [LoanController::class, 'index']);
//         Route::post('/loans', [LoanController::class, 'store']);
//         Route::get('/loans/{id}', [LoanController::class, 'show']);
//     });


// // COMPANY API


// Route::prefix('company')
//     ->middleware(['auth:sanctum', 'role:company'])
//     ->group(function () {

//         // // dashboard
//         Route::get('/dashboard', [DashboardController::class, 'index']);

//         // // company profile
//         Route::get('/profile', [CompanyProfileController::class, 'show']);
//         Route::post('/profile', [CompanyProfileController::class, 'update']);

//         // // employees
//         Route::apiResource('/employees', CompanyEmployeeController::class);
//         // status
//         Route::post('/employees/{id}/status', [CompanyEmployeeController::class, 'updateStatus']);

//         // // attendances
//         Route::get('/attendances', [CompanyAttendanceController::class, 'index']);
//         Route::get('/attendances/{id}', [CompanyAttendanceController::class, 'show']);
//         Route::patch('/attendances/{id}/overtime', [CompanyAttendanceController::class, 'approveOvertime']);

//         // // permissions approval
//         Route::get('/permissions', [CompanyPermissionController::class, 'index']);
//         Route::post('/permissions/{id}/approve', [CompanyPermissionController::class, 'approve']);
//         Route::post('/permissions/{id}/reject', [CompanyPermissionController::class, 'reject']);

//         // // shifts
//         Route::apiResource('/shifts', CompanyShiftController::class);
//         Route::patch('/shifts/{id}/default', [CompanyShiftController::class, 'setDefault']);

//         // // payrolls
//         Route::apiResource('/payrolls', CompanyPayrollController::class);
//         Route::post('/payrolls/{id}/status', [CompanyPayrollController::class, 'changeStatus']);

//         // // loans
//         Route::apiResource('/loans', CompanyLoanController::class);
//         Route::post('/loans/{id}/status', [CompanyLoanController::class, 'changeStatus']);

//         // report
//         Route::get('/reports/attendance', [CompanyReportController::class, 'attendance']);
//         Route::get('/reports/permission', [CompanyReportController::class, 'permission']);
//         Route::get('/reports/overtime', [CompanyReportController::class, 'overtime']);
//         Route::get('/reports/loan', [CompanyReportController::class, 'loan']);
//         Route::get('/reports/payroll', [CompanyReportController::class, 'payroll']);
//     });


// // PUBLIC API


// Route::prefix('public')->group(function () {

//     // // app info
//     // Route::get('/app-info', [AppController::class, 'info']);

//     // // prayers
//     // Route::get('/prayers', [PrayerController::class, 'today']);
//     // Route::get('/prayers/{city}', [PrayerController::class, 'byCity']);
// });


// END ROUTE NEWS #################################################################################

// ROUTE NEWS 2 #################################################################################

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register-organization', [AuthController::class, 'registerOrganization']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/update-fcm-token', [AuthController::class, 'updateFcmToken']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
    });
});


Route::prefix('company')
    ->middleware(['auth:sanctum', 'context:company'])
    ->group(function () {

        // =======================
        // 👨‍💼 EMPLOYEE (karyawan)
        // =======================
        Route::middleware('context:company,employee')->group(function () {

            Route::get('/profile', [AuthController::class, 'show']);
            Route::post('/profile', [AuthController::class, 'update']);

            Route::get('/attendances', [AttendanceController::class, 'index']);
            Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn']);
            Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut']);
            Route::get('/attendances/is-checkin', [AttendanceController::class, 'isCheckedIn']);

            Route::apiResource('/notes', NoteController::class);
            Route::apiResource('/schedules', ScheduleController::class);
            Route::post('/schedules/{id}/status', [ScheduleController::class, 'updateStatus']);

            Route::get('/payrolls', [PayrollController::class, 'index']);
            Route::get('/payrolls/{id}', [PayrollController::class, 'show']);

            Route::get('/loans', [LoanController::class, 'index']);
            Route::post('/loans', [LoanController::class, 'store']);
            Route::get('/loans/{id}', [LoanController::class, 'show']);
        });

        // =======================
        // 🧑‍💼 HR / ADMIN COMPANY
        // =======================
        Route::middleware('context:company,hr')->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index']);

            Route::get('/employees', [CompanyEmployeeController::class, 'index']);
            Route::post('/employees', [CompanyEmployeeController::class, 'store']);
            Route::put('/employees/{id}', [CompanyEmployeeController::class, 'update']);
            Route::delete('/employees/{id}', [CompanyEmployeeController::class, 'destroy']);

            Route::get('/attendances', [CompanyAttendanceController::class, 'index']);
            Route::get('/attendances/{id}', [CompanyAttendanceController::class, 'show']);
            Route::patch('/attendances/{id}/overtime', [CompanyAttendanceController::class, 'approveOvertime']);

            Route::get('/permissions', [CompanyPermissionController::class, 'index']);
            Route::post('/permissions/{id}/approve', [CompanyPermissionController::class, 'approve']);
            Route::post('/permissions/{id}/reject', [CompanyPermissionController::class, 'reject']);

            Route::apiResource('/shifts', CompanyShiftController::class);
            Route::patch('/shifts/{id}/default', [CompanyShiftController::class, 'setDefault']);

            Route::apiResource('/payrolls', CompanyPayrollController::class);
            Route::post('/payrolls/{id}/status', [CompanyPayrollController::class, 'changeStatus']);

            Route::apiResource('/loans', CompanyLoanController::class);
            Route::post('/loans/{id}/status', [CompanyLoanController::class, 'changeStatus']);

            Route::get('/reports/attendance', [CompanyReportController::class, 'attendance']);
            Route::get('/reports/permission', [CompanyReportController::class, 'permission']);
            Route::get('/reports/overtime', [CompanyReportController::class, 'overtime']);
            Route::get('/reports/loan', [CompanyReportController::class, 'loan']);
            Route::get('/reports/payroll', [CompanyReportController::class, 'payroll']);
        });
    });


Route::prefix('pesantren')
    ->middleware(['auth:sanctum', 'context:pesantren'])
    ->group(function () {

        // 🧑‍🏫 USTADZ
        Route::middleware('context:pesantren,ustadz')->group(function () {
            // Route::get('/santri', [SantriController::class, 'index']);
            // Route::get('/attendances', [PesantrenAttendanceController::class, 'index']);
        });

        // 👦 SANTRI
        Route::middleware('context:pesantren,santri')->group(function () {
            // Route::get('/my-attendance', [PesantrenAttendanceController::class, 'my']);
            // Route::get('/hafalan', [HafalanController::class, 'index']);
        });
    });

Route::prefix('school')
    ->middleware(['auth:sanctum', 'context:school'])
    ->group(function () {

        // 👩‍🏫 TEACHER
        Route::middleware('context:school,teacher')->group(function () {
            // Route::get('/classes', [ClassController::class, 'index']);
            // Route::get('/attendance', [SchoolAttendanceController::class, 'index']);
        });

        // 👨‍🎓 STUDENT
        Route::middleware('context:school,student')->group(function () {
            // Route::get('/my-attendance', [SchoolAttendanceController::class, 'my']);
            // Route::get('/schedule', [ScheduleController::class, 'my']);
        });
    });


// END ROUTE NEWS 2 #################################################################################
