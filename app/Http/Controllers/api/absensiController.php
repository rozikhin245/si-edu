<?php

namespace App\Http\Controllers\Api;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class absensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komunitas_id, $absensiId)
    {
        $absensi = Absensi::with('siswa')->where('tanggal_id', $absensiId)->orderBy('created_at', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'data absensi ditemukan',
            'data' => $absensi
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $absensi  = new Absensi();

        $rules = [
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal_id' => 'required|exists:tanggal_absensi,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat data absensi',
                'data' => $validator->errors()
            ], 400);
        }

        $absensi->tanggal_id = $request->tanggal_id;
        $absensi->status = $request->status;
        $absensi->keterangan = $request->keterangan;
        $absensi->siswa_id = $request->siswa_id;

        $absensi->save();

        return response()->json([
            'status' => true,
            'message' => 'absensi berhasil dibuat',
            'data' => $absensi
        ], 201);
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
    // public function update(Request $request, string $id)
    // {
    //     $absensi  = Absensi::find($id);

    //     if(empty($absensi )) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'absensi tidak ditemukan',
    //         ]);
    //     }

    //     $rules = [
    //         'tanggal' => 'required|date',
    //         'status' => 'required|in:hadir,izin,sakit,alpa',
    //         'keterangan' => 'required|string',
    //         'siswa_id' => 'required|exists:siswa,id',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Gagal membuat absensi',
    //             'data' => $validator->errors()
    //         ], 400);
    //     }

    //     $absensi->tanggal = $request->tanggal;
    //     $absensi->status = $request->status;
    //     $absensi->keterangan = $request->keterangan;
    //     $absensi->siswa_id = $request->siswa_id;

    //     $absensi->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'absensi berhasil diupdate',
    //         'data' => $absensi
    //     ], 201);
    // }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($komunitas, $tanggalId, Absensi $absensi)
    {

        if (empty($absensi)) {
            return response()->json([
                'status' => false,
                'message' => 'absensi tidak ditemukan',
            ]);
        }

        $absensi->delete();

        return response()->json([
            'status' => true,
            'message' => 'absensi berhasil dihapus',
            'data' => $absensi
        ], 200);
    }
}
