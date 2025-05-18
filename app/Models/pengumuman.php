<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman'; // Gunakan nama sesuai migrasi, bisa diganti ke 'pengumuman' jika ingin

    protected $fillable = [
        'judul',
        'keterangan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
