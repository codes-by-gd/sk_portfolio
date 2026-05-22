<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryImage::latest();

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $images = $query->paginate(12)->withQueryString();

        return view('admin.gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'category'    => 'required|string|in:visits,events,works,community',
            'caption_en'  => 'nullable|string|max:255',
            'caption_gu'  => 'nullable|string|max:255',
            'caption_hi'  => 'nullable|string|max:255',
        ]);

        $uploadPath = public_path('uploads/gallery');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $file     = $request->file('image');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        GalleryImage::create([
            'image_path'  => 'uploads/gallery/' . $filename,
            'category'    => $validated['category'],
            'caption_en'  => $validated['caption_en'] ?? '',
            'caption_gu'  => $validated['caption_gu'] ?? '',
            'caption_hi'  => $validated['caption_hi'] ?? '',
        ]);

        return back()->with('success', 'Gallery image uploaded successfully.');
    }

    public function destroy(GalleryImage $gallery)
    {
        // Remove physical file if exists
        if ($gallery->image_path && file_exists(public_path($gallery->image_path))) {
            @unlink(public_path($gallery->image_path));
        }

        $gallery->delete();

        return back()->with('success', 'Gallery image deleted successfully.');
    }
}
