<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Permission;
use App\Models\Loan;
use App\Models\Payrool;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $companyId = $request->user()->company_id;
        $today = Carbon::today();

        // Total karyawan (role user)
        $totalEmployees = User::where('company_id', $companyId)
            ->where('role', 'user')
            ->count();

        // Absensi hari ini
        $attendanceToday = Attendance::whereDate('date', $today)
            ->whereHas('user', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $attendanceSummary = [
            'on_time' => (clone $attendanceToday)->where('status', 'on_time')->count(),
            'late' => (clone $attendanceToday)->where('status', 'late')->count(),
            'permission' => (clone $attendanceToday)->where('status', 'permission')->count(),
            'absent' => (clone $attendanceToday)->where('status', 'absent')->count(),
        ];

        // Pending approval
        $pendingPermissions = Permission::where('is_approved', false)
            ->whereHas('user', fn($q) => $q->where('company_id', $companyId))
            ->count();

        $pendingLoans = Loan::where('status', 'pending')
            ->whereHas('user', fn($q) => $q->where('company_id', $companyId))
            ->count();

        // Overtime hari ini
        $overtimeToday = Attendance::whereDate('date', $today)
            ->where('overtime_minutes', '>', 0)
            ->whereHas('user', fn($q) => $q->where('company_id', $companyId))
            ->sum('overtime_minutes');

        // Payroll bulan berjalan (opsional)
        $currentMonth = Carbon::now()->format('Y-m');
        $payrollSummary = Payrool::whereHas('user', fn($q) => $q->where('company_id', $companyId))
            ->whereRaw("DATE_FORMAT(period_start, '%Y-%m') = ?", [$currentMonth])
            ->selectRaw('
                COUNT(*) as total_slips,
                SUM(net_pay) as total_net_pay
            ')
            ->first();

        return response()->json([
            'employees' => [
                'total' => $totalEmployees
            ],
            'attendance_today' => $attendanceSummary,
            'pending' => [
                'permissions' => $pendingPermissions,
                'loans' => $pendingLoans
            ],
            'overtime_today_minutes' => $overtimeToday,
            'payroll_monthly' => [
                'month' => $currentMonth,
                'total_slips' => $payrollSummary->total_slips ?? 0,
                'total_net_pay' => $payrollSummary->total_net_pay ?? 0
            ]
        ]);
    }
}
