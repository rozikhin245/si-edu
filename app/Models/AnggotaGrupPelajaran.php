<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaGrupPelajaran extends Model
{
    use HasFactory;

    protected $table = 'anggota_grup_pelajaran';

    protected $fillable = [
        'role',
        'grup_mata_pelajaran_id',
        'users_id',
    ];

    // Relasi ke GrupMatapelajaran
    public function grupMataPelajaran()
    {
        return $this->belongsTo(GrupMatapelajaran::class, 'grup_mata_pelajaran_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
