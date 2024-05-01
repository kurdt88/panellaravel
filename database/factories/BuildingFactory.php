<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class BuildingFactory extends Factory
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
        //     // 'building_id' => $this->faker->randomNumber(1),
        //     'name' => 'Edificio ' . $this->faker->city(),
        //     'address' => $this->faker->address(),
        //     'description' => $this->faker->text(50),

        // ];
    }
}
