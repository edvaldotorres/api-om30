<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => rand(1, 10),
            'zip_code' => rand(10000000, 99999999),
            'street' => $this->faker->word(),
            'number' => rand(1, 1000),
            'complement' => $this->faker->word(),
            'district' => $this->faker->word(),
            'city' => $this->faker->word(),
            'state' => $this->faker->word(),
        ];
    }
}
