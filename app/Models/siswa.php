<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'nis',
        'nisn',
        'angkatan',
        'users_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
