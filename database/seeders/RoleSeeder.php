<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creating roles\n";
        // Remove existing users, roles, authors, and books
        Book ::truncate();
        Author::truncate();
        User::truncate();
        Role::truncate();

        Role::insert(
            [
                [
                    'name' => 'user'
                ],
                [
                    'name' => 'admin'
                ]
            ]
        );
    }
}
