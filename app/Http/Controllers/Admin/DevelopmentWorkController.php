<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentWork;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DevelopmentWorkController extends Controller
{
    public function index()
    {
        $works = DevelopmentWork::latest()->paginate(10);
        return view('admin.development.index', compact('works'));
    }

    public function create()
    {
        return view('admin.development.create');
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
            $filename = time() . '_before_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['before_image'] = 'uploads/development/' . $filename;
        }

        if ($request->hasFile('after_image')) {
            $file = $request->file('after_image');
            $filename = time() . '_after_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['after_image'] = 'uploads/development/' . $filename;
        }

        DevelopmentWork::create($data);

        return redirect()->route('admin.development.index')->with('success', 'Development project added successfully.');
    }

    public function edit(DevelopmentWork $development)
    {
        return view('admin.development.edit', compact('development'));
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
            if ($development->before_image && file_exists(public_path($development->before_image))) {
                @unlink(public_path($development->before_image));
            }
            $file = $request->file('before_image');
            $filename = time() . '_before_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['before_image'] = 'uploads/development/' . $filename;
        }

        if ($request->hasFile('after_image')) {
            if ($development->after_image && file_exists(public_path($development->after_image))) {
                @unlink(public_path($development->after_image));
            }
            $file = $request->file('after_image');
            $filename = time() . '_after_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['after_image'] = 'uploads/development/' . $filename;
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

        return back()->with('success', 'Development project deleted successfully.');
    }
}
