<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'administrator@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Administrator'),
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('user12345678'),
            'role_id' => 2,
        ]);
    }
}
