@extends('layouts.admin')

@section('title', 'Edit Development Project - Admin Portal')

@section('content')
<div class="flex items-center gap-4">
    <a href="{{ route('admin.development.index') }}" class="btn btn-sm btn-ghost gap-1.5 text-neutral/70 hover:text-primary rounded-lg">
        <i class="fa-solid fa-arrow-left-long"></i> Back to Projects
    </a>
    <div>
        <h1 class="font-heading font-extrabold text-2xl text-neutral">Edit Project</h1>
        <p class="text-xs text-neutral/50 font-bold uppercase tracking-wider">{{ $development->title_en }}</p>
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

<div class="bg-[#FFFDF8] border border-base-300 rounded-2xl shadow-sm p-6 sm:p-8">
    <form action="{{ route('admin.development.update', $development) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title Fields -->
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-neutral border-b border-base-300 pb-2">
                <i class="fa-solid fa-heading text-primary mr-1.5"></i> Project Title
            </h3>
            <div class="form-control">
                <x-float-input 
                    type="text" 
                    name="title_en" 
                    label="Title (English)" 
                    value="{{ old('title_en', $development->title_en) }}" 
                    required="true"
                />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <x-float-input 
                        type="text" 
                        name="title_gu" 
                        label="Title (ગુજરાતી)" 
                        value="{{ old('title_gu', $development->title_gu) }}"
                    />
                </div>
                <div class="form-control">
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
            <h3 class="font-heading font-bold text-base text-neutral border-b border-base-300 pb-2">
                <i class="fa-solid fa-align-left text-primary mr-1.5"></i> Description
            </h3>
            <div class="form-control">
                <label class="floating-label w-full block">
                    <span>Description (English) <span class="text-error font-extrabold">*</span></span>
                    <textarea 
                        name="description_en" 
                        id="description_en" 
                        required 
                        rows="3" 
                        placeholder="Description (English)"
                        class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"
                    >{{ old('description_en', $development->description_en) }}</textarea>
                </label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="floating-label w-full block">
                        <span>Description (ગુજરાતી)</span>
                        <textarea 
                            name="description_gu" 
                            id="description_gu" 
                            rows="3" 
                            placeholder="Description (ગુજરાતી)"
                            class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"
                        >{{ old('description_gu', $development->description_gu) }}</textarea>
                    </label>
                </div>
                <div class="form-control">
                    <label class="floating-label w-full block">
                        <span>Description (हिंदी)</span>
                        <textarea 
                            name="description_hi" 
                            id="description_hi" 
                            rows="3" 
                            placeholder="Description (हिंदी)"
                            class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-24"
                        >{{ old('description_hi', $development->description_hi) }}</textarea>
                    </label>
                </div>
            </div>
        </div>

        <!-- Before / After Images -->
        <div class="space-y-3">
            <h3 class="font-heading font-bold text-base text-neutral border-b border-base-300 pb-2">
                <i class="fa-solid fa-images text-primary mr-1.5"></i> Before / After Images
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    @if($development->before_image)
                        <div class="flex items-center gap-3 p-3 bg-base-200 rounded-xl">
                            <img src="{{ asset($development->before_image) }}" class="w-14 h-14 object-cover rounded-lg border border-base-300">
                            <span class="text-xs text-neutral/70 font-medium">Current Before Image</span>
                        </div>
                    @endif
                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-xs text-neutral/70 uppercase tracking-wider">{{ $development->before_image ? 'Replace Before Image' : 'Before Image' }}</span></label>
                        <input type="file" name="before_image" accept="image/*" class="file-input file-input-bordered file-input-warning w-full rounded-xl bg-transparent border-base-300">
                    </div>
                </div>
                <div class="space-y-2">
                    @if($development->after_image)
                        <div class="flex items-center gap-3 p-3 bg-base-200 rounded-xl">
                            <img src="{{ asset($development->after_image) }}" class="w-14 h-14 object-cover rounded-lg border border-base-300">
                            <span class="text-xs text-neutral/70 font-medium">Current After Image</span>
                        </div>
                    @endif
                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-xs text-neutral/70 uppercase tracking-wider">{{ $development->after_image ? 'Replace After Image' : 'After Image' }}</span></label>
                        <input type="file" name="after_image" accept="image/*" class="file-input file-input-bordered file-input-success w-full rounded-xl bg-transparent border-base-300">
                    </div>
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
@endsection
