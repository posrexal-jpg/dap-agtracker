<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $names = [
            'SCUBA Diving',
            'Snorkeling',
            'Swimming',
            'Shore observation',
            'Boat observation',
            'Opportunistic report',
            'Others, please specify',
        ];

        DB::table('activity_types')->insert(array_map(
            fn (string $name, int $index) => [
                'name' => $name,
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            $names,
            array_keys($names)
        ));
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_types');
    }
};
