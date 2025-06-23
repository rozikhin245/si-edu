<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DiskusiPelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DikusiGrupMataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komunitas, $grup_id)
    {
        $diskusiGrupPelajaran = DiskusiPelajaran::with(['user', 'grupMataPelajaran'])
        ->where('grup_mata_pelajaran_id', $grup_id)
        ->get();


        return response()->json([
            'status' => true,
            'message' => 'Diskusi grup pelajaran ditemukan',
            'data' => $diskusiGrupPelajaran,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $diskusipelajaran = new DiskusiPelajaran();

        $rules = [
            'pesan' => 'required',
            'grup_mata_pelajaran_id' => 'required|exists:grup_matapelajaran,id',
            'users_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal membuat pesan',
                'data' => $validator->errors()
            ]);
        }

        $diskusipelajaran->pesan = $request->pesan;
        $diskusipelajaran->grup_mata_pelajaran_id = $request->grup_mata_pelajaran_id;
        $diskusipelajaran->users_id = $request->users_id;

        $diskusipelajaran->save();

        return response()->json([
            'status' => true,
            'message' => 'Diskusi pelajaran berhasil dibuat',
            'data' => $diskusipelajaran,
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
    public function destroy($komunitas, $grup_id, $diskusi)
    {
        $diskusiPelajaran = DiskusiPelajaran::findOrFail($diskusi);

        $diskusiPelajaran->delete();

        return response()->json([
            'status' => true,
            'message' => 'diskusi pelajaran berhasil dihapus',
            'data' => $diskusiPelajaran
        ]);
    }

    public function deleteForAll($komunitas, $grup_id, $diskusi)
    {
        $message = DiskusiPelajaran::findOrFail($diskusi);

        // Pastikan hanya pengirim yang bisa hapus
        if ($message->users_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message->is_deleted = true;
        $message->save();

        return response()->json(['message' => 'Pesan berhasil dihapus']);
    }

}
