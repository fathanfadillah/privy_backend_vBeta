<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuntungan extends Model
{
    protected $table    = 'keuntungans';
    protected $fillable = ['title_keuntungan', 'deskripsi_keuntungan', 'icon'];
}
