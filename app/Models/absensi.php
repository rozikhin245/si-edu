<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'status',
        'keterangan',
        'siswa_id',
        'tanggal_id',
    ];

    // Relasi ke model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke model TanggalAbsensi
    public function tanggal()
    {
        return $this->belongsTo(TanggalAbsensi::class, 'tanggal_id');
    }
}
