<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;

class CompanyLoanController extends Controller
{

    /**
     * LIST KASBON
     */
    public function index(Request $request)
    {
        $query = Loan::with('user')
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            });

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json($loans);
    }

    /**
     * DETAIL KASBON
     */
    public function show(Request $request, $id)
    {
        $loan = Loan::with('user')
            ->where('id', $id)
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            })
            ->firstOrFail();

        return response()->json($loan);
    }

    /**
     * APPROVE / REJECT KASBON
     */
    public function approve(Request $request, $id)
    {
        $loan = Loan::where('id', $id)
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', $request->user()->company_id);
            })
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $loan->status = $request->status;

        // jika ditolak, balance jadi 0
        if ($request->status === 'rejected') {
            $loan->balance = 0;
        }

        $loan->save();

        return response()->json([
            'message' => $request->status === 'approved'
                ? 'Kasbon disetujui'
                : 'Kasbon ditolak',
            'data' => $loan
        ]);
    }
}
