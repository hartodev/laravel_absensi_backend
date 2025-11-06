<?php

namespace App\Http\Controllers\Backend\Company;

use App\Http\Controllers\Controller;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        return view('pages.companies.dashboard');
    }
}
