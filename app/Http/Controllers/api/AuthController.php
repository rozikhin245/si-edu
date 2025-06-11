<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
            ], 422);
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
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses login gagal',
                'data' => $validator->errors(),
            ], 401);
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email atau password salah',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak bisa membuat token',
            ], 500);
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
                'message' => 'Logout berhasil',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal logout',
            ], 500);
        }
    }
}
