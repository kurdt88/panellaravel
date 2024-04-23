<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->numerify('##########'),
            'description' => $this->faker->text(50),
        ];
    }
}
