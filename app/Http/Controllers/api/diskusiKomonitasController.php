<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\DiskusiKomonitas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiskusiKomonitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($komonitas_id)
    {
        $diskusiKomonitas = DiskusiKomonitas::with(['user', 'komonitas'])
            ->where('komonitas_id', $komonitas_id)
            ->get();


        return response()->json([
            'status' => true,
            'message' => 'Diskusi komonitas ditemukan',
            'data' => $diskusiKomonitas
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $diskusi = new DiskusiKomonitas();

        $rules = [
            'pesan' => 'required',
            'komonitas_id' => 'required|exists:komonitas,id',
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

        $diskusi->pesan = $request->pesan;
        $diskusi->komonitas_id = $request->komonitas_id;
        $diskusi->users_id = $request->users_id;

        $diskusi->save();

        return response()->json([
            'status' => true,
            'message' => 'Diskusi berhasil dibuat',
            'data' => $diskusi
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
    public function destroy($komunitas, $dikusikomonitasid)
    {
        $diskusi = DiskusiKomonitas::findOrFail($dikusikomonitasid);

        $diskusi->delete();

        return response()->json([
            'status' => true,
            'message' => 'diskusi berhasil dihapus',
            'data' => $diskusi
        ]);
    }
}
