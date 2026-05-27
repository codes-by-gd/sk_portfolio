@extends('layouts.admin')

@section('title', 'Contacts Directory - Admin Portal')

@section('content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">Contacts Directory</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Manage institutional contacts, mobile numbers, and designations</p>
    </div>
    <div class="flex items-center gap-2">
        <button type="button" onclick="openExportModal()" class="btn btn-ghost border border-base-300 hover:bg-base-200 rounded-xl gap-1.5 text-sm font-semibold">
            <i class="fa-solid fa-file-excel text-success"></i> Export XLSX
        </button>
        <button type="button" onclick="openAddModal()" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
            <i class="fa-solid fa-plus text-base"></i> Add Contact
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
    <form action="{{ route('admin.contact.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 w-full items-center">
        <div class="relative w-full sm:flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, mobile, designation..."
                class="input input-sm input-bordered w-full pl-8 rounded-xl bg-transparent border-base-300 focus:outline-none focus:border-primary text-xs text-base-content" />
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-xs"></i>
        </div>
        <div class="flex gap-1.5 w-full sm:w-auto shrink-0">
            <button type="submit" class="btn btn-sm btn-secondary text-white font-bold rounded-xl px-4 text-xs w-full sm:w-auto">Filter</button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.contact.index') }}" class="btn btn-sm btn-ghost border border-base-300 hover:bg-base-200 rounded-xl px-3 text-xs w-full sm:w-auto flex items-center justify-center">Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- Contacts Table --}}
<div class="bg-base-100 card-base border border-base-300 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="table table-md w-full text-left">
            <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-base-content/70 border-b border-base-300">
                <tr>
                    <th class="py-4">Contact</th>
                    <th class="py-4">Mobile</th>
                    <th class="py-4">Email</th>
                    <th class="py-4">Designation</th>
                    <th class="py-4">Address / Notes</th>
                    <th class="py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-300 text-sm text-base-content">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-base-200/50 transition-colors">
                        <td class="py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-extrabold text-xs shrink-0">
                                    {{ strtoupper(substr($contact->first_name, 0, 1) . substr($contact->last_name ?? '', 0, 1)) }}
                                </div>
                                <span class="font-bold text-base-content leading-tight">{{ $contact->name }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <a href="tel:{{ $contact->mobile_number }}" class="font-semibold text-primary hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-phone text-[10px] opacity-70"></i> {{ $contact->mobile_number }}
                            </a>
                        </td>
                        <td class="py-4 text-xs text-base-content/75">
                            @if($contact->email)
                                <a href="mailto:{{ $contact->email }}" class="hover:text-primary hover:underline">{{ $contact->email }}</a>
                            @else
                                <span class="italic opacity-50">—</span>
                            @endif
                        </td>
                        <td class="py-4">
                            @if($contact->designation)
                                <span class="badge badge-outline badge-sm font-semibold text-xs">{{ $contact->designation }}</span>
                            @else
                                <span class="text-xs italic opacity-50">—</span>
                            @endif
                        </td>
                        <td class="py-4 max-w-xs">
                            <p class="text-xs text-base-content/70 line-clamp-2 leading-relaxed">{{ $contact->address ?: ($contact->notes ?: '—') }}</p>
                        </td>
                        <td class="py-4 text-center">
                            <div class="flex gap-1.5 justify-center">
                                <button type="button"
                                    onclick="openEditModal({{ json_encode($contact) }})"
                                    class="btn btn-sm btn-square btn-soft btn-info tooltip tooltip-top"
                                    data-tip="Edit Contact">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                @can('super-admin')
                                    <form action="{{ route('admin.contact.destroy', $contact) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this contact permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Delete Contact">
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
                            No contacts found. <button type="button" onclick="openAddModal()" class="text-primary underline font-bold">Add your first contact</button>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($contacts->hasPages())
        <div class="p-4 border-t border-base-300 flex justify-center">
            {{ $contacts->links() }}
        </div>
    @endif
</div>

{{-- ========== ADD CONTACT MODAL ========== --}}
<div id="contact-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-lg p-6 relative">
        <button type="button" onclick="closeContactModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 id="contact-modal-title" class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-address-book text-primary"></i> Add Contact
        </h3>
        <p id="contact-modal-subtitle" class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Add a new institutional contact to the directory</p>

        <form id="contact-form" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="contact-form-method" value="POST">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="text" name="first_name" id="contact-first-name" label="First Name" required="true" />
                </div>
                <div class="form-control">
                    <x-float-input type="text" name="last_name" id="contact-last-name" label="Last Name" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input type="tel" name="mobile_number" id="contact-mobile" label="Mobile Number" required="true" />
                </div>
                <div class="form-control">
                    <x-float-input type="text" name="designation" id="contact-designation" label="Designation / Role" />
                </div>
            </div>

            <div class="form-control">
                <x-float-input type="email" name="email" id="contact-email" label="Email Address" />
            </div>

            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Postal / Office Address</span>
                    <textarea id="contact-address" name="address" rows="2" placeholder="Postal / Office Address"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-20"></textarea>
                </label>
            </div>

            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Notes</span>
                    <textarea id="contact-notes" name="notes" rows="2" placeholder="Notes"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-20"></textarea>
                </label>
            </div>

            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeContactModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">Cancel</button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Save Contact
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========== EXPORT MODAL ========== --}}
<div id="export-contact-modal" class="modal modal-bottom sm:modal-middle transition-all duration-300 z-50">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-sm p-6 relative">
        <button type="button" onclick="closeExportModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <h3 class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-file-excel text-success"></i> Export Contacts to XLSX
        </h3>
        <p class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Downloads a styled Excel spreadsheet of all contacts</p>

        <form action="{{ route('admin.contact.export') }}" method="GET" onsubmit="closeExportModal()">
            <div class="form-control mb-4">
                <x-float-input type="text" name="search" id="export-search" label="Filter by keyword (optional)" />
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.openAddModal = function () {
        document.getElementById('contact-form').action = "{{ route('admin.contact.store') }}";
        document.getElementById('contact-form-method').value = 'POST';
        document.getElementById('contact-modal-title').innerHTML = '<i class="fa-solid fa-address-book text-primary"></i> Add Contact';
        document.getElementById('contact-modal-subtitle').textContent = 'Add a new institutional contact to the directory';

        ['contact-first-name','contact-last-name','contact-mobile','contact-designation','contact-email','contact-address','contact-notes']
            .forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });

        document.getElementById('contact-modal').classList.add('modal-open');
    };

    window.openEditModal = function (contact) {
        document.getElementById('contact-form').action = `/admin/contacts/${contact.id}`;
        document.getElementById('contact-form-method').value = 'PUT';
        document.getElementById('contact-modal-title').innerHTML = '<i class="fa-solid fa-pen-to-square text-primary"></i> Edit Contact';
        document.getElementById('contact-modal-subtitle').textContent = 'Modify existing contact details';

        document.getElementById('contact-first-name').value = contact.first_name || '';
        document.getElementById('contact-last-name').value = contact.last_name || '';
        document.getElementById('contact-mobile').value = contact.mobile_number || '';
        document.getElementById('contact-designation').value = contact.designation || '';
        document.getElementById('contact-email').value = contact.email || '';
        document.getElementById('contact-address').value = contact.address || '';
        document.getElementById('contact-notes').value = contact.notes || '';

        document.getElementById('contact-modal').classList.add('modal-open');
    };

    window.closeContactModal = function () {
        document.getElementById('contact-modal').classList.remove('modal-open');
    };

    window.openExportModal = function () {
        document.getElementById('export-contact-modal').classList.add('modal-open');
    };

    window.closeExportModal = function () {
        document.getElementById('export-contact-modal').classList.remove('modal-open');
    };
});
</script>
@endsection
