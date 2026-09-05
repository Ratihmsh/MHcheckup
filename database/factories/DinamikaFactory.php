<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DinamikaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['depression', 'anxiety', 'stress']),
            'level' => $this->faker->randomElement(['normal', 'ringan', 'sedang', 'tinggi', 'sangat tinggi']),
            'dinamika_psikologis' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
