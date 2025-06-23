<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\komonitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class komonitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // Mengambil data komonitas dan mengurutkannya berdasarkan kolom 'nama_komonitas'
    //     $komonitas = Komonitas::orderBy('nama_komonitas', 'asc')->get();

    //     // Mengirim data ke view
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Data komonitas berhasil diambil',
    //         'data' => $komonitas
    //     ], 200);
    // }
    public function index()
    {
        $user = auth()->user();

        // Kalau admin, ambil semua komunitas
        if ($user->role === 'admin') {
            $komonitas = Komonitas::orderBy('created_at', 'desc')->get();
        } else {
            // Selain admin (guru, wali murid), ambil hanya yang dia ikuti
            $komonitas = Komonitas::whereHas('anggotaKomonitas', function ($q) use ($user) {
                $q->where('users_id', $user->id);
            })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json([
            'status' => true,
            'message' => 'Data komonitas berhasil diambil',
            'data' => $komonitas
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datakomonitas = new komonitas;

        $rules = [
            'nama_komonitas' => 'required',
            'tahun_ajaran' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal memebuat komonitas',
                'data' => $validator->errors()
            ]);
        }

        $datakomonitas->nama_komonitas = $request->nama_komonitas;
        $datakomonitas->tahun_ajaran = $request->tahun_ajaran;

        $post = $datakomonitas->save();

        return response()->json([
            'status' => true,
            'message' => 'komonitas berhasil dibuat',
            'data' => $datakomonitas,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Komonitas $komunitas)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $komunitas
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Komonitas $komunitas)
    {
        $rules = [
            'nama_komonitas' => 'required',
            'tahun_ajaran' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data komonitas',
                'data' => $validator->errors(),
            ]);
        }

        $komunitas->nama_komonitas = $request->nama_komonitas;
        $komunitas->tahun_ajaran = $request->tahun_ajaran;
        $komunitas->save();

        return response()->json([
            'status' => true,
            'message' => 'Data komonitas berhasil diperbarui',
            'data' => $komunitas
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komonitas $komunitas)
    {
        $komunitas->delete();

        return response()->json([
            'status' => true,
            'message' => 'komonitas berhasil dihapus',
            'data' => $komunitas,
        ]);
    }
}
