<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;

class ScheduleController extends Controller
{
      public function index()
    {
        $schedules = Schedule::with('user')->latest()->paginate(20);
        return view('pages.admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.admin.schedules.create', compact('users'));
    }

public function store(Request $request)
{
    $request->validate([
        'user_id'         => 'required|exists:users,id',
        'title'           => 'required|string',
        'description'     => 'nullable|string',
        'start_datetime'  => 'required|date',

        // string lalu diolah manual
        'reminder_offsets'=> 'nullable|string',  

        // string JSON lalu di-decode
        'location'        => 'nullable|string',

        'is_task_duty'    => 'nullable|boolean',
        'status'          => 'required|in:upcoming,done,canceled',
    ]);

    // Convert reminder_offsets string "5,15,60" -> array [5,15,60]
    $reminderOffsets = null;
    if (!empty($request->reminder_offsets)) {
        $reminderOffsets = array_map('intval', explode(',', $request->reminder_offsets));
    }

    // Convert location => JSON decode
    $location = null;
    if (!empty($request->location)) {
        $location = json_decode($request->location, true);
    }

    Schedule::create([
        'user_id'         => $request->user_id,
        'title'           => $request->title,
        'description'     => $request->description,
        'start_datetime'  => $request->start_datetime,
        'reminder_offsets'=> $reminderOffsets,
        'location'        => $location,
        'is_task_duty'    => $request->is_task_duty ? 1 : 0,
        'status'          => $request->status,
    ]);

    return redirect()->route('schedules.index')
                     ->with('success', 'Schedule created successfully!');
}

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $users = User::where('role', 'user')->get();

        return view('pages.admin.schedules.edit', compact('schedule', 'users'));
    }

 public function update(Request $request, $id)
{
    $schedule = Schedule::findOrFail($id);

    $request->validate([
        'user_id'         => 'required|exists:users,id',
        'title'           => 'required|string',
        'description'     => 'nullable|string',
        'start_datetime'  => 'required|date',
        'reminder_offsets'=> 'nullable|string',   // string, bukan array
        'location'        => 'nullable|string',   // JSON string
        'is_task_duty'    => 'nullable|boolean',
        'status'          => 'required|in:upcoming,done,canceled',
    ]);

    // Convert reminder offsets
    $reminderOffsets = null;
    if (!empty($request->reminder_offsets)) {
        $reminderOffsets = array_map('intval', explode(',', $request->reminder_offsets));
    }

    // Convert location JSON
    $location = null;
    if (!empty($request->location)) {
        $location = json_decode($request->location, true);
    }

    $schedule->update([
        'user_id'         => $request->user_id,
        'title'           => $request->title,
        'description'     => $request->description,
        'start_datetime'  => $request->start_datetime,
        'reminder_offsets'=> $reminderOffsets,
        'location'        => $location,
        'is_task_duty'    => $request->is_task_duty ? 1 : 0,
        'status'          => $request->status,
    ]);

    return redirect()->route('schedules.index')
                     ->with('success', 'Schedule updated successfully!');
}

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully!');
    }
}