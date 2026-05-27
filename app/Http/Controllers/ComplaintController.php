<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    /**
     * Show the public Citizen Grievance Portal form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('grievance');
    }

    /**
     * Store a newly created citizen grievance in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'complainant_name' => 'required|string|max:255',
            'complainant_mobile' => 'required|string|regex:/^[0-9]{10}$/',
            'area' => 'required|string|max:255',
            'category' => 'required|in:water,sanitation,road,electricity,street_light,other',
            'description' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'camera_photo' => 'nullable|string',
        ]);

        $data = [
            'complainant_name' => $validated['complainant_name'],
            'complainant_mobile' => $validated['complainant_mobile'],
            'area' => $validated['area'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'status' => 'pending',
        ];

        // Ensure complaints upload directory exists
        $uploadPath = public_path('uploads/complaints');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Handle File Attachment Upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            try {
                $filename = time() . '_complaint_' . Str::random(8);
                $webpName = ImageHelper::convertToWebP($file, $uploadPath, $filename);
                $data['attachment_path'] = 'uploads/complaints/' . $webpName;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP public complaint file upload failed: " . $e->getMessage());
            }
        } 
        // Handle Live Camera base64 Upload (if file is not uploaded)
        elseif (!empty($validated['camera_photo'])) {
            try {
                $filename = time() . '_complaint_cam_' . Str::random(8);
                $webpName = ImageHelper::base64ToWebP($validated['camera_photo'], $uploadPath, $filename);
                $data['attachment_path'] = 'uploads/complaints/' . $webpName;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("WebP public complaint camera upload failed: " . $e->getMessage());
            }
        }

        $complaint = Complaint::create($data);

        // Render response according to request type
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.grievance.success_desc', ['id' => $complaint->complaint_number]),
                'id' => $complaint->id,
                'complaint_number' => $complaint->complaint_number,
            ]);
        }

        return redirect()->back()->with('success', __('messages.grievance.success_desc', ['id' => $complaint->complaint_number]));
    }

    /**
     * Track a citizen grievance status dynamically.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function track(Request $request)
    {
        $number = trim($request->input('number'));

        if (empty($number)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid complaint number.',
            ], 400);
        }

        $complaint = Complaint::with(['logs' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->where('complaint_number', $number)->first();

        if (!$complaint) {
            return response()->json([
                'success' => false,
                'message' => 'No grievance records found matching this tracking number.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'complaint' => [
                'complaint_number' => $complaint->complaint_number,
                'complainant_name' => $complaint->complainant_name,
                'area' => $complaint->area,
                'category' => ucfirst(str_replace('_', ' ', $complaint->category)),
                'status' => $complaint->status,
                'status_label' => ucfirst(str_replace('_', ' ', $complaint->status)),
                'created_at' => $complaint->created_at->format('d M Y h:i A'),
            ],
            'logs' => $complaint->logs->map(function ($log) {
                return [
                    'status' => $log->status,
                    'status_label' => ucfirst(str_replace('_', ' ', $log->status)),
                    'message' => $log->message,
                    'timestamp' => $log->created_at->format('d M Y h:i A'),
                ];
            }),
        ]);
    }
}
