<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupMatapelajaran extends Model
{
    use HasFactory;

    protected $table = 'grup_matapelajaran';

    public $timestamps = false;

    protected $fillable = [
        'nama_grup',
        'komonitas_id',
    ];

    // Relasi: GrupMatapelajaran dimiliki oleh satu Komonitas
    public function komonitas()
    {
        return $this->belongsTo(Komonitas::class, 'komonitas_id');
    }
}
