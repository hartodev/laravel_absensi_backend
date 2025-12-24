<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyProfileController extends Controller
{
    /**
     * SHOW COMPANY PROFILE
     */
    public function show(Request $request)
    {
        $company = Company::findOrFail($request->user()->company_id);

        return response()->json($company);
    }

    /**
     * UPDATE COMPANY PROFILE
     */
    public function update(Request $request)
    {
        $company = Company::findOrFail($request->user()->company_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius_km' => 'nullable|numeric',
            'time_in' => 'nullable',
            'time_out' => 'nullable',
            'timezone' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->hashName();
            $image->move(public_path('image/company'), $filename);

            $company->image_url = 'image/company/' . $filename;
        }

        $company->update($request->except('image'));

        return response()->json([
            'message' => 'Profile perusahaan berhasil diperbarui',
            'data' => $company
        ]);
    }
}
