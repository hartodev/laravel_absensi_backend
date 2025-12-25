<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * LIST JADWAL USER
     */
    public function index(Request $request)
    {
        $query = Schedule::where('user_id', $request->user()->id);

        // filter status (optional)
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $schedules = $query
            ->orderBy('start_datetime', 'asc')
            ->paginate(15);

        return response()->json($schedules);
    }

    /**
     * SIMPAN JADWAL BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'reminder_offsets' => 'nullable|array',
            'reminder_offsets.*' => 'integer',
            'is_task_duty' => 'boolean',
            'location' => 'nullable|array',
        ]);

        $schedule = Schedule::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'start_datetime' => $request->start_datetime,
            'reminder_offsets' => $request->reminder_offsets,
            'is_task_duty' => $request->is_task_duty ?? false,
            'location' => $request->location,
            'status' => 'upcoming',
        ]);

        return response()->json([
            'message' => 'Jadwal berhasil dibuat',
            'data' => $schedule
        ], 201);
    }

    /**
     * DETAIL JADWAL
     */
    public function show(Request $request, $id)
    {
        $schedule = Schedule::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($schedule);
    }

    /**
     * UPDATE JADWAL
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'reminder_offsets' => 'nullable|array',
            'reminder_offsets.*' => 'integer',
            'location' => 'nullable|array',
        ]);

        $schedule->update($request->only([
            'title',
            'description',
            'start_datetime',
            'reminder_offsets',
            'location'
        ]));

        return response()->json([
            'message' => 'Jadwal berhasil diperbarui',
            'data' => $schedule
        ]);
    }

    /**
     * UPDATE STATUS JADWAL
     */
    public function updateStatus(Request $request, $id)
    {
        $schedule = Schedule::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:upcoming,done,canceled'
        ]);

        $schedule->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status jadwal diperbarui',
            'data' => $schedule
        ]);
    }

    /**
     * HAPUS JADWAL
     */
    public function destroy(Request $request, $id)
    {
        $schedule = Schedule::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $schedule->delete();

        return response()->json([
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }
}
