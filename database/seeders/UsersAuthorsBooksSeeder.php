<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use Faker\Factory as FakerFactory;

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

        // Creates random users
        $users = User::factory(env('USERS_TO_SEED', 2000))->create();

        // Loop through users and create associated authors and books
        
        foreach ($users as $user) {
            // Creates and associates author with user
            $author = Author::factory(1)->withUser($user)->create();

            // Create some books for each author
            Book::factory(env('BOOKS_TO_SEED', 5))->withAuthor($author->first())->create();
        }
    }
}

