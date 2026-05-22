@extends('layouts.admin')

@section('title', 'Gallery Management - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">Gallery Management</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Upload and manage ward photo gallery</p>
    </div>
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

<!-- Upload Form Card -->
<div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6">
    <h2 class="font-heading font-bold text-lg text-base-content mb-5 flex items-center gap-2">
        <i class="fa-solid fa-cloud-arrow-up text-primary"></i> Upload New Image
    </h2>
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Image Upload -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Image File *</span></label>
                <input type="file" name="image" accept="image/*" required class="file-input file-input-bordered file-input-primary w-full rounded-xl bg-transparent border-base-300" />
            </div>
            <!-- Category -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Category *</span></label>
                <select name="category" required class="select select-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content">
                    <option value="">Select Category</option>
                    <option value="visits">Ward Visits</option>
                    <option value="events">BJP Events</option>
                    <option value="works">Development Works</option>
                    <option value="community">Community Programs</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="form-control">
                <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Caption (English)</span></label>
                <input type="text" name="caption_en" placeholder="English caption" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" />
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Caption (ગુજરાતી)</span></label>
                <input type="text" name="caption_gu" placeholder="Gujarati caption" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" />
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text font-bold text-xs text-base-content/75 uppercase tracking-wider">Caption (हिंदी)</span></label>
                <input type="text" name="caption_hi" placeholder="Hindi caption" class="input input-bordered rounded-xl bg-transparent border-base-300 w-full text-base-content" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary text-white font-bold rounded-xl gap-2">
            <i class="fa-solid fa-upload"></i> Upload Image
        </button>
    </form>
</div>

<!-- Gallery Grid -->
<div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 mt-6">
    <h2 class="font-heading font-bold text-lg text-base-content mb-5 flex items-center gap-2">
        <i class="fa-solid fa-images text-primary"></i> Current Gallery <span class="badge badge-neutral text-white ml-2 text-xs py-2.5">{{ $images->total() }}</span>
    </h2>

    @if($images->isEmpty())
        <p class="text-center text-base-content/50 italic py-8 text-sm">No gallery images uploaded yet.</p>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($images as $img)
                <div class="relative group rounded-xl overflow-hidden border border-base-300 bg-base-200 aspect-square">
                    <img src="{{ asset($img->image_path) }}" alt="{{ $img->caption }}" class="object-cover w-full h-full" loading="lazy" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=Gallery&backgroundColor=d1d5db&textColor=1f2937'">
                    <!-- Overlay with delete -->
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col items-center justify-center gap-2 p-2">
                        <span class="badge badge-primary text-white text-[10px] font-bold uppercase py-2">{{ $img->category }}</span>
                        @if($img->caption)
                            <p class="text-white text-[10px] text-center leading-tight line-clamp-2">{{ $img->caption }}</p>
                        @endif
                        <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-error text-white rounded-lg mt-1">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($images->hasPages())
            <div class="flex justify-center pt-6">
                {{ $images->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
