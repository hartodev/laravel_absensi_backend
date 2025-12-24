<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;

class CompanyShiftController extends Controller
{
    /**
     * LIST SHIFT
     */
    public function index(Request $request)
    {
        $shifts = Shift::where('company_id', $request->user()->company_id)
            ->orderBy('is_default', 'desc')
            ->orderBy('start_time')
            ->get();

        return response()->json($shifts);
    }

    /**
     * CREATE SHIFT
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'grace_period_minutes' => 'nullable|integer|min:0',
        ]);

        $shift = Shift::create([
            'company_id' => $request->user()->company_id,
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'grace_period_minutes' => $request->grace_period_minutes ?? 15,
            'is_default' => false,
        ]);

        return response()->json([
            'message' => 'Shift berhasil dibuat',
            'data' => $shift
        ], 201);
    }

    /**
     * DETAIL SHIFT
     */
    public function show(Request $request, $id)
    {
        $shift = Shift::where('id', $id)
            ->where('company_id', $request->user()->company_id)
            ->firstOrFail();

        return response()->json($shift);
    }

    /**
     * UPDATE SHIFT
     */
    public function update(Request $request, $id)
    {
        $shift = Shift::where('id', $id)
            ->where('company_id', $request->user()->company_id)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'grace_period_minutes' => 'nullable|integer|min:0',
        ]);

        $shift->update($request->only([
            'name',
            'start_time',
            'end_time',
            'grace_period_minutes'
        ]));

        return response()->json([
            'message' => 'Shift berhasil diperbarui',
            'data' => $shift
        ]);
    }

    /**
     * DELETE SHIFT
     */
    public function destroy(Request $request, $id)
    {
        $shift = Shift::where('id', $id)
            ->where('company_id', $request->user()->company_id)
            ->firstOrFail();

        $shift->delete();

        return response()->json([
            'message' => 'Shift berhasil dihapus'
        ]);
    }

    /**
     * SET DEFAULT SHIFT
     */
    public function setDefault(Request $request, $id)
    {
        // reset default
        Shift::where('company_id', $request->user()->company_id)
            ->update(['is_default' => false]);

        $shift = Shift::where('id', $id)
            ->where('company_id', $request->user()->company_id)
            ->firstOrFail();

        $shift->is_default = true;
        $shift->save();

        return response()->json([
            'message' => 'Shift default berhasil diatur',
            'data' => $shift
        ]);
    }
}
