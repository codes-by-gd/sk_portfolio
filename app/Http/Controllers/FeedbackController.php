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
        $approvedFeedbacks = Feedback::where('status', 'approved')
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
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Feedback::create([
            'name' => $validated['name'],
            'mobile_number' => $validated['mobile_number'],
            'area' => $validated['area'],
            'message' => $validated['message'],
            'rating' => $validated['rating'],
            'status' => 'pending',
            'is_featured' => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.form.success'),
            ]);
        }

        return redirect()->route('feedback.detailed')->with('success', __('messages.form.success'));
    }
}
