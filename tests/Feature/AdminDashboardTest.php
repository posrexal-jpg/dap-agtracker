<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Location;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_the_admin_dashboard()
    {
        // Create a role
        $role = Role::create(['name' => 'admin']);
        
        // Create an admin user and assign the role
        $admin = User::factory()->create();
        $admin->role_id = $role->id;
        $admin->save();

        // Create a location with some data
        Location::create([
            'name' => 'Test Location',
            'municipality' => 'Test Municipality',
            'latitude' => 10.0,
            'longitude' => 125.0,
            'early_juvenile' => 1,
            'juvenile' => 2,
            'sub_adult' => 3,
            'adult' => 4,
            'late_adult' => 5,
        ]);

        // Act as the admin user
        $this->actingAs($admin);
        
        // Access the admin dashboard page
        $response = $this->get(route('admin.index'));
        
        // Assert that the page is accessible
        $response->assertStatus(200);
        
        // Assert that the response contains the text 'Admin Dashboard'
        $response->assertSee('Admin Dashboard');

        // Assert that the total COTS is calculated correctly
        $response->assertSee('15');
    }
}
