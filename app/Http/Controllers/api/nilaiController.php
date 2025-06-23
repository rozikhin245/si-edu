<?php

namespace App\Http\Controllers\api;

use App\Models\nilai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AnggotaKomonitas;
use App\Models\Nilai as ModelsNilai;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class nilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komunitas, $grup_id, $tugas)
    {
        $nilai = Nilai::with('siswa', 'tugas')
            ->where('tugas_id', $tugas)
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
        $nilai = new Nilai();
        $siswa = Siswa::find($request->siswa_id);

        $rules = [
            'nilai' => 'required|string',
            // 'keterangan' => 'nullable|string',
            'siswa_id' => 'required|exists:siswa,id',
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
        $nilai->nilai = $request->nilai;
        // $nilai->keterngan = $request->keterngan;
        $nilai->siswa_id = $request->siswa_id;
        $nilai->tugas_id = $request->tugas_id;
        $nilai->users_id = $siswa->users_id;

        $nilai->save();

        return response()->json([
            'status' => true,
            'message' => 'nilai berhasil dibuat',
            'data' => $nilai,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($komunitas, $grup_id, $tugasid, $nilaiid)
    {
        $nilai = Nilai::where('id', $nilaiid)
            ->where('tugas_id', $tugasid)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $nilai
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $komunitas, $grup_id, $tugas, $nilaiid)
    {
        $nilai = Nilai::findOrFail($nilaiid);
        $siswa = Siswa::find($request->siswa_id);

        $rules = [
            'nilai' => 'required|string',
            // 'keterangan' => 'nullable|string',
            'siswa_id' => 'required|exists:siswa,id',
            'tugas_id' => 'required|exists:tugas,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate nilai',
                'data' => $validator->errors()
            ]);
        }
        $nilai->nilai = $request->nilai;
        $nilai->siswa_id = $request->siswa_id;
        $nilai->tugas_id = $request->tugas_id;
        $nilai->users_id = $siswa->users_id;

        $nilai->save();

        return response()->json([
            'status' => true,
            'message' => 'nilai berhasil diupdate',
            'data' => $nilai,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($komunitas, $grup_id, $tugas, $nilaiid)
    {
        $nilai = Nilai::findOrFail($nilaiid);

        $nilai->delete();

        return response()->json([
            'status' => true,
            'message' => 'nilai berhasil dihapus',
            'data' => $nilai,
        ]);
    }

    public function siswaByKomonitas($komonitas_id)
    {
        // Ambil semua user_id yang tergabung dalam komunitas tertentu
        $userIds = AnggotaKomonitas::where('komonitas_id', $komonitas_id)
            ->pluck('users_id');

        // Ambil data siswa yang user_id-nya termasuk ke komunitas itu
        $siswa = Siswa::with('user')
            ->whereIn('users_id', $userIds)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data siswa dalam komunitas ditemukan',
            'data' => $siswa
        ], 200);
    }

    public function getByLoggedInUser($komunitas, $grup_id, $tugas_id)
    {
        $user = Auth::user();

        $nilai = Nilai::where('users_id', $user->id)
            ->where('tugas_id', $tugas_id)
            ->first();

        return response()->json([
            'status' => true,
            'data' => $nilai,
            'message' => $nilai ? 'Nilai ditemukan' : 'Belum ada nilai'
        ]);
    }
}
