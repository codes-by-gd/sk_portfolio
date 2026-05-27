<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Feedback;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Helpers\ImageHelper;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query();

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('area', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            if (in_array($status, ['pending', 'approved', 'rejected'])) {
                $query->where('status', $status);
            }
        }

        $feedbacks = $query->latest()->paginate(5)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.partials.feedback-table', compact('feedbacks'))->render(),
            ]);
        }

        // Calculate counts
        $counts = [
            'total' => Feedback::count(),
            'pending' => Feedback::where('status', 'pending')->count(),
            'approved' => Feedback::where('status', 'approved')->count(),
            'rejected' => Feedback::where('status', 'rejected')->count(),
        ];

        return view('admin.feedback', compact('feedbacks', 'counts'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'area' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $feedback->update($validated);

        return back()->with('success', 'Feedback updated successfully.');
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $feedback->update(['status' => $validated['status']]);

        return back()->with('success', 'Feedback status updated successfully.');
    }

    public function toggleFeatured(Feedback $feedback)
    {
        $feedback->update(['is_featured' => !$feedback->is_featured]);

        return back()->with('success', 'Feedback featured status toggled.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return back()->with('success', 'Feedback deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Feedback::query();

        // Filter 1: Status
        if ($request->filled('status')) {
            if ($request->input('status') !== 'all') {
                $query->where('status', $request->input('status'));
            }
        } else {
            // Default to approved to keep continuity with previous baseline
            $query->where('status', 'approved');
        }

        // Filter 2: Rating Stars
        $query->when($request->filled('rating'), function($q) use ($request) {
            $q->where('rating', $request->input('rating'));
        });

        // Filter 3: Date Range
        $query->when($request->filled('start_date'), function($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->input('start_date'));
        });
        $query->when($request->filled('end_date'), function($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->input('end_date'));
        });

        $feedbacks = $query->oldest()->get();

        $headers = [
            'ID', 'Name', 'Mobile Number', 'Area', 'Message', 'Rating', 'Status', 'Is Featured', 'Submitted At'
        ];

        $rows = [];
        foreach ($feedbacks as $feedback) {
            $rows[] = [
                $feedback->id,
                $feedback->name,
                $feedback->mobile_number,
                $feedback->area,
                $feedback->message,
                $feedback->rating,
                ucfirst($feedback->status),
                $feedback->is_featured ? 'Yes' : 'No',
                $feedback->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return \App\Helpers\ExcelExportHelper::exportToXlsx('feedbacks_export', $headers, $rows, 'Feedbacks');
    }
}
