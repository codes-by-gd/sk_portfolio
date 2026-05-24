@foreach($images as $img)
    <div class="relative group rounded-2xl overflow-hidden border border-base-300 bg-base-200 aspect-square card-base">
        <!-- Category Badge (Top-Left - Always Visible) -->
        <span class="absolute top-2.5 left-2.5 z-20 badge badge-xs bg-primary border-primary text-white font-bold uppercase py-2.5 px-3 shadow-md shadow-primary/20 select-none">
            {{ $img->category }}
        </span>

        <!-- Edit/Delete Action Buttons (Top-Right - Visible ONLY on Hover) -->
        <div class="absolute top-2.5 right-2.5 z-30 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <button type="button" 
                class="btn btn-sm btn-square btn-soft btn-info edit-gallery-btn tooltip tooltip-top shadow-md" 
                data-tip="Edit Details"
                data-id="{{ $img->id }}"
                data-category="{{ $img->category }}"
                data-image-path="{{ asset($img->image_path) }}"
                data-caption-en="{{ $img->caption_en }}"
                data-caption-gu="{{ $img->caption_gu }}"
                data-caption-hi="{{ $img->caption_hi }}"
            >
                <i class="fa-solid fa-pen text-xs"></i>
            </button>
            <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-square btn-soft btn-error tooltip tooltip-top shadow-md" data-tip="Delete Image">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </form>
        </div>

        <!-- Image Container (Clickable to View Full Size) -->
        <div class="relative w-full h-full bg-base-300/40 cursor-zoom-in"
             onclick="openViewerModal('{{ asset($img->image_path) }}', '{{ $img->category }}', '{{ $img->caption }}')">
            
            <img src="{{ asset($img->image_path) }}" 
                 alt="{{ $img->caption }}" 
                 class="object-cover w-full h-full transition-opacity duration-300 opacity-0" 
                 loading="lazy"
                 onload="this.classList.remove('opacity-0')"
                 onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
            >
            <!-- Native Premium Fallback Placeholder -->
            <div class="hidden absolute inset-0 bg-base-300 flex flex-col items-center justify-center text-base-content/30 gap-1.5 p-2">
                <i class="fa-regular fa-image text-2xl text-base-content/40 animate-pulse"></i>
                <span class="text-[9px] font-bold uppercase tracking-wider text-center">Image Error</span>
            </div>

            <!-- Central Zoom Icon on Hover -->
            <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center z-10">
                <i class="fa-solid fa-magnifying-glass-plus text-white text-xl drop-shadow-md"></i>
            </div>
        </div>

        <!-- Caption Overlay (Bottom - Always Visible Overlay on Image) -->
        <div class="absolute bottom-0 inset-x-0 z-20 bg-gradient-to-t from-black/90 via-black/50 to-transparent p-3.5 pt-8 pointer-events-none select-none">
            <p class="text-white text-[10px] leading-snug font-medium line-clamp-2">
                {{ $img->caption ?: 'No caption provided.' }}
            </p>
        </div>
    </div>
@endforeach
