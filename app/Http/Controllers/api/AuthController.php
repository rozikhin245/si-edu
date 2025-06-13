<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


use function Pest\Laravel\json;

class AuthController extends Controller
{
    public function regiterUsers(Request  $request)
    {
        $dataUser = new User();

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:admin,guru,wali-murid',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses validasi gagal',
                'data' => $validator->errors(),
            ], 401);
        }

        $dataUser->name = $request->name;
        $dataUser->email = $request->email;
        $dataUser->password = Hash::make($request->password);
        $dataUser->role = $request->role;
        $dataUser->save();

        return response()->json([
            'status' => true,
            'message' => 'berhasil menambahkan data baru',
            'data' => $dataUser
        ], 200);
    }


    public function loginUsers(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'data' => $user,
        ]);
    }

    public function logoutUsers(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => true,
                'message' => 'Logout berhasil, token dihapus',
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Logout gagal',
            ], 500);
        }
    }
}
