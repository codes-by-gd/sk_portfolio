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
        // Fetch CMS content
        $cms = CmsPage::all()->pluck('content', 'key');

        // Fetch settings
        $settings = Setting::all()->pluck('value', 'key');

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
