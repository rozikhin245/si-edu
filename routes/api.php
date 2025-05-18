<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\nilaiController;
use App\Http\Controllers\Api\siswaController;
use App\Http\Controllers\api\tugasController;
use App\Http\Controllers\Api\absensiController;
use App\Http\Controllers\api\komonitasController;
use App\Http\Controllers\Api\pengumumanController;
use App\Http\Controllers\api\komentarTugasController;
use App\Http\Controllers\Api\AnggotaKomonitasController;
use App\Http\Controllers\api\DiskusiKomonitasController;
use App\Http\Controllers\Api\GrupMataPelajaranController;
use App\Http\Controllers\api\anggotaGrupPelajaranController;
use App\Http\Controllers\Api\DikusiGrupMataPelajaranController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return response()->json([
        'status' => false,
        'messege' => 'anda tidak memiliki akses'
    ], 401);
})->name('login');

Route::post('registerUsers', [AuthController::class, 'regiterUsers']);
Route::post('loginUsers', [AuthController::class, 'loginUsers']);
Route::middleware('auth:sanctum')->post('logoutUsers', [AuthController::class, 'logoutUsers']);


Route::middleware('auth:sanctum')->group(function () {
    /**
     * route ini untuk crud data di komonitas
     */
    Route::get('komonitas', [komonitasController::class, 'index']);
    Route::get('komonitas/{komunitas}', [komonitasController::class, 'show']);
    Route::post('komonitas', [komonitasController::class, 'store']);
    Route::put('komonitas/{komunitas}', [komonitasController::class, 'update']);
    Route::delete('komonitas/{komunitas}', [komonitasController::class, 'destroy']);

    /**
     * route ini utuk menambahkan anggota yang bisa mengakses dari komonitas ini
     */
    Route::get('komonitas/{komunitas}/anggota', [AnggotaKomonitasController::class, 'index']);
    Route::post('komonitas/{komunitas}/anggota', [AnggotaKomonitasController::class, 'store']);
    Route::delete('komonitas/{komunitas}/anggota/{anggotaKomonitas}', [AnggotaKomonitasController::class, 'destroy']);

    /**
     * route ini untuk membuat fiutr chating di laman diskusi
     */
    Route::get('komonitas/{komunitas}/diskusiKomonitas', [DiskusiKomonitasController::class, 'index']);
    Route::post('komonitas/{komunitas}/diskusiKomonitas', [DiskusiKomonitasController::class, 'store']);
    Route::delete('komonitas/{komunitas}/diskusiKomonitas/{diskusikomonitas}', [DiskusiKomonitasController::class, 'destroy']);

    /**
     * route ini untuk membuat grup per mata pelajaran
     */
    Route::get('komonitas/{komunitas}/GrupMataPelajaran', [GrupMataPelajaranController::class, 'index']);
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}', [GrupMataPelajaranController::class, 'show']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran', [GrupMataPelajaranController::class, 'store']);
    Route::put('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}', [GrupMataPelajaranController::class, 'update']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}', [GrupMataPelajaranController::class, 'destroy']);

    /**
     * route ini untuk membuat fitur chat real time pada laman grup mata pelajran
     */
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/diskusipelajaran', [DikusiGrupMataPelajaranController::class, 'index']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/diskusipelajaran', [DikusiGrupMataPelajaranController::class, 'store']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/diskusipelajaran/{diskusi}', [DikusiGrupMataPelajaranController::class, 'destroy']);

    /**
     * route ini berfungsi untuk meambahkan anggota grup kedalam grup per matapelajaran
     */
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/anggotagrup', [anggotaGrupPelajaranController::class, 'index']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/anggotagrup', [anggotaGrupPelajaranController::class, 'store']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/anggotagrup/{anggota}', [anggotaGrupPelajaranController::class, 'destroy']);

    /**
     * route ini untuk membuat tugas baru
     */
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas', [tugasController::class, 'index']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas', [tugasController::class, 'store']);
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}', [tugasController::class, 'show']);
    Route::put('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}', [tugasController::class, 'update']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}', [tugasController::class, 'destroy']);

    /**
     * route ini untuk membuat nilai dari tugas yang sudah diberikna
     */
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai', [nilaiController::class, 'index']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai', [nilaiController::class, 'store']);
    Route::put('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai/{nilaiid}', [nilaiController::class, 'update']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai/{nilaiid}', [nilaiController::class, 'destroy']);

    /**
     * route ini berfungsi untuk membuat komentar di tugas yang sudah diberikan
     */
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/komentar', [komentarTugasController::class, 'index']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/komentar', [komentarTugasController::class, 'store']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/komentar/{komentarid}', [komentarTugasController::class, 'destroy']);

    /**
     * route untuk membuat pengumuman sekolah
     */
    Route::Resource('pengumuman', pengumumanController::class);

    /**
     * route untuk membuat nama siswa
     */
    Route::Resource('siswa', siswaController::class);

    /**
     * route untuk membuat absensi siswa
     */
    Route::Resource('absensi', absensiController::class);
});
