<dialog id="gallery_viewer_modal" class="modal modal-middle z-50">
    <div class="modal-box w-11/12 max-w-4xl p-0 overflow-hidden rounded-3xl shadow-2xl bg-base-100 border border-base-300">
        <!-- Close button (top-right) -->
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3 z-50 bg-base-300/80 backdrop-blur-sm hover:bg-error hover:text-white transition-all">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </form>

        <!-- Lightbox Main Frame (Image with Navigation Chevrons) -->
        <div class="relative w-full aspect-[4/3] sm:aspect-[16/10] bg-neutral flex items-center justify-center group/lightbox">
            <img id="viewer-lightbox-img" src="" class="max-w-full max-h-full object-contain select-none" alt="Gallery Lightbox Image" onerror="this.onerror=null; this.src='/images/before_road.jpg';">
            
            <!-- Left Control Button -->
            <button onclick="navigateGalleryViewer(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost bg-black/30 text-white hover:bg-primary border-none shadow-md" aria-label="Previous Photo">
                <i class="fa-solid fa-chevron-left text-lg"></i>
            </button>

            <!-- Right Control Button -->
            <button onclick="navigateGalleryViewer(1)" class="absolute right-4 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost bg-black/30 text-white hover:bg-primary border-none shadow-md" aria-label="Next Photo">
                <i class="fa-solid fa-chevron-right text-lg"></i>
            </button>
        </div>

        <!-- Meta Section underneath the image -->
        <div class="p-6 bg-base-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t border-base-300">
            <div class="space-y-1 flex-1">
                <span id="viewer-lightbox-category" class="badge badge-primary font-bold uppercase tracking-widest text-[10px]"></span>
                <h3 id="viewer-lightbox-caption" class="font-heading font-extrabold text-lg text-base-content leading-snug"></h3>
            </div>
            <!-- Close Dialog button -->
            <form method="dialog" class="shrink-0">
                <button class="btn btn-sm btn-outline hover:bg-neutral hover:text-white rounded-xl gap-1">
                    <i class="fa-solid fa-circle-xmark"></i> Close
                </button>
            </form>
        </div>
    </div>
    <!-- Backdrop click closes modal -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentViewerIndex = 0;
    let viewerItemSelector = '.gallery-viewer-item';

    window.openGalleryViewer = function (elementOrIndex, customSelector = '.gallery-viewer-item') {
        viewerItemSelector = customSelector;
        const visibleItems = Array.from(document.querySelectorAll(`${viewerItemSelector}:not(.hidden)`));
        
        // Show/hide navigation chevrons based on item count
        const navButtons = document.querySelectorAll('#gallery_viewer_modal button[onclick^="navigateGalleryViewer"]');
        if (visibleItems.length > 1) {
            navButtons.forEach(btn => btn.classList.remove('hidden'));
        } else {
            navButtons.forEach(btn => btn.classList.add('hidden'));
        }

        if (visibleItems.length === 0) return;

        let targetElement = null;
        if (typeof elementOrIndex === 'number') {
            targetElement = visibleItems[elementOrIndex];
        } else {
            targetElement = elementOrIndex;
        }

        if (!targetElement) return;

        currentViewerIndex = visibleItems.indexOf(targetElement);
        
        const src = targetElement.dataset.image || targetElement.dataset.src || '';
        const cat = targetElement.dataset.categoryLabel || targetElement.dataset.category || '';
        const cap = targetElement.dataset.caption || '';
        updateViewerContent(src, cat, cap);

        const modal = document.getElementById('gallery_viewer_modal');
        if (modal) modal.showModal();
    };

    window.openGalleryViewerDirect = function (src, category = '', caption = '') {
        // Hide navigation chevrons for single direct views
        const navButtons = document.querySelectorAll('#gallery_viewer_modal button[onclick^="navigateGalleryViewer"]');
        navButtons.forEach(btn => btn.classList.add('hidden'));

        updateViewerContent(src, category, caption);

        const modal = document.getElementById('gallery_viewer_modal');
        if (modal) modal.showModal();
    };

    window.navigateGalleryViewer = function (direction) {
        const visibleItems = Array.from(document.querySelectorAll(`${viewerItemSelector}:not(.hidden)`));
        if (visibleItems.length === 0) return;

        currentViewerIndex = (currentViewerIndex + direction + visibleItems.length) % visibleItems.length;
        const nextItem = visibleItems[currentViewerIndex];
        
        const src = nextItem.dataset.image || nextItem.dataset.src || '';
        const cat = nextItem.dataset.categoryLabel || nextItem.dataset.category || '';
        const cap = nextItem.dataset.caption || '';
        updateViewerContent(src, cat, cap);
    };

    function updateViewerContent(src, category, caption) {
        const img = document.getElementById('viewer-lightbox-img');
        const cap = document.getElementById('viewer-lightbox-caption');
        const cat = document.getElementById('viewer-lightbox-category');

        if (img) img.src = src || '';
        if (cap) cap.textContent = caption || '';
        if (cat) {
            if (category) {
                cat.textContent = category;
                cat.classList.remove('hidden');
            } else {
                cat.classList.add('hidden');
            }
        }
    }

    // Support Arrow keys for Lightbox navigation
    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('gallery_viewer_modal');
        if (modal && modal.open) {
            if (e.key === 'ArrowLeft') {
                navigateGalleryViewer(-1);
            } else if (e.key === 'ArrowRight') {
                navigateGalleryViewer(1);
            }
        }
    });
});
</script>
