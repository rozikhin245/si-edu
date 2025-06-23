<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class allUser extends Controller
{
    public function index() {
        $allUser = User::select('id', 'name', 'email', 'role')->get();
        
        return response()->json([
            'status' => true,
            'message' => 'data user ditemukan',
            'data' => $allUser
        ], 200);
    }


    public function destroy(user $user)
    {
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'user berhasil dihapus',
            'data' => $user,
        ]);
    }
}
