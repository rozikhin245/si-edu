<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskusiKomonitas extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi Laravel (plural)
    protected $table = 'diskusi_komonitas';

    // Field yang boleh di-*mass-assign*
    protected $fillable = [
        'pesan',
        'users_id',
        'komonitas_id',
    ];

    // Relasi: Diskusi dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relasi: Diskusi terkait satu komunitas
    public function komonitas()
    {
        return $this->belongsTo(Komonitas::class, 'komonitas_id');
    }
}
