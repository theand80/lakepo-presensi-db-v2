<?php

namespace Database\Factories;

use App\Models\DataAbsen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DataAbsen>
 */
class DataAbsenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('#################'),
            'nama' => fake()->name(),
            'date' => now()->format('Y-m-d'),
            'hari_libur' => '0',
            'kegiatan' => null,
            'unor_simpegnas' => null,
            'unor_simpegnas_id' => null,
            'checkIn_work_from' => '07:30',
            'checkIn_status' => 'H',
            'checkIn_status_script' => null,
            'checkIn_status_change' => null,
            'checkIn_time_with_timezone' => '07:30',
            'checkIn_time_with_timezone_change' => null,
            'checkIn_late' => '0',
            'checkRest_work_from' => '12:00',
            'checkRest_status' => 'H',
            'checkRest_status_script' => null,
            'checkRest_status_change' => null,
            'checkRest_time_with_timezone' => '12:00',
            'checkRest_time_with_timezone_change' => null,
            'checkRest_late' => '0',
            'checkOut_work_from' => '16:00',
            'checkOut_status' => 'H',
            'checkOut_status_script' => null,
            'checkOut_status_change' => null,
            'checkOut_time_with_timezone' => '16:00',
            'checkOut_time_with_timezone_change' => null,
            'checkOut_late' => '0',
            'status' => 'HM',
            'status_script' => null,
            'status_change' => null,
            'late' => '0',
            'tak' => null,
            'persentase' => null,
        ];
    }
}
