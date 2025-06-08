<?php

namespace App\Http\Controllers\Api;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class pengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumuman = Pengumuman::with('user')->orderBy('created_at', 'desc')->get();

        // Mengirim data ke view
        return response()->json([
            'status' => true,
            'message' => 'Data pengumuman ditemukan',
            'data' => $pengumuman
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pengumuma = new Pengumuman();

        $rules = [
            'judul' => 'required',
            'keterangan' => 'required',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }

        $pengumuma->judul = $request->judul;
        $pengumuma->keterangan = $request->keterangan;
        $pengumuma->users_id = $request->users_id;

        $pengumuma->save();

        return response()->json([
            'status' => true,
            'message' => 'pengumuman berhasil disimpan',
            'data' => $pengumuma
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $grup = Pengumuman::with('user')->findOrFail($id);
        if ($grup) {
            return response()->json([
                'status' => true,
                'message' => 'pengumuman ditemukan',
                'data' => $grup
            ], 200);
        } else {
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
        $pengumuma = Pengumuman::find($id);

        if (empty($pengumuma)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $rules = [
            'judul' => 'required',
            'keterangan' => 'required',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }

        $pengumuma->judul = $request->judul;
        $pengumuma->keterangan = $request->keterangan;
        $pengumuma->users_id = $request->users_id;

        $pengumuma->save();

        return response()->json([
            'status' => true,
            'message' => 'pengumuman berhasil diubah',
            'data' => $pengumuma
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengumuma = Pengumuman::find($id);

        if (empty($pengumuma)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $pengumuma->delete();

        return response()->json([
            'status' => true,
            'message' => 'pengumuman berhasil dihapus',
            'data' => $pengumuma
        ]);
    }
}
