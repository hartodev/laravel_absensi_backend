<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyEmployeeController extends Controller
{
    /**
     * LIST KARYAWAN
     */
    public function index(Request $request)
    {
        $query = User::where('company_id', $request->user()->company_id)
            ->where('role', 'user');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json($employees);
    }

    /**
     * TAMBAH KARYAWAN
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'password' => 'required|min:6',
        ]);

        $employee = User::create([
            'company_id' => $request->user()->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'department' => $request->department,
            'role' => 'user',
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Karyawan berhasil ditambahkan',
            'data' => $employee
        ], 201);
    }

    /**
     * DETAIL KARYAWAN
     */
    public function show(Request $request, $id)
    {
        $employee = User::where('id', $id)
            ->where('company_id', $request->user()->company_id)
            ->where('role', 'user')
            ->firstOrFail();

        return response()->json($employee);
    }

    /**
     * UPDATE KARYAWAN
     */
    public function update(Request $request, $id)
    {
        $employee = User::where('id', $id)
            ->where('company_id', $request->user()->company_id)
            ->where('role', 'user')
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        $employee->update($request->only([
            'name',
            'phone',
            'position',
            'department'
        ]));

        return response()->json([
            'message' => 'Data karyawan berhasil diperbarui',
            'data' => $employee
        ]);
    }

    /**
     * NONAKTIF / AKTIF KARYAWAN
     */
    public function updateStatus(Request $request, $id)
    {
        $employee = User::where('id', $id)
            ->where('company_id', $request->user()->company_id)
            ->where('role', 'user')
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        // gunakan email_verified_at sebagai flag aktif sederhana
        if ($request->status === 'inactive') {
            $employee->email_verified_at = null;
        } else {
            $employee->email_verified_at = now();
        }

        $employee->save();

        return response()->json([
            'message' => 'Status karyawan berhasil diperbarui'
        ]);
    }
}
