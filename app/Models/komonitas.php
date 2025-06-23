<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komonitas extends Model
{
    use HasFactory;
    protected $table = 'komonitas';
    protected $fillable = ['nama_komonitas', 'tahun_ajaran',];

    // relasi 2 arah untuk daftar komonitas
    // berfungsi untuk mengambil data komonitas tertentu untuk user dan guru
    public function anggotaKomonitas()
    {
        return $this->hasMany(AnggotaKomonitas::class, 'komonitas_id');
    }

    public function tanggalAbsensi()
    {
        return $this->hasMany(TanggalAbsensi::class, 'komunitas_id');
    }
}
