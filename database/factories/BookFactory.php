<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name,
            'created_at' => fake()->dateTimeBetween('-2 years'),
            // 'updated-at' => function (array $attributes) {
            //           return Fake()->dateTimeBetween($attributes['created_at']);
            // },
            'updated_at' => fake()->dateTimeBetween('created_at','now'),
        ];
    }
}
