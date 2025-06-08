<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\nilaiController;
use App\Http\Controllers\Api\siswaController;
use App\Http\Controllers\api\tugasController;
use App\Http\Controllers\Api\absensiController;
use App\Http\Controllers\api\allUser;
use App\Http\Controllers\api\komonitasController;
use App\Http\Controllers\Api\pengumumanController;
use App\Http\Controllers\api\komentarTugasController;
use App\Http\Controllers\api\ForgotPasswordController;
use App\Http\Controllers\Api\AnggotaKomonitasController;
use App\Http\Controllers\api\DiskusiKomonitasController;
use App\Http\Controllers\Api\GrupMataPelajaranController;
use App\Http\Controllers\api\anggotaGrupPelajaranController;
use App\Http\Controllers\Api\DikusiGrupMataPelajaranController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
})->name('login');

Route::post('registerUsers', [AuthController::class, 'regiterUsers']);
Route::post('loginUsers', [AuthController::class, 'loginUsers']);
Route::middleware('auth:sanctum')->post('logoutUsers', [AuthController::class, 'logoutUsers']);

/**
 * route untuk lupa password
 * tapi route ini belum berfungsi,selengkapnya ada di route
 */
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'reset']);

// route untuk data yang bisa dilihat oleh semua jenis users
Route::middleware('auth:sanctum', 'role:admin,guru,wali-murid')->group(function () {
    /**
     * route untuk aktifitas akun users
     */
    Route::get('profile', [UserController::class, 'profile']);
    Route::put('updateProfile', [UserController::class, 'updateProfile']);
    Route::put('change-password', [UserController::class, 'changePassword']);

    // fungsi untuk menampilkan data komonitas
    // untuk admin, semua data komonitas ditampilkan, selain admin hanya ditampilkan data komonitas yng ditambahkan
    Route::get('komonitas', [komonitasController::class, 'index']);
    Route::get('komonitas/{komunitas}', [komonitasController::class, 'show']);

    // fungsi untuk menampilkan anggota komonitas
    Route::get('komonitas/{komunitas}/anggota', [AnggotaKomonitasController::class, 'index']);


    // fungsi untuk fitur diskusi komonitas
    Route::get('komonitas/{komunitas}/diskusiKomonitas', [DiskusiKomonitasController::class, 'index']);
    Route::post('komonitas/{komunitas}/diskusiKomonitas', [DiskusiKomonitasController::class, 'store']);
    Route::delete('komonitas/{komunitas}/diskusiKomonitas/{diskusikomonitas}', [DiskusiKomonitasController::class, 'destroy']);

    // fungsi untuk menampilkan grup mata pelajaran
    Route::get('komonitas/{komunitas}/GrupMataPelajaran', [GrupMataPelajaranController::class, 'index']);
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}', [GrupMataPelajaranController::class, 'show']);

    // fungsi untuk fitur diskusi mata pelajaran
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/diskusipelajaran', [DikusiGrupMataPelajaranController::class, 'index']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/diskusipelajaran', [DikusiGrupMataPelajaranController::class, 'store']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/diskusipelajaran/{diskusi}', [DikusiGrupMataPelajaranController::class, 'destroy']);

    // fungsi untuk menampilkan anggota grup
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/anggotagrup', [anggotaGrupPelajaranController::class, 'index']);

    // fungsi untuk menampilkan tugas
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas', [tugasController::class, 'index']);
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}', [tugasController::class, 'show']);

    // fungsi untuk menampilkan nilai
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai', [nilaiController::class, 'index']);

    // fungsi untuk fitur komentar tugas
    Route::get('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/komentar', [komentarTugasController::class, 'index']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/komentar', [komentarTugasController::class, 'store']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/komentar/{komentarid}', [komentarTugasController::class, 'destroy']);

    // fungsi untuk menampilkan pengumuman sekolah
    Route::get('pengumuman', [pengumumanController::class, 'index']);
    Route::get('pengumuman/{id}', [pengumumanController::class, 'show']);

    // fungsi untuk menampilkan data siswa
    Route::get('siswa', [siswaController::class, 'index']);
    Route::get('siswa/{id}', [siswaController::class, 'show']);

    // fungsi untuk menampilkan absensi
    Route::get('absensi', [absensiController::class, 'index']);
});


// route ini hanya bisa diakses oleh admin dan guru
Route::middleware('auth:sanctum', 'role:admin,guru')->group(function () {

    // fungsi untuk membuat, mengupdate, dan menghapus tugas
    Route::put('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}', [tugasController::class, 'update']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}', [tugasController::class, 'destroy']);
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas', [tugasController::class, 'store']);

    // fungsi untuk membuat, mengupdate, dan menghapus nilai
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai', [nilaiController::class, 'store']);
    Route::put('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai/{nilaiid}', [nilaiController::class, 'update']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/tugas/{tugas}/nilai/{nilaiid}', [nilaiController::class, 'destroy']);

    // fungsi untuk membuat, mengupdate, dan menghapus absensi
    Route::Resource('absensi', absensiController::class);
});


// route ini hanya bisa diakses oleh admin
Route::middleware('auth:sanctum', 'role:admin')->group(function () {
    // fungsi mengelola komonitas, show dan get bisa dilakukan oleh semua orang
    Route::post('komonitas', [komonitasController::class, 'store']);
    Route::put('komonitas/{komunitas}', [komonitasController::class, 'update']);
    Route::delete('komonitas/{komunitas}', [komonitasController::class, 'destroy']);

    // Fungsi untuk menambah dan menghapus anggota komonitas
    Route::post('komonitas/{komunitas}/anggota', [AnggotaKomonitasController::class, 'store']);
    Route::delete('komonitas/{komunitas}/anggota/{anggotaKomonitas}', [AnggotaKomonitasController::class, 'destroy']);

    // Fungsi untuk membuat, mengupdate, dan menghapus grup pelajaran
    Route::post('komonitas/{komunitas}/GrupMataPelajaran', [GrupMataPelajaranController::class, 'store']);
    Route::put('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}', [GrupMataPelajaranController::class, 'update']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}', [GrupMataPelajaranController::class, 'destroy']);

    // fungsi untuk menambah dan menghapus anggota grup pelajaran
    Route::post('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/anggotagrup', [anggotaGrupPelajaranController::class, 'store']);
    Route::delete('komonitas/{komunitas}/GrupMataPelajaran/{grup_id}/anggotagrup/{anggota}', [anggotaGrupPelajaranController::class, 'destroy']);

    // fungsi untuk mengelola pengumuman sekolah
    Route::Resource('pengumuman', pengumumanController::class);


    Route::Resource('siswa', siswaController::class);

    Route::get('allUsers', [allUser::class, 'index']);
    Route::delete('deleteUser/{user}', [allUser::class, 'destroy']);
});
