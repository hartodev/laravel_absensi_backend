<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('pages.user.dashboard');
    }
}
