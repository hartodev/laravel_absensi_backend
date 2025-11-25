<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payrool;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyPayroolsController extends Controller
{
        public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $query = Payrool::with('user')
            ->whereHas('user', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $payrolls = $query->paginate(10);

        return view('pages.companies.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $companyId = Auth::user()->company_id;
        $users = User::where('company_id', $companyId)->where('role', 'user')->get();

        return view('pages.companies.payrolls.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'period_start'  => 'required|date',
            'period_end'    => 'required|date|after_or_equal:period_start',
            'base_salary'   => 'required|numeric|min:0',
            'allowance'     => 'required|numeric|min:0',
            'deductions'    => 'required|numeric|min:0',
            'overtime_pay'  => 'required|numeric|min:0',
            'bonus'         => 'required|numeric|min:0',
        ]);

        $net = $request->base_salary + 
               $request->allowance + 
               $request->overtime_pay + 
               $request->bonus - 
               $request->deductions;

        Payrool::create([
            'user_id'      => $request->user_id,
            'period_start' => $request->period_start,
            'period_end'   => $request->period_end,
            'base_salary'  => $request->base_salary,
            'allowance'    => $request->allowance,
            'deductions'   => $request->deductions,
            'overtime_pay' => $request->overtime_pay,
            'bonus'        => $request->bonus,
            'net_pay'      => $net,
            'status'       => 'draft',
        ]);

        return redirect()->route('company.payrolls.index')->with('success', 'Payroll created successfully!');
    }

    public function edit($id)
    {
        $payroll = Payrool::findOrFail($id);

        if ($payroll->status == 'paid') {
            return back()->with('error', 'Paid payroll cannot be edited.');
        }

        $companyId = Auth::user()->company_id;
        $users = User::where('company_id', $companyId)->get();

        return view('pages.companies.payrolls.edit', compact('payroll', 'users'));
    }

    public function update(Request $request, $id)
    {
        $payroll = Payrool::findOrFail($id);

        if ($payroll->status == 'paid') {
            return back()->with('error', 'Paid payroll cannot be edited.');
        }

        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'period_start'  => 'required|date',
            'period_end'    => 'required|date|after_or_equal:period_start',
            'base_salary'   => 'required|numeric|min:0',
            'allowance'     => 'required|numeric|min:0',
            'deductions'    => 'required|numeric|min:0',
            'overtime_pay'  => 'required|numeric|min:0',
            'bonus'         => 'required|numeric|min:0',
        ]);

        $net = $request->base_salary + 
               $request->allowance + 
               $request->overtime_pay + 
               $request->bonus - 
               $request->deductions;

        $payroll->update([
            'user_id'      => $request->user_id,
            'period_start' => $request->period_start,
            'period_end'   => $request->period_end,
            'base_salary'  => $request->base_salary,
            'allowance'    => $request->allowance,
            'deductions'   => $request->deductions,
            'overtime_pay' => $request->overtime_pay,
            'bonus'        => $request->bonus,
            'net_pay'      => $net,
        ]);

        return redirect()->route('company.payrolls.index')->with('success', 'Payroll updated successfully!');
    }

    public function destroy($id)
    {
        Payrool::findOrFail($id)->delete();

        return redirect()->route('company.payrolls.index')->with('success', 'Payroll deleted.');
    }

    public function changeStatus(Request $request, $id)
    {
        $payroll = Payrool::findOrFail($id);

        $request->validate([
            'status' => 'required|in:draft,approved,paid'
        ]);

        $payroll->status = $request->status;
        $payroll->save();

        return back()->with('success', 'Status updated successfully');
    }
}
