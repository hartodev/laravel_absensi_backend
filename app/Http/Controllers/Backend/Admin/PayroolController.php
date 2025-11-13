<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payrool;
use App\Models\User;

class PayroolController extends Controller
{
     public function index()
    {
        $payrolls = Payrool::with('user')->latest()->paginate(10);
        return view('pages.admin.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.admin.payrolls.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'base_salary' => 'required|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,approved,paid',
        ]);

        $net_pay = $request->base_salary + $request->allowance + $request->overtime_pay + $request->bonus - $request->deductions;

        Payrool::create([
            'user_id' => $request->user_id,
            'period_start' => $request->period_start,
            'period_end' => $request->period_end,
            'base_salary' => $request->base_salary,
            'allowance' => $request->allowance,
            'deductions' => $request->deductions,
            'overtime_pay' => $request->overtime_pay,
            'bonus' => $request->bonus,
            'net_pay' => $net_pay,
            'status' => $request->status,
        ]);

        return redirect()->route('payrools.index')->with('success', 'Data payroll berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $payroll = Payrool::findOrFail($id);
        $users = User::where('role', 'user')->get();
        return view('pages.admin.payrolls.edit', compact('payroll', 'users'));
    }

    public function update(Request $request, $id)
    {
        $payroll = Payrool::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'base_salary' => 'required|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,approved,paid',
        ]);

        $net_pay = $request->base_salary + $request->allowance + $request->overtime_pay + $request->bonus - $request->deductions;

        $payroll->update([
            'user_id' => $request->user_id,
            'period_start' => $request->period_start,
            'period_end' => $request->period_end,
            'base_salary' => $request->base_salary,
            'allowance' => $request->allowance,
            'deductions' => $request->deductions,
            'overtime_pay' => $request->overtime_pay,
            'bonus' => $request->bonus,
            'net_pay' => $net_pay,
            'status' => $request->status,
        ]);

        return redirect()->route('payrools.index')->with('success', 'Data payroll berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $payroll = Payrool::findOrFail($id);
        $payroll->delete();
        return redirect()->route('payrools.index')->with('success', 'Data payroll berhasil dihapus.');
    }
}
