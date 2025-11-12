<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PermissionController extends Controller
{
      /**
     * List semua permission
     */
    public function index()
    {
        $permissions = Permission::with('user')->latest()->paginate(10);
        return view('pages.admin.permission.index', compact('permissions'));
    }

    /**
     * Form tambah permission manual
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.admin.permission.create', compact('users'));
    }

    /**
     * Simpan permission baru
     */
public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'date_permission' => 'required|date',
        'reason' => 'required|string|min:5',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'is_approved' => 'nullable|boolean',
    ]);

    $data = $request->only(['user_id', 'date_permission', 'reason', 'is_approved']);
    $data['is_approved'] = $request->is_approved ?? false;

    if ($request->hasFile('image')) {
        // Buat folder jika belum ada
        $path = public_path('image/permission');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Simpan file ke folder public/image/permission
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($path, $filename);

        // Simpan path relatif ke database
        $data['image'] = 'image/permission/' . $filename;
    }

    Permission::create($data);

    return redirect()->route('permissions.index')->with('success', 'Data izin berhasil ditambahkan.');
}


    /**
     * Edit permission
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $users = User::where('role', 'user')->get();
        return view('pages.admin.permission.edit', compact('permission', 'users'));
    }

    /**
     * Update permission
     */
    public function update(Request $request, $id)
{
    $permission = Permission::findOrFail($id);

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'date_permission' => 'required|date',
        'reason' => 'required|string|min:5',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'is_approved' => 'nullable|boolean',
    ]);

    $data = $request->only(['user_id', 'date_permission', 'reason', 'is_approved']);
    $data['is_approved'] = $request->is_approved ?? false;

    if ($request->hasFile('image')) {
        $path = public_path('image/permission');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Hapus gambar lama jika ada
        if ($permission->image && file_exists(public_path($permission->image))) {
            unlink(public_path($permission->image));
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($path, $filename);

        $data['image'] = 'image/permission/' . $filename;
    }

    $permission->update($data);

    return redirect()->route('permissions.index')->with('success', 'Data izin berhasil diperbarui.');
}


    /**
     * Hapus permission
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if ($permission->image && Storage::disk('public')->exists($permission->image)) {
            Storage::disk('public')->delete($permission->image);
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Data izin berhasil dihapus.');
    }
}
