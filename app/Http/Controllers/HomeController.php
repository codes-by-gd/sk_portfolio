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
        // Determine active locale for locale-aware caching
        $locale = app()->getLocale();

        // Fetch CMS content — cached PER LOCALE so language switching always
        // returns the correct translated content. Cache is invalidated by
        // CmsController::update/updateSection which clears all locale variants.
        $cms = \Illuminate\Support\Facades\Cache::rememberForever('site_cms_pages_' . $locale, function() {
            return CmsPage::all()->pluck('content', 'key')->toArray();
        });

        // Fetch settings (single-language, cached forever, invalidated on admin update)
        $settings = \Illuminate\Support\Facades\Cache::rememberForever('site_settings', function() {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        // Fetch development works — NOT cached; model accessors (getTitleAttribute,
        // getDescriptionAttribute) resolve locale dynamically at render time.
        $developmentWorks = DevelopmentWork::latest()->get();

        // Fetch approved & featured feedbacks for the carousel
        $feedbacks = Feedback::where('status', 'approved')
            ->where('is_featured', true)
            ->latest()
            ->get();

        // Fetch gallery images — NOT cached; getCaptionAttribute resolves locale
        // dynamically at render time.
        $galleryImages = GalleryImage::latest()->get();

        return view('landing', compact('cms', 'settings', 'developmentWorks', 'feedbacks', 'galleryImages'));
    }
}
