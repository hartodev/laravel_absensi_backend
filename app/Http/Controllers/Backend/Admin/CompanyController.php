<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('pages.admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('pages.admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|unique:companies,email',
            'address'    => 'nullable|string|max:500',
            'latitude'   => 'nullable|numeric|between:-90,90',
            'longitude'  => 'nullable|numeric|between:-180,180',
            'radius_km'  => 'nullable|numeric|min:0.1|max:10',
            'time_in'    => 'required|date_format:H:i',
            'time_out'   => 'required|date_format:H:i|after:time_in',
            'timezone'   => 'required|string|max:50',
            'type'       => 'required|in:company,school,pesantren',
            'image_url'  => 'nullable|url',
        ]);

        Company::create($request->all());

        return redirect()->route('admin.companies.index')->with('success', 'Company berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('pages.admin.companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|unique:companies,email,' . $company->id,
            'address'    => 'nullable|string|max:500',
            'latitude'   => 'nullable|numeric|between:-90,90',
            'longitude'  => 'nullable|numeric|between:-180,180',
            'radius_km'  => 'nullable|numeric|min:0.1|max:10',
            'time_in'    => 'required|date_format:H:i',
            'time_out'   => 'required|date_format:H:i|after:time_in',
            'timezone'   => 'required|string|max:50',
            'type'       => 'required|in:company,school,pesantren',
            'image_url'  => 'nullable|url',
        ]);

        $company->update($request->all());

        return redirect()->route('admin.companies.index')->with('success', 'Company berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Company berhasil dihapus.');
    }
}
