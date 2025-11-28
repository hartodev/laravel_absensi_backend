<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;


class UserAttendanceController extends Controller
{
      public function index(Request $request)
    {
        $userId = Auth::id();

        // Filter by date (optional)
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        $query = Attendance::where('user_id', $userId);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(20);

        return view('pages.user.attendances.index', compact('attendances', 'startDate', 'endDate'));
    }
}
