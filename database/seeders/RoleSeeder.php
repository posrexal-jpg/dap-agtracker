<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Make sure to import the DB facade
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Using the DB facade to insert data directly into the role table
        DB::table('roles')->insert([
            [
                'role_name' => 'admin',
            ],
            [
                'role_name' => 'user', // Add other roles if needed
            ],
        ]);
    }
}
