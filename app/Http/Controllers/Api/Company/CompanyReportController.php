<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Permission;
use App\Models\Loan;
use App\Models\Payrool;

class CompanyReportController extends Controller
{
    /**
     * REPORT ABSENSI
     */
    public function attendance(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $data = Attendance::with('user')
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->get();

        return response()->json($data);
    }

    /**
     * REPORT IZIN
     */
    public function permission(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $data = Permission::with('user')
            ->whereBetween('date_permission', [$request->start_date, $request->end_date])
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->get();

        return response()->json($data);
    }

    /**
     * REPORT LEMBUR
     */
    public function overtime(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $data = Attendance::with('user')
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->where('approved_overtime', true)
            ->where('overtime_minutes', '>', 0)
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->get();

        return response()->json($data);
    }

    /**
     * REPORT KASBON
     */
    public function loan(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $data = Loan::with('user')
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->get();

        return response()->json($data);
    }

    /**
     * REPORT PAYROLL
     */
    public function payroll(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $data = Payrool::with('user')
            ->whereBetween('period_start', [$request->start_date, $request->end_date])
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->get();

        return response()->json($data);
    }
}
