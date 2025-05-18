<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AnggotaKomonitas;
use App\Models\anggota_komonitas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AnggotaKomonitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komonitas_id)
    {
        $dataAngotaKomonitas = AnggotaKomonitas::with(['user', 'komonitas'])
            ->where('komonitas_id', $komonitas_id)
            ->get();


        return response()->json([
            'status' => true,
            'message' => 'Data anggota komonitas ditemukan',
            'data' => $dataAngotaKomonitas
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $anggotakomonitas = new AnggotaKomonitas();

        $rules = [
            'komonitas_id' => 'required|exists:komonitas,id',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal memasukkan anggota ke grup',
                'data' => $validator->errors()
            ]);
        }

        // Ambil data user dari users_id
        $user = User::find($request->users_id);

        // Pastikan user ditemukan (jaga-jaga kalau misalnya ada keanehan)
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        $anggotakomonitas->role = $user->role;
        $anggotakomonitas->komonitas_id = $request->komonitas_id;
        $anggotakomonitas->users_id = $request->users_id;

        $anggotakomonitas->save();

        return response()->json([
            'status' => true,
            'message' => 'anggota baru berhasil ditambahkan',
            'data' => $anggotakomonitas,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnggotaKomonitas $anggotaKomonitas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($komunitas, $anggotaKomonitasId)
    {
        // Ambil model berdasarkan ID anggota komonitas
        $anggotakomonitas = AnggotaKomonitas::findOrFail($anggotaKomonitasId);

        // Hapus data
        $anggotakomonitas->delete();

        return response()->json([
            'status' => true,
            'message' => 'anggota berhasil dikeluarkan',
            'data' => $anggotakomonitas,
        ]);
    }
}
