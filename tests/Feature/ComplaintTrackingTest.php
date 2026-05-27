<?php

namespace Tests\Feature;

use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintTrackingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_new_complaint_automatically_generates_complaint_number_and_initial_log()
    {
        $complaint = Complaint::create([
            'complainant_name' => 'John Doe',
            'complainant_mobile' => '1234567890',
            'area' => 'Downtown',
            'category' => 'water',
            'description' => 'Water pressure is extremely low.',
            'status' => 'pending',
        ]);

        $this->assertNotNull($complaint->complaint_number);
        $this->assertStringStartsWith('CMP-', $complaint->complaint_number);

        // Assert initial log was created
        $this->assertDatabaseHas('complaint_logs', [
            'complaint_id' => $complaint->id,
            'status' => 'pending',
            'message' => 'Grievance registered successfully.',
        ]);
    }

    /** @test */
    public function test_public_user_can_track_complaint_status_and_progress_timeline()
    {
        $complaint = Complaint::create([
            'complainant_name' => 'Jane Doe',
            'complainant_mobile' => '0987654321',
            'area' => 'West End',
            'category' => 'streetlights',
            'description' => 'Lights are not working.',
            'status' => 'pending',
        ]);

        $response = $this->getJson(route('complaint.track', ['number' => $complaint->complaint_number]));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'complaint' => [
                    'complaint_number' => $complaint->complaint_number,
                    'complainant_name' => 'Jane Doe',
                    'status' => 'pending',
                ]
            ]);

        $this->assertCount(1, $response->json('logs'));
    }

    /** @test */
    public function test_admin_can_add_custom_resolution_comment_which_creates_new_tracking_log()
    {
        $admin = \App\Models\User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => \App\Models\User::ROLE_SUPER_ADMIN,
            'is_active' => true,
        ]);

        $complaint = Complaint::create([
            'complainant_name' => 'Bob Smith',
            'complainant_mobile' => '5555555555',
            'area' => 'North Side',
            'category' => 'garbage',
            'description' => 'Trash pile is blocking the road.',
            'status' => 'pending',
        ]);

        // Eager load logs relation
        $complaint->load('logs');

        // Simulate admin update
        $response = $this->actingAs($admin)->put(route('admin.complaint.update', $complaint), [
            'status' => 'under_review',
            'official_action' => 'Dispatched cleanup crew to the location.',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'status' => 'under_review',
        ]);

        // Verify custom action log exists
        $this->assertDatabaseHas('complaint_logs', [
            'complaint_id' => $complaint->id,
            'status' => 'under_review',
            'message' => 'Dispatched cleanup crew to the location.',
        ]);
    }
}
