<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\GalleryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GallerySearchFilterTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected GalleryImage $imageA;
    protected GalleryImage $imageB;

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

        // Seed gallery images
        $this->imageA = GalleryImage::create([
            'image_path' => 'uploads/gallery/a.webp',
            'category' => 'events',
            'caption_en' => 'BJP Election Rally',
            'caption_gu' => 'ચૂંટણી રેલી',
            'caption_hi' => 'चुनाव रैली',
        ]);

        $this->imageB = GalleryImage::create([
            'image_path' => 'uploads/gallery/b.webp',
            'category' => 'visits',
            'caption_en' => 'Ward Visit under bridge',
            'caption_gu' => 'વોર્ડ મુલાકાત',
            'caption_hi' => 'वार्ड दौरा',
        ]);
    }

    /**
     * Test admin can access gallery index.
     */
    public function test_admin_can_access_gallery_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.gallery.index'));

        $response->assertStatus(200);
        $response->assertSee('Gallery Management');
        $response->assertSee('BJP Election Rally');
        $response->assertSee('Ward Visit under bridge');
    }

    /**
     * Test admin can search gallery by keyword.
     */
    public function test_admin_can_search_gallery_by_keyword()
    {
        // Search matches "Rally" in Image A caption
        $response = $this->actingAs($this->admin)
            ->get(route('admin.gallery.index', ['search' => 'Rally']));

        $response->assertStatus(200);
        $response->assertSee('BJP Election Rally');
        $response->assertDontSee('Ward Visit under bridge');

        // Search matches "वार्ड" (Hindi text) in Image B
        $response = $this->actingAs($this->admin)
            ->get(route('admin.gallery.index', ['search' => 'वार्ड']));

        $response->assertStatus(200);
        $response->assertSee('Ward Visit under bridge');
        $response->assertDontSee('BJP Election Rally');
    }

    /**
     * Test admin can filter gallery by category.
     */
    public function test_admin_can_filter_gallery_by_category()
    {
        // Filter by category "visits"
        $response = $this->actingAs($this->admin)
            ->get(route('admin.gallery.index', ['category' => 'visits']));

        $response->assertStatus(200);
        $response->assertSee('Ward Visit under bridge');
        $response->assertDontSee('BJP Election Rally');

        // Filter by category "events"
        $response = $this->actingAs($this->admin)
            ->get(route('admin.gallery.index', ['category' => 'events']));

        $response->assertStatus(200);
        $response->assertSee('BJP Election Rally');
        $response->assertDontSee('Ward Visit under bridge');
    }

    /**
     * Test AJAX dynamic requests for infinite scrolling with active search parameter.
     */
    public function test_admin_can_filter_gallery_by_ajax()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.gallery.index', ['search' => 'Election']), [
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->assertStatus(200);
        $response->assertSee('BJP Election Rally');
        $response->assertDontSee('Ward Visit under bridge');
        $response->assertHeader('X-Next-Page');
    }
}
