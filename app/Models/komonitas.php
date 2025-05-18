<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komonitas extends Model
{
    use HasFactory;
    protected $table = 'komonitas';
    protected $fillable = ['nama_komonitas', 'tahun_ajaran',];
}
