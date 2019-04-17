<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    public function run()
    {
        // Create default user for each role
        \App\User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => env('DEFAULT_USER'),
            'password' => bcrypt(env('DEFAULT_PASSWORD')),
            'remember_token' => Str::random(32),
            'confirmed' => 1,
            'role' => 'admin',
        ]);

        factory(App\User::class, 20)->create();
    }
}
