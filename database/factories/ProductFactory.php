<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'unique_id' => Str::uuid(),
            'image' => fake()->randomElement([
                asset('assets/img/product/1.jpg'),     
                asset('assets/img/product/2.jpeg'),     
                asset('assets/img/product/3.jpg'),     
                asset('assets/img/product/4.jpeg'),     
                asset('assets/img/product/5.jpg')
            ]),
            'name' => fake()->words(3, true),
            'slug' => fake()->slug(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 1000), 
            'rating' => fake()->randomFloat(2, 1, 5),    
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
