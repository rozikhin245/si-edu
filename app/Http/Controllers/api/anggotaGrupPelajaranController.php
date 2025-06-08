<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AnggotaGrupPelajaran;
use Illuminate\Support\Facades\Validator;

class anggotaGrupPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komunitas, $grup_id)
    {
        $anggotaGrupPelajaran = AnggotaGrupPelajaran::with(['user', 'grupMataPelajaran'])
        ->where('grup_mata_pelajaran_id', $grup_id)
        ->get();


        return response()->json([
            'status' => true,
            'message' => 'data anggota ditemukan',
            'data' => $anggotaGrupPelajaran,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $anggotaGrup = new AnggotaGrupPelajaran();

        $rules = [
            'grup_mata_pelajaran_id' => 'required|exists:grup_matapelajaran,id',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal menambahkan anggota',
                'data' => $validator->errors()
            ]);
        }

        $user = User::find($request->users_id);

        // Pastikan user ditemukan (jaga-jaga kalau misalnya ada keanehan)
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        $anggotaGrup->role = $user->role;
        $anggotaGrup->grup_mata_pelajaran_id = $request->grup_mata_pelajaran_id;
        $anggotaGrup->users_id = $request->users_id;

        $anggotaGrup->save();

        return response()->json([
            'status' => true,
            'message' => 'anggota berhasil ditambahkan',
            'data' => $anggotaGrup,
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($komunitas, $grup_id, $anggota)
    {
        $anggotaGrup = AnggotaGrupPelajaran::findOrFail($anggota);

        $anggotaGrup->delete();

        return response()->json([
            'status' => true,
            'message' => 'anggota berhasil dikeluarkan',
            'data' => $anggotaGrup
        ]);
    }
}
