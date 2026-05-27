@extends('layouts.admin')

@section('title', 'Gallery Management - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">Gallery Management</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Upload and manage ward photo gallery</p>
    </div>
    <button type="button" onclick="openAddModal()" class="btn btn-primary text-white font-bold rounded-xl gap-2 shadow-md">
        <i class="fa-solid fa-plus text-base"></i> Add New Image
    </button>
</div>

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

<!-- Search and Filters Row -->
<div class="bg-base-100 card-base border border-base-300 rounded-2xl p-3.5 shadow-sm mt-6">
    <form action="{{ route('admin.gallery.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 w-full items-center">
        <!-- Search input -->
        <div class="relative w-full sm:flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search gallery by caption or category..."
                class="input input-sm input-bordered w-full pl-8 rounded-xl bg-transparent border-base-300 focus:outline-none focus:border-primary text-xs text-base-content" />
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 text-xs"></i>
        </div>

        <!-- Category Filter -->
        <select name="category" class="select select-sm select-bordered rounded-xl bg-base-100 border-base-300 focus:outline-none focus:border-primary text-xs text-base-content w-full sm:w-[160px] shrink-0">
            <option value="">All Categories</option>
            <option value="visits" {{ request('category') === 'visits' ? 'selected' : '' }}>Ward Visits</option>
            <option value="events" {{ request('category') === 'events' ? 'selected' : '' }}>BJP Events</option>
            <option value="works" {{ request('category') === 'works' ? 'selected' : '' }}>Development Works</option>
            <option value="community" {{ request('category') === 'community' ? 'selected' : '' }}>Community Programs</option>
        </select>

        <!-- Action buttons -->
        <div class="flex gap-1.5 w-full sm:w-auto shrink-0">
            <button type="submit" class="btn btn-sm btn-secondary text-white font-bold rounded-xl px-4 text-xs w-full sm:w-auto">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'category']))
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-ghost border border-base-300 hover:bg-base-200 rounded-xl px-3 text-xs w-full sm:w-auto flex items-center justify-center">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Gallery Modal -->
<dialog id="gallery-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-2xl shadow-xl max-w-2xl p-6 relative">
        <!-- Close Button -->
        <button type="button" onclick="closeGalleryModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <!-- ESC shortcut label -->
        <div class="absolute right-14 top-5 text-[9px] opacity-40 font-bold hidden sm:block">
            <kbd class="kbd kbd-sm bg-base-200">ESC</kbd>
        </div>

        <h3 id="modal-title" class="font-heading font-extrabold text-xl text-base-content mb-1 flex items-center gap-2">
            <i class="fa-solid fa-images text-primary"></i> Upload New Image
        </h3>
        <p id="modal-subtitle" class="text-xs text-base-content/50 uppercase tracking-wider font-bold mb-6">Add a new photo to the ward gallery</p>

        <form id="gallery-form" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <!-- Method placeholder toggled between POST and PUT via JS -->
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="flex flex-col sm:flex-row gap-5 items-stretch bg-base-200/40 p-4 rounded-2xl border border-base-300">
                <!-- Compact Preview Card (Left) -->
                <div id="gallery-preview-container" class="relative group w-32 h-32 shrink-0 rounded-xl overflow-hidden border border-dashed border-base-300 bg-base-100 flex flex-col items-center justify-center transition-all duration-300 hover:border-primary/40">
                    <!-- Default empty state -->
                    <div id="gallery-empty-state" class="flex flex-col items-center gap-1 p-2 text-center text-base-content/40 transition-opacity">
                        <i class="fa-solid fa-cloud-arrow-up text-xl text-primary/60"></i>
                        <div class="text-[10px] font-semibold">Select image</div>
                        <div class="text-[8px]">JPEG, PNG, WEBP</div>
                    </div>
                    <!-- Preview Image Tag -->
                    <img id="gallery-preview-img" class="hidden w-full h-full object-cover rounded-xl" alt="Gallery Preview">
                    <!-- Floating clear button if selected -->
                    <button type="button" id="gallery-clear-btn" class="hidden absolute top-1 right-1 btn btn-circle btn-xs btn-error text-white shadow-md hover:scale-105 transition-all w-5 h-5 min-h-0">
                        <i class="fa-solid fa-xmark text-[9px]"></i>
                    </button>
                </div>

                <!-- File and Category Stack (Right) -->
                <div class="flex-grow w-full flex flex-col justify-between gap-3">
                    <!-- File Input -->
                    <div class="form-control w-full">
                        <label class="label py-0 pb-1">
                            <span class="label-text font-bold text-[10px] text-base-content/75 uppercase tracking-wider">Image File <span class="text-error font-extrabold" id="image-required-star">*</span></span>
                        </label>
                        <input type="file" name="image" id="image_upload" accept="image/*" class="file-input file-input-bordered file-input-primary file-input-sm w-full rounded-xl bg-transparent border-base-300" />
                    </div>
                    
                    <!-- Category -->
                    <div class="form-control w-full">
                        <label class="floating-label w-full block relative">
                            <select 
                                id="gallery-category"
                                name="category" 
                                required 
                                class="select select-sm w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10"
                            >
                                <option value="" disabled selected>Select Category</option>
                                <option value="visits">Ward Visits</option>
                                <option value="events">BJP Events</option>
                                <option value="works">Development Works</option>
                                <option value="community">Community Programs</option>
                            </select>
                            <span>
                                Category
                                <span class="text-error font-extrabold">*</span>
                            </span>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-1.5 text-base-content/50">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Multilingual Captions -->
            <div class="space-y-3">
                <h3 class="font-heading font-bold text-xs text-base-content/75 uppercase tracking-wider">
                    Captions / Descriptions
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- English Caption -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                        <x-float-input 
                            type="text" 
                            name="caption_en" 
                            id="gallery-caption-en"
                            label="Caption (English)" 
                        />
                    </div>
                    <!-- Gujarati Caption -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                        <x-float-input 
                            type="text" 
                            name="caption_gu" 
                            id="gallery-caption-gu"
                            label="Caption (ગુજરાતી)" 
                        />
                    </div>
                    <!-- Hindi Caption -->
                    <div class="form-control relative">
                        <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                        <x-float-input 
                            type="text" 
                            name="caption_hi" 
                            id="gallery-caption-hi"
                            label="Caption (हिंदी)" 
                        />
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2.5 pt-4 border-t border-base-300 mt-6">
                <button type="button" onclick="closeGalleryModal()" class="btn btn-ghost hover:bg-base-200 rounded-xl px-5 text-sm font-semibold">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary text-white font-bold rounded-xl px-6 shadow-md gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Save Image
                </button>
            </div>
        </form>
    </div>
    <!-- Backdrop to close natively on click -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<!-- Gallery Grid -->
<div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 mt-6">
    <h2 class="font-heading font-bold text-lg text-base-content mb-5 flex items-center gap-2">
        <i class="fa-solid fa-images text-primary"></i> Current Gallery <span class="badge badge-neutral text-white ml-2 text-xs py-2.5">{{ $images->total() }}</span>
    </h2>

    @if($images->isEmpty())
        <p class="text-center text-base-content/50 italic py-8 text-sm">No gallery images uploaded yet.</p>
    @else
        <div id="gallery-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @include('admin.gallery.partials.items')
        </div>

        <!-- Sentinel element for Infinite Scroll -->
        <div id="scroll-sentinel" class="w-full flex flex-col items-center justify-center py-6 mt-4 min-h-[64px]">
            <div id="scroll-loading" class="hidden loading loading-spinner loading-md text-primary"></div>
            <div id="scroll-no-more" class="hidden text-xs text-base-content/40 font-semibold italic">No more images to load</div>
        </div>
    @endif
</div>

<!-- Reusable Lightbox Viewer Modal -->
<x-gallery-lightbox />

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('gallery-modal');
    const form = document.getElementById('gallery-form');
    const formMethod = document.getElementById('form-method');
    const modalTitle = document.getElementById('modal-title');
    const modalSubtitle = document.getElementById('modal-subtitle');
    const imageRequiredStar = document.getElementById('image-required-star');

    const input = document.getElementById('image_upload');
    const img = document.getElementById('gallery-preview-img');
    const empty = document.getElementById('gallery-empty-state');
    const container = document.getElementById('gallery-preview-container');
    const clearBtn = document.getElementById('gallery-clear-btn');

    const categorySelect = document.getElementById('gallery-category');
    const captionEnInput = document.getElementById('gallery-caption-en');
    const captionGuInput = document.getElementById('gallery-caption-gu');
    const captionHiInput = document.getElementById('gallery-caption-hi');

    let currentDatabaseImage = null;

    // File input change preview
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
            }
            reader.readAsDataURL(file);
        }
    });

    // Clear file selection
    clearBtn.addEventListener('click', function() {
        input.value = '';
        if (currentDatabaseImage) {
            // Revert back to original database image
            img.src = currentDatabaseImage;
            img.classList.remove('hidden');
            empty.classList.add('hidden');
            clearBtn.classList.add('hidden'); // hide clear as it matches initial DB state
            container.classList.remove('border-dashed');
            container.classList.add('border-solid');
        } else {
            // Revert to empty state
            img.src = '';
            img.classList.add('hidden');
            empty.classList.remove('hidden');
            clearBtn.classList.add('hidden');
            container.classList.add('border-dashed');
            container.classList.remove('border-solid');
        }
    });

    // Open Modal for Add
    window.openAddModal = function() {
        form.action = "{{ route('admin.gallery.store') }}";
        formMethod.value = "POST";
        modalTitle.innerHTML = '<i class="fa-solid fa-cloud-arrow-up text-primary"></i> Upload New Image';
        modalSubtitle.textContent = 'Add a new photo to the ward gallery';
        
        // Reset Inputs
        input.value = '';
        input.required = true;
        imageRequiredStar.classList.remove('hidden');
        categorySelect.value = '';
        captionEnInput.value = '';
        captionGuInput.value = '';
        captionHiInput.value = '';

        currentDatabaseImage = null;

        // Reset Preview
        img.src = '';
        img.classList.add('hidden');
        empty.classList.remove('hidden');
        clearBtn.classList.add('hidden');
        container.classList.add('border-dashed');
        container.classList.remove('border-solid');

        modal.showModal();
    };

    // Open Modal for Edit
    window.openEditModal = function(btn) {
        const id = btn.getAttribute('data-id');
        const category = btn.getAttribute('data-category');
        const imagePath = btn.getAttribute('data-image-path');
        const captionEn = btn.getAttribute('data-caption-en');
        const captionGu = btn.getAttribute('data-caption-gu');
        const captionHi = btn.getAttribute('data-caption-hi');

        form.action = `/admin/gallery/${id}`;
        formMethod.value = "PUT";
        modalTitle.innerHTML = '<i class="fa-solid fa-pen-to-square text-primary"></i> Edit Gallery Image';
        modalSubtitle.textContent = 'Modify existing photo category and caption details';

        // Fill Inputs
        input.value = '';
        input.required = false;
        imageRequiredStar.classList.add('hidden');
        categorySelect.value = category;
        captionEnInput.value = captionEn || '';
        captionGuInput.value = captionGu || '';
        captionHiInput.value = captionHi || '';

        currentDatabaseImage = imagePath;

        // Load Database Image Preview
        img.src = imagePath;
        img.classList.remove('hidden');
        empty.classList.add('hidden');
        clearBtn.classList.add('hidden'); // start hidden, since it is the initial DB image state
        container.classList.remove('border-dashed');
        container.classList.add('border-solid');

        modal.showModal();
    };

    // Close Modal
    window.closeGalleryModal = function() {
        modal.close();
    };

    // Event delegation for Edit buttons inside hover overlays
    document.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-gallery-btn');
        if (editBtn) {
            e.preventDefault();
            openEditModal(editBtn);
        }
    });

    // Infinite Scroll Intersection Observer
    const sentinel = document.getElementById('scroll-sentinel');
    const loadingSpinner = document.getElementById('scroll-loading');
    const noMoreMsg = document.getElementById('scroll-no-more');
    const grid = document.getElementById('gallery-grid');

    let nextPageUrl = "{{ $images->nextPageUrl() }}";
    let isScrollLoading = false;

    if (sentinel && nextPageUrl) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isScrollLoading && nextPageUrl) {
                    loadMoreImages();
                }
            });
        }, {
            rootMargin: '150px'
        });

        observer.observe(sentinel);

        function loadMoreImages() {
            isScrollLoading = true;
            loadingSpinner.classList.remove('hidden');

            fetch(nextPageUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                nextPageUrl = res.headers.get('X-Next-Page');
                return res.text();
            })
            .then(html => {
                if (html.trim()) {
                    grid.insertAdjacentHTML('beforeend', html);
                }
                
                isScrollLoading = false;
                loadingSpinner.classList.add('hidden');

                if (!nextPageUrl) {
                    noMoreMsg.classList.remove('hidden');
                    observer.unobserve(sentinel);
                }
            })
            .catch(err => {
                console.error("Infinite scroll error:", err);
                isScrollLoading = false;
                loadingSpinner.classList.add('hidden');
            });
        }
    } else if (sentinel) {
        noMoreMsg.classList.remove('hidden');
    }


});
</script>
@endsection
