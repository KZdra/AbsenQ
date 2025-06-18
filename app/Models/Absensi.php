<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'siswa_id',
        'waktu',
        'status',
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
