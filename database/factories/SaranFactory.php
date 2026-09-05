<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['depression', 'anxiety', 'stress']),
            'level' => $this->faker->randomElement(['normal', 'ringan', 'sedang', 'tinggi', 'sangat tinggi']),
            'saran_rekomendasi' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
