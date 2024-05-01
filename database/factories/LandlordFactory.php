<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Landlord>
 */
class LandlordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
        // return [
        //     'name' => $this->faker->name(),
        //     'email' => $this->faker->email(),
        //     'address' => $this->faker->address(),
        //     'phone' => $this->faker->phoneNumber(),
        //     'comment' => $this->faker->text(50),
        // ];
    }
}
