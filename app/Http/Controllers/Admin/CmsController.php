<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\Setting;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::all()->keyBy('key');
        $heroImage = Setting::getValue('hero_image');
        return view('admin.cms.index', compact('pages', 'heroImage'));
    }

    public function update(Request $request, CmsPage $cms)
    {
        $validated = $request->validate([
            'content_en' => 'required|string',
            'content_gu' => 'nullable|string',
            'content_hi' => 'nullable|string',
        ]);

        $cms->update([
            'content_en' => $validated['content_en'],
            'content_gu' => $validated['content_gu'] ?? $validated['content_en'],
            'content_hi' => $validated['content_hi'] ?? $validated['content_en'],
        ]);

        return back()->with('success', "CMS key '{$cms->key}' updated successfully.");
    }

    public function updateSection(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|array',
            'content.*.content_en' => 'required|string',
            'content.*.content_gu' => 'nullable|string',
            'content.*.content_hi' => 'nullable|string',
        ]);

        foreach ($validated['content'] as $key => $translations) {
            $cms = CmsPage::where('key', $key)->first();
            if ($cms) {
                $cms->update([
                    'content_en' => $translations['content_en'],
                    'content_gu' => $translations['content_gu'] ?? $translations['content_en'],
                    'content_hi' => $translations['content_hi'] ?? $translations['content_en'],
                ]);
            }
        }

        return back()->with('success', 'CMS content section updated successfully.');
    }

    public function updateHero(Request $request)
    {
        // Explicitly catch if the uploaded file exceeds PHP's upload_max_filesize limit before Laravel validation
        if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === UPLOAD_ERR_INI_SIZE) {
            $maxPhpSize = ini_get('upload_max_filesize');
            \Illuminate\Support\Facades\Log::error(
                "WebP CMS hero_image upload failed due to PHP settings: " .
                "The uploaded file size exceeds upload_max_filesize (currently {$maxPhpSize}). " .
                "Resolution: Please restart your development server using: " .
                "php -d upload_max_filesize=20M -d post_max_size=25M artisan serve"
            );

            return back()->withErrors([
                'hero_image' => "The uploaded image exceeds the allowed system limit. Please upload a smaller image, or contact your system administrator to increase the upload limit."
            ]);
        }

        $request->validate([
            'hero_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ], [
            'hero_image.uploaded' => "The uploaded image exceeds the allowed system limit. Please upload a smaller image, or contact your system administrator to increase the upload limit.",
        ]);

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            try {
                $uploadPath = public_path('uploads/settings');
                $filename = 'hero_portrait_' . time();
                $webpName = \App\Helpers\ImageHelper::convertToWebP($file, $uploadPath, $filename);
                
                Setting::updateOrCreate(
                    ['key' => 'hero_image'],
                    ['value' => 'uploads/settings/' . $webpName]
                );
                
                return back()->with('success', 'Hero portrait image updated successfully.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP CMS hero_image upload failed: " . $e->getMessage());
                return back()->withErrors(['hero_image' => 'Failed to process and upload the hero image: ' . $e->getMessage()]);
            }
        }

        return back()->withErrors(['hero_image' => 'No image file uploaded.']);
    }
}
