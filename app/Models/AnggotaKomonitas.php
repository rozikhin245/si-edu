<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKomonitas  extends Model
{
    use HasFactory;

    protected $table = 'anggota_komonitas';

    protected $fillable = [
        'role',
        'komonitas_id',
        'users_id',
    ];

    // Relasi ke model Komonitas
    public function komonitas()
    {
        return $this->belongsTo(Komonitas::class, 'komonitas_id');
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
