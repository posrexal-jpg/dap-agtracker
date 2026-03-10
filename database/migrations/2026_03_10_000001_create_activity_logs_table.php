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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('activity_type', 100); // create, update, delete, approve, reject, export, etc.
            $table->text('description');
            $table->string('model_type')->nullable(); // The model class name (e.g., User, Location)
            $table->unsignedBigInteger('model_id')->nullable(); // The model ID
            $table->json('old_values')->nullable(); // Previous values before update
            $table->json('new_values')->nullable(); // New values after update
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Indexes for better query performance
            $table->index('user_id');
            $table->index('activity_type');
            $table->index(['model_type', 'model_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
