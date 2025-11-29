<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payrool;
use Illuminate\Support\Facades\Auth;

class UserPayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payrool::where('user_id', Auth::id())
            ->orderBy('period_end', 'desc')
            ->paginate(10);

        return view('pages.user.payrolls.index', compact('payrolls'));
    }

    public function show($id)
    {
        $payroll = Payrool::where('user_id', Auth::id())->findOrFail($id);

        return view('pages.user.payrolls.show', compact('payroll'));
    }
}
