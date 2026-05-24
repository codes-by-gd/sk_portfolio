<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::create([
            'first_name' => 'Sachin',
            'last_name' => 'Khandelwal',
            'email' => 'admin@sachinkhandelwal.com',
            'password' => bcrypt('Password@123'),
        ]);
    }

    public function test_admin_can_access_settings_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.settings.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_save_settings_without_image()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.settings.update'), [
                'office_address' => 'Test Address',
                'office_phone' => '1234567890',
                'office_email' => 'office@test.com',
                'office_timings' => '9 AM - 5 PM',
                'facebook_url' => 'facebook.com/test',
                'twitter_url' => 'twitter.com/test',
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertEquals('Test Address', Setting::getValue('office_address'));
        $this->assertEquals('facebook.com/test', Setting::getValue('facebook_url'));
    }
}
