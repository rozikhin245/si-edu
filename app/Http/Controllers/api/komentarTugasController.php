<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\KomentarTugas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class komentarTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komunitas, $grup_id, $tugas)
    {
        $nilai = KomentarTugas::with('user', 'tugas')
            ->where('tugas_id', $tugas)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data nilai berhasil ditemukan',
            'data' => $nilai,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $komentar = new KomentarTugas();

        $rules = [
            'komentar' => 'required|string',
            'users_id' => 'required|exists:users,id',
            'tugas_id' => 'required|exists:tugas,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat tugas',
                'data' => $validator->errors()
            ]);
        }
        $komentar->komentar = $request->komentar;
        $komentar->users_id = $request->users_id;
        $komentar->tugas_id = $request->tugas_id;

        $komentar->save();

        return response()->json([
            'status' => true,
            'message' => 'komentar berhasil dibuat',
            'data' => $komentar,
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
    public function destroy($komunitas, $grup_id, $tugas, $komentarid)
    {
        $komentar = KomentarTugas::findOrFail($komentarid);

        $komentar->delete();

        return response()->json([
            'status' => true,
            'message' => 'komentar berhasil dihapus',
            'data' => $komentar,
        ]);
    }
}
