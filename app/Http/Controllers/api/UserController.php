<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * untuk mengambil data user yang sedang login
     */
    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'data profil berhasil diambil',
            'data' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user(); // user yang sedang login

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors(),
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user,
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors(),
            ], 422);
        }

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password lama tidak sesuai',
            ], 403);
        }

        // Simpan password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diperbarui',
        ]);
    }

    public function getAvailableWaliMurid()
    {
        $availableUsers = User::where('role', 'wali-murid')
            ->whereDoesntHave('siswa')
            ->get(['id', 'name', 'email']); // Pilih field yang diperlukan

        return response()->json([
            'status' => true,
            'message' => 'diskusi pelajaran berhasil dihapus',
            'data' => $availableUsers
        ]);
    }
}
