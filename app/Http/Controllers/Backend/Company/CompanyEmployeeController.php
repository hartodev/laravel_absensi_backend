<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyEmployeeController extends Controller
{
      public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $employees = User::where('company_id', $companyId)
            ->where('role', 'user')
            ->latest()
            ->paginate(20);

        return view('pages.companies.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('pages.companies.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|string',
            'position'  => 'nullable|string',
            'department'=> 'nullable|string',
            'password'  => 'required|min:6',
        ]);

        User::create([
            'company_id' => Auth::user()->company_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'position'   => $request->position,
            'department' => $request->department,
            'role'       => 'user',
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully!');
    }

    public function edit($id)
    {
        $employee = User::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->where('role', 'user')
            ->firstOrFail();

        return view('company.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->where('role', 'user')
            ->firstOrFail();

        $request->validate([
            'name'      => 'required',
            'email'     => "required|email|unique:users,email,{$id}",
            'phone'     => 'nullable|string',
            'position'  => 'nullable|string',
            'department'=> 'nullable|string',
            'password'  => 'nullable|min:6',
        ]);

        $employee->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'position'  => $request->position,
            'department'=> $request->department,
            'password'  => $request->password ? Hash::make($request->password) : $employee->password,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = User::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->where('role', 'user')
            ->firstOrFail();

        $employee->delete();

        return back()->with('success', 'Employee deleted successfully!');
    }
}
