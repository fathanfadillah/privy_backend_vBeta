<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedagangAlamat extends Model
{
    protected $table    = 'tm_pedagang_alamats';
    protected $fillable = ['id', 'tm_pedagang_id', 'tm_pasar_kategori_id', 'nm_toko', 'kd_toko', 'nm_blok', 'tgl_tinggal', 'status', 'created_at', 'updated_at'];

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class, 'tm_pedagang_id');
    }

    public function pasarkategori()
    {
        return $this->belongsTo(PasarKategori::class, 'tm_pasar_kategori_id');
    }
}
