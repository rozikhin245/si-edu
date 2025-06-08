<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses login gagal',
                'data' => $validator->errors(),
            ], 401);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'email dan password yang dimasukkan tidak sesuai'
            ], 401);
        }

        $dataUser = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'proses login berhasil',
            'token' => $dataUser->createToken('api-users')->plainTextToken,
            'data' => $dataUser,
        ]);
    }

    public function logoutUsers(Request $request)
    {
        // Menghapus token saat ini (yang sedang dipakai)
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'berhasil logout dan token dihapus',
        ]);
    }
}
