<?php

namespace Database\Factories;

use App\Models\ListKantor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ListKantor>
 */
class ListKantorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_kantor' => (string) Str::uuid(),
            'nama_kantor' => fake()->unique()->company(),
        ];
    }
}
