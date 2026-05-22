<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_detailed_feedback_page_loads_normally_and_supports_ajax_pagination()
    {
        // Seed some approved feedback
        for ($i = 0; $i < 10; $i++) {
            Feedback::create([
                'name' => "Citizen $i",
                'mobile_number' => '1234567890',
                'area' => 'Ward 7',
                'title' => "Feedback Title $i",
                'message' => "Message $i",
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false,
            ]);
        }

        // 1. Normal GET request returns full page
        $response = $this->get(route('feedback.detailed'));
        $response->assertStatus(200);
        $response->assertSee('feedback-listing-container');

        // 2. AJAX GET request returns JSON with html key
        $ajaxResponse = $this->getJson(route('feedback.detailed'), [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        $ajaxResponse->assertStatus(200);
        $ajaxResponse->assertJsonStructure(['html']);
    }

    public function test_admin_dashboard_page_requires_auth_and_supports_ajax_pagination()
    {
        // Seed some feedback
        for ($i = 0; $i < 15; $i++) {
            Feedback::create([
                'name' => "Citizen $i",
                'mobile_number' => '1234567890',
                'area' => 'Ward 7',
                'title' => "Feedback Title $i",
                'message' => "Message $i",
                'rating' => 5,
                'status' => 'approved',
                'is_featured' => false,
            ]);
        }

        // 1. Guest is redirected
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));

        // Create and authenticate user
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. Normal authenticated GET request returns full page
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('admin-feedback-table-container');

        // 3. AJAX GET request returns JSON with html key
        $ajaxResponse = $this->getJson(route('admin.dashboard'), [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        $ajaxResponse->assertStatus(200);
        $ajaxResponse->assertJsonStructure(['html']);
    }
}
