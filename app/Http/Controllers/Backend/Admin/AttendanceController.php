<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')->latest('date')->paginate(15);
        return view('pages.admin.attendances.index', compact('attendances'));
    }

    /**
     * Form tambah absensi manual
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.admin.attendances.create', compact('users'));
    }

    /**
     * Simpan absensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after_or_equal:time_in',
            'latlon_in' => 'nullable|string|max:100',
            'latlon_out' => 'nullable|string|max:100',
            'status' => 'required|in:on_time,late,absent,permission,overtime,guest',
            'overtime_minutes' => 'nullable|integer|min:0',
            'approved_overtime' => 'nullable|boolean',

        ]);

        Attendance::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'latlon_in' => $request->latlon_in,
            'latlon_out' => $request->latlon_out,
            'status' => $request->status,
            'overtime_minutes' => $request->overtime_minutes ?? 0,
            'approved_overtime' => $request->approved_overtime ?? false,
        ]);

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil ditambahkan.');
    }

    /**
     * Form edit absensi
     */
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $users = User::where('role', 'user')->get();
        return view('pages.admin.attendances.edit', compact('attendance', 'users'));
    }

    /**
     * Update absensi
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

           // Normalisasi format waktu
    $request->merge([
        'time_in'  => $request->time_in ? str_replace('.', ':', $request->time_in) : null,
        'time_out' => $request->time_out ? str_replace('.', ':', $request->time_out) : null,
    ]);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after_or_equal:time_in',
            'latlon_in' => 'nullable|string|max:100',
            'latlon_out' => 'nullable|string|max:100',
            'status' => 'required|in:on_time,late,absent,permission,overtime,guest',
            'overtime_minutes' => 'nullable|integer|min:0',
           'approved_overtime' => 'nullable|boolean',

        ]);

        $attendance->update([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'latlon_in' => $request->latlon_in,
            'latlon_out' => $request->latlon_out,
            'status' => $request->status,
            'overtime_minutes' => $request->overtime_minutes ?? 0,
            'approved_overtime' => $request->approved_overtime ?? false,
        ]);

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    /**
     * Hapus data absensi
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
