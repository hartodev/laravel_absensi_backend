<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    /**
     * LIST KASBON USER
     */
    public function index(Request $request)
    {
        $loans = Loan::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalBalance = Loan::where('user_id', $request->user()->id)
            ->whereIn('status', ['approved', 'pending'])
            ->sum('balance');

        return response()->json([
            'data' => $loans,
            'total_balance' => $totalBalance
        ]);
    }

    /**
     * AJUKAN KASBON
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'installments' => 'required|integer|min:1',
        ]);

        $loan = Loan::create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'balance' => $request->amount,
            'installments' => $request->installments,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Pengajuan kasbon berhasil',
            'data' => $loan
        ], 201);
    }

    /**
     * DETAIL KASBON
     */
    public function show(Request $request, $id)
    {
        $loan = Loan::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($loan);
    }
}
