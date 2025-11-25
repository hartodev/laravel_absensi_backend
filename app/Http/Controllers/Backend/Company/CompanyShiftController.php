<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;


class CompanyShiftController extends Controller
{
      public function index()
    {
        $companyId = Auth::user()->company_id;

        $shifts = Shift::where('company_id', $companyId)->paginate(10);

        return view('pages.companies.shiftser.index', compact('shifts'));
    }

    public function create()
    {
        return view('pages.companies.shiftser.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'    => 'required|string',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'grace_period_minutes' => 'nullable|integer|min:0',
            'is_default' => 'boolean',
        ]);

        Shift::create([
            'company_id' => Auth::user()->company_id,
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'grace_period_minutes' => $request->grace_period_minutes ?? 15,
            'is_default' => $request->is_default ? 1 : 0,
        ]);

        return redirect()->route('company.shifts.index')->with('success', 'Shift created successfully.');
    }



    public function edit($id)
    {
        $shift = Shift::where('company_id', Auth::user()->company_id)->findOrFail($id);

        return view('pages.companies.shiftser.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $shift = Shift::where('company_id', Auth::user()->company_id)->findOrFail($id);

        $request->validate([
            'name'    => 'required|string',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'grace_period_minutes' => 'nullable|integer|min:0',
            'is_default' => 'boolean',
        ]);

        $shift->update([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'grace_period_minutes' => $request->grace_period_minutes ?? 15,
            'is_default' => $request->is_default ? 1 : 0,
        ]);

        return redirect()->route('company.shifts.index')->with('success', 'Shift updated successfully.');
    }

    public function destroy($id)
    {
        $shift = Shift::where('company_id', Auth::user()->company_id)->findOrFail($id);

        $shift->delete();

        return redirect()->route('company.shifts.index')->with('success', 'Shift deleted.');
    }
}
