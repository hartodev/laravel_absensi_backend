<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payrool;

class PayrollController extends Controller
{
     /**
     * LIST PAYROLL USER
     */
    public function index(Request $request)
    {
        $payrolls = Payrool::where('user_id', $request->user()->id)
            ->orderBy('period_start', 'desc')
            ->paginate(12);

        return response()->json($payrolls);
    }

    /**
     * DETAIL PAYROLL
     */
    public function show(Request $request, $id)
    {
        $payroll = Payrool::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($payroll);
    }
}
