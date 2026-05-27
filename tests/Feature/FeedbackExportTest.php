<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_route_requires_auth()
    {
        $response = $this->get(route('admin.feedback.export'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_export_feedbacks_as_xlsx()
    {
        $user = User::factory()->create(['role' => 'super_admin', 'is_active' => true]);
        
        // Seed feedbacks of different statuses
        Feedback::create([
            'name' => 'Citizen Approved',
            'mobile_number' => '1234567890',
            'area' => 'Ward 7',
            'title' => 'Approved Review',
            'message' => 'Approved message',
            'rating' => 5,
            'status' => 'approved',
        ]);

        Feedback::create([
            'name' => 'Citizen Pending',
            'mobile_number' => '1234567890',
            'area' => 'Ward 7',
            'title' => 'Pending Review',
            'message' => 'Pending message',
            'rating' => 4,
            'status' => 'pending',
        ]);

        Feedback::create([
            'name' => 'Citizen Rejected',
            'mobile_number' => '1234567890',
            'area' => 'Ward 7',
            'title' => 'Rejected Review',
            'message' => 'Rejected message',
            'rating' => 1,
            'status' => 'rejected',
        ]);

        // 1. Export default (defaults to approved)
        $response = $this->actingAs($user)->get(route('admin.feedback.export'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename="feedbacks_export_' . date('Y-m-d') . '.xlsx"');

        // 2. Export only approved
        $responseApproved = $this->actingAs($user)->get(route('admin.feedback.export', ['status' => 'approved']));
        $responseApproved->assertStatus(200);
        $responseApproved->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        // 3. Export only pending
        $responsePending = $this->actingAs($user)->get(route('admin.feedback.export', ['status' => 'pending']));
        $responsePending->assertStatus(200);
        $responsePending->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        // 4. Export all statuses
        $responseAll = $this->actingAs($user)->get(route('admin.feedback.export', ['status' => 'all']));
        $responseAll->assertStatus(200);
        $responseAll->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
