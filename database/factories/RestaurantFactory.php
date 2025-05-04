<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(3),
            'image' => $this->faker->imageUrl(200, 200),
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'opens_at' => $this->faker->time(),
            'closes_at' => $this->faker->time(),
        ];
    }
}
