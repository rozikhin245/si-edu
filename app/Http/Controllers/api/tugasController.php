<?php

namespace App\Http\Controllers\api;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class tugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komunitas, $grup_id)
    {
        $tugas = Tugas::with('grupMataPelajaran', 'user')
            ->where('grup_matapelajaran_id', $grup_id)
            ->latest()
            ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Data tugas berhasil ditemukan',
            'data' => $tugas,
        ], 200);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tugas = new Tugas();

        $rules = [
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'file' => 'nullable|string',
            'grup_matapelajaran_id' => 'required|exists:grup_matapelajaran,id',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat tugas',
                'data' => $validator->errors()
            ]);
        }
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->deadline = $request->deadline;
        $tugas->file = $request->file;
        $tugas->grup_matapelajaran_id = $request->grup_matapelajaran_id;
        $tugas->users_id = $request->users_id;

        $tugas->save();

        return response()->json([
            'status' => true,
            'message' => 'Tugas berhasil dibuat',
            'data' => $tugas,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($komunitas, $grup_id, $tugasid)
    {
        $tugas = Tugas::findOrFail($tugasid);

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $tugas
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $komunitas, $grup_id, $tugasid)
    {
        $tugas = Tugas::findOrFail($tugasid);

        $rules = [
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'file' => 'nullable|string',
            'grup_matapelajaran_id' => 'required|exists:grup_matapelajaran,id',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate tugas',
                'data' => $validator->errors()
            ]);
        }
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->deadline = $request->deadline;
        $tugas->file = $request->file;
        $tugas->grup_matapelajaran_id = $request->grup_matapelajaran_id;
        $tugas->users_id = $request->users_id;

        $tugas->save();

        return response()->json([
            'status' => true,
            'message' => 'Tugas berhasil diupdate',
            'data' => $tugas,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($komunitas, $grup_id, $tugasid)
    {
        $tugas = Tugas::findOrFail($tugasid);

        $tugas->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tugas berhasil dihapus',
            'data' => $tugas,
        ]);
    }
}
