<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::query();

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('complainant_name', 'like', "%{$search}%")
                  ->orWhere('complainant_mobile', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('official_action', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            if (in_array($status, ['pending', 'under_review', 'resolved', 'rejected'])) {
                $query->where('status', $status);
            }
        }

        // Category filter
        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();

        return view('admin.complaint.index', compact('complaints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'complainant_name' => 'required|string|max:255',
            'complainant_mobile' => 'required|string|max:20',
            'area' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'complainant_name' => $validated['complainant_name'],
            'complainant_mobile' => $validated['complainant_mobile'],
            'area' => $validated['area'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'status' => 'pending',
        ];

        if ($request->hasFile('attachment')) {
            $uploadPath = public_path('uploads/complaints');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('attachment');
            try {
                $filename = time() . '_complaint_' . Str::random(8);
                $webpName = ImageHelper::convertToWebP($file, $uploadPath, $filename);
                $data['attachment_path'] = 'uploads/complaints/' . $webpName;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP complaint attachment upload failed: " . $e->getMessage());
            }
        }

        Complaint::create($data);

        return back()->with('success', 'Complaint logged successfully.');
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,resolved,rejected',
            'official_action' => 'nullable|string',
        ]);

        $complaint->update($validated);

        return back()->with('success', 'Complaint status and resolution details updated.');
    }

    public function destroy(Complaint $complaint)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($complaint->attachment_path && file_exists(public_path($complaint->attachment_path))) {
            @unlink(public_path($complaint->attachment_path));
        }

        $complaint->delete();

        return back()->with('success', 'Complaint record deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Complaint::query();

        // Apply filters
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('complainant_name', 'like', "%{$search}%")
                  ->orWhere('complainant_mobile', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        $complaints = $query->latest()->get();

        $headers = [
            'ID', 'Complainant Name', 'Complainant Mobile', 'Ward Area', 'Category', 'Description', 'Status', 'Official Action Taken', 'Attachment Link', 'Created At'
        ];

        $rows = [];
        foreach ($complaints as $complaint) {
            $rows[] = [
                $complaint->id,
                $complaint->complainant_name,
                $complaint->complainant_mobile,
                $complaint->area,
                $complaint->category,
                $complaint->description,
                ucfirst(str_replace('_', ' ', $complaint->status)),
                $complaint->official_action ?? 'None',
                $complaint->attachment_path ? url($complaint->attachment_path) : 'None',
                $complaint->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return \App\Helpers\ExcelExportHelper::exportToXlsx('complaints_export', $headers, $rows, 'Complaints');
    }
}
