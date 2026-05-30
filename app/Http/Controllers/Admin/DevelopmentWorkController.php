<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentWork;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class DevelopmentWorkController extends Controller
{
    public function index(Request $request)
    {
        $query = DevelopmentWork::latest();

        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', $search)
                  ->orWhere('title_gu', 'like', $search)
                  ->orWhere('title_hi', 'like', $search)
                  ->orWhere('description_en', 'like', $search)
                  ->orWhere('description_gu', 'like', $search)
                  ->orWhere('description_hi', 'like', $search)
                  ->orWhere('location', 'like', $search);
            });
        }

        $works = $query->paginate(10)->withQueryString();

        return view('admin.development.index', compact('works'));
    }

    public function create()
    {
        return redirect()->route('admin.development.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en'      => 'required|string|max:255',
            'title_gu'      => 'nullable|string|max:255',
            'title_hi'      => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_gu' => 'nullable|string',
            'description_hi' => 'nullable|string',
            'location'      => 'required|string|max:255',
            'before_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'after_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'title_en'       => $validated['title_en'],
            'title_gu'       => $validated['title_gu'] ?? $validated['title_en'],
            'title_hi'       => $validated['title_hi'] ?? $validated['title_en'],
            'description_en' => $validated['description_en'],
            'description_gu' => $validated['description_gu'] ?? $validated['description_en'],
            'description_hi' => $validated['description_hi'] ?? $validated['description_en'],
            'location'       => $validated['location'],
        ];

        $uploadPath = public_path('uploads/development');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('before_image')) {
            $file = $request->file('before_image');
            try {
                $filename = time() . '_before_' . Str::random(8);
                $webpName = ImageHelper::convertToWebP($file, $uploadPath, $filename);
                $data['before_image'] = 'uploads/development/' . $webpName;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP before_image upload failed: " . $e->getMessage());
            }
        }

        if ($request->hasFile('after_image')) {
            $file = $request->file('after_image');
            try {
                $filename = time() . '_after_' . Str::random(8);
                $webpName = ImageHelper::convertToWebP($file, $uploadPath, $filename);
                $data['after_image'] = 'uploads/development/' . $webpName;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP after_image upload failed: " . $e->getMessage());
            }
        }

        DevelopmentWork::create($data);

        return redirect()->route('admin.development.index')->with('success', 'Development project added successfully.');
    }

    public function edit(DevelopmentWork $development)
    {
        return redirect()->route('admin.development.index');
    }

    public function update(Request $request, DevelopmentWork $development)
    {
        $validated = $request->validate([
            'title_en'       => 'required|string|max:255',
            'title_gu'       => 'nullable|string|max:255',
            'title_hi'       => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_gu' => 'nullable|string',
            'description_hi' => 'nullable|string',
            'location'       => 'required|string|max:255',
            'before_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'after_image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'title_en'       => $validated['title_en'],
            'title_gu'       => $validated['title_gu'] ?? $validated['title_en'],
            'title_hi'       => $validated['title_hi'] ?? $validated['title_en'],
            'description_en' => $validated['description_en'],
            'description_gu' => $validated['description_gu'] ?? $validated['description_en'],
            'description_hi' => $validated['description_hi'] ?? $validated['description_en'],
            'location'       => $validated['location'],
        ];

        $uploadPath = public_path('uploads/development');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('before_image')) {
            $file = $request->file('before_image');
            try {
                $filename = time() . '_before_' . Str::random(8);
                $webpName = ImageHelper::convertToWebP($file, $uploadPath, $filename);

                if ($development->before_image && file_exists(public_path($development->before_image))) {
                    @unlink(public_path($development->before_image));
                }
                $data['before_image'] = 'uploads/development/' . $webpName;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP before_image update failed: " . $e->getMessage());
            }
        }

        if ($request->hasFile('after_image')) {
            $file = $request->file('after_image');
            try {
                $filename = time() . '_after_' . Str::random(8);
                $webpName = ImageHelper::convertToWebP($file, $uploadPath, $filename);

                if ($development->after_image && file_exists(public_path($development->after_image))) {
                    @unlink(public_path($development->after_image));
                }
                $data['after_image'] = 'uploads/development/' . $webpName;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP after_image update failed: " . $e->getMessage());
            }
        }

        $development->update($data);

        return redirect()->route('admin.development.index')->with('success', 'Development project updated successfully.');
    }

    public function destroy(DevelopmentWork $development)
    {
        if ($development->before_image && file_exists(public_path($development->before_image))) {
            @unlink(public_path($development->before_image));
        }
        if ($development->after_image && file_exists(public_path($development->after_image))) {
            @unlink(public_path($development->after_image));
        }

        $development->delete();

        return redirect()->route('admin.development.index')->with('success', 'Development project deleted successfully.');
    }

    public function export(Request $request)
    {
        $works = DevelopmentWork::latest()->get();

        $headers = [
            'ID', 'Location', 'English Title', 'Gujarati Title', 'Hindi Title', 
            'English Description', 'Gujarati Description', 'Hindi Description', 
            'Before Image', 'After Image', 'Created At'
        ];

        $rows = [];
        foreach ($works as $work) {
            $rows[] = [
                $work->id,
                $work->location,
                $work->title_en,
                $work->title_gu,
                $work->title_hi,
                $work->description_en,
                $work->description_gu,
                $work->description_hi,
                $work->before_image ? url($work->before_image) : 'None',
                $work->after_image ? url($work->after_image) : 'None',
                $work->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return \App\Helpers\ExcelExportHelper::exportToXlsx('development_works_export', $headers, $rows, 'Development Works');
    }
}
