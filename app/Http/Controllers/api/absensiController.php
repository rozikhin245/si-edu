<?php

namespace App\Http\Controllers\Api;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with(['siswa', 'tanggal.komunitas'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Data absensi ditemukan',
            'data' => $absensi
        ], 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'tanggal_id' => 'required|exists:tanggal_absensi,id',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'required|string',
            'siswa_id' => 'required|exists:siswa,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors()
            ], 400);
        }

        $absensi = Absensi::create([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'siswa_id' => $request->siswa_id,
            'tanggal_id' => $request->tanggal_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Absensi berhasil dibuat',
            'data' => $absensi->load('siswa', 'tanggal.komunitas')
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'status' => false,
                'message' => 'Absensi tidak ditemukan',
            ], 404);
        }

        $rules = [
            'tanggal_id' => 'required|exists:tanggal_absensi,id',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'required|string',
            'siswa_id' => 'required|exists:siswa,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors()
            ], 400);
        }

        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'siswa_id' => $request->siswa_id,
            'tanggal_id' => $request->tanggal_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Absensi berhasil diupdate',
            'data' => $absensi->load('siswa', 'tanggal.komunitas')
        ], 200);
    }

    public function destroy(string $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'status' => false,
                'message' => 'Absensi tidak ditemukan',
            ], 404);
        }

        $absensi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Absensi berhasil dihapus',
        ], 200);
    }
}
