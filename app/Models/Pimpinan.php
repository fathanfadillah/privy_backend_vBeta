<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pimpinan extends Model
{
    protected $table    = 'pimpinans';
    protected $fillable = ['nama', 'jabatan', 'foto'];
}
