<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table    = 'dokumentasis';
    protected $fillable = ['title', 'deskripsi', 'link', 'icon'];
}