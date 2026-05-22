@extends('layouts.app')

@section('title', __('messages.form.detailed_title') . ' - Sachin Khandelwal')

@section('content')
<section class="py-12 bg-gradient-to-b from-[#FFFDF8] via-[#FFFDF8] to-[#F3EFE6] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Breadcrumb / Back button -->
        <div class="flex justify-start">
            <a href="{{ route('home') }}" class="btn btn-sm btn-ghost gap-1.5 text-neutral/70 hover:text-primary rounded-lg">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Homepage
            </a>
        </div>

        <div class="w-full">
            <div class="bg-[#FFFDF8] border border-base-300 rounded-3xl shadow-xl overflow-hidden">
            <!-- Saffron Accent Banner -->
            <div class="h-2.5 w-full bg-[#FF8A3D]"></div>

            <div class="p-8 sm:p-12 space-y-8">
                <!-- Header -->
                <div class="text-center space-y-2">
                    <h1 class="font-heading font-extrabold text-3xl text-neutral">
                        {{ __('messages.form.detailed_title') }}
                    </h1>
                    <p class="text-neutral/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
                        {{ __('messages.form.detailed_subtitle') }}
                    </p>
                    <div class="w-16 h-0.5 bg-secondary mx-auto mt-4 rounded-full"></div>
                </div>

                <!-- Alert Messages -->
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

                <!-- Feedback Survey Form -->
                <form action="{{ route('feedback.detailed.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="detailed-feedback-form">
                    @csrf

                    <!-- 1. Personal Details Section -->
                    <div class="space-y-4">
                        <h3 class="font-heading font-bold text-lg text-secondary border-b border-base-300 pb-2"><i class="fa-solid fa-user-tag text-[#FF8A3D] mr-1.5"></i> Personal Details</h3>
                        
                        <!-- Floating Label Name -->
                        <div class="relative w-full">
                            <input type="text" id="name" name="name" required placeholder=" " 
                                class="peer input input-bordered w-full pt-4 pb-1 h-14 bg-transparent border-base-300 focus:border-primary focus:outline-none rounded-xl text-neutral text-sm transition-all" />
                            <label for="name" 
                                class="absolute left-4 pointer-events-none transition-all duration-200 text-neutral/50 font-medium
                                top-3 -translate-y-0 text-xs
                                peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-sm
                                peer-focus:top-3 peer-focus:-translate-y-0 peer-focus:text-xs peer-focus:text-primary">
                                {{ __('messages.form.name') }}
                            </label>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Floating Label Mobile -->
                            <div class="relative w-full">
                                <input type="tel" id="mobile_number" name="mobile_number" required placeholder=" " 
                                    class="peer input input-bordered w-full pt-4 pb-1 h-14 bg-transparent border-base-300 focus:border-primary focus:outline-none rounded-xl text-neutral text-sm transition-all" />
                                <label for="mobile_number" 
                                    class="absolute left-4 pointer-events-none transition-all duration-200 text-neutral/50 font-medium
                                    top-3 -translate-y-0 text-xs
                                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-sm
                                    peer-focus:top-3 peer-focus:-translate-y-0 peer-focus:text-xs peer-focus:text-primary">
                                    {{ __('messages.form.mobile') }}
                                </label>
                            </div>

                            <!-- Floating Label Area -->
                            <div class="relative w-full">
                                <input type="text" id="area" name="area" required placeholder=" " 
                                    class="peer input input-bordered w-full pt-4 pb-1 h-14 bg-transparent border-base-300 focus:border-primary focus:outline-none rounded-xl text-neutral text-sm transition-all" />
                                <label for="area" 
                                    class="absolute left-4 pointer-events-none transition-all duration-200 text-neutral/50 font-medium
                                    top-3 -translate-y-0 text-xs
                                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-sm
                                    peer-focus:top-3 peer-focus:-translate-y-0 peer-focus:text-xs peer-focus:text-primary">
                                    {{ __('messages.form.area') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Survey Content Section -->
                    <div class="space-y-4 pt-4">
                        <h3 class="font-heading font-bold text-lg text-secondary border-b border-base-300 pb-2"><i class="fa-solid fa-square-poll-horizontal text-[#FF8A3D] mr-1.5"></i> Feedback & Service Rating</h3>
                        
                        <!-- Floating Label Title -->
                        <div class="relative w-full">
                            <input type="text" id="title" name="title" required placeholder=" " 
                                class="peer input input-bordered w-full pt-4 pb-1 h-14 bg-transparent border-base-300 focus:border-primary focus:outline-none rounded-xl text-neutral text-sm transition-all" />
                            <label for="title" 
                                class="absolute left-4 pointer-events-none transition-all duration-200 text-neutral/50 font-medium
                                top-3 -translate-y-0 text-xs
                                peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-sm
                                peer-focus:top-3 peer-focus:-translate-y-0 peer-focus:text-xs peer-focus:text-primary">
                                {{ __('messages.form.title') }}
                            </label>
                        </div>

                        <!-- Floating Label Message -->
                        <div class="relative w-full">
                            <textarea id="message" name="message" required placeholder=" " rows="4" 
                                class="peer textarea textarea-bordered w-full pt-5 pb-1 min-h-[6rem] bg-transparent border-base-300 focus:border-primary focus:outline-none rounded-xl text-neutral text-sm transition-all"></textarea>
                            <label for="message" 
                                class="absolute left-4 pointer-events-none transition-all duration-200 text-neutral/50 font-medium
                                top-5 -translate-y-1/2 text-sm
                                peer-placeholder-shown:top-5 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-sm
                                peer-focus:top-2 peer-focus:-translate-y-0 peer-focus:text-xs peer-focus:text-primary">
                                {{ __('messages.form.message') }}
                            </label>
                        </div>

                        <!-- Rating selection -->
                        <div class="flex flex-col gap-2 bg-[#F6F3EB] p-4 rounded-xl border border-base-300">
                            <span class="text-xs font-bold text-neutral/70 uppercase tracking-wider">{{ __('messages.form.rating') }}</span>
                            <div class="rating rating-lg gap-1">
                                <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-warning" checked />
                            </div>
                        </div>
                    </div>

                    <!-- 3. Photo Capture & Media upload Section -->
                    <div class="space-y-4 pt-4">
                        <h3 class="font-heading font-bold text-lg text-secondary border-b border-base-300 pb-2"><i class="fa-solid fa-camera text-[#FF8A3D] mr-1.5"></i> Camera Capture & Document Upload</h3>
                        
                        <!-- Camera capture interactive workspace -->
                        <div class="card bg-[#F6F3EB] border border-base-300 p-6 rounded-2xl space-y-4">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-heading font-bold text-sm text-neutral">Live Camera Capture</h4>
                                    <p class="text-xs text-neutral/60">Capture a live photo of ward issues or development projects using your device camera.</p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" id="start-camera-btn" onclick="initCamera()" class="btn btn-xs btn-outline btn-neutral rounded-lg"><i class="fa-solid fa-video"></i> Open Camera</button>
                                    <button type="button" id="capture-photo-btn" onclick="takeSnapshot()" class="btn btn-xs btn-primary text-white rounded-lg hidden"><i class="fa-solid fa-circle-dot"></i> Capture</button>
                                    <button type="button" id="retake-photo-btn" onclick="resetCamera()" class="btn btn-xs btn-warning rounded-lg hidden"><i class="fa-solid fa-rotate-left"></i> Retake</button>
                                </div>
                            </div>

                            <!-- Video / Canvas display panel -->
                            <div class="relative w-full max-w-md mx-auto aspect-video rounded-xl bg-neutral/10 border border-base-300 overflow-hidden flex items-center justify-center">
                                <video id="camera-video" autoplay playsinline class="hidden w-full h-full object-cover"></video>
                                <canvas id="camera-canvas" class="hidden w-full h-full object-cover"></canvas>
                                
                                <!-- Empty state text -->
                                <div id="camera-placeholder" class="text-center p-4 space-y-2">
                                    <i class="fa-solid fa-camera-rotate text-3xl text-neutral/30"></i>
                                    <p class="text-xs font-semibold text-neutral/50">Camera is closed. Tap "Open Camera" to start.</p>
                                </div>
                            </div>

                            <!-- Hidden Base64 Field -->
                            <input type="hidden" name="camera_photo" id="camera-photo-input">
                        </div>

                        <!-- Fallback / Multi file upload field -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-bold text-xs text-neutral/70 uppercase tracking-wider">Select Files from Device</span>
                            </label>
                            <input type="file" name="photos[]" multiple accept="image/*" class="file-input file-input-bordered file-input-primary w-full rounded-xl bg-transparent border-base-300" />
                            <label class="label">
                                <span class="label-text-alt text-neutral/50 text-[10px]">Max image size 5MB. You can select multiple images.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-full text-white font-bold h-12 rounded-xl mt-4 hover:shadow-lg transition-all">
                        {{ __('messages.form.submit') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative flex py-6 items-center">
            <div class="flex-grow border-t border-base-300/60"></div>
            <span class="flex-shrink mx-4 text-neutral/30"><i class="fa-solid fa-comments text-lg"></i></span>
            <div class="flex-grow border-t border-base-300/60"></div>
        </div>

        <!-- Approved Feedbacks Listing Section -->
        <div class="space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-neutral">
                    {{ __('messages.sections.approved_list_title') }}
                </h2>
                <p class="text-xs sm:text-sm text-neutral/60">Verified feedback and testimonials from citizens of Ward No. 7</p>
                <div class="w-16 h-1 bg-[#FF8A3D] mx-auto mt-2 rounded-full"></div>
            </div>

            <div id="feedback-listing-container">
                @include('partials.feedback-list-container')
            </div>
        </div>
    </div>
</section>

<!-- Camera Javascript handler -->
<script>
    let localStream = null;
    const video = document.getElementById('camera-video');
    const canvas = document.getElementById('camera-canvas');
    const placeholder = document.getElementById('camera-placeholder');
    const startBtn = document.getElementById('start-camera-btn');
    const captureBtn = document.getElementById('capture-photo-btn');
    const retakeBtn = document.getElementById('retake-photo-btn');
    const photoInput = document.getElementById('camera-photo-input');

    async function initCamera() {
        try {
            // Request permissions for camera
            localStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "environment" }, // Prioritize rear camera for ward surveys
                audio: false 
            });
            
            video.srcObject = localStream;
            video.classList.remove('hidden');
            placeholder.classList.add('hidden');
            canvas.classList.add('hidden');
            
            startBtn.classList.add('hidden');
            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
        } catch (err) {
            console.error("Camera access failed: ", err);
            alert("Could not access camera. Please select photos using the file upload option below instead.");
        }
    }

    function takeSnapshot() {
        if (!localStream) return;

        const ctx = canvas.getContext('2d');
        
        // Match canvas bounds to video frame aspect
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw frame
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Convert to dataUrl base64
        const dataUrl = canvas.toDataURL('image/jpeg');
        photoInput.value = dataUrl;

        // Toggle visibility
        video.classList.add('hidden');
        canvas.classList.remove('hidden');
        
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');

        // Stop camera streams
        stopCamera();
    }

    function resetCamera() {
        // Clear value
        photoInput.value = '';
        canvas.classList.add('hidden');
        video.classList.remove('hidden');
        
        // Re-initialize camera stream
        initCamera();
    }

    function stopCamera() {
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
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
        container.style.opacity = '0.5';
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            container.innerHTML = data.html;
            container.style.opacity = '1';
            
            // Scroll to the top of the listing section smoothly
            const sectionHeader = document.querySelector('#feedback-listing-container');
            if (sectionHeader) {
                sectionHeader.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        })
        .catch(error => {
            console.error('Error fetching feedbacks:', error);
            container.style.opacity = '1';
        });
    }
});
</script>
@endsection
