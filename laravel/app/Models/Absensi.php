<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'jam_masuk',
        'jam_pulang',
        'foto_masuk',
        'foto_pulang',
        'foto_izin'];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

}
