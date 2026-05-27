<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DevelopmentWork;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DevelopmentWorkDialogTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected DevelopmentWork $project;

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

        // Create a mock development project
        $this->project = DevelopmentWork::create([
            'title_en' => 'Water Pipeline Repair',
            'title_gu' => 'પાણીની પાઇપલાઇન સમારકામ',
            'title_hi' => 'पानी की पाइपलाइन मरम्मत',
            'description_en' => 'Fixed pipeline issues in sector 4.',
            'description_gu' => 'સેક્ટર 4 માં પાઇપલાઇન સમસ્યાઓ સુધારી.',
            'description_hi' => 'सेक्टर 4 में पाइपलाइन समस्याओं को ठीक किया।',
            'location' => 'Sector 4, Ward 7',
        ]);
    }

    /**
     * Test admin can access development works index.
     */
    public function test_admin_can_access_development_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.development.index'));

        $response->assertStatus(200);
        $response->assertSee('Development Works');
        $response->assertSee('Water Pipeline Repair');
        $response->assertSee('Sector 4, Ward 7');
    }

    /**
     * Test create and edit endpoints redirect to index (unified dialog workflow).
     */
    public function test_create_and_edit_endpoints_redirect_to_index()
    {
        // GET create
        $response = $this->actingAs($this->admin)
            ->get(route('admin.development.create'));
        $response->assertRedirect(route('admin.development.index'));

        // GET edit
        $response = $this->actingAs($this->admin)
            ->get(route('admin.development.edit', $this->project));
        $response->assertRedirect(route('admin.development.index'));
    }

    /**
     * Test admin can store a new project via dialog submit.
     */
    public function test_admin_can_store_development_project()
    {
        // Mock fake images
        $before = UploadedFile::fake()->image('before.jpg', 100, 100);
        $after = UploadedFile::fake()->image('after.png', 100, 100);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.development.store'), [
                'title_en' => 'New Road Construction',
                'title_gu' => 'નવો રોડ બાંધકામ',
                'title_hi' => 'नया सड़क निर्माण',
                'description_en' => 'Paved 3km long internal streets.',
                'description_gu' => '3 કિમી લાંબી આંતરિક ગલીઓ બનાવી.',
                'description_hi' => '3 किमी लंबी आंतरिक सड़कों का निर्माण किया।',
                'location' => 'Ward 7 South Side',
                'before_image' => $before,
                'after_image' => $after,
            ]);

        $response->assertRedirect(route('admin.development.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');

        // Assert database insertion
        $this->assertDatabaseHas('development_works', [
            'title_en' => 'New Road Construction',
            'location' => 'Ward 7 South Side',
        ]);

        $newProject = DevelopmentWork::where('title_en', 'New Road Construction')->first();
        $this->assertNotNull($newProject);
        $this->assertNotNull($newProject->before_image);
        $this->assertNotNull($newProject->after_image);

        // Delete test created files from local uploads folder
        if (file_exists(public_path($newProject->before_image))) {
            @unlink(public_path($newProject->before_image));
        }
        if (file_exists(public_path($newProject->after_image))) {
            @unlink(public_path($newProject->after_image));
        }
    }

    /**
     * Test admin can update a development project.
     */
    public function test_admin_can_update_development_project()
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.development.update', $this->project), [
                'title_en' => 'Updated Water Pipeline',
                'title_gu' => 'પાણીની પાઇપલાઇન અપડેટ',
                'title_hi' => 'पानी की पाइपलाइन अपडेट',
                'description_en' => 'Updated description.',
                'location' => 'Sector 4 Area',
            ]);

        $response->assertRedirect(route('admin.development.index'));
        $response->assertSessionHasNoErrors();

        $this->project->refresh();
        $this->assertEquals('Updated Water Pipeline', $this->project->title_en);
        $this->assertEquals('Sector 4 Area', $this->project->location);
    }

    /**
     * Test admin can delete a development project.
     */
    public function test_admin_can_delete_development_project()
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('admin.development.destroy', $this->project));

        $response->assertRedirect(route('admin.development.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('development_works', [
            'id' => $this->project->id,
        ]);
    }
}
