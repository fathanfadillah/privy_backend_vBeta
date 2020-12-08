<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table    = 'tm_penduduks';
    protected $fillable = ['id', 'nm_penduduk', 'no_ktp','created_at', 'updated_at'];

    public function jenisRumah()
    {
        return $this->belongsTo(JenisRumah::class, 'tm_jenis_rumah_id');
    }



}
