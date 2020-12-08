<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisRumah extends Model
{
    protected $table    = 'tm_jenis_rumah';
    protected $fillable = ['id', 'nm_jenis_rumah', 'created_at', 'updated_at'];
}
