<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;

class CompanyPermissionController extends Controller
{
    /**
     * LIST IZIN KARYAWAN
     */
    public function index(Request $request)
    {
        $query = Permission::with('user')
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            });

        if ($request->status !== null) {
            $query->where('is_approved', $request->status);
        }

        if ($request->date) {
            $query->whereDate('date_permission', $request->date);
        }

        $permissions = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json($permissions);
    }

    /**
     * DETAIL IZIN
     */
    public function show(Request $request, $id)
    {
        $permission = Permission::with('user')
            ->where('id', $id)
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            })
            ->firstOrFail();

        return response()->json($permission);
    }

    /**
     * APPROVE / REJECT IZIN
     */
    public function approve(Request $request, $id)
    {
        $permission = Permission::where('id', $id)
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            })
            ->firstOrFail();

        $request->validate([
            'approved' => 'required|boolean'
        ]);

        $permission->is_approved = $request->approved;
        $permission->save();

        return response()->json([
            'message' => $request->approved
                ? 'Izin disetujui'
                : 'Izin ditolak',
            'data' => $permission
        ]);
    }
}
