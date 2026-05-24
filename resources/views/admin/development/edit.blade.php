@extends('layouts.admin')

@section('title', 'Edit Development Project - Admin Portal')

@section('content')
<div class="flex items-center gap-4">
    <a href="{{ route('admin.development.index') }}" class="btn btn-sm btn-ghost gap-1.5 text-base-content/70 hover:text-primary rounded-lg">
        <i class="fa-solid fa-arrow-left-long"></i> Back to Projects
    </a>
    <div>
        <h1 class="font-heading font-extrabold text-2xl text-base-content">Edit Project</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider">{{ $development->title_en }}</p>
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
    <form action="{{ route('admin.development.update', $development) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title Fields -->
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-2">
                <i class="fa-solid fa-heading text-primary mr-1.5"></i> Project Title
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- English input -->
                <div class="form-control relative">
                    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                    <x-float-input 
                        type="text" 
                        name="title_en" 
                        label="Title (English)" 
                        value="{{ old('title_en', $development->title_en) }}" 
                        required="true"
                    />
                </div>
                <!-- Gujarati input -->
                <div class="form-control relative">
                    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                    <x-float-input 
                        type="text" 
                        name="title_gu" 
                        label="Title (ગુજરાતી)" 
                        value="{{ old('title_gu', $development->title_gu) }}"
                    />
                </div>
                <!-- Hindi input -->
                <div class="form-control relative">
                    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                    <x-float-input 
                        type="text" 
                        name="title_hi" 
                        label="Title (हिंदी)" 
                        value="{{ old('title_hi', $development->title_hi) }}"
                    />
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="form-control">
            <x-float-input 
                type="text" 
                name="location" 
                label="Location / Area" 
                value="{{ old('location', $development->location) }}" 
                required="true"
            />
        </div>

        <!-- Description Fields -->
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-2">
                <i class="fa-solid fa-align-left text-primary mr-1.5"></i> Description
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- English description -->
                <div class="form-control relative">
                    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                    <label class="floating-label w-full block">
                        <span>Description (English) <span class="text-error font-extrabold">*</span></span>
                        <textarea 
                            name="description_en" 
                            id="description_en" 
                            required 
                            rows="3" 
                            placeholder="Description (English)"
                            class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-28"
                        >{{ old('description_en', $development->description_en) }}</textarea>
                    </label>
                </div>
                <!-- Gujarati description -->
                <div class="form-control relative">
                    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                    <label class="floating-label w-full block">
                        <span>Description (ગુજરાતી)</span>
                        <textarea 
                            name="description_gu" 
                            id="description_gu" 
                            rows="3" 
                            placeholder="Description (ગુજરાતી)"
                            class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-28"
                        >{{ old('description_gu', $development->description_gu) }}</textarea>
                    </label>
                </div>
                <!-- Hindi description -->
                <div class="form-control relative">
                    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                    <label class="floating-label w-full block">
                        <span>Description (हिंदी)</span>
                        <textarea 
                            name="description_hi" 
                            id="description_hi" 
                            rows="3" 
                            placeholder="Description (हिंदी)"
                            class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-28"
                        >{{ old('description_hi', $development->description_hi) }}</textarea>
                    </label>
                </div>
            </div>
        </div>

        <!-- Before / After Images -->
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-base-content border-b border-base-300 pb-2">
                <i class="fa-solid fa-images text-primary mr-1.5"></i> Before / After Images
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Before Image Input & Preview -->
                <div class="space-y-3">
                    <label class="label pb-0">
                        <span class="label-text font-bold text-xs text-base-content/70 uppercase tracking-wider">Before Image</span>
                    </label>
                    
                    <!-- Premium Preview Card -->
                    <div id="before-preview-container" class="relative group aspect-video w-full rounded-2xl overflow-hidden border {{ $development->before_image ? 'border-solid' : 'border-dashed' }} border-base-300 bg-base-200/50 flex flex-col items-center justify-center transition-all duration-300 hover:border-primary/40">
                        @if($development->before_image)
                            <!-- Existing state -->
                            <img id="before-preview-img" src="{{ asset($development->before_image) }}" class="w-full h-full object-cover rounded-2xl" alt="Before Preview">
                            <div id="before-empty-state" class="hidden flex flex-col items-center gap-2 p-6 text-center text-base-content/40 transition-opacity">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-primary/60"></i>
                                <div class="text-xs font-semibold">No before image selected</div>
                            </div>
                            <span class="absolute bottom-3 left-3 z-10 badge badge-sm bg-neutral/80 text-white font-semibold backdrop-blur-sm border-none">Current Image</span>
                        @else
                            <!-- Empty state -->
                            <div id="before-empty-state" class="flex flex-col items-center gap-2 p-6 text-center text-base-content/40 transition-opacity">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-primary/60"></i>
                                <div class="text-xs font-semibold">No before image selected</div>
                                <div class="text-[10px]">JPEG, PNG, JPG, WEBP up to 5MB</div>
                            </div>
                            <img id="before-preview-img" class="hidden w-full h-full object-cover rounded-2xl" alt="Before Preview">
                        @endif
                        <!-- Floating clear button if selected -->
                        <button type="button" id="before-clear-btn" class="hidden absolute top-3 right-3 btn btn-circle btn-xs btn-error text-white shadow-md hover:scale-105 transition-all">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <input type="file" name="before_image" id="before_image" accept="image/*" class="file-input file-input-bordered file-input-warning w-full rounded-xl bg-transparent border-base-300">
                </div>

                <!-- After Image Input & Preview -->
                <div class="space-y-3">
                    <label class="label pb-0">
                        <span class="label-text font-bold text-xs text-base-content/70 uppercase tracking-wider">After Image</span>
                    </label>

                    <!-- Premium Preview Card -->
                    <div id="after-preview-container" class="relative group aspect-video w-full rounded-2xl overflow-hidden border {{ $development->after_image ? 'border-solid' : 'border-dashed' }} border-base-300 bg-base-200/50 flex flex-col items-center justify-center transition-all duration-300 hover:border-primary/40">
                        @if($development->after_image)
                            <!-- Existing state -->
                            <img id="after-preview-img" src="{{ asset($development->after_image) }}" class="w-full h-full object-cover rounded-2xl" alt="After Preview">
                            <div id="after-empty-state" class="hidden flex flex-col items-center gap-2 p-6 text-center text-base-content/40 transition-opacity">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-success/60"></i>
                                <div class="text-xs font-semibold">No after image selected</div>
                            </div>
                            <span class="absolute bottom-3 left-3 z-10 badge badge-sm bg-neutral/80 text-white font-semibold backdrop-blur-sm border-none">Current Image</span>
                        @else
                            <!-- Empty state -->
                            <div id="after-empty-state" class="flex flex-col items-center gap-2 p-6 text-center text-base-content/40 transition-opacity">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-success/60"></i>
                                <div class="text-xs font-semibold">No after image selected</div>
                                <div class="text-[10px]">JPEG, PNG, JPG, WEBP up to 5MB</div>
                            </div>
                            <img id="after-preview-img" class="hidden w-full h-full object-cover rounded-2xl" alt="After Preview">
                        @endif
                        <!-- Floating clear button if selected -->
                        <button type="button" id="after-clear-btn" class="hidden absolute top-3 right-3 btn btn-circle btn-xs btn-error text-white shadow-md hover:scale-105 transition-all">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <input type="file" name="after_image" id="after_image" accept="image/*" class="file-input file-input-bordered file-input-success w-full rounded-xl bg-transparent border-base-300">
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn btn-primary text-white font-bold rounded-xl gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
            <a href="{{ route('admin.development.index') }}" class="btn btn-ghost border border-base-300 rounded-xl">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupImagePreview(inputId, imgId, emptyId, containerId, clearId, originalSrc) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);
        const empty = document.getElementById(emptyId);
        const container = document.getElementById(containerId);
        const clearBtn = document.getElementById(clearId);

        // Find the "Current Image" badge if it exists inside this container
        const currentBadge = container.querySelector('.badge');

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
                    if (currentBadge) currentBadge.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        clearBtn.addEventListener('click', function() {
            input.value = '';
            if (originalSrc) {
                img.src = originalSrc;
                img.classList.remove('hidden');
                empty.classList.add('hidden');
                clearBtn.classList.add('hidden');
                container.classList.remove('border-dashed');
                container.classList.add('border-solid');
                if (currentBadge) currentBadge.classList.remove('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                empty.classList.remove('hidden');
                clearBtn.classList.add('hidden');
                container.classList.add('border-dashed');
                container.classList.remove('border-solid');
                if (currentBadge) currentBadge.classList.add('hidden');
            }
        });
    }

    setupImagePreview(
        'before_image', 
        'before-preview-img', 
        'before-empty-state', 
        'before-preview-container', 
        'before-clear-btn',
        {!! $development->before_image ? "'" . asset($development->before_image) . "'" : 'null' !!}
    );
    setupImagePreview(
        'after_image', 
        'after-preview-img', 
        'after-empty-state', 
        'after-preview-container', 
        'after-clear-btn',
        {!! $development->after_image ? "'" . asset($development->after_image) . "'" : 'null' !!}
    );
});
</script>
@endsection
