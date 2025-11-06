<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }
}
