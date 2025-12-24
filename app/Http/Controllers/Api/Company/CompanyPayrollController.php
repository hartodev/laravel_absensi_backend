<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payrool;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Loan;

class CompanyPayrollController extends Controller
{
    /**
     * GENERATE PAYROLL
     */
    public function generate(Request $request)
    {
        $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);

        $companyId = $request->user()->company_id;

        $employees = User::where('company_id', $companyId)
            ->where('role', 'user')
            ->get();

        foreach ($employees as $employee) {

            // Cegah double generate
            $exists = Payrool::where('user_id', $employee->id)
                ->where('period_start', $request->period_start)
                ->first();

            if ($exists) {
                continue;
            }

            // === HITUNG OVERTIME ===
            $overtimeMinutes = Attendance::where('user_id', $employee->id)
                ->whereBetween('date', [$request->period_start, $request->period_end])
                ->where('approved_overtime', true)
                ->sum('overtime_minutes');

            $overtimePay = $overtimeMinutes * 2000; // contoh rate

            // === POTONG KASBON ===
            $loan = Loan::where('user_id', $employee->id)
                ->where('status', 'approved')
                ->where('balance', '>', 0)
                ->first();

            $deduction = 0;
            if ($loan) {
                $deduction = $loan->balance / max($loan->installments, 1);
                $loan->balance -= $deduction;

                if ($loan->balance <= 0) {
                    $loan->status = 'paid';
                    $loan->balance = 0;
                }

                $loan->save();
            }

            // === SIMPAN PAYROLL ===
            $baseSalary = 5000000; // contoh
            $allowance = 500000; // contoh

            $netPay = $baseSalary + $allowance + $overtimePay - $deduction;

            Payrool::create([
                'user_id' => $employee->id,
                'period_start' => $request->period_start,
                'period_end' => $request->period_end,
                'base_salary' => $baseSalary,
                'allowance' => $allowance,
                'deductions' => $deduction,
                'overtime_pay' => $overtimePay,
                'bonus' => 0,
                'net_pay' => $netPay,
                'status' => 'draft',
            ]);
        }

        return response()->json([
            'message' => 'Payroll berhasil digenerate'
        ]);
    }

    /**
     * LIST PAYROLL
     */
    public function index(Request $request)
    {
        $query = Payrool::with('user')
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            );

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $payrolls = $query->orderBy('period_start', 'desc')->paginate(15);

        return response()->json($payrolls);
    }

    /**
     * DETAIL PAYROLL
     */
    public function show(Request $request, $id)
    {
        $payroll = Payrool::with('user')
            ->where('id', $id)
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->firstOrFail();

        return response()->json($payroll);
    }

    /**
     * APPROVE PAYROLL
     */
    public function approve(Request $request, $id)
    {
        $payroll = Payrool::where('id', $id)
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->firstOrFail();

        $payroll->status = 'approved';
        $payroll->save();

        return response()->json([
            'message' => 'Payroll disetujui'
        ]);
    }

    /**
     * MARK AS PAID
     */
    public function changeStatus(Request $request, $id)
    {
        $payroll = Payrool::where('id', $id)
            ->whereHas(
                'user',
                fn($q) =>
                $q->where('company_id', $request->user()->company_id)
            )
            ->firstOrFail();

        $payroll->status = 'paid';
        $payroll->save();

        return response()->json([
            'message' => 'Payroll ditandai sudah dibayar'
        ]);
    }
}
