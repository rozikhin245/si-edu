<?php

namespace App\Http\Controllers\Api;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class siswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with(['user'])
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'data siswa ditemukan',
            'data' => $siswa
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $siswa  = new Siswa();

        $rules = [
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'angkatan' => 'required|integer',
            'nis' => 'required|numeric|unique:siswa,nis',
            'nisn' => 'required|numeric|unique:siswa,nisn',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat data siswa',
                'data' => $validator->errors()
            ], 400);
        }

        $siswa ->nama = $request->nama;
        $siswa ->jenis_kelamin = $request->jenis_kelamin;
        $siswa ->tanggal_lahir = $request->tanggal_lahir;
        $siswa ->alamat = $request->alamat;
        $siswa ->angkatan = $request->angkatan;
        $siswa ->nis = $request->nis;
        $siswa ->nisn = $request->nisn;
        $siswa ->users_id = $request->users_id;

        $siswa ->save();

        return response()->json([
            'status' => true,
            'message' => 'Data siswa berhasil dibuat',
            'data' => $siswa
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        if($siswa) {
            return response()->json([
                'status' => true,
                'message' => 'grup ditemukan',
                'data' => $siswa
            ],200);
        } else{
            return response()->json([
                'status' => true,
                'message' => 'Data tidak ditemukan',
            ]);
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa  = Siswa::find($id);

        if(empty($siswa )) {
            return response()->json([
                'status' => false,
                'message' => 'data siswa tidak ditemukan',
            ]);
        }

        $rules = [
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'angkatan' => 'required|integer',
            'nis' => 'required|numeric:siswa,nis',
            'nisn' => 'required|numeric:siswa,nisn',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat data siswa',
                'data' => $validator->errors()
            ], 400);
        }

        $siswa ->nama = $request->nama;
        $siswa ->jenis_kelamin = $request->jenis_kelamin;
        $siswa ->tanggal_lahir = $request->tanggal_lahir;
        $siswa ->alamat = $request->alamat;
        $siswa ->angkatan = $request->angkatan;
        $siswa ->nis = $request->nis;
        $siswa ->nisn = $request->nisn;
        $siswa ->users_id = $request->users_id;

        $siswa ->save();

        return response()->json([
            'status' => true,
            'message' => 'Data siswa berhasil diupdate',
            'data' => $siswa
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa  = Siswa::find($id);

        if(empty($siswa )) {
            return response()->json([
                'status' => false,
                'message' => 'data siswa tidak ditemukan',
            ]);
        }

        $siswa ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data siswa berhasil dihapus',
            'data' => $siswa
        ], 201);
    }
}
