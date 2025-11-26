<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CompanyDashboardController extends Controller
{
    // public function index()
    // {
    //     return view('pages.companies.dashboard');
    // }

    public function index()
    {
        $companyId = Auth::user()->company_id;
        $today     = Carbon::today();

        // Employees under this company
        $employees = User::where('company_id', $companyId)
                         ->where('role', 'user')
                         ->pluck('id');

        return view('pages.companies.dashboard', [
            'totalEmployees'     => $employees->count(),

            'todayPresent'       => Attendance::whereIn('user_id', $employees)
                ->whereDate('date', $today)
                ->whereNotNull('time_in')
                ->count(),

            'todayLate'          => Attendance::whereIn('user_id', $employees)
                ->whereDate('date', $today)
                ->where('status', 'late')
                ->count(),

            'todayPermission'    => Permission::whereIn('user_id', $employees)
                ->whereDate('date_permission', $today)
                ->count(),

            'todayOvertime'      => Attendance::whereIn('user_id', $employees)
                ->whereDate('date', $today)
                ->where('status', 'overtime')
                ->count(),

            'outsideAttendance'  => Attendance::whereIn('user_id', $employees)
                ->whereDate('date', $today)
                ->where('status', 'guest')
                ->count(),

            'todayAttendanceList' => Attendance::with('user')
                ->whereIn('user_id', $employees)
                ->whereDate('date', $today)
                ->latest()
                ->limit(10)
                ->get(),

            'permissionList' => Permission::with('user')
                ->whereIn('user_id', $employees)
                ->latest()
                ->limit(10)
                ->get(),
        ]);
    }
}
