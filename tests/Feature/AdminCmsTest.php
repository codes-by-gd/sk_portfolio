<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CmsPage;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminCmsTest extends TestCase
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
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Create mock CMS pages required by the admin view
        $cmsKeys = [
            'hero_greeting' => ['Welcome English', 'Welcome Gujarati', 'Welcome Hindi'],
            'hero_title' => ['Title English', 'Title Gujarati', 'Title Hindi'],
            'hero_mission' => ['Mission English', 'Mission Gujarati', 'Mission Hindi'],
            'about_title' => ['About English', 'About Gujarati', 'About Hindi'],
            'about_bio' => ['Bio English', 'Bio Gujarati', 'Bio Hindi'],
            'about_vision' => ['Vision English', 'Vision Gujarati', 'Vision Hindi'],
            'achievement_roads' => ['12 | + km | Roads Built', '12 | + km | રસ્તાઓ બનાવેલ', '12 | + km | सड़कें निर्मित'],
            'achievement_lights' => ['1500 | + | Lights', '1500 | + | લાઈટો', '1500 | + | लाइटें'],
            'achievement_grievances' => ['98 | % | Grievances', '98 | % | ફરિયાદો', '98 | % | शिकायतें'],
            'achievement_camps' => ['50 | + | Camps', '50 | + | કેम्पો', '50 | + | शिविर'],
        ];

        foreach ($cmsKeys as $key => $vals) {
            $page = CmsPage::create([
                'key' => $key,
                'content_en' => $vals[0],
                'content_gu' => $vals[1],
                'content_hi' => $vals[2],
            ]);

            if ($key === 'hero_greeting') {
                $this->cmsPage = $page;
            }
        }
    }

    public function test_admin_can_access_cms_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.cms.index'));

        $response->assertStatus(200);
        $response->assertSee('CMS Content');
        $response->assertSee('Hero Portrait Branding');
    }

    public function test_admin_can_update_cms_text()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.cms.update', $this->cmsPage), [
                'content_en' => 'Updated English',
                'content_gu' => 'Updated Gujarati',
                'content_hi' => 'Updated Hindi',
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->cmsPage->refresh();
        $this->assertEquals('Updated English', $this->cmsPage->content_en);
        $this->assertEquals('Updated Gujarati', $this->cmsPage->content_gu);
    }

    public function test_admin_can_upload_hero_portrait_on_cms_page()
    {
        // Mock a simple 100x100 JPG image
        $image = UploadedFile::fake()->image('hero_portrait_upload.jpg', 100, 100);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.cms.update-hero'), [
                'hero_image' => $image,
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $heroSetting = Setting::getValue('hero_image');
        $this->assertNotNull($heroSetting);
        $this->assertStringContainsString('uploads/settings/', $heroSetting);
        $this->assertStringEndsWith('.webp', $heroSetting);

        // Assert file exists on disk
        $fullPath = public_path($heroSetting);
        $this->assertTrue(file_exists($fullPath));

        // Clean up the created test file
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
