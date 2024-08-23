<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "productTitle" => fake()->title,
            "productCategoryId"=> random_int(1,10),
            "barcode"=> random_int(100,500),
            "productStatus"=> random_int(0,1),
            "price" => random_int(0,1000),
            "stock" => random_int(0,100),
            'slug' => fake()->name(),
        ];
    }
}
