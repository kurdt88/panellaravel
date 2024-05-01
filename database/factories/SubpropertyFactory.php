<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subproperty>
 */
class SubpropertyFactory extends Factory
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
        //     'title' => $this->faker->company(),
        //     'rent' => $this->faker->randomNumber(4),
        //     'address' => $this->faker->address(),
        //     'type' => $this->faker->randomElement(['Bodega', 'Estudio', 'Estacionamento']),
        //     'description' => $this->faker->text(50),
        //     'landlord_id' => $this->faker->randomElement([2, 3, 4]),
        //     'property_id' => $this->faker->randomElement([2, 4, 6, 8, 10, 11]),

        // ];
    }
}


