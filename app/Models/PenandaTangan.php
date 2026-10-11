<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

class PenandaTangan extends Model
{
    //
    protected $fillable = [
        'unor_siasn_induk',
        'sebagai',
        'nama_pen_ttd',
        'pangkat_gol',
        'nip',
    ];
}
