<?php

namespace Tests\Feature;

use App\Models\ActivityType;
use App\Models\Location;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SurveyFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_recommended_activity_types_and_threshold_are_seeded(): void
    {
        $this->assertSame(7, ActivityType::count());
        $this->assertSame('25', Setting::get('outbreak_threshold'));
        $this->assertTrue(ActivityType::where('name', 'SCUBA Diving')->exists());
        $this->assertTrue(ActivityType::where('name', 'Others, please specify')->exists());
    }

    public function test_mobile_report_accepts_optional_survey_fields(): void
    {
        $role = Role::where('role_name', 'user')->firstOrFail();
        $user = User::factory()->create([
            'role_id' => $role->id,
            'is_approved' => true,
        ]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/sightings', [
            'client_uuid' => 'aa3de0f7-27c9-45d4-a215-ff340452438d',
            'location_name' => 'Test Reef',
            'latitude' => 10.25,
            'longitude' => 125.01,
            'barangay' => 'San Roque',
            'municipality' => 'Bontoc',
            'activity_type' => 'SCUBA Diving',
            'survey_status' => 'Systematic survey',
            'observation_start_time' => '09:00',
            'observation_end_time' => '10:30',
            'transect_length_m' => 50,
            'transect_width_m' => 5,
            'depth_m' => 8.5,
            'water_visibility_m' => 12,
            'weather_sea_condition' => 'Clear and calm',
            'adult' => 12,
            'late_adult' => 30,
        ]);

        $response->assertCreated()
            ->assertJsonPath('sighting.observation_duration_minutes', 90)
            ->assertJsonPath('sighting.outbreak_count', 42);

        $location = Location::firstOrFail();
        $this->assertSame(42, $location->outbreak_count);
        $this->assertSame('250.00', $location->surveyed_area_m2);
        $this->assertSame('Clear and calm', $location->weather_sea_condition);
    }
}
