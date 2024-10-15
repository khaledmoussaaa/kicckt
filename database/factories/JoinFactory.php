<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Joins>
 */
class JoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_color' => $this->faker->randomElement(['red', 'purple']), // Random team_color: red or purple
            'user_id' => $this->faker->numberBetween(1, 10), // Random user_id between 1 and 10
            'match_id' => 1, // Match ID 1
        ];
    }
}
