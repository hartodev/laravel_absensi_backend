<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyLoansController extends Controller
{
    // LIST LOANS
    public function index( )    {
        $companyId = Auth::user()->company_id;

        $loans = Loan::with('user')
            ->whereHas('user', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->latest()
            ->paginate(10);

        return view('pages.companies.loans.index', compact('loans'));
    }

    // CREATE
    public function create()
    {
        $employees = User::where('company_id', Auth::user()->company_id)
            ->where('role', 'user')
            ->get();

        return view('pages.companies.loans.create', compact('employees'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'amount'       => 'required|numeric|min:0',
            'installments' => 'required|numeric|min:1',
        ]);

        Loan::create([
            'user_id'     => $request->user_id,
            'amount'      => $request->amount,
            'balance'     => $request->amount,
            'installments'=> $request->installments,
            'status'      => 'pending',
        ]);

        return redirect()->route('company.loans.index')
            ->with('success', 'Loan created successfully!');
    }

    // EDIT
    public function edit($id)
    {
        $loan = Loan::findOrFail($id);

        $employees = User::where('company_id', Auth::user()->company_id)
            ->where('role', 'user')
            ->get();

        return view('pages.companies.loans.edit', compact('loan', 'employees'));
    }

    // UPDATE
//     public function update(Request $request, $id)
//     {  $loan = Loan::findOrFail($id);

//     if ($loan->status == 'paid') {
//         return back()->with('error', 'Paid loan cannot be edited.');
//     }

//     $request->validate([
//         'user_id'      => 'required|exists:users,id',
//         'amount'       => 'required|numeric|min:0',
//         'installments' => 'required|numeric|min:1',
//         'status'       => 'required|in:pending,approved,rejected,paid',
//     ]);

//     // --- HITUNG BALANCE BARU ---
//     // balance lama
//     $oldBalance = $loan->balance;
//     $oldAmount  = $loan->amount;
//     $newAmount  = $request->amount;

//     // Koreksi balance berdasarkan perubahan amount
//     // Jika amount naik → balance naik
//     // Jika amount turun → balance turun (max 0)
//     $newBalance = $oldBalance - ($oldAmount - $newAmount);
//     if ($newBalance < 0) {
//         $newBalance = 0;
//     }

//     // Update
//     $loan->update([
//         'user_id'      => $request->user_id,
//         'amount'       => $newAmount,
//         'installments' => $request->installments,
//         'balance'      => $newBalance,
//         'status'       => $request->status,
//     ]);

//     return redirect()->route('company.loans.index')
//         ->with('success', 'Loan updated successfully!');
// }

// UPDATE
public function update(Request $request, $id)
{
    $loan = Loan::findOrFail($id);

    if ($loan->status == 'paid') {
        return back()->with('error', 'Paid loan cannot be edited.');
    }

    $request->validate([
        'user_id'      => 'required|exists:users,id',
        'amount'       => 'required|numeric|min:0',
        'installments' => 'required|numeric|min:1',
        'status'       => 'required|in:pending,approved,rejected,paid',
        'payment'      => 'nullable|numeric|min:0',
    ]);

    $oldBalance = $loan->balance;
    $payment = $request->payment ?? 0;

    // kurangi balance jika ada pembayaran
    $newBalance = $oldBalance - $payment;

    if ($newBalance < 0) {
        $newBalance = 0;
    }

    // update
    $loan->update([
        'user_id'      => $request->user_id,
        'amount'       => $request->amount,
        'installments' => $request->installments,
        'balance'      => $newBalance,
        'status'       => $request->status,
    ]);

    return redirect()->route('company.loans.index')
        ->with('success', 'Loan updated successfully!');
}


    // DELETE
    public function destroy($id)
    {
        Loan::findOrFail($id)->delete();

        return back()->with('success', 'Loan deleted successfully');
    }

    // CHANGE STATUS (Quick Action)
    public function changeStatus(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected,paid'
        ]);

        $loan->status = $request->status;
        $loan->save();

        return back()->with('success', 'Loan status updated!');
    }

}