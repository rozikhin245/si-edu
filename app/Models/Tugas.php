<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'judul',
        'deskripsi',
        'deadline',
        'file',
        'grup_matapelajaran_id',
    ];

    // Relasi ke GrupMatapelajaran
    public function grupMataPelajaran()
    {
        return $this->belongsTo(GrupMatapelajaran::class, 'grup_matapelajaran_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
