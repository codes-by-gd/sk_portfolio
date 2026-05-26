@extends('layouts.app')

@section('title', 'Feedback Survey — Sachin Khandelwal, Ward 7')
@section('meta_description', 'Submit your detailed feedback, share development concerns and rate ward services for Sachin Khandelwal, Corporator & BJP Adhyaksh, Vadodara Ward No. 7.')

@section('content')
<section class="py-12 bg-gradient-to-b from-base-100 via-base-100 to-base-200 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Breadcrumb / Back button -->
        <div class="flex justify-start">
            <a href="{{ route('home') }}" class="btn btn-sm btn-ghost gap-1.5 text-base-content/70 hover:text-primary rounded-lg">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Homepage
            </a>
        </div>

        <!-- Two-column grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: Approved Feedbacks Listing (order-2 lg:order-1) -->
            <div class="lg:col-span-7 order-2 lg:order-1 space-y-8">
                <div class="text-center lg:text-left space-y-2">
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-base-content">
                        {{ __('messages.sections.approved_list_title') }}
                      </h2>
                    <p class="text-xs sm:text-sm text-base-content/60">Verified feedback and testimonials from citizens of Ward No. 7</p>
                    <div class="w-16 h-1 bg-primary lg:mx-0 mx-auto mt-2 rounded-full"></div>
                </div>

                <div id="feedback-listing-container">
                    @include('partials.feedback-list-container')
                </div>
            </div>

            <!-- RIGHT COLUMN: Compact Feedback Form (order-1 lg:order-2) -->
            <div class="lg:col-span-5 order-1 lg:order-2 w-full">
                <div class="bg-base-100 card-base rounded-3xl overflow-hidden shadow-xl">
                    <!-- Saffron Accent Banner -->
                    <div class="h-2.5 w-full bg-primary"></div>

                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Header -->
                        <div class="text-center space-y-2">
                            <h1 class="font-heading font-extrabold text-2xl text-base-content leading-tight">
                                {{ __('messages.form.detailed_title') }}
                            </h1>
                            <p class="text-xs text-base-content/70 max-w-sm mx-auto leading-relaxed">
                                {{ __('messages.form.detailed_subtitle') }}
                            </p>
                            <div class="w-12 h-0.5 bg-primary mx-auto mt-2 rounded-full"></div>
                        </div>

                        <!-- Alert Messages -->

                        @if($errors->any())
                            <div class="alert alert-error shadow-sm rounded-xl text-white py-3">
                                <ul class="text-[11px] list-disc pl-4 font-medium">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Feedback Survey Form -->
                        <form action="{{ route('feedback.detailed.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3" id="detailed-feedback-form">
                            @csrf

                            <!-- Row 1: Name and Mobile Number -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="floating-label w-full block">
                                        <span>{{ __('messages.form.name') }} <span class="text-error font-extrabold">*</span></span>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('messages.form.name') }}" required class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Please enter your name</div>
                                </div>

                                <div>
                                    <label class="floating-label w-full block">
                                        <span>{{ __('messages.form.mobile') }} <span class="text-error font-extrabold">*</span></span>
                                        <input type="tel" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="{{ __('messages.form.mobile') }}" required pattern="[0-9]{10}" class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Enter a 10-digit mobile number (e.g. 9876543210)</div>
                                </div>
                            </div>

                            <!-- Row 2: Ward Area and Feedback Title -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="floating-label w-full block">
                                        <span>{{ __('messages.form.area') }} <span class="text-error font-extrabold">*</span></span>
                                        <input type="text" name="area" id="area" value="{{ old('area') }}" placeholder="{{ __('messages.form.area') }}" required class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Ward Area or Block is required</div>
                                </div>

                                <div>
                                    <label class="floating-label w-full block">
                                        <span>{{ __('messages.form.title') }} <span class="text-error font-extrabold">*</span></span>
                                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="{{ __('messages.form.title') }}" required class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">A brief title is required</div>
                                </div>
                            </div>

                            <!-- DaisyUI Star Rating Input block nested perfectly -->
                            <div class="flex items-center gap-3 bg-base-200 px-4 py-2 border border-base-300 rounded-xl justify-between h-[3.25rem]">
                                <span class="text-xs font-extrabold text-base-content/65 uppercase tracking-wider">{{ __('messages.form.rating') }}</span>
                                <div class="rating rating-md gap-0.5">
                                    <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-warning" />
                                    <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-warning" />
                                    <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-warning" />
                                    <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-warning" />
                                    <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-warning" checked />
                                </div>
                            </div>

                            <!-- Row 3: Feedback Message Area -->
                            <div class="relative w-full">
                                <textarea id="message" name="message" required placeholder=" " rows="3" 
                                    class="peer textarea textarea-bordered w-full pt-5 pb-2 min-h-[5rem] bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary placeholder-transparent transition-all validator"></textarea>
                                <label for="message" 
                                    class="absolute left-4 top-2.5 text-[10px] text-base-content/50 font-extrabold uppercase tracking-wider transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:font-medium peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-focus:top-2.5 peer-focus:text-[10px] peer-focus:text-primary peer-focus:font-extrabold peer-focus:uppercase peer-focus:tracking-wider pointer-events-none">
                                    {{ __('messages.form.message') }}
                                </label>
                                <div class="validator-hint text-[10px] font-semibold text-error/90 font-sans">Please share your feedback details</div>
                            </div>

                            <!-- Unified Media Upload & Live Camera Grid Row -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end bg-base-200 p-4 rounded-xl border border-base-300">
                                <!-- Device Upload file-input -->
                                <div class="form-control w-full sm:col-span-2">
                                    <label class="label py-0.5">
                                        <span class="label-text font-extrabold text-[10px] text-base-content/70 uppercase tracking-wider">Upload Photos</span>
                                    </label>
                                    <input type="file" name="photos[]" multiple accept="image/*" class="file-input file-input-bordered file-input-primary file-input-sm w-full rounded-xl bg-base-100 border-base-300 text-xs" />
                                </div>

                                <!-- Live Camera Button -->
                                <div class="w-full sm:col-span-1">
                                    <button type="button" onclick="openCameraModal()" class="btn btn-xs sm:btn-sm btn-outline btn-secondary w-full rounded-xl gap-1.5 font-bold h-8 sm:h-9">
                                        <i class="fa-solid fa-camera text-[10px]"></i> Live Photo
                                    </button>
                                </div>
                            </div>

                            <!-- Camera photo preview badge (appears if captured) -->
                            <div id="camera-preview-container" class="hidden flex items-center justify-between bg-success/10 border border-success/30 px-3 py-2 rounded-xl text-success transition-all duration-200">
                                <div class="flex items-center gap-2">
                                    <img id="camera-preview-thumbnail" class="w-8 h-8 object-cover rounded-lg border border-success/35" src="" alt="Captured Photo Preview">
                                    <span class="text-xs font-semibold">Live photo attached!</span>
                                </div>
                                <button type="button" onclick="removeCameraPhoto()" class="btn btn-xs btn-circle btn-ghost text-error hover:bg-error/10">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <!-- Hidden Base64 Field -->
                            <input type="hidden" name="camera_photo" id="camera-photo-input">

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-full text-white font-bold h-11 rounded-xl mt-2 hover:shadow-lg transition-all">
                                {{ __('messages.form.submit') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- DaisyUI Modal for Camera Capture -->
<dialog id="camera_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-3xl p-6 relative">
        <!-- Close button at corner -->
        <button type="button" onclick="closeCameraModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60"><i class="fa-solid fa-xmark"></i></button>

        <h3 class="font-heading font-extrabold text-lg text-base-content flex items-center gap-2">
            <i class="fa-solid fa-camera text-primary"></i> Take a Live Photo
        </h3>
        <p class="text-xs text-base-content/60 mt-1 mb-4">Allow camera access to capture a dynamic live photo of the ward.</p>

        <!-- Video / Canvas display panel -->
        <div class="relative w-full aspect-video rounded-2xl bg-base-200 border border-base-300 overflow-hidden flex items-center justify-center">
            <video id="camera-video" autoplay playsinline class="hidden w-full h-full object-cover"></video>
            <canvas id="camera-canvas" class="hidden w-full h-full object-cover"></canvas>
            
            <!-- Empty state / Initial loading text -->
            <div id="camera-placeholder" class="text-center p-6 space-y-2">
                <i class="fa-solid fa-camera-retro text-4xl text-base-content/30 animate-bounce"></i>
                <p class="text-xs font-bold text-base-content/50">Camera stream starting...</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-6">
            <button type="button" onclick="closeCameraModal()" class="btn btn-sm btn-ghost rounded-xl">Cancel</button>
            <button type="button" id="capture-photo-btn" onclick="takeSnapshot()" class="btn btn-sm btn-primary text-white rounded-xl font-bold"><i class="fa-solid fa-circle-dot"></i> Capture Photo</button>
            <button type="button" id="retake-photo-btn" onclick="resetCamera()" class="btn btn-sm btn-warning rounded-xl hidden font-bold"><i class="fa-solid fa-rotate-left"></i> Retake</button>
            <button type="button" id="use-photo-btn" onclick="useCapturedPhoto()" class="btn btn-sm btn-success text-white rounded-xl hidden font-bold"><i class="fa-solid fa-check"></i> Use Photo</button>
        </div>
    </div>
    <!-- Backdrop to close on tap outside -->
    <form method="dialog" class="modal-backdrop">
        <button onclick="closeCameraModal()">close</button>
    </form>
</dialog>

<!-- Camera Javascript handler -->
<script>
    let localStream = null;
    const video = document.getElementById('camera-video');
    const canvas = document.getElementById('camera-canvas');
    const placeholder = document.getElementById('camera-placeholder');
    const captureBtn = document.getElementById('capture-photo-btn');
    const retakeBtn = document.getElementById('retake-photo-btn');
    const useBtn = document.getElementById('use-photo-btn');
    const photoInput = document.getElementById('camera-photo-input');
    const previewContainer = document.getElementById('camera-preview-container');
    const previewThumbnail = document.getElementById('camera-preview-thumbnail');
    const modal = document.getElementById('camera_modal');

    async function openCameraModal() {
        modal.showModal();
        
        // Reset modal layout visibility
        video.classList.add('hidden');
        canvas.classList.add('hidden');
        placeholder.classList.remove('hidden');
        
        captureBtn.classList.remove('hidden');
        retakeBtn.classList.add('hidden');
        useBtn.classList.add('hidden');

        try {
            // Request permissions for camera
            localStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "environment" }, // Prioritize rear camera for ward surveys
                audio: false 
            });
            
            video.srcObject = localStream;
            video.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } catch (err) {
            console.error("Camera access failed: ", err);
            placeholder.innerHTML = `
                <div class="p-4 text-center space-y-1">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-error"></i>
                    <p class="text-xs font-bold text-base-content/75">Camera access unavailable</p>
                    <p class="text-[10px] text-base-content/50">Please upload files using the device selector directly instead.</p>
                </div>
            `;
            captureBtn.classList.add('hidden');
        }
    }

    function closeCameraModal() {
        stopCamera();
        modal.close();
    }

    function takeSnapshot() {
        if (!localStream) return;

        const ctx = canvas.getContext('2d');
        
        // Match canvas bounds to video frame aspect
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw frame
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Toggle visibility
        video.classList.add('hidden');
        canvas.classList.remove('hidden');
        
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');
        useBtn.classList.remove('hidden');

        // Stop camera stream to conserve resources
        stopCamera();
    }

    function resetCamera() {
        // Clear old input
        canvas.classList.add('hidden');
        video.classList.add('hidden');
        placeholder.classList.remove('hidden');
        
        // Re-initialize stream
        openCameraModal();
    }

    function useCapturedPhoto() {
        // Convert canvas image to dataUrl base64
        const dataUrl = canvas.toDataURL('image/jpeg');
        photoInput.value = dataUrl;

        // Set thumbnail source and make preview badge visible
        previewThumbnail.src = dataUrl;
        previewContainer.classList.remove('hidden');

        // Close modal cleanly
        closeCameraModal();
    }

    function removeCameraPhoto() {
        // Purge stored value and hide badge
        photoInput.value = '';
        previewThumbnail.src = '';
        previewContainer.classList.add('hidden');
    }

    function stopCamera() {
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }
        if (video.srcObject) {
            video.srcObject = null;
        }
    }

    // Clean up streams if navigating away
    window.addEventListener('beforeunload', stopCamera);
</script>

<!-- AJAX Pagination Handler -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('feedback-listing-container');
    if (container) {
        container.addEventListener('click', function(e) {
            const link = e.target.closest('.join-item[href]');
            if (link) {
                e.preventDefault();
                const url = link.getAttribute('href');
                fetchFeedbacks(url);
            }
        });
    }

    function fetchFeedbacks(url) {
        if (!container) return;
        
        container.classList.add('relative');
        
        // Remove any old overlay
        const oldOverlay = container.querySelector('.feedback-loader-overlay');
        if (oldOverlay) oldOverlay.remove();
        
        // Create dynamic premium overlay loading block
        const loader = document.createElement('div');
        loader.className = 'feedback-loader-overlay absolute inset-0 bg-base-100/75 backdrop-blur-[2px] flex items-center justify-center z-50 min-h-[300px] transition-opacity duration-300';
        loader.innerHTML = `
            <div class="flex flex-col items-center gap-3 bg-base-100 border border-base-300 shadow-2xl px-6 py-4 rounded-3xl animate-fade-in">
                <span class="loading loading-spinner loading-md text-primary animate-spin"></span>
                <span class="text-[10px] font-extrabold text-base-content/75 uppercase tracking-wider">Loading Feedbacks...</span>
            </div>
        `;
        container.appendChild(loader);
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            container.innerHTML = data.html;
            
            // Scroll to the top of the listing section smoothly
            const sectionHeader = document.getElementById('feedback-listing-container');
            if (sectionHeader) {
                sectionHeader.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        })
        .catch(error => {
            console.error('Error fetching feedbacks:', error);
            const overlay = container.querySelector('.feedback-loader-overlay');
            if (overlay) overlay.remove();
        });
    }
});
</script>

@if(session('success'))
<!-- Success Modal Popup -->
<dialog id="success_modal" class="modal modal-bottom sm:modal-middle modal-open">
    <div class="modal-box bg-base-100 border border-base-300 rounded-3xl p-8 max-w-sm text-center relative overflow-hidden shadow-2xl">
        <!-- Confetti/Glow background shapes -->
        <div class="absolute -top-12 -left-12 w-24 h-24 bg-success/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute -bottom-12 -right-12 w-24 h-24 bg-primary/10 rounded-full blur-xl animate-pulse"></div>

        <!-- Lotus gradient background ring with Success Icon -->
        <div class="mx-auto w-16 h-16 bg-gradient-to-tr from-success to-emerald-400 rounded-full flex items-center justify-center text-white text-3xl shadow-lg shadow-success/20 mb-4 animate-bounce">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h3 class="font-heading font-extrabold text-xl text-base-content">
            Thank You, Citizen!
        </h3>
        <p class="text-xs text-base-content/70 mt-2 leading-relaxed">
            {{ session('success') }}
        </p>

        <!-- Dynamic development quote or thank you note -->
        <div class="bg-base-200/60 rounded-xl p-3 mt-4 text-[10px] text-base-content/60 italic border border-base-300/40">
            "Your feedback is a valuable brick in building a stronger, safer, and cleaner Vadodara Ward 7."
        </div>

        <div class="modal-action justify-center mt-6">
            <button type="button" onclick="closeSuccessModal()" class="btn btn-sm btn-primary text-white rounded-xl font-bold px-6 shadow-md hover:shadow-lg transition-all duration-200">
                Jai Hind
            </button>
        </div>
    </div>
    <!-- Backdrop to close on click -->
    <div class="modal-backdrop bg-black/45 backdrop-blur-sm" onclick="closeSuccessModal()"></div>
</dialog>

<script>
    function closeSuccessModal() {
        const modal = document.getElementById('success_modal');
        if (modal) {
            modal.classList.remove('modal-open');
            modal.removeAttribute('open');
        }
    }
</script>
@endif
@endsection
