<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAbsen extends Model
{
    protected $fillable = [
        'nip',
        'nama',
        'date',
        'libur',
        'kegiatan',

        'unor_simpegnas',
        'unor_simpegnas_id',
        // ---
        // 'checkIn',
        'checkIn_work_from',
        'checkIn_status',
        'checkIn_status_change',
        'checkIn_time_with_timezone',
        'checkIn_time_with_timezone_change',
        'checkIn_late',
        // ---
        // 'checkRest',
        'checkRest_work_from',
        'checkRest_status',
        'checkRest_status_change',
        'checkRest_time_with_timezone',
        'checkRest_time_with_timezone_change',
        'checkRest_late',
        // ---
        // 'checkOut',
        'checkOut_work_from',
        'checkOut_status',
        'checkOut_status_change',
        'checkOut_time_with_timezone',
        'checkOut_time_with_timezone_change',
        'checkOut_late',
        // ---
        'status',
        'status_change',
        'late',
        'tak',
    ];
}
