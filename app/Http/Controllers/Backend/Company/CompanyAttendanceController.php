<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CompanyAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $query = Attendance::with('user')
            ->whereHas('user', fn($q) => $q->where('company_id', $companyId));

        // Filter by date
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by specific user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->latest()->paginate(20);

        // Ambil list karyawan perusahaan untuk dropdown filter
        $employees = User::where('company_id', $companyId)
            ->where('role', 'user')
            ->get();

        return view('pages.companies.attendances.index', compact('attendances', 'employees'));
    }



      public function show($id)
    {
        $attendance = Attendance::with('user')
            ->where('id', $id)
            ->whereHas('user', function($q){
                $q->where('company_id', Auth::user()->company_id);
            })
            ->firstOrFail();

        return view('pages.companies.attendances.show', compact('attendance'));
    }

}