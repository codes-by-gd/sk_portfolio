@extends('layouts.admin')

@section('title', 'Development Works - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">Development Works</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Manage ward development projects</p>
    </div>
    <button type="button" onclick="openAddModal()" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
        <i class="fa-solid fa-plus text-base"></i> Add New Project
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm rounded-xl text-white mt-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error shadow-sm rounded-xl text-white mt-6">
        <ul class="text-xs list-disc pl-4 font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Development Project Dialog Modal -->
<dialog id="project-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-4xl p-6 relative">
        <!-- Close Button -->
        <button type="button" onclick="closeProjectModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <!-- ESC shortcut label -->
        <div class="absolute right-14 top-5 text-[9px] opacity-40 font-bold hidden sm:block">
            <kbd class="kbd kbd-sm bg-base-200">ESC</kbd>
        </div>

        <h3 id="modal-title" class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-helmet-safety text-primary"></i> Add New Development Project
        </h3>
        <p id="modal-subtitle" class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Create a new development work report for the ward portal</p>

        <form id="project-form" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <!-- Method placeholder toggled between POST and PUT via JS -->
            <input type="hidden" name="_method" id="form-method" value="POST">

            <!-- Title Fields -->
            <div class="space-y-3">
                <h3 class="font-heading font-bold text-xs text-base-content/75 uppercase tracking-wider border-b border-base-300 pb-2">
                    <i class="fa-solid fa-heading text-primary mr-1"></i> Project Title
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- English Title -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                        <x-float-input 
                            type="text" 
                            name="title_en" 
                            id="project-title-en"
                            label="Title (English)" 
                            required="true"
                        />
                    </div>
                    <!-- Gujarati Title -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                        <x-float-input 
                            type="text" 
                            name="title_gu" 
                            id="project-title-gu"
                            label="Title (ગુજરાતી)" 
                        />
                    </div>
                    <!-- Hindi Title -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                        <x-float-input 
                            type="text" 
                            name="title_hi" 
                            id="project-title-hi"
                            label="Title (हिंदी)" 
                        />
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="form-control">
                <x-float-input 
                    type="text" 
                    name="location" 
                    id="project-location"
                    label="Location / Area" 
                    required="true"
                />
            </div>

            <!-- Description Fields -->
            <div class="space-y-3">
                <h3 class="font-heading font-bold text-xs text-base-content/75 uppercase tracking-wider border-b border-base-300 pb-2">
                    <i class="fa-solid fa-align-left text-primary mr-1"></i> Descriptions
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- English description -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                        <label class="floating-label w-full block">
                            <span>Description (English) <span class="text-error font-extrabold">*</span></span>
                            <textarea 
                                name="description_en" 
                                id="project-description-en" 
                                required 
                                rows="3" 
                                placeholder="Description (English)"
                                class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"
                            ></textarea>
                        </label>
                    </div>
                    <!-- Gujarati description -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                        <label class="floating-label w-full block">
                            <span>Description (ગુજરાતી)</span>
                            <textarea 
                                name="description_gu" 
                                id="project-description-gu" 
                                rows="3" 
                                placeholder="Description (ગુજરાતી)"
                                class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"
                            ></textarea>
                        </label>
                    </div>
                    <!-- Hindi description -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                        <label class="floating-label w-full block">
                            <span>Description (हिंदी)</span>
                            <textarea 
                                name="description_hi" 
                                id="project-description-hi" 
                                rows="3" 
                                placeholder="Description (हिंदी)"
                                class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"
                            ></textarea>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Before / After Images -->
            <div class="space-y-3">
                <h3 class="font-heading font-bold text-xs text-base-content/75 uppercase tracking-wider border-b border-base-300 pb-2">
                    <i class="fa-solid fa-images text-primary mr-1"></i> Before / After Images
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Before Image Input & Preview -->
                    <div class="space-y-3">
                        <label class="label py-0 pb-1">
                            <span class="label-text font-bold text-[10px] text-base-content/70 uppercase tracking-wider">Before Image</span>
                        </label>
                        
                        <!-- Premium Preview Card -->
                        <div id="before-preview-container" class="relative group aspect-video w-full rounded-xl overflow-hidden border border-dashed border-base-300 bg-base-200/40 flex flex-col items-center justify-center transition-all duration-300 hover:border-primary/40">
                            <!-- Default empty state -->
                            <div id="before-empty-state" class="flex flex-col items-center gap-1.5 p-4 text-center text-base-content/40 transition-opacity">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-primary/60"></i>
                                <div class="text-[10px] font-semibold">No before image selected</div>
                                <div class="text-[8px]">JPEG, PNG, JPG, WEBP up to 5MB</div>
                            </div>
                            <!-- Preview Image Tag -->
                            <img id="before-preview-img" class="hidden w-full h-full object-cover rounded-xl" alt="Before Preview">
                            <span id="before-current-badge" class="hidden absolute bottom-2 left-2 z-10 badge badge-xs bg-neutral/80 text-white font-semibold backdrop-blur-sm border-none">Current Image</span>
                            <!-- Floating clear button if selected -->
                            <button type="button" id="before-clear-btn" class="hidden absolute top-2 right-2 btn btn-circle btn-xs btn-error text-white shadow-md hover:scale-105 transition-all w-5 h-5 min-h-0">
                                <i class="fa-solid fa-xmark text-[9px]"></i>
                            </button>
                        </div>

                        <input type="file" name="before_image" id="before_image" accept="image/*" class="file-input file-input-bordered file-input-warning file-input-sm w-full rounded-xl bg-transparent border-base-300">
                    </div>

                    <!-- After Image Input & Preview -->
                    <div class="space-y-3">
                        <label class="label py-0 pb-1">
                            <span class="label-text font-bold text-[10px] text-base-content/70 uppercase tracking-wider">After Image</span>
                        </label>

                        <!-- Premium Preview Card -->
                        <div id="after-preview-container" class="relative group aspect-video w-full rounded-xl overflow-hidden border border-dashed border-base-300 bg-base-200/40 flex flex-col items-center justify-center transition-all duration-300 hover:border-primary/40">
                            <!-- Default empty state -->
                            <div id="after-empty-state" class="flex flex-col items-center gap-1.5 p-4 text-center text-base-content/40 transition-opacity">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-success/60"></i>
                                <div class="text-[10px] font-semibold">No after image selected</div>
                                <div class="text-[8px]">JPEG, PNG, JPG, WEBP up to 5MB</div>
                            </div>
                            <!-- Preview Image Tag -->
                            <img id="after-preview-img" class="hidden w-full h-full object-cover rounded-xl" alt="After Preview">
                            <span id="after-current-badge" class="hidden absolute bottom-2 left-2 z-10 badge badge-xs bg-neutral/80 text-white font-semibold backdrop-blur-sm border-none">Current Image</span>
                            <!-- Floating clear button if selected -->
                            <button type="button" id="after-clear-btn" class="hidden absolute top-2 right-2 btn btn-circle btn-xs btn-error text-white shadow-md hover:scale-105 transition-all w-5 h-5 min-h-0">
                                <i class="fa-solid fa-xmark text-[9px]"></i>
                            </button>
                        </div>

                        <input type="file" name="after_image" id="after_image" accept="image/*" class="file-input file-input-bordered file-input-success file-input-sm w-full rounded-xl bg-transparent border-base-300">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeProjectModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Save Project
                </button>
            </div>
        </form>
    </div>
    <!-- Backdrop to close natively on click -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<!-- Works Table -->
<div class="bg-base-100 card-base border border-base-300 rounded-2xl overflow-hidden shadow-sm mt-6">
    <div class="overflow-x-auto">
        <table class="table table-md w-full text-left">
            <thead class="bg-base-200 text-xs font-bold uppercase tracking-wider text-base-content/70 border-b border-base-300">
                <tr>
                    <th class="py-4">Preview</th>
                    <th class="py-4">Title & Location</th>
                    <th class="py-4">Description</th>
                    <th class="py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-base-300 text-sm text-base-content">
                @forelse($works as $work)
                    <tr class="hover:bg-base-200/50 transition-colors">
                        <!-- Before/After Preview -->
                        <td class="py-4 min-w-[140px]">
                            <div class="flex gap-1.5">
                                <div class="w-14 h-14 rounded-lg overflow-hidden border border-base-300 bg-base-200 flex items-center justify-center">
                                    @if($work->before_image)
                                        <img src="{{ asset($work->before_image) }}" class="object-cover w-full h-full" alt="Before" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=Before&backgroundColor=d1d5db&textColor=1f2937'">
                                    @else
                                        <i class="fa-solid fa-image text-base-content/30 text-lg"></i>
                                    @endif
                                </div>
                                <div class="w-14 h-14 rounded-lg overflow-hidden border border-base-300 bg-base-200 flex items-center justify-center">
                                    @if($work->after_image)
                                        <img src="{{ asset($work->after_image) }}" class="object-cover w-full h-full" alt="After" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=After&backgroundColor=53C58B&textColor=ffffff'">
                                    @else
                                        <i class="fa-solid fa-circle-check text-accent text-lg"></i>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <!-- Title & Location -->
                        <td class="py-4 min-w-[200px]">
                            <p class="font-bold text-base-content leading-tight">{{ $work->title_en }}</p>
                            <p class="text-xs text-secondary font-extrabold mt-1"><i class="fa-solid fa-location-dot mr-1 opacity-60"></i>{{ $work->location }}</p>
                        </td>
                        <!-- Description -->
                        <td class="py-4 max-w-xs">
                            <p class="text-xs text-base-content/75 line-clamp-3 leading-relaxed">{{ $work->description_en }}</p>
                        </td>
                        <!-- Actions -->
                        <td class="py-4 text-center">
                            <div class="flex gap-1.5 justify-center">
                                <button type="button"
                                    class="btn btn-sm btn-square btn-soft btn-info tooltip tooltip-top edit-project-btn" 
                                    data-tip="Edit Project"
                                    data-id="{{ $work->id }}"
                                    data-title-en="{{ $work->title_en }}"
                                    data-title-gu="{{ $work->title_gu }}"
                                    data-title-hi="{{ $work->title_hi }}"
                                    data-location="{{ $work->location }}"
                                    data-description-en="{{ $work->description_en }}"
                                    data-description-gu="{{ $work->description_gu }}"
                                    data-description-hi="{{ $work->description_hi }}"
                                    data-before-image="{{ $work->before_image ? asset($work->before_image) : '' }}"
                                    data-after-image="{{ $work->after_image ? asset($work->after_image) : '' }}">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <form action="{{ route('admin.development.destroy', $work) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top" data-tip="Delete Project">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-12 text-base-content/50 font-medium italic">
                            No development projects found. <button type="button" onclick="openAddModal()" class="text-primary underline font-bold">Add your first project</button>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($works->hasPages())
        <div class="p-4 border-t border-base-300 flex justify-center">
            {{ $works->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('project-modal');
    const form = document.getElementById('project-form');
    const formMethod = document.getElementById('form-method');
    const modalTitle = document.getElementById('modal-title');
    const modalSubtitle = document.getElementById('modal-subtitle');

    const titleEn = document.getElementById('project-title-en');
    const titleGu = document.getElementById('project-title-gu');
    const titleHi = document.getElementById('project-title-hi');
    const locationInput = document.getElementById('project-location');
    
    const descEn = document.getElementById('project-description-en');
    const descGu = document.getElementById('project-description-gu');
    const descHi = document.getElementById('project-description-hi');

    let currentBeforeImage = null;
    let currentAfterImage = null;

    // Helper to configure before/after image previews dynamically
    function initImagePreview(inputId, imgId, emptyId, containerId, clearId, currentBadgeId, dbGetter) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);
        const empty = document.getElementById(emptyId);
        const container = document.getElementById(containerId);
        const clearBtn = document.getElementById(clearId);
        const currentBadge = document.getElementById(currentBadgeId);

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    empty.classList.add('hidden');
                    clearBtn.classList.remove('hidden');
                    container.classList.remove('border-dashed');
                    container.classList.add('border-solid');
                    currentBadge.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        clearBtn.addEventListener('click', function() {
            input.value = '';
            const dbVal = dbGetter();
            if (dbVal) {
                img.src = dbVal;
                img.classList.remove('hidden');
                empty.classList.add('hidden');
                clearBtn.classList.add('hidden');
                container.classList.remove('border-dashed');
                container.classList.add('border-solid');
                currentBadge.classList.remove('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                empty.classList.remove('hidden');
                clearBtn.classList.add('hidden');
                container.classList.add('border-dashed');
                container.classList.remove('border-solid');
                currentBadge.classList.add('hidden');
            }
        });
    }

    initImagePreview(
        'before_image', 
        'before-preview-img', 
        'before-empty-state', 
        'before-preview-container', 
        'before-clear-btn', 
        'before-current-badge',
        () => currentBeforeImage
    );

    initImagePreview(
        'after_image', 
        'after-preview-img', 
        'after-empty-state', 
        'after-preview-container', 
        'after-clear-btn', 
        'after-current-badge',
        () => currentAfterImage
    );

    // Reset preview visuals
    function resetPreviewVisuals(imgId, emptyId, containerId, clearId, currentBadgeId, originalSrc) {
        const img = document.getElementById(imgId);
        const empty = document.getElementById(emptyId);
        const container = document.getElementById(containerId);
        const clearBtn = document.getElementById(clearId);
        const currentBadge = document.getElementById(currentBadgeId);

        if (originalSrc) {
            img.src = originalSrc;
            img.classList.remove('hidden');
            empty.classList.add('hidden');
            clearBtn.classList.add('hidden');
            container.classList.remove('border-dashed');
            container.classList.add('border-solid');
            currentBadge.classList.remove('hidden');
        } else {
            img.src = '';
            img.classList.add('hidden');
            empty.classList.remove('hidden');
            clearBtn.classList.add('hidden');
            container.classList.add('border-dashed');
            container.classList.remove('border-solid');
            currentBadge.classList.add('hidden');
        }
    }

    // Open Add Modal
    window.openAddModal = function() {
        form.action = "{{ route('admin.development.store') }}";
        formMethod.value = "POST";
        modalTitle.innerHTML = '<i class="fa-solid fa-helmet-safety text-primary"></i> Add New Development Project';
        modalSubtitle.textContent = 'Create a new development work report for the ward portal';

        // Reset text elements
        titleEn.value = '';
        titleGu.value = '';
        titleHi.value = '';
        locationInput.value = '';
        descEn.value = '';
        descGu.value = '';
        descHi.value = '';

        // Clear files
        document.getElementById('before_image').value = '';
        document.getElementById('after_image').value = '';
        currentBeforeImage = null;
        currentAfterImage = null;

        resetPreviewVisuals('before-preview-img', 'before-empty-state', 'before-preview-container', 'before-clear-btn', 'before-current-badge', null);
        resetPreviewVisuals('after-preview-img', 'after-empty-state', 'after-preview-container', 'after-clear-btn', 'after-current-badge', null);

        modal.showModal();
    };

    // Open Edit Modal
    window.openEditModal = function(btn) {
        const id = btn.getAttribute('data-id');
        const tEn = btn.getAttribute('data-title-en');
        const tGu = btn.getAttribute('data-title-gu');
        const tHi = btn.getAttribute('data-title-hi');
        const loc = btn.getAttribute('data-location');
        const dEn = btn.getAttribute('data-description-en');
        const dGu = btn.getAttribute('data-description-gu');
        const dHi = btn.getAttribute('data-description-hi');
        const bImg = btn.getAttribute('data-before-image');
        const aImg = btn.getAttribute('data-after-image');

        form.action = `/admin/development/${id}`;
        formMethod.value = "PUT";
        modalTitle.innerHTML = '<i class="fa-solid fa-pen-to-square text-primary"></i> Edit Development Project';
        modalSubtitle.textContent = 'Modify existing development project specifications';

        // Populate fields
        titleEn.value = tEn || '';
        titleGu.value = tGu || '';
        titleHi.value = tHi || '';
        locationInput.value = loc || '';
        descEn.value = dEn || '';
        descGu.value = dGu || '';
        descHi.value = dHi || '';

        // Clear files
        document.getElementById('before_image').value = '';
        document.getElementById('after_image').value = '';
        currentBeforeImage = bImg || null;
        currentAfterImage = aImg || null;

        resetPreviewVisuals('before-preview-img', 'before-empty-state', 'before-preview-container', 'before-clear-btn', 'before-current-badge', currentBeforeImage);
        resetPreviewVisuals('after-preview-img', 'after-empty-state', 'after-preview-container', 'after-clear-btn', 'after-current-badge', currentAfterImage);

        modal.showModal();
    };

    // Close Modal
    window.closeProjectModal = function() {
        modal.close();
    };

    // Event delegation for Edit button inside dynamic templates
    document.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-project-btn');
        if (editBtn) {
            e.preventDefault();
            openEditModal(editBtn);
        }
    });
});
</script>
@endsection
