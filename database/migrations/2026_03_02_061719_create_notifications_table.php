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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Type of notification (e.g., 'new_sighting')
            $table->unsignedBigInteger('location_id')->nullable(); // Related location/sighting
            $table->unsignedBigInteger('user_id')->nullable(); // User who created the sighting
            $table->string('title'); // Notification title
            $table->text('message'); // Notification message
            $table->boolean('is_read')->default(false); // Read status
            $table->timestamp('read_at')->nullable(); // When notification was read
            $table->timestamps();

            // Foreign keys
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
