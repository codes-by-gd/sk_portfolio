<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectTimeline;
use App\Models\ProjectMilestone;
use Illuminate\Http\Request;

class ProjectTimelineController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectTimeline::withCount('milestones');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('current_phase', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if (in_array($status, ['pending', 'active', 'completed', 'delayed'])) {
                $query->where('status', $status);
            }
        }

        $timelines = $query->latest()->paginate(10)->withQueryString();

        return view('admin.timeline.index', compact('timelines'));
    }

    public function create()
    {
        return view('admin.timeline.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'target_completion' => 'nullable|date',
            'current_phase' => 'required|string|max:255',
            'status' => 'required|in:pending,active,completed,delayed',
            'notes' => 'nullable|string',
        ]);

        ProjectTimeline::create($validated);

        return redirect()->route('admin.timeline.index')->with('success', 'Project timeline created successfully.');
    }

    public function show(ProjectTimeline $timeline)
    {
        $timeline->load('milestones');
        return view('admin.timeline.show', compact('timeline'));
    }

    public function edit(ProjectTimeline $timeline)
    {
        return view('admin.timeline.edit', compact('timeline'));
    }

    public function update(Request $request, ProjectTimeline $timeline)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'target_completion' => 'nullable|date',
            'current_phase' => 'required|string|max:255',
            'status' => 'required|in:pending,active,completed,delayed',
            'notes' => 'nullable|string',
        ]);

        $timeline->update($validated);

        return redirect()->route('admin.timeline.index')->with('success', 'Project timeline updated successfully.');
    }

    public function destroy(ProjectTimeline $timeline)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $timeline->delete();

        return redirect()->route('admin.timeline.index')->with('success', 'Project timeline deleted successfully.');
    }

    // Milestones Management Handlers
    public function storeMilestone(Request $request, ProjectTimeline $timeline)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
            'milestone_date' => 'nullable|date',
        ]);

        $timeline->milestones()->create($validated);

        return back()->with('success', 'Milestone milestone added successfully.');
    }

    public function updateMilestone(Request $request, ProjectMilestone $milestone)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
            'milestone_date' => 'nullable|date',
        ]);

        $milestone->update($validated);

        return back()->with('success', 'Milestone updated successfully.');
    }

    public function destroyMilestone(ProjectMilestone $milestone)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $milestone->delete();

        return back()->with('success', 'Milestone deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = ProjectTimeline::withCount('milestones');

        if ($status = $request->input('status')) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        $timelines = $query->latest()->get();

        $headers = [
            'ID', 'Project Name', 'Location', 'Budget (INR)', 'Start Date', 'Target Completion', 'Current Phase', 'Status', 'Milestones Count', 'Progress (%)', 'Notes', 'Created At'
        ];

        $rows = [];
        foreach ($timelines as $timeline) {
            $rows[] = [
                $timeline->id,
                $timeline->project_name,
                $timeline->location,
                $timeline->budget ? number_format($timeline->budget, 2) : 'None',
                $timeline->start_date ?? 'None',
                $timeline->target_completion ?? 'None',
                $timeline->current_phase,
                ucfirst($timeline->status),
                $timeline->milestones_count,
                $timeline->progress_percent . '%',
                $timeline->notes ?? 'None',
                $timeline->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return \App\Helpers\ExcelExportHelper::exportToXlsx('project_timelines_export', $headers, $rows, 'Project Timelines');
    }
}
