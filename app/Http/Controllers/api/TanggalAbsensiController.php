<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TanggalAbsensi;
use Illuminate\Support\Facades\Validator;

class TanggalAbsensiController extends Controller
{
    public function index()
    {
        $tanggalAbsensi = TanggalAbsensi::with('komunitas')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data tanggal absensi ditemukan',
            'data' => $tanggalAbsensi
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date|unique:tanggal_absensi,tanggal',
            'nama_guru' => 'required|string',
            'komunitas_id' => 'required|exists:komonitas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors()
            ], 400);
        }

        $tanggal = TanggalAbsensi::create([
            'tanggal' => $request->tanggal,
            'nama_guru' => $request->nama_guru,
            'komunitas_id' => $request->komunitas_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tanggal berhasil ditambahkan',
            'data' => $tanggal
        ], 201);
    }

    public function show($id)
    {
        $tanggal = TanggalAbsensi::with('komunitas')->find($id);

        if (!$tanggal) {
            return response()->json([
                'status' => false,
                'message' => 'Tanggal absensi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tanggal absensi ditemukan',
            'data' => $tanggal
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $tanggal = TanggalAbsensi::find($id);

        if (!$tanggal) {
            return response()->json([
                'status' => false,
                'message' => 'Tanggal absensi tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date|unique:tanggal_absensi,tanggal,' . $id,
            'nama_guru' => 'required|string',
            'komunitas_id' => 'required|exists:komonitas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors()
            ], 400);
        }

        $tanggal->update([
            'tanggal' => $request->tanggal,
            'nama_guru' => $request->nama_guru,
            'komunitas_id' => $request->komunitas_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tanggal berhasil diupdate',
            'data' => $tanggal
        ], 200);
    }

    public function destroy($id)
    {
        $tanggal = TanggalAbsensi::find($id);

        if (!$tanggal) {
            return response()->json([
                'status' => false,
                'message' => 'Tanggal absensi tidak ditemukan'
            ], 404);
        }

        $tanggal->absensi()->delete();
        $tanggal->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tanggal berhasil dihapus'
        ], 200);
    }
}
