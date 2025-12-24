<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;


class PermissionController extends Controller
{
    // //create
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'date' => 'required',
    //         'reason' => 'required',
    //     ]);

    //     $permission = new Permission();
    //     $permission->user_id = $request->user()->id;
    //     $permission->date_permission = $request->date;
    //     $permission->reason = $request->reason;
    //     $permission->is_approved = 0;

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $image->storeAs('public/permissions', $image->hashName());
    //         $permission->image = $image->hashName();
    //     }

    //     $permission->save();

    //     return response()->json(['message' => 'Permission created successfully'], 201);
    // }


    // versi 2
        public function index(Request $request)
    {
        $permissions = Permission::where('user_id', $request->user()->id)
            ->orderBy('date_permission', 'desc')
            ->paginate(15);

        return response()->json($permissions);
    }

    /**
     * AJUKAN IZIN / CUTI
     */
public function store(Request $request)
{
    $request->validate([
        'date_permission' => 'required|date',
        'reason' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Cegah izin ganda di tanggal sama
    $exists = Permission::where('user_id', $request->user()->id)
        ->where('date_permission', $request->date_permission)
        ->first();

    if ($exists) {
        return response()->json([
            'message' => 'Izin pada tanggal tersebut sudah diajukan'
        ], 400);
    }

    $permission = new Permission();
    $permission->user_id = $request->user()->id;
    $permission->date_permission = $request->date_permission;
    $permission->reason = $request->reason;
    $permission->is_approved = false;

    // Upload image ke public/image/permission
    if ($request->hasFile('image')) {
        $image = $request->file('image');

        $filename = time() . '_' . $image->hashName();
        $image->move(public_path('image/permission'), $filename);

        $permission->image = 'image/permission/' . $filename;
    }

    $permission->save();

    return response()->json([
        'message' => 'Pengajuan izin berhasil',
        'data' => $permission
    ], 201);
}


    /**
     * DETAIL IZIN
     */
    public function show(Request $request, $id)
    {
        $permission = Permission::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($permission);
    }
}
