<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image' => $this->faker->imageUrl(),
            'name' => $this->faker->name(),
            'mother_name' => $this->faker->name(),
            'birth_date' => $this->faker->date(),
            'cpf' => $this->faker->cpf(),
            'cns' => null,
        ];
    }
}
