<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;

class LoanController extends Controller
{
        public function index()
    {
        $loans = Loan::with('user')->orderBy('id', 'DESC')->get();
        return view('pages.admin.loans.index', compact('loans'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.admin.loans.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'installments' => 'required|integer|min:0',
            'status' => 'required|in:pending,approved,rejected,paid',
        ]);

        Loan::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'balance' => $request->amount, // awal balance = total kasbon
            'installments' => $request->installments,
            'status' => $request->status,
        ]);

        return redirect()->route('loans.index')->with('success', 'Data kasbon berhasil ditambahkan.');
    }

    public function show($id)
    {
        $loan = Loan::with('user')->findOrFail($id);
        return view('pages.admin.loans.show', compact('loan'));
    }

    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        $users = User::where('role', 'user')->get();
        return view('pages.admin.loans.edit', compact('loan', 'users'));
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'installments' => 'required|integer|min:0',
            'status' => 'required|in:pending,approved,rejected,paid',
        ]);

        $loan->update([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'balance' => $request->balance,
            'installments' => $request->installments,
            'status' => $request->status,
        ]);

        return redirect()->route('loans.index')->with('success', 'Kasbon berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Loan::findOrFail($id)->delete();

        return redirect()->route('loans.index')->with('success', 'Kasbon berhasil dihapus.');
    }
}
