<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Userss>
 */
class UserssFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "username"=> fake()->userName,
            "userTitle"=> fake()->title,
            "password"=> "123",
            'slug' => fake()->name()
        ];
    }
}
