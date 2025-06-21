<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'siswa_id',
        'waktu_absen',
        'status',
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
