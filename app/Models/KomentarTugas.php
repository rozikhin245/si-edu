<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarTugas extends Model
{
    use HasFactory;

    protected $table = 'komentar_tugas'; // Gunakan nama sesuai migrasi

    protected $fillable = [
        'komentar',
        'users_id',
        'tugas_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relasi ke Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}
