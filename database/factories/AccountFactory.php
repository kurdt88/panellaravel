<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'landlord_id' => $this->faker->randomElement([2, 3, 4]),
            'alias' => $this->faker->text(8),
            'bank' => $this->faker->randomElement(['HSBC', 'City Banamex', 'BBVA Bancomer', 'Banorte']),
            'number' => $this->faker->creditCardNumber(),
            'type' => $this->faker->randomElement(['USD', 'MXN']),
            'comment' => $this->faker->text(50),
        ];
    }
}
