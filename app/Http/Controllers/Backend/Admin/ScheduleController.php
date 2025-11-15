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
            'reminder_offsets'=> 'nullable|array',
            'is_task_duty'    => 'nullable|boolean',
            'location'        => 'nullable|array',
            'status'          => 'required|in:upcoming,done,canceled',
        ]);

        Schedule::create([
            'user_id'         => $request->user_id,
            'title'           => $request->title,
            'description'     => $request->description,
            'start_datetime'  => $request->start_datetime,
            'reminder_offsets'=> $request->reminder_offsets ? json_encode($request->reminder_offsets) : null,
            'is_task_duty'    => $request->is_task_duty ? 1 : 0,
            'location'        => json_encode($request->location),
            'status'          => $request->status,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully!');
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
            'reminder_offsets'=> 'nullable|array',
            'is_task_duty'    => 'nullable|boolean',
            'location'        => 'nullable|array',
            'status'          => 'required|in:upcoming,done,canceled',
        ]);

        $schedule->update([
            'user_id'         => $request->user_id,
            'title'           => $request->title,
            'description'     => $request->description,
            'start_datetime'  => $request->start_datetime,
            'reminder_offsets'=> $request->reminder_offsets ? json_encode($request->reminder_offsets) : null,
            'is_task_duty'    => $request->is_task_duty ? 1 : 0,
            'location'        => json_encode($request->location),
            'status'          => $request->status,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully!');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully!');
    }
}
