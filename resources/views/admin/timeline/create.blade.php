@extends('layouts.admin')

@section('title', 'Add Project Timeline - Admin Portal')

@section('content')
{{-- Back + Header --}}
<div class="flex items-center gap-4">
    <a href="{{ route('admin.timeline.index') }}" class="btn btn-sm btn-ghost gap-1.5 text-base-content/70 hover:text-primary rounded-lg">
        <i class="fa-solid fa-arrow-left-long"></i> Back to Timelines
    </a>
    <div>
        <h1 class="font-heading font-extrabold text-2xl text-base-content">Create Project Timeline</h1>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-error shadow-sm rounded-xl text-white">
        <ul class="text-xs list-disc pl-4 font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-base rounded-2xl p-6 sm:p-8">
    <form action="{{ route('admin.timeline.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Project Identity --}}
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-2">
                <i class="fa-solid fa-map-location-dot text-primary mr-1.5"></i> Project Identity
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="text" name="project_name" label="Project Name" value="{{ old('project_name') }}" required="true" />
                </div>
                <div class="form-control">
                    <x-float-input type="text" name="location" label="Location / Ward Area" value="{{ old('location') }}" required="true" />
                </div>
            </div>
        </div>

        {{-- Schedule & Budget --}}
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-2">
                <i class="fa-solid fa-indian-rupee-sign text-primary mr-1.5"></i> Schedule & Budget
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="form-control">
                    <x-float-input type="number" name="budget" label="Budget (INR)" value="{{ old('budget') }}" />
                </div>
                <div class="form-control">
                    <x-float-input type="date" name="start_date" label="Start Date" value="{{ old('start_date') }}" />
                </div>
                <div class="form-control">
                    <x-float-input type="date" name="target_completion" label="Target Completion" value="{{ old('target_completion') }}" />
                </div>
                <div class="form-control">
                    <label class="floating-label w-full block relative">
                        <span>Current Status <span class="text-error font-extrabold">*</span></span>
                        <select name="status" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Planning / Pending</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active Execution</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="delayed" {{ old('status') == 'delayed' ? 'selected' : '' }}>Delayed / Suspended</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Phase & Notes --}}
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-2">
                <i class="fa-solid fa-clipboard-list text-primary mr-1.5"></i> Phase & Notes
            </h3>
            <div class="form-control">
                <x-float-input type="text" name="current_phase" label="Current Phase Description" value="{{ old('current_phase') }}" required="true" />
            </div>
            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Internal Documentation Notes</span>
                    <textarea name="notes" rows="4" placeholder="Internal Documentation Notes"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-28">{{ old('notes') }}</textarea>
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn btn-primary text-white font-bold rounded-xl gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Save Project
            </button>
            <a href="{{ route('admin.timeline.index') }}" class="btn btn-ghost border border-base-300 rounded-xl">Cancel</a>
        </div>
    </form>
</div>
@endsection
