<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CmsPage;
use App\Models\DevelopmentWork;
use App\Models\Feedback;
use App\Models\GalleryImage;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch CMS content (Cached forever, invalidated instantly on admin update)
        $cmsPages = \Illuminate\Support\Facades\Cache::rememberForever('site_cms_pages', function() {
            return CmsPage::all()->keyBy('key')->toArray();
        });

        // Resolve active locale at runtime to populate correct translation
        $locale = app()->getLocale();
        $cms = [];
        foreach ($cmsPages as $key => $translations) {
            $cms[$key] = $translations["content_{$locale}"] ?? $translations["content_gu"] ?? $translations["content_en"] ?? '';
        }


        // Fetch settings (Cached forever, invalidated instantly on admin update)
        $settings = \Illuminate\Support\Facades\Cache::rememberForever('site_settings', function() {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        // Fetch development works
        $developmentWorks = DevelopmentWork::latest()->get();

        // Fetch approved & featured feedbacks for the carousel
        $feedbacks = Feedback::with('images')
            ->where('status', 'approved')
            ->where('is_featured', true)
            ->latest()
            ->get();

        // Fetch gallery images
        $galleryImages = GalleryImage::latest()->get();

        return view('landing', compact('cms', 'settings', 'developmentWorks', 'feedbacks', 'galleryImages'));
    }
}
