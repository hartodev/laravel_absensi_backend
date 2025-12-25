<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company;

use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // login
    // public function login(Request $request)
    // {
    //     $loginData = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $loginData['email'])->first();

    //     //check user exist
    //     if (!$user) {
    //         return response(['message' => 'Invalid credentials'], 401);
    //     }

    //     //check password
    //     if (!Hash::check($loginData['password'], $user->password)) {
    //         return response(['message' => 'Invalid credentials'], 401);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response(['user' => $user, 'token' => $token], 200);
    // }

    // kode revisi 2
    public function login(Request $request)
    {

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Buat token sanctum
        $tokenName = $user->role . '-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        // Ambil company jika ada
        $company = null;
        if ($user->company_id) {
            $company = Company::find($user->company_id);
        }


        $token = $user->createToken('user_token')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 200);
    }



    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'Logged out Sucessfully'], 200);
    }

    //update image profile & face_embedding
    public function updateProfile(Request $request)
    {
        $request->validate([
            //  'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'face_embedding' => 'required',
        ]);

        $user = $request->user();
        //  $image = $request->file('image');
        $face_embedding = $request->face_embedding;

        //  //save image
        //  $image->storeAs('public/images', $image->hashName());
        //  $user->image_url = $image->hashName();
        $user->face_embedding = $face_embedding;
        $user->save();

        return response([
            'message' => 'Profile updated',
            'user' => $user,
        ], 200);
    }


    // me
    public function me(Request $request)
    {
        $user = $request->user();
        $company = null;

        if ($user->company_id) {
            $company = Company::find($user->company_id);
        }

        return response()->json([
            'user'    => $user,
            'company' => $company
        ]);
    }

    //update fcm_token
    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required',
        ]);

        $user = $request->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response([
            'message' => 'FCM token updated',
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Password lama salah'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password berhasil diubah'
        ]);
    }

    /**
     * SHOW PROFILE
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json(
            $user
        );
    }

    /**
     * UPDATE PROFILE
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'fcm_token' => 'nullable|string',
        ]);

        // Update basic data
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
        }

        // Upload image profile
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->hashName();
            $image->move(public_path('image/profile'), $filename);

            $user->image_url = 'image/profile/' . $filename;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile berhasil diperbarui',
            'data' => $user
        ]);
    }
}
