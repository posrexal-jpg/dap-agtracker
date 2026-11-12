<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('activity_type_other')->nullable()->after('activity_type');
            $table->string('survey_status')->nullable()->after('observer_category');
            $table->time('observation_start_time')->nullable()->after('time_of_sighting');
            $table->time('observation_end_time')->nullable()->after('observation_start_time');
            $table->unsignedInteger('observation_duration_minutes')->nullable()->after('observation_end_time');
            $table->decimal('transect_length_m', 10, 2)->nullable()->after('observation_duration_minutes');
            $table->decimal('transect_width_m', 10, 2)->nullable()->after('transect_length_m');
            $table->decimal('surveyed_area_m2', 12, 2)->nullable()->after('transect_width_m');
            $table->decimal('depth_m', 8, 2)->nullable()->after('surveyed_area_m2');
            $table->decimal('water_visibility_m', 8, 2)->nullable()->after('depth_m');
            $table->string('weather_sea_condition')->nullable()->after('water_visibility_m');
        });

        DB::table('settings')->updateOrInsert(
            ['key' => 'outbreak_threshold'],
            ['value' => '25', 'updated_at' => now(), 'created_at' => now()]
        );
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn([
                'activity_type_other',
                'survey_status',
                'observation_start_time',
                'observation_end_time',
                'observation_duration_minutes',
                'transect_length_m',
                'transect_width_m',
                'surveyed_area_m2',
                'depth_m',
                'water_visibility_m',
                'weather_sea_condition',
            ]);
        });
    }
};
