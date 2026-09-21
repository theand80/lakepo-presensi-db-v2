<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamReferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jam_referensis')->insert([
            [
                'kode' => 'TL1',
                'waktu' => '07:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TL2',
                'waktu' => '08:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TL3',
                'waktu' => '08:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TL4',
                'waktu' => '09:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PSW1',
                'waktu' => '16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PSW2',
                'waktu' => '15:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PSW3',
                'waktu' => '15:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PSW4',
                'waktu' => '14:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
