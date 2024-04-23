<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->city(),
            'rent' => $this->faker->randomNumber(5),
            // 'tags' => $this->faker->word() . ',' . $this->faker->word(),
            'location' => $this->faker->address(),
            // 'website' => $this->faker->url(),
            'description' => $this->faker->text(50),
            'building_id' => $this->faker->randomElement([1, 3, 4]),
            'landlord_id' => $this->faker->randomElement([2, 3, 4])

        ];
    }
}
