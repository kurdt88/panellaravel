<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'building_id' => $this->faker->randomNumber(1),
            'name' => $this->faker->city() . ' Supplier INC ',
            'email' => $this->faker->email(),
            'phone' => $this->faker->numerify('##########'),
            'comment' => $this->faker->text(50),

        ];
    }
}
