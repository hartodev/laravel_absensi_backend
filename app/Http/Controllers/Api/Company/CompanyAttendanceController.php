<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class CompanyAttendanceController extends Controller
{
    /**
     * LIST ABSENSI KARYAWAN
     */
    public function index(Request $request)
    {
        $query = Attendance::with('user')
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            });

        // filter tanggal
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        // filter user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(15);

        return response()->json($attendances);
    }

    /**
     * DETAIL ABSENSI
     */
    public function show(Request $request, $id)
    {
        $attendance = Attendance::with('user')
            ->where('id', $id)
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            })
            ->firstOrFail();

        return response()->json($attendance);
    }

    /**
     * APPROVE / REJECT OVERTIME
     */
    public function approveOvertime(Request $request, $id)
    {
        $attendance = Attendance::where('id', $id)
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            })
            ->firstOrFail();

        $request->validate([
            'approved' => 'required|boolean'
        ]);

        $attendance->approved_overtime = $request->approved;
        $attendance->save();

        return response()->json([
            'message' => $request->approved
                ? 'Overtime disetujui'
                : 'Overtime ditolak',
            'data' => $attendance
        ]);
    }
}
