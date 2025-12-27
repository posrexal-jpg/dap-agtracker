<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name')->unique();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            [
                'role_name' => 'admin',
                'created_at' => now(),  // Manually set the created_at timestamp
                'updated_at' => now() 
            ],
            [
                'role_name' => 'user',
                'created_at' => now(),  // Manually set the created_at timestamp
                'updated_at' => now()  // Add other roles if needed
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};