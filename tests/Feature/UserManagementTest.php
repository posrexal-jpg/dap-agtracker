<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_the_user_list_page()
    {
        // Create a role
        $role = Role::create(['name' => 'admin']);
        
        // Create an admin user and assign the role
        $admin = User::factory()->create();
        $admin->role_id = $role->id;
        $admin->save();

        // Act as the admin user
        $this->actingAs($admin);
        
        // Access the user list page
        $response = $this->get(route('admin.users.index'));
        
        // Assert that the page is accessible
        $response->assertStatus(200);
        
        // Assert that the response contains the text 'Users'
        $response->assertSee('Users');
    }
}
