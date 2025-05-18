<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskusiPelajaran extends Model
{
    use HasFactory;

    protected $table = 'diskusi_pelajaran';

    protected $fillable = [
        'pesan',
        'users_id',
        'grup_mata_pelajaran_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relasi ke GrupMataPelajaran
    public function grupMataPelajaran()
    {
        return $this->belongsTo(GrupMatapelajaran::class, 'grup_mata_pelajaran_id');
    }
}
