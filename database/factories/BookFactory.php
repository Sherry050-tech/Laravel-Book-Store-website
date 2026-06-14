<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(3),
            'author'      => $this->faker->name(),
            'price'       => $this->faker->randomFloat(2, 5, 50),
            'image'       => 'default.jpg',
            'description' => $this->faker->paragraph(),
            'category'    => $this->faker->randomElement(['bestseller','new_release','top_rated','popular','suggestion']),
            'rating'      => $this->faker->randomFloat(1, 3, 5),
            'stock'       => $this->faker->numberBetween(10, 200),
            'is_active'   => true,
        ];
    }
}