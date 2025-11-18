<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Permission;
use Carbon\Carbon;
use App\Models\User;


class AdminDashboardController extends Controller
{
          public function index()
    {
        $today = Carbon::today();

        return view('pages.admin.dashboard', [
            'totalCompanies'      => Company::count(),
            'totalEmployees'      => User::where('role', 'user')->count(),
            'todayPresent'        => Attendance::whereDate('date', $today)->whereNotNull('time_in')->count(),
            'todayLate'           => Attendance::whereDate('date', $today)->where('status', 'late')->count(),
            'todayPermission'     => Permission::whereDate('date_permission', $today)->count(),
            'outsideAttendance'   => Attendance::whereDate('date', $today)->where('status', 'guest')->count(),

            // Untuk daftar kehadiran kanan
            'todayAttendanceList' => Attendance::with('user')
                ->whereDate('date', $today)
                ->latest()
                ->limit(10)
                ->get(),

            // Permission table
            'permissionList' => Permission::with('user')
                ->latest()
                ->limit(10)
                ->get(),
        ]);
    }
}
