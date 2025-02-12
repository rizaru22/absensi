<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_instansi',
        'latitude',
        'longitude',
        'jam_masuk',
        'jam_pulang',
        'jam_maksimal_masuk',
        'jam_maksimal_pulang',
        'jarak_maksimal',
        'group_wa_id',
        'token'
    ];

}
