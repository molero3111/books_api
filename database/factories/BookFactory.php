<?php

namespace Database\Factories;

use App\Models\Author;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();

        return [
            'author_id' => null,  // Allow null for author association during testing
            'title' => $faker->sentence(4),
            'genre' => $faker->word(),
            'published_at' => $faker->dateTimeBetween('-100 years', 'now'),
        ];
    }

    public function withAuthor(Author $author): BookFactory
    {
        return $this->state(function (array $attributes) use ($author) {
            return [
                'author_id' => $author->id,
            ];
        });
    }
}
