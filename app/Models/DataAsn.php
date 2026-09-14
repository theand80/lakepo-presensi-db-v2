<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAsn extends Model
{
    /** @use HasFactory<\Database\Factories\DataAsnFactory> */
    use HasFactory;

    protected $fillable = ['nip', 'nama', 'pangkat', 'golongan', 'status', 'jabatan', 'unor_siasn', 'unor_siasn_induk', 'unor_simpegnas_id', 'unor_simpegnas', 'foto_simpegnas'];
}
