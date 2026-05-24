<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Feedback;
use App\Models\FeedbackImage;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'area' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $feedback = Feedback::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.form.success'),
            ]);
        }

        return back()->with('success', __('messages.form.success'));
    }

    public function createDetailed(Request $request)
    {
        $approvedFeedbacks = Feedback::with('images')
            ->where('status', 'approved')
            ->latest()
            ->paginate(6);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.feedback-list-container', compact('approvedFeedbacks'))->render(),
            ]);
        }

        return view('detailed-feedback', compact('approvedFeedbacks'));
    }

    public function storeDetailed(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'area' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'camera_photo' => 'nullable|string',
        ]);

        $feedback = Feedback::create([
            'name' => $validated['name'],
            'mobile_number' => $validated['mobile_number'],
            'area' => $validated['area'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'rating' => $validated['rating'],
            'status' => 'pending',
            'is_featured' => false,
        ]);

        $uploadPath = public_path('uploads/feedbacks');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Handle uploaded files
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                try {
                    $filename = time() . '_' . Str::random(10);
                    $webpName = ImageHelper::convertToWebP($photo, $uploadPath, $filename);

                    FeedbackImage::create([
                        'feedback_id' => $feedback->id,
                        'image_path' => 'uploads/feedbacks/' . $webpName,
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("WebP upload failed: " . $e->getMessage());
                }
            }
        }

        // Handle camera photo (Base64 data URL)
        if (!empty($validated['camera_photo'])) {
            try {
                $filename = time() . '_camera_' . Str::random(10);
                $webpName = ImageHelper::base64ToWebP($validated['camera_photo'], $uploadPath, $filename);

                FeedbackImage::create([
                    'feedback_id' => $feedback->id,
                    'image_path' => 'uploads/feedbacks/' . $webpName,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP camera snapshot conversion failed: " . $e->getMessage());
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.form.success'),
            ]);
        }

        return redirect()->route('feedback.detailed')->with('success', __('messages.form.success'));
    }
}
