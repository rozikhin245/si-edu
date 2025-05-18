<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\GrupMatapelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GrupMataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komonitas_id)
    {
        $grupMataPelajaran = GrupMatapelajaran::with(['komonitas'])
        ->where('komonitas_id', $komonitas_id)
        ->get();


    return response()->json([
        'status' => true,
        'message' => 'grup mata pelajaran ditemukan',
        'data' => $grupMataPelajaran
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $grupMatkul  = new GrupMatapelajaran();

        $rules = [
            'nama_grup' => 'required',
            'komonitas_id' => 'required|exists:komonitas,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal membuat grup',
                'data' => $validator->errors()
            ]);
        }

        $grupMatkul ->nama_grup = $request->nama_grup;
        $grupMatkul ->komonitas_id = $request->komonitas_id;

        $grupMatkul ->save();

        return response()->json([
            'status' => true,
            'message' => 'Grup berhasil dibuat',
            'data' => $grupMatkul
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($komonitas, $grup_id)
    {
        $grup = GrupMatapelajaran::findOrFail($grup_id);
        if($grup) {
            return response()->json([
                'status' => true,
                'message' => 'grup ditemukan',
                'data' => $grup
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
    public function update(Request $request, $komonitas, $grup_id)
    {
        $grup = GrupMatapelajaran::findOrFail($grup_id);

        if(empty($grup )) {
            return response()->json([
                'status' => false,
                'message' => 'Grup tidak ditemukan',
                'data' => $grup
            ]);
        }

        $rules = [
            'nama_grup' => 'required',
            'komonitas_id' => 'required|exists:komonitas,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal mengupdate grup',
                'data' => $validator->errors()
            ]);
        }

        $grup ->nama_grup = $request->nama_grup;
        $grup ->komonitas_id = $request->komonitas_id;

        $grup ->save();

        return response()->json([
            'status' => true,
            'message' => 'Grup berhasil diupdate',
            'data' => $grup
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($komonitas, $grup_id)
    {
        $grup = GrupMatapelajaran::findOrFail($grup_id);

        if(empty($grup)) {
            return response()->json([
                'status' => false,
                'message' => 'Grup tidak ditemukan',
            ]);
        }

        $grup->delete();

        return response()->json([
            'status' => true,
            'message' => 'Grup berhasil dihapus',
            'data' => $grup
        ]);
    }
}
