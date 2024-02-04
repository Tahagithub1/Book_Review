<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{

    public function definition(): array
    {
        return [
             'book_id' => null,
             'review' => fake()->paragraph,
             'rating' => fake()->numberBetween(1,5),
             'created_at' => fake()->dateTimeBetween('-2 years'),
            //  'updated-at' => function (array $attributes) {
            //           return fake()->dateTimeBetween($attributes['created_at']);
            // },
            'updated_at' => fake()->dateTimeBetween('created_at','now'),

        ];
    }

    public function good() {
        return $this->state(function (array $attributes)  {
        return[
           'rating' => fake()->numberBetween(4,5)
        ];
    });
    }
    public function average() {
        return $this->state(function (array $attributes)  {
        return[
           'rating' => fake()->numberBetween(2,5)
        ];
    });
    }

    public function bad() {
        return $this->state(function (array $attributes)  {
        return[
           'rating' => fake()->numberBetween(1,3)
        ];
    });
    }
}
