<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Feedback;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with('images');

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('area', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            if (in_array($status, ['pending', 'approved', 'rejected'])) {
                $query->where('status', $status);
            }
        }

        $feedbacks = $query->latest()->paginate(10)->withQueryString();

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

        return view('admin.dashboard', compact('feedbacks', 'counts'));
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

    public function updateAvatar(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $uploadPath = public_path('uploads/avatars');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $file = $request->file('avatar');
        $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        // Delete old avatar if exists
        if ($feedback->avatar_path && file_exists(public_path($feedback->avatar_path))) {
            @unlink(public_path($feedback->avatar_path));
        }

        $feedback->update([
            'avatar_path' => 'uploads/avatars/' . $filename,
        ]);

        return back()->with('success', 'Citizen avatar updated successfully.');
    }

    public function export()
    {
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility with Gujarati/Hindi characters
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($handle, [
                'ID', 'Name', 'Mobile Number', 'Area', 'Title', 'Message', 'Rating', 'Status', 'Is Featured', 'Submitted At'
            ]);

            // Data
            Feedback::where('status', 'approved')
                ->oldest()
                ->chunk(100, function($feedbacks) use ($handle) {
                    foreach ($feedbacks as $feedback) {
                        fputcsv($handle, [
                            $feedback->id,
                            $feedback->name,
                            $feedback->mobile_number,
                            $feedback->area,
                            $feedback->title,
                            $feedback->message,
                            $feedback->rating,
                            $feedback->status,
                            $feedback->is_featured ? 'Yes' : 'No',
                            $feedback->created_at->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="approved_feedbacks_' . date('Y-m-d') . '.csv"',
        ]);

        return $response;
    }
}
