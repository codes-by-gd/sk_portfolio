@extends('layouts.admin')

@section('title', 'Project Timelines - Admin Portal')

@section('content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">Project Timelines</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Monitor standalone municipal project schedules, budgets, and milestone progress</p>
    </div>
    <div class="flex items-center gap-2">
        <button type="button" onclick="openExportModal()" class="btn btn-ghost border border-base-300 hover:bg-base-200 rounded-xl gap-1.5 text-sm font-semibold">
            <i class="fa-solid fa-file-excel text-success"></i> Export XLSX
        </button>
        <a href="{{ route('admin.timeline.create') }}" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
            <i class="fa-solid fa-plus text-base"></i> Create Project
        </a>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif

{{-- Filters Row --}}
<div class="bg-base-100 card-base border border-base-300 rounded-2xl p-3.5 shadow-sm flex items-center">
    <form action="{{ route('admin.timeline.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 w-full items-center">
        <div class="relative w-full sm:flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by project name, location or phase..."
                class="input input-sm input-bordered w-full pl-8 rounded-xl bg-transparent border-base-300 focus:outline-none focus:border-primary text-xs text-base-content" />
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-xs"></i>
        </div>
        <select name="status" class="select select-sm select-bordered rounded-xl bg-base-100 border-base-300 focus:outline-none focus:border-primary text-xs text-base-content w-full sm:w-[145px] shrink-0">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Planning</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="delayed" {{ request('status') === 'delayed' ? 'selected' : '' }}>Delayed</option>
        </select>
        <div class="flex gap-1.5 w-full sm:w-auto shrink-0">
            <button type="submit" class="btn btn-sm btn-secondary text-white font-bold rounded-xl px-4 text-xs w-full sm:w-auto">Filter</button>
            @if(request()->anyFilled(['search','status']))
                <a href="{{ route('admin.timeline.index') }}" class="btn btn-sm btn-ghost border border-base-300 hover:bg-base-200 rounded-xl px-3 text-xs w-full sm:w-auto flex items-center justify-center">Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- Timelines Table --}}
<div class="bg-base-100 card-base border border-base-300 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="table table-md w-full text-left">
            <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-base-content/70 border-b border-base-300">
                <tr>
                    <th class="py-4">Project</th>
                    <th class="py-4">Budget</th>
                    <th class="py-4">Progress</th>
                    <th class="py-4">Current Phase</th>
                    <th class="py-4">Status</th>
                    <th class="py-4">Dates</th>
                    <th class="py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-300 text-sm text-base-content">
                @forelse($timelines as $timeline)
                    <tr class="hover:bg-base-200/50 transition-colors">
                        <td class="py-4 min-w-[180px]">
                            <p class="font-bold text-base-content leading-tight">{{ $timeline->project_name }}</p>
                            <p class="text-xs text-secondary font-extrabold mt-1"><i class="fa-solid fa-location-dot mr-1 opacity-60"></i>{{ $timeline->location }}</p>
                        </td>
                        <td class="py-4 font-semibold text-xs">
                            {{ $timeline->budget ? '₹ ' . number_format($timeline->budget, 2) : '—' }}
                        </td>
                        <td class="py-4 min-w-[130px]">
                            <div class="flex justify-between text-[10px] font-bold mb-1">
                                <span class="opacity-60">{{ $timeline->milestones_count }} steps</span>
                                <span class="text-primary">{{ $timeline->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-base-300 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-primary h-full rounded-full" style="width: {{ $timeline->progress_percent }}%"></div>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="badge badge-outline badge-sm font-semibold text-xs">{{ $timeline->current_phase }}</span>
                        </td>
                        <td class="py-4">
                            @if($timeline->status === 'pending')
                                <span class="badge badge-ghost badge-sm font-bold text-[9px] uppercase">Planning</span>
                            @elseif($timeline->status === 'active')
                                <span class="badge badge-info badge-sm font-bold text-[9px] uppercase">Active</span>
                            @elseif($timeline->status === 'completed')
                                <span class="badge badge-success badge-sm font-bold text-[9px] uppercase">Completed</span>
                            @else
                                <span class="badge badge-error badge-sm font-bold text-[9px] uppercase">Delayed</span>
                            @endif
                        </td>
                        <td class="py-4">
                            <div class="flex flex-col text-[11px] font-semibold opacity-70">
                                <span>Start: {{ $timeline->start_date ?: 'TBD' }}</span>
                                <span class="mt-0.5">End: {{ $timeline->target_completion ?: 'TBD' }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            <div class="flex gap-1.5 justify-center">
                                <a href="{{ route('admin.timeline.show', $timeline) }}"
                                   class="btn btn-sm btn-square btn-soft btn-success tooltip tooltip-top"
                                   data-tip="Manage Milestones">
                                    <i class="fa-solid fa-list-check text-xs"></i>
                                </a>
                                <a href="{{ route('admin.timeline.edit', $timeline) }}"
                                   class="btn btn-sm btn-square btn-soft btn-info tooltip tooltip-top"
                                   data-tip="Edit Project">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                                @can('super-admin')
                                    <form action="{{ route('admin.timeline.destroy', $timeline) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this project and all its milestones?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Delete Project">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-base-content/50 font-medium italic">
                            No timeline projects found. <a href="{{ route('admin.timeline.create') }}" class="text-primary underline font-bold">Create your first project</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($timelines->hasPages())
        <div class="p-4 border-t border-base-300 flex justify-center">
            {{ $timelines->links() }}
        </div>
    @endif
</div>

{{-- ========== EXPORT MODAL ========== --}}
<dialog id="export-timeline-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-sm p-6 relative">
        <button type="button" onclick="closeExportModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <!-- ESC shortcut label -->
        <div class="absolute right-14 top-5 text-[9px] opacity-40 font-bold hidden sm:block">
            <kbd class="kbd kbd-sm bg-base-200">ESC</kbd>
        </div>

        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-file-excel text-success"></i> Export Timelines to XLSX
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Select filters for your report (leave blank to export all)</p>
        <form action="{{ route('admin.timeline.export') }}" method="GET" onsubmit="closeExportModal()" class="space-y-4">
            <div class="form-control">
                <label class="floating-label w-full block relative">
                    <select name="status" class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                        <option value="all">All Statuses</option>
                        <option value="pending">Planning</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="delayed">Delayed</option>
                    </select>
                    <span>Status Filter</span>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </label>
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeExportModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md">
                    <i class="fa-solid fa-download mr-1"></i> Download XLSX
                </button>
            </div>
        </form>
    </div>
    <!-- Backdrop to close natively on click -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.openExportModal = function () {
        document.getElementById('export-timeline-modal').showModal();
    };
    window.closeExportModal = function () {
        document.getElementById('export-timeline-modal').close();
    };
});
</script>
@endsection
