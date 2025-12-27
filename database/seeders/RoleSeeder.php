<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Make sure to import the DB facade
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Using the Role model to create or update roles
        \App\Models\Role::firstOrCreate(['role_name' => 'admin']);
        \App\Models\Role::firstOrCreate(['role_name' => 'user']);
    }
}
