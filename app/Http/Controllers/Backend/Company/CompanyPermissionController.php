<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class CompanyPermissionController extends Controller
{
     public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $permissions = Permission::with('user')
            ->whereHas('user', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->latest()
            ->paginate(20);

        return view('pages.companies.permissions.index', compact('permissions'));
    }

    public function approve($id)
    {
        $companyId = Auth::user()->company_id;

        $permission = Permission::with('user')->where('id', $id)->firstOrFail();

        // keamanan: hanya approve izin employees yang satu company
        if ($permission->user->company_id != $companyId) {
            abort(403);
        }

        $permission->update([
            'is_approved' => true
        ]);

        return back()->with('success', 'Permission approved successfully');
    }

    public function reject($id)
    {
        $companyId = Auth::user()->company_id;

        $permission = Permission::with('user')->where('id', $id)->firstOrFail();

        if ($permission->user->company_id != $companyId) {
            abort(403);
        }

        $permission->update([
            'is_approved' => false
        ]);

        return back()->with('success', 'Permission rejected');
    }
}
