<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin-user {name} {username} {email} {password}';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user with admin priveleges';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $username = $this->argument('username');
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => Role::where('name', 'admin')->first()->id
        ]);

        if ($user) {
            $this->info('User created successfully!');
        } else {
            $this->error('Failed to create user!');
        }

        return self::SUCCESS;
    }
}
