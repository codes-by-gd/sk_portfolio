@extends('layouts.admin')

@section('title', 'Project Milestones - Admin Portal')

@section('content')
{{-- Back + Header --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.timeline.index') }}" class="btn btn-sm btn-ghost gap-1.5 text-base-content/70 hover:text-primary rounded-lg">
            <i class="fa-solid fa-arrow-left-long"></i> Back to Timelines
        </a>
        <div>
            <h1 class="font-heading font-extrabold text-2xl text-base-content">{{ $timeline->project_name }}</h1>
            <p class="text-xs text-secondary font-extrabold mt-0.5"><i class="fa-solid fa-location-dot mr-1 opacity-60"></i>{{ $timeline->location }}</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.timeline.edit', $timeline) }}" class="btn btn-sm btn-ghost border border-base-300 hover:bg-base-200 rounded-xl gap-1.5 text-xs font-semibold">
            <i class="fa-solid fa-pen-to-square"></i> Edit Project
        </a>
        <button type="button" onclick="openAddMilestoneModal()" class="btn btn-sm btn-primary text-white font-bold rounded-xl gap-1.5 shadow-md">
            <i class="fa-solid fa-plus"></i> Add Milestone
        </button>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-error shadow-sm rounded-xl text-white">
        <ul class="text-xs list-disc pl-4 font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Two Column Split --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

    {{-- Left: Project Details Card --}}
    <div class="card-base rounded-2xl p-5 space-y-4">
        <h2 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-2 flex items-center gap-2">
            <i class="fa-solid fa-circle-info text-primary"></i> Project Details
        </h2>

        {{-- Progress Ring Area --}}
        <div class="flex flex-col items-center bg-base-200/50 py-5 rounded-2xl border border-base-300">
            <div class="radial-progress text-primary font-extrabold font-heading text-xl"
                 style="--value:{{ $timeline->progress_percent }}; --size:5.5rem; --thickness:0.55rem;" role="progressbar">
                {{ $timeline->progress_percent }}%
            </div>
            <span class="text-[10px] font-extrabold text-base-content/50 uppercase tracking-widest mt-3">Milestone Progress</span>
        </div>

        <div class="space-y-2.5 text-sm font-semibold">
            <div class="flex justify-between border-b border-base-200 pb-2">
                <span class="text-base-content/60">Status</span>
                @if($timeline->status === 'pending')
                    <span class="badge badge-ghost badge-sm font-bold text-[9px] uppercase">Planning</span>
                @elseif($timeline->status === 'active')
                    <span class="badge badge-info badge-sm font-bold text-[9px] uppercase">Active</span>
                @elseif($timeline->status === 'completed')
                    <span class="badge badge-success badge-sm font-bold text-[9px] uppercase">Completed</span>
                @else
                    <span class="badge badge-error badge-sm font-bold text-[9px] uppercase">Delayed</span>
                @endif
            </div>
            <div class="flex justify-between border-b border-base-200 pb-2">
                <span class="text-base-content/60">Budget</span>
                <span>{{ $timeline->budget ? '₹ ' . number_format($timeline->budget, 2) : '—' }}</span>
            </div>
            <div class="flex justify-between border-b border-base-200 pb-2">
                <span class="text-base-content/60">Phase</span>
                <span class="badge badge-outline badge-xs font-semibold text-[10px]">{{ $timeline->current_phase }}</span>
            </div>
            <div class="flex justify-between border-b border-base-200 pb-2">
                <span class="text-base-content/60">Start</span>
                <span>{{ $timeline->start_date ?: '—' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-base-content/60">Target End</span>
                <span>{{ $timeline->target_completion ?: '—' }}</span>
            </div>
        </div>

        @if($timeline->notes)
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold text-base-content/50 uppercase tracking-widest">Notes</span>
                <div class="bg-base-200/60 border border-base-300 p-3 rounded-xl text-xs leading-relaxed text-base-content/80 whitespace-pre-line">{{ $timeline->notes }}</div>
            </div>
        @endif
    </div>

    {{-- Right: Milestones --}}
    <div class="lg:col-span-2 card-base rounded-2xl p-5">
        <h2 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-3 mb-5 flex items-center justify-between">
            <span class="flex items-center gap-2"><i class="fa-solid fa-list-check text-primary"></i> Progress Milestones</span>
            <span class="badge badge-primary badge-sm font-extrabold text-[10px]">{{ $timeline->milestones->count() }} Steps</span>
        </h2>

        @if($timeline->milestones->count() > 0)
            <div class="relative border-l-2 border-primary/20 ml-3 space-y-5">
                @foreach($timeline->milestones as $milestone)
                    <div class="relative pl-7">
                        {{-- Marker --}}
                        <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full border-4 border-base-100 shadow
                             {{ $milestone->status === 'completed' ? 'bg-primary' : 'bg-base-300' }}">
                        </div>

                        <div class="bg-base-100 border border-base-300 hover:border-primary/30 p-4 rounded-2xl shadow-sm transition-all duration-200">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-2">
                                <div class="flex-grow min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-bold text-sm text-base-content leading-tight">{{ $milestone->title }}</span>
                                        @if($milestone->status === 'completed')
                                            <span class="badge badge-success badge-xs font-bold uppercase">Done</span>
                                        @else
                                            <span class="badge badge-ghost badge-xs font-bold uppercase">Pending</span>
                                        @endif
                                    </div>
                                    @if($milestone->description)
                                        <p class="text-xs text-base-content/60 mt-1 leading-relaxed">{{ $milestone->description }}</p>
                                    @endif
                                    @if($milestone->milestone_date)
                                        <span class="text-[10px] text-base-content/40 font-bold mt-1.5 block">
                                            <i class="fa-regular fa-calendar mr-1"></i> {{ $milestone->milestone_date }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-1 shrink-0 sm:self-start">
                                    {{-- Quick Toggle --}}
                                    <form action="{{ route('admin.milestones.update', $milestone) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="title" value="{{ $milestone->title }}">
                                        <input type="hidden" name="description" value="{{ $milestone->description }}">
                                        <input type="hidden" name="milestone_date" value="{{ $milestone->milestone_date }}">
                                        <input type="hidden" name="status" value="{{ $milestone->status === 'completed' ? 'pending' : 'completed' }}">
                                        <button type="submit"
                                            class="btn btn-xs rounded-lg font-bold {{ $milestone->status === 'completed' ? 'btn-ghost btn-soft' : 'btn-success' }}"
                                            title="{{ $milestone->status === 'completed' ? 'Mark as Pending' : 'Mark as Done' }}">
                                            {{ $milestone->status === 'completed' ? 'Undo' : 'Mark Done' }}
                                        </button>
                                    </form>

                                    {{-- Edit --}}
                                    <button type="button"
                                        onclick="openEditMilestoneModal({{ json_encode($milestone) }})"
                                        class="btn btn-xs btn-square btn-soft btn-info tooltip tooltip-top"
                                        data-tip="Edit Step">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                    </button>

                                    {{-- Delete (Super Admin Only) --}}
                                    @can('super-admin')
                                        <form action="{{ route('admin.milestones.destroy', $milestone) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete this milestone step?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Delete Step">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-base-content/50 font-medium italic">
                No milestones added yet. <button type="button" onclick="openAddMilestoneModal()" class="text-primary underline font-bold not-italic">Add your first step</button>.
            </div>
        @endif
    </div>
</div>

{{-- ========== ADD MILESTONE MODAL ========== --}}
<div id="add-milestone-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-md p-6 relative">
        <button type="button" onclick="closeAddMilestoneModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-primary"></i> Add Milestone Step
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Add a new progress checkpoint to this project</p>

        <form action="{{ route('admin.milestones.store', $timeline) }}" method="POST" class="space-y-4">
            @csrf
            <div class="form-control">
                <x-float-input type="text" name="title" label="Milestone Title" required="true" />
            </div>
            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Description / Memo</span>
                    <textarea name="description" rows="3" placeholder="Description / Memo"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"></textarea>
                </label>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="date" name="milestone_date" label="Estimated Date" />
                </div>
                <div class="form-control">
                    <label class="floating-label w-full block relative">
                        <span>Initial Status <span class="text-error font-extrabold">*</span></span>
                        <select name="status" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                            <option value="pending" selected>Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeAddMilestoneModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Add Step
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========== EDIT MILESTONE MODAL ========== --}}
<div id="edit-milestone-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-md p-6 relative">
        <button type="button" onclick="closeEditMilestoneModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-primary"></i> Edit Milestone Step
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Modify an existing project milestone</p>

        <form id="edit-milestone-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="form-control">
                <x-float-input type="text" name="title" id="edit-mil-title" label="Milestone Title" required="true" />
            </div>
            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Description / Memo</span>
                    <textarea id="edit-mil-description" name="description" rows="3" placeholder="Description / Memo"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"></textarea>
                </label>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="date" name="milestone_date" id="edit-mil-date" label="Estimated Date" />
                </div>
                <div class="form-control">
                    <label class="floating-label w-full block relative">
                        <span>Status <span class="text-error font-extrabold">*</span></span>
                        <select id="edit-mil-status" name="status" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeEditMilestoneModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Save Step
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.openAddMilestoneModal = function () {
        document.getElementById('add-milestone-modal').classList.add('modal-open');
    };
    window.closeAddMilestoneModal = function () {
        document.getElementById('add-milestone-modal').classList.remove('modal-open');
    };

    window.openEditMilestoneModal = function (milestone) {
        document.getElementById('edit-milestone-form').action = `/admin/milestones/${milestone.id}`;
        document.getElementById('edit-mil-title').value = milestone.title || '';
        document.getElementById('edit-mil-description').value = milestone.description || '';
        document.getElementById('edit-mil-date').value = milestone.milestone_date || '';
        document.getElementById('edit-mil-status').value = milestone.status || 'pending';
        document.getElementById('edit-milestone-modal').classList.add('modal-open');
    };
    window.closeEditMilestoneModal = function () {
        document.getElementById('edit-milestone-modal').classList.remove('modal-open');
    };
});
</script>
@endsection
