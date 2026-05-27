@extends('layouts.admin')

@section('title', 'Citizen Grievances - Admin Portal')

@section('content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">Citizen Grievances</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Track and resolve complaints received via visits, mail, or telephone</p>
    </div>
    <div class="flex items-center gap-2">
        <button type="button" onclick="openExportModal()" class="btn btn-ghost border border-base-300 hover:bg-base-200 rounded-xl gap-1.5 text-sm font-semibold">
            <i class="fa-solid fa-file-excel text-success"></i> Export XLSX
        </button>
        <button type="button" onclick="openAddModal()" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
            <i class="fa-solid fa-plus text-base"></i> Log Grievance
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

{{-- Filters Row --}}
<div class="bg-base-100 card-base border border-base-300 rounded-2xl p-3.5 shadow-sm flex items-center">
    <form action="{{ route('admin.complaint.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 w-full items-center">
        <div class="relative w-full sm:flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, mobile, description..."
                class="input input-sm input-bordered w-full pl-8 rounded-xl bg-transparent border-base-300 focus:outline-none focus:border-primary text-xs text-base-content" />
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-xs"></i>
        </div>
        <select name="status" class="select select-sm select-bordered rounded-xl bg-base-100 border-base-300 focus:outline-none focus:border-primary text-xs text-base-content w-full sm:w-[145px] shrink-0">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under Review</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <div class="flex gap-1.5 w-full sm:w-auto shrink-0">
            <button type="submit" class="btn btn-sm btn-secondary text-white font-bold rounded-xl px-4 text-xs w-full sm:w-auto">Filter</button>
            @if(request()->anyFilled(['search','status']))
                <a href="{{ route('admin.complaint.index') }}" class="btn btn-sm btn-ghost border border-base-300 hover:bg-base-200 rounded-xl px-3 text-xs w-full sm:w-auto flex items-center justify-center">Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- Complaints Table --}}
<div class="bg-base-100 card-base border border-base-300 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="table table-md w-full text-left">
            <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-base-content/70 border-b border-base-300">
                <tr>
                    <th class="py-4">Complainant</th>
                    <th class="py-4">Area / Category</th>
                    <th class="py-4">Description</th>
                    <th class="py-4">Official Action Log</th>
                    <th class="py-4">Attachment</th>
                    <th class="py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-300 text-sm text-base-content">
                @forelse($complaints as $complaint)
                    <tr class="hover:bg-base-200/50 transition-colors">
                        <td class="py-4 min-w-[150px]">
                            <p class="font-bold text-base-content leading-tight">{{ $complaint->complainant_name }}</p>
                            <a href="tel:{{ $complaint->complainant_mobile }}" class="text-xs text-primary hover:underline mt-0.5 flex items-center gap-1">
                                <i class="fa-solid fa-phone text-[9px]"></i> {{ $complaint->complainant_mobile }}
                            </a>
                            <div class="mt-1.5">
                                @if($complaint->isPending())
                                    <span class="badge badge-warning badge-sm font-bold text-[9px] uppercase">Pending</span>
                                @elseif($complaint->isUnderReview())
                                    <span class="badge badge-info badge-sm font-bold text-[9px] uppercase">Under Review</span>
                                @elseif($complaint->isResolved())
                                    <span class="badge badge-success badge-sm font-bold text-[9px] uppercase">Resolved</span>
                                @else
                                    <span class="badge badge-error badge-sm font-bold text-[9px] uppercase">Rejected</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 min-w-[130px]">
                            <p class="text-xs text-secondary font-extrabold"><i class="fa-solid fa-location-dot mr-1 opacity-60"></i>{{ $complaint->area }}</p>
                            <span class="badge badge-outline badge-xs font-semibold mt-1 uppercase">{{ str_replace('_', ' ', $complaint->category) }}</span>
                        </td>
                        <td class="py-4 max-w-xs">
                            <p class="text-xs text-base-content/75 line-clamp-3 leading-relaxed">{{ $complaint->description }}</p>
                            <span class="text-[10px] text-base-content/40 font-semibold mt-1 block">{{ $complaint->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="py-4 max-w-xs">
                            @if($complaint->official_action)
                                <p class="text-xs text-base-content/70 line-clamp-3 leading-relaxed bg-base-200/60 p-2 rounded-lg border border-base-300">{{ $complaint->official_action }}</p>
                            @else
                                <span class="text-xs italic opacity-40">No action logged yet</span>
                            @endif
                        </td>
                        <td class="py-4">
                            @if($complaint->attachment_path)
                                <div class="w-12 h-12 rounded-lg overflow-hidden border border-base-300 bg-base-200 cursor-zoom-in group relative hover:scale-105 transition-transform"
                                     onclick="openViewerModal('{{ asset($complaint->attachment_path) }}', 'Attachment', '{{ $complaint->complainant_name }}')">
                                    <img src="{{ asset($complaint->attachment_path) }}" class="object-cover w-full h-full" alt="Attachment">
                                    <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <i class="fa-solid fa-magnifying-glass-plus text-white text-xs"></i>
                                    </div>
                                </div>
                            @else
                                <span class="text-xs italic opacity-40">—</span>
                            @endif
                        </td>
                        <td class="py-4 text-center">
                            <div class="flex gap-1.5 justify-center">
                                <button type="button"
                                    onclick="openResolveModal({{ json_encode($complaint) }})"
                                    class="btn btn-sm btn-square btn-soft btn-info tooltip tooltip-top"
                                    data-tip="Log Resolution">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                @can('super-admin')
                                    <form action="{{ route('admin.complaint.destroy', $complaint) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this grievance log permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Delete Log">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-base-content/50 font-medium italic">
                            No grievances logged. <button type="button" onclick="openAddModal()" class="text-primary underline font-bold">Log your first complaint</button>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($complaints->hasPages())
        <div class="p-4 border-t border-base-300 flex justify-center">
            {{ $complaints->links() }}
        </div>
    @endif
</div>

{{-- ========== ADD COMPLAINT MODAL ========== --}}
<div id="complaint-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-xl p-6 relative">
        <button type="button" onclick="closeComplaintModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-primary"></i> Log Citizen Grievance
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Record a complaint received via telephone, office visit, or letter</p>

        <form action="{{ route('admin.complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="text" name="complainant_name" label="Complainant Name" required="true" />
                </div>
                <div class="form-control">
                    <x-float-input type="tel" name="complainant_mobile" label="Mobile Number" required="true" />
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="text" name="area" label="Ward / Area" required="true" />
                </div>
                <div class="form-control">
                    <label class="floating-label w-full block relative">
                        <span>Category <span class="text-error font-extrabold">*</span></span>
                        <select name="category" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                            <option value="water">Water Supply Issues</option>
                            <option value="sanitation">Drainage & Sanitation</option>
                            <option value="road">Road Damage & Potholes</option>
                            <option value="electricity">Power & Electricity</option>
                            <option value="street_light">Street Light Faults</option>
                            <option value="other">Other Grievances</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Description <span class="text-error font-extrabold">*</span></span>
                    <textarea name="description" required rows="3" placeholder="Description"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"></textarea>
                </label>
            </div>
            <div class="form-control">
                <label class="label py-0 pb-1">
                    <span class="label-text font-bold text-[10px] text-base-content/75 uppercase tracking-wider">Attachment Photo (Optional)</span>
                </label>
                <input type="file" name="attachment" accept="image/*" class="file-input file-input-bordered file-input-primary file-input-sm w-full rounded-xl bg-transparent border-base-300" />
                <span class="text-[10px] text-base-content/40 font-semibold mt-1">Images up to 5MB – auto-converted to WebP.</span>
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeComplaintModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Log Grievance
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========== RESOLVE MODAL ========== --}}
<div id="resolve-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-md p-6 relative">
        <button type="button" onclick="closeResolveModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-file-signature text-primary"></i> Log Action & Resolution
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Update status and record official action details</p>

        <form id="resolve-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="form-control">
                <label class="floating-label w-full block relative">
                    <span>Grievance Status <span class="text-error font-extrabold">*</span></span>
                    <select id="res-status" name="status" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                        <option value="pending">Pending Action</option>
                        <option value="under_review">Under Review / Investigation</option>
                        <option value="resolved">Resolved / Action Completed</option>
                        <option value="rejected">Dismissed / Rejected</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </label>
            </div>
            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Official Action Log & Resolution Comments</span>
                    <textarea id="res-action" name="official_action" rows="4" placeholder="Official Action Log & Resolution Comments"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-32"></textarea>
                </label>
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeResolveModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md">Save Resolution</button>
            </div>
        </form>
    </div>
</div>

{{-- ========== EXPORT MODAL ========== --}}
<div id="export-complaint-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-sm p-6 relative">
        <button type="button" onclick="closeExportModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-file-excel text-success"></i> Export Grievances to XLSX
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Select filters for your report (leave blank to export all)</p>
        <form action="{{ route('admin.complaint.export') }}" method="GET" onsubmit="closeExportModal()" class="space-y-4">
            <div class="form-control">
                <label class="floating-label w-full block relative">
                    <span>Status Filter</span>
                    <select name="status" class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="under_review">Under Review</option>
                        <option value="resolved">Resolved</option>
                        <option value="rejected">Rejected</option>
                    </select>
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
</div>

{{-- Lightbox Viewer --}}
<dialog id="viewer-modal" class="modal bg-black/85 backdrop-blur-sm cursor-zoom-out" onclick="closeViewerModal()">
    <div class="modal-box max-w-4xl max-h-[85vh] p-0 bg-transparent shadow-none border-none relative flex flex-col items-center justify-center cursor-default" onclick="event.stopPropagation()">
        <button type="button" onclick="closeViewerModal()" class="btn btn-sm btn-circle btn-neutral absolute top-4 right-4 z-50 text-white bg-black/40 border-none hover:bg-black/60 shadow-lg">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <img id="viewer-image" src="" alt="Attachment" class="max-w-full max-h-[75vh] rounded-2xl object-contain border border-white/10 shadow-2xl select-none">
        <div id="viewer-caption-box" class="w-full bg-black/70 backdrop-blur-md text-white text-xs text-center py-3 px-5 rounded-2xl mt-4 max-w-2xl border border-white/10 hidden">
            <span id="viewer-category" class="badge badge-primary badge-sm font-bold uppercase mr-2.5 py-2"></span>
            <span id="viewer-caption" class="font-medium text-white/95"></span>
        </div>
    </div>
</dialog>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.openAddModal = function () {
        document.getElementById('complaint-modal').classList.add('modal-open');
    };
    window.closeComplaintModal = function () {
        document.getElementById('complaint-modal').classList.remove('modal-open');
    };

    window.openResolveModal = function (complaint) {
        document.getElementById('resolve-form').action = `/admin/complaints/${complaint.id}`;
        document.getElementById('res-status').value = complaint.status;
        document.getElementById('res-action').value = complaint.official_action || '';
        document.getElementById('resolve-modal').classList.add('modal-open');
    };
    window.closeResolveModal = function () {
        document.getElementById('resolve-modal').classList.remove('modal-open');
    };

    window.openExportModal = function () {
        document.getElementById('export-complaint-modal').classList.add('modal-open');
    };
    window.closeExportModal = function () {
        document.getElementById('export-complaint-modal').classList.remove('modal-open');
    };

    window.openViewerModal = function (src, category, caption) {
        const modal = document.getElementById('viewer-modal');
        document.getElementById('viewer-image').src = src;
        if (category || caption) {
            document.getElementById('viewer-category').textContent = category || '';
            document.getElementById('viewer-caption').textContent = caption || '';
            document.getElementById('viewer-caption-box').classList.remove('hidden');
        } else {
            document.getElementById('viewer-caption-box').classList.add('hidden');
        }
        modal.showModal();
    };
    window.closeViewerModal = function () {
        document.getElementById('viewer-modal').close();
    };
});
</script>
@endsection
