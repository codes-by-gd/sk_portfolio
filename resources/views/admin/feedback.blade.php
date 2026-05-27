@extends('layouts.admin')

@section('title', 'Admin Dashboard - Sachin Khandelwal Portal')

@section('content')
<!-- Dashboard Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">
            {{ __('messages.admin.feedback_mgmt') }}
        </h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Review and manage citizen submissions</p>
    </div>
    
    <!-- Export Feedbacks to Excel -->
    <button onclick="document.getElementById('export-feedback-modal').showModal()" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
        <i class="fa-solid fa-file-excel text-lg"></i> {{ __('messages.admin.export') }}
    </button>
</div>

<!-- Action alerts -->
@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif

<!-- Stats and Filters Unified Row -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-4 items-stretch">
    <!-- Stats Cards (Left 7 Columns on XL, Full width on smaller) -->
    <div class="xl:col-span-7 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <!-- Metric 1: Total -->
        <div class="bg-base-100 card-base border border-base-300 p-3.5 rounded-2xl shadow-sm flex items-center gap-3 border-l-4 border-l-primary">
            <div class="bg-primary/10 text-primary w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                <i class="fa-solid fa-comments text-base"></i>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] font-extrabold text-base-content/50 uppercase tracking-wider leading-none">{{ __('messages.admin.total_feedbacks') }}</span>
                <span class="font-heading font-extrabold text-lg text-base-content mt-1.5 leading-none">{{ $counts['total'] }}</span>
            </div>
        </div>

        <!-- Metric 2: Pending -->
        <div class="bg-base-100 card-base border border-base-300 p-3.5 rounded-2xl shadow-sm flex items-center gap-3 border-l-4 border-l-warning">
            <div class="bg-warning/10 text-warning w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                <i class="fa-solid fa-clock text-base"></i>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] font-extrabold text-base-content/50 uppercase tracking-wider leading-none">{{ __('messages.admin.pending') }}</span>
                <span class="font-heading font-extrabold text-lg text-warning mt-1.5 leading-none">{{ $counts['pending'] }}</span>
            </div>
        </div>

        <!-- Metric 3: Approved -->
        <div class="bg-base-100 card-base border border-base-300 p-3.5 rounded-2xl shadow-sm flex items-center gap-3 border-l-4 border-l-success">
            <div class="bg-success/10 text-success w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-check text-base"></i>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] font-extrabold text-base-content/50 uppercase tracking-wider leading-none">{{ __('messages.admin.approved') }}</span>
                <span class="font-heading font-extrabold text-lg text-success mt-1.5 leading-none">{{ $counts['approved'] }}</span>
            </div>
        </div>

        <!-- Metric 4: Rejected -->
        <div class="bg-base-100 card-base border border-base-300 p-3.5 rounded-2xl shadow-sm flex items-center gap-3 border-l-4 border-l-error">
            <div class="bg-error/10 text-error w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-xmark text-base"></i>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] font-extrabold text-base-content/50 uppercase tracking-wider leading-none">{{ __('messages.admin.rejected') }}</span>
                <span class="font-heading font-extrabold text-lg text-error mt-1.5 leading-none">{{ $counts['rejected'] }}</span>
            </div>
        </div>
    </div>

    <!-- Filters Card (Right 5 Columns on XL, Full width on smaller) -->
    <div class="xl:col-span-5 bg-base-100 card-base border border-base-300 rounded-2xl p-3.5 shadow-sm flex items-center">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 w-full items-center justify-between">
            <!-- Search input -->
            <div class="relative w-full sm:flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search feedbacks..." 
                    class="input input-sm input-bordered w-full pl-8 rounded-xl bg-transparent border-base-300 focus:outline-none focus:border-primary text-xs text-base-content" />
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-xs"></i>
            </div>

            <!-- Status Filter -->
            <select name="status" class="select select-sm select-bordered rounded-xl bg-base-100 border-base-300 focus:outline-none focus:border-primary text-xs text-base-content w-full sm:w-[130px] shrink-0">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <!-- Filter Actions -->
            <div class="flex gap-1.5 w-full sm:w-auto shrink-0">
                <button type="submit" class="btn btn-sm btn-secondary text-white font-bold rounded-xl px-4 text-xs w-full sm:w-auto">
                    Filter
                </button>
                @if(request()->has('search') || request()->has('status'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-ghost border border-base-300 hover:bg-base-200 rounded-xl px-3 text-xs w-full sm:w-auto flex items-center justify-center">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Feedbacks List Table Card -->
<div id="admin-feedback-table-container" class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm overflow-hidden">
    @include('admin.partials.feedback-table')
</div>

<!-- Edit Feedback Modal -->
<!-- Edit Feedback Modal -->
<dialog id="edit-feedback-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-lg p-6 relative">
        <button type="button" onclick="closeEditModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <!-- ESC shortcut label -->
        <div class="absolute right-14 top-5 text-[9px] opacity-40 font-bold hidden sm:block">
            <kbd class="kbd kbd-sm bg-base-200">ESC</kbd>
        </div>

        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-primary"></i> Edit Feedback Submission
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Modify citizen submission details</p>

        <form id="edit-feedback-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Name & Mobile Group -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input 
                        type="text" 
                        name="name" 
                        id="edit-name" 
                        label="Citizen Name" 
                        required="true"
                    />
                </div>
                <div class="form-control">
                    <x-float-input 
                        type="text" 
                        name="mobile_number" 
                        id="edit-mobile" 
                        label="Mobile Number" 
                        required="true"
                    />
                </div>
            </div>

            <!-- Area & Status Group -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input 
                        type="text" 
                        name="area" 
                        id="edit-area" 
                        label="Ward/Area" 
                        required="true"
                    />
                </div>
                <div class="form-control">
                    <label class="floating-label w-full block relative">
                        <select 
                            id="edit-status" 
                            name="status" 
                            required
                            class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10"
                        >
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <span>
                            Status
                            <span class="text-error font-extrabold">*</span>
                        </span>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Rating Group -->
            <div class="form-control">
                <label class="floating-label w-full block group relative">
                    <input 
                        type="text" 
                        placeholder="Rating"
                        class="input input-md w-full bg-base-100 border border-base-300 rounded-xl pointer-events-none select-none text-transparent transition-all duration-200 group-hover:border-base-content/30 group-focus-within:border-primary group-focus-within:ring-1 group-focus-within:ring-primary"
                        style="color: transparent; caret-color: transparent;"
                        readonly
                        value="Rating"
                    />
                    <span class="group-focus-within:text-primary transition-colors duration-200">
                        Rating <span class="text-error font-extrabold">*</span>
                    </span>
                    <div class="absolute inset-x-0 bottom-0 h-12 flex items-center justify-center rating rating-md gap-0.5 pointer-events-auto z-20">
                        <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
                        <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
                        <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
                        <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
                        <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
                    </div>
                </label>
            </div>

            <!-- Message Textarea -->
            <div class="form-control">
                <label class="floating-label w-full block">
                    <textarea 
                        id="edit-message" 
                        name="message" 
                        rows="4" 
                        required 
                        placeholder="Detailed Message"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-32"
                    ></textarea>
                    <span>
                        Detailed Message
                        <span class="text-error font-extrabold">*</span>
                    </span>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeEditModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
    <!-- Backdrop to close natively on click -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<!-- Export Feedback Modal -->
<dialog id="export-feedback-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-md p-6 relative">
        <button type="button" onclick="closeExportModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <!-- ESC shortcut label -->
        <div class="absolute right-14 top-5 text-[9px] opacity-40 font-bold hidden sm:block">
            <kbd class="kbd kbd-sm bg-base-200">ESC</kbd>
        </div>

        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-file-excel text-primary"></i> Export Feedbacks to Excel
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Select filters for your Excel report (leave blank to export all)</p>

        <form action="{{ route('admin.feedback.export') }}" method="GET" class="space-y-4" onsubmit="closeExportModal()">
            <!-- Status Filter -->
            <div class="form-control">
                <label class="floating-label w-full block relative">
                    <select 
                        id="export-status" 
                        name="status" 
                        class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10"
                    >
                        <option value="all">All Statuses</option>
                        <option value="approved" selected>Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <span>
                        Status Filter
                    </span>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </label>
            </div>


            <!-- Rating Stars Filter -->
            <div class="form-control">
                <label class="floating-label w-full block relative">
                    <select 
                        id="export-rating" 
                        name="rating" 
                        class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10"
                    >
                        <option value="">All Ratings</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                    <span>
                        Rating Stars
                    </span>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </label>
            </div>

            <!-- Date Range Filter -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input 
                        type="date" 
                        name="start_date" 
                        id="export-start-date" 
                        label="Start Date" 
                    />
                </div>
                <div class="form-control">
                    <x-float-input 
                        type="date" 
                        name="end_date" 
                        id="export-end-date" 
                        label="End Date" 
                    />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeExportModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md">
                    <i class="fa-solid fa-file-excel mr-1"></i> Download Excel
                </button>
            </div>
        </form>
    </div>
    <!-- Backdrop to close natively on click -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<!-- Dashboard Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableContainer = document.getElementById('admin-feedback-table-container');
    if (tableContainer) {
        tableContainer.addEventListener('click', function(e) {
            // Find if pagination link was clicked (e.g. inside nav or pagination list)
            const link = e.target.closest('nav a, .pagination a, a[href*="page="], .join a');
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

    // Event delegation for dynamically loaded Edit buttons
    document.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-feedback-btn');
        if (editBtn) {
            e.preventDefault();
            const feedback = {
                id: editBtn.getAttribute('data-id'),
                name: editBtn.getAttribute('data-name'),
                mobileNumber: editBtn.getAttribute('data-mobile'),
                area: editBtn.getAttribute('data-area'),
                message: editBtn.getAttribute('data-message'),
                rating: editBtn.getAttribute('data-rating'),
                status: editBtn.getAttribute('data-status'),
            };
            openEditModal(feedback);
        }
    });

    // Dynamic Edit Modal handling
    window.openEditModal = function(feedback) {
        const modal = document.getElementById('edit-feedback-modal');
        if (!modal) return;
        
        const form = document.getElementById('edit-feedback-form');
        form.action = `/admin/feedback/${feedback.id}`;
        
        document.getElementById('edit-name').value = feedback.name;
        document.getElementById('edit-mobile').value = feedback.mobileNumber;
        document.getElementById('edit-area').value = feedback.area;
        document.getElementById('edit-message').value = feedback.message;
        
        // Select corresponding star rating radio button
        const ratingRadios = form.querySelectorAll('input[name="rating"]');
        ratingRadios.forEach(radio => {
            if (radio.value == feedback.rating) {
                radio.checked = true;
            }
        });
        
        document.getElementById('edit-status').value = feedback.status;
        
        modal.showModal();
    };

    window.closeEditModal = function() {
        const modal = document.getElementById('edit-feedback-modal');
        if (modal) {
            modal.close();
        }
    };

    window.closeExportModal = function() {
        const modal = document.getElementById('export-feedback-modal');
        if (modal) {
            modal.close();
        }
    };

    // Lightbox modal functions mapping to unified component
    window.openViewerModal = function(imageSrc, category, caption) {
        openGalleryViewerDirect(imageSrc, category, caption);
    };
});
</script>

<!-- Reusable Lightbox Viewer Modal -->
<x-gallery-lightbox />
@endsection
