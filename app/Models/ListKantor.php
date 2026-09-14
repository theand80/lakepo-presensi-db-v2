<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListKantor extends Model
{
    protected $fillable = [
        'id_kantor',
        'nama_kantor',
        'bulan_1',
        'bulan_2',
        'bulan_3',
        'bulan_4',
        'bulan_5',
        'bulan_6',
        'bulan_7',
        'bulan_8',
        'bulan_9',
        'bulan_10',
        'bulan_11',
        'bulan_12',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_unor', 'list_kantor_id', 'user_id');
    }
}
