<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalAbsensi extends Model
{
    use HasFactory;

    protected $table = 'tanggal_absensi';

    protected $fillable = [
        'tanggal',
        'nama_guru',
        'komunitas_id',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'tanggal_id');
    }
    public function komunitas()
    {
        return $this->belongsTo(Komonitas::class, 'komunitas_id');
    }
}
