@extends('layouts.admin')

@section('title', 'Admin Dashboard - Sachin Khandelwal Portal')

@section('content')
<!-- Dashboard Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-neutral">
            {{ __('messages.admin.feedback_mgmt') }}
        </h1>
        <p class="text-xs text-neutral/50 font-bold uppercase tracking-wider mt-1">Review and manage citizen submissions</p>
    </div>
    
    <!-- Export Approved Reviews to CSV -->
    <a href="{{ route('admin.feedback.export') }}" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
        <i class="fa-solid fa-file-csv text-lg"></i> {{ __('messages.admin.export') }}
    </a>
</div>

<!-- Action alerts -->
@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif

<!-- Metric Summary Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Metric 1: Total -->
    <div class="bg-[#FFFDF8] border border-base-300 p-5 rounded-2xl shadow-sm flex flex-col justify-between">
        <span class="text-xs font-bold text-neutral/45 uppercase tracking-wider">{{ __('messages.admin.total_feedbacks') }}</span>
        <span class="font-heading font-extrabold text-2xl text-neutral mt-2">{{ $counts['total'] }}</span>
    </div>
    <!-- Metric 2: Pending -->
    <div class="bg-[#FFFDF8] border border-base-300 p-5 rounded-2xl shadow-sm flex flex-col justify-between border-l-4 border-l-warning">
        <span class="text-xs font-bold text-neutral/45 uppercase tracking-wider">{{ __('messages.admin.pending') }}</span>
        <span class="font-heading font-extrabold text-2xl text-warning mt-2">{{ $counts['pending'] }}</span>
    </div>
    <!-- Metric 3: Approved -->
    <div class="bg-[#FFFDF8] border border-base-300 p-5 rounded-2xl shadow-sm flex flex-col justify-between border-l-4 border-l-success">
        <span class="text-xs font-bold text-neutral/45 uppercase tracking-wider">{{ __('messages.admin.approved') }}</span>
        <span class="font-heading font-extrabold text-2xl text-success mt-2">{{ $counts['approved'] }}</span>
    </div>
    <!-- Metric 4: Rejected -->
    <div class="bg-[#FFFDF8] border border-base-300 p-5 rounded-2xl shadow-sm flex flex-col justify-between border-l-4 border-l-error">
        <span class="text-xs font-bold text-neutral/45 uppercase tracking-wider">{{ __('messages.admin.rejected') }}</span>
        <span class="font-heading font-extrabold text-2xl text-error mt-2">{{ $counts['rejected'] }}</span>
    </div>
</div>

<!-- Filter and Search Row -->
<div class="bg-[#FFFDF8] border border-base-300 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
    <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full">
        <!-- Search input -->
        <div class="relative flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, mobile, message..." 
                class="input input-bordered w-full pl-10 rounded-xl bg-transparent border-base-300 focus:outline-none focus:border-primary text-sm text-neutral" />
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral/40 text-sm"></i>
        </div>

        <!-- Status Filter -->
        <select name="status" class="select select-bordered rounded-xl bg-transparent border-base-300 focus:outline-none focus:border-primary text-sm text-neutral min-w-[150px]">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <!-- Filter Actions -->
        <div class="flex gap-2">
            <button type="submit" class="btn btn-secondary text-white font-bold rounded-xl px-5">
                Filter
            </button>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost border border-base-300 hover:bg-base-200 rounded-xl">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Feedbacks List Table Card -->
<div class="bg-[#FFFDF8] border border-base-300 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-md w-full text-left">
            <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-neutral/70 border-b border-base-300">
                <tr>
                    <th class="py-4">Submitter Details</th>
                    <th class="py-4">Feedback Content</th>
                    <th class="py-4 text-center">Rating</th>
                    <th class="py-4">Photos</th>
                    <th class="py-4">{{ __('messages.admin.status') }}</th>
                    <th class="py-4 text-center">{{ __('messages.admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-300 text-sm text-neutral">
                @forelse($feedbacks as $feedback)
                    <tr class="hover:bg-base-100/50 transition-colors">
                        <!-- Submitter Details -->
                        <td class="py-4 space-y-1 vertical-align-top min-w-[150px]">
                            <p class="font-bold text-neutral">{{ $feedback->name }}</p>
                            <p class="text-xs text-neutral/70 font-semibold"><i class="fa-solid fa-phone mr-1 opacity-50"></i>{{ $feedback->mobile_number }}</p>
                            <p class="text-xs text-secondary font-bold uppercase tracking-wider"><i class="fa-solid fa-location-dot mr-1 opacity-50"></i>{{ $feedback->area }}</p>
                        </td>

                        <!-- Feedback Content -->
                        <td class="py-4 max-w-sm vertical-align-top">
                            <p class="font-bold text-neutral mb-1 leading-snug">{{ $feedback->title }}</p>
                            <p class="text-xs text-neutral/80 line-clamp-3 leading-relaxed whitespace-pre-line">{{ $feedback->message }}</p>
                            <span class="text-[10px] text-neutral/40 font-bold block mt-1">{{ $feedback->created_at->format('M d, Y h:i A') }}</span>
                        </td>

                        <!-- Rating Stars -->
                        <td class="py-4 text-center vertical-align-top">
                            <div class="inline-flex text-warning text-xs gap-0.5 font-bold">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= $feedback->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                        </td>

                        <!-- Uploaded/Captured Photos -->
                        <td class="py-4 vertical-align-top min-w-[120px]">
                            @if($feedback->images->isNotEmpty())
                                <div class="flex gap-1.5 flex-wrap">
                                    @foreach($feedback->images as $img)
                                        <a href="{{ asset($img->image_path) }}" target="_blank" class="w-12 h-12 rounded-lg overflow-hidden border border-base-300 hover:scale-105 transition-transform duration-200 block bg-base-300">
                                            <img src="{{ asset($img->image_path) }}" class="object-cover w-full h-full" alt="Review Media">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-neutral/40 italic">No Media</span>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 vertical-align-top">
                            @if($feedback->status === 'approved')
                                <span class="badge badge-success text-white font-bold text-xs">Approved</span>
                                @if($feedback->is_featured)
                                    <span class="badge badge-warning text-[10px] uppercase font-bold text-white block mt-1 tracking-wider">Featured</span>
                                @endif
                            @elseif($feedback->status === 'rejected')
                                <span class="badge badge-error text-white font-bold text-xs">Rejected</span>
                            @else
                                <span class="badge badge-warning font-bold text-xs">Pending</span>
                            @endif
                        </td>

                        <!-- Actions row buttons -->
                        <td class="py-4 vertical-align-top text-center space-y-1.5 min-w-[180px]">
                            <div class="flex flex-wrap justify-center gap-1.5">
                                <!-- Approval Action Form -->
                                @if($feedback->status !== 'approved')
                                    <form action="{{ route('admin.feedback.status', $feedback) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-xs btn-success text-white rounded-lg px-2.5 font-bold">
                                            Approve
                                        </button>
                                    </form>
                                @endif

                                <!-- Rejection Action Form -->
                                @if($feedback->status !== 'rejected')
                                    <form action="{{ route('admin.feedback.status', $feedback) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-xs btn-error text-white rounded-lg px-2.5 font-bold">
                                            Reject
                                        </button>
                                    </form>
                                @endif

                                <!-- Feature Toggle Action Form -->
                                @if($feedback->status === 'approved')
                                    <form action="{{ route('admin.feedback.featured', $feedback) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-xs {{ $feedback->is_featured ? 'btn-neutral' : 'btn-warning text-white' }} rounded-lg px-2 font-bold">
                                            {{ $feedback->is_featured ? 'Unfeature' : 'Feature' }}
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete Action Form -->
                                <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this feedback permanent?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline btn-neutral rounded-lg px-2.5">
                                        <i class="fa-solid fa-trash-can text-red-500"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-neutral/50 font-medium italic">
                            No feedbacks found matching query criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination block -->
    @if($feedbacks->hasPages())
        <div class="p-4 border-t border-base-300 flex justify-center">
            {{ $feedbacks->links() }}
        </div>
    @endif
</div>
@endsection
