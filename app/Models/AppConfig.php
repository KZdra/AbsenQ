<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    protected $fillable = [
        'app_name',
        'logo_path',
        'mode_scan'
    ];
}
