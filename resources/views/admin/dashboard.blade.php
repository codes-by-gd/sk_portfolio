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
<div id="admin-feedback-table-container" class="bg-[#FFFDF8] border border-base-300 rounded-2xl shadow-sm overflow-hidden">
    @include('admin.partials.feedback-table')
</div>

<!-- AJAX Pagination Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableContainer = document.getElementById('admin-feedback-table-container');
    if (tableContainer) {
        tableContainer.addEventListener('click', function(e) {
            // Find if pagination link was clicked (e.g. inside nav or pagination list)
            const link = e.target.closest('nav a, .pagination a, a[href*="page="]');
            if (link) {
                e.preventDefault();
                const url = link.getAttribute('href');
                fetchTable(url);
            }
        });
    }

    function fetchTable(url) {
        if (!tableContainer) return;
        tableContainer.style.opacity = '0.5';
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            tableContainer.innerHTML = data.html;
            tableContainer.style.opacity = '1';
            
            // Scroll table container header into view smoothly
            tableContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        })
        .catch(error => {
            console.error('Error fetching admin table:', error);
            tableContainer.style.opacity = '1';
        });
    }
});
</script>
@endsection
