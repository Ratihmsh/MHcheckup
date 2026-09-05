<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Jawaban>
 */
class JawabanFactory extends Factory
{
    public function definition(): array
    {
        $data = [];

        for ($i = 1; $i <= 42; $i++) {
            $data["soal_$i"] = $this->faker->numberBetween(0, 3);
        }

        return $data;
    }
}
