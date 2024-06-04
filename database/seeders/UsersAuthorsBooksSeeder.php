<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersAuthorsBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        // Remove existing users, authors, and books
        Book::truncate();
        Author::truncate();
        User::truncate();
       

        echo "Creating users\n";
        // Prepare user data for bulk insert
        $users = [];
        $total_users = env('USERS_TO_SEED', 2000);
        $password = Hash::make(env('SEEDER_TEST_PASSWORD', 'test'));
        foreach (range(1, $total_users) as $i) {
            if ($i % 100 == 0) {
                echo "On iteration: $i / $total_users\n";
            }
            $username = $this::generateUniqueUsername();
            $users[] = [
                'name' => $faker->name(),
                'username' => $username,
                'email' => $username . '@test.com',
                'email_verified_at' => now(),
                'password' => $password,
                'remember_token' => Str::random(10),
            ];
        }

        echo "\nInserting users\n";
        User::insert($users); // Insert users in bulk

        echo "Creating authors\n";
        $authors = [];
        // Loop through users and create associated authors
        foreach (User::all() as $user) {
            $authors[] = [
                'user_id' => $user->id,
                'nickname' => $this::generateUniqueUsername(),
                'published_books' => env('BOOKS_TO_SEED', 5)
            ];
        }
        echo "Inserting Authors\n";
        Author::insert($authors); // Insert authors in bulk

        echo "Creating books\n";
        $books = [];
        // Loop through authors and create associated books
        foreach (Author::all() as $author) {
            foreach (range(1, env('BOOKS_TO_SEED', 5)) as $i) {
                $books[] = [
                    'author_id' => $author->id,
                    'title' => $faker->sentence(4),
                    'genre' => $faker->word(),
                    'published_at' => $faker->dateTimeBetween('-100 years', 'now'),
                ];
            }
        }
        echo "Inserting books\n";
        Book::insert($books); // Insert books in bulk

        echo "Seeding finished.\n";
    }

    public static function generateUniqueUsername()
    {
        return  fake()->unique()->userName() . '-' . Str::random(15);
    }
}
