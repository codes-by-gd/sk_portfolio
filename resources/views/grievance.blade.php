@extends('layouts.app')

@section('title', __('messages.grievance.title') . ' — Sachin Khandelwal, Ward 7')
@section('meta_description', __('messages.grievance.subtitle'))

@section('content')
<section class="py-12 bg-gradient-to-b from-base-100 via-base-100 to-base-200 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Breadcrumb / Back button -->
        <div class="flex justify-start">
            <a href="{{ route('home') }}" class="btn btn-sm btn-ghost gap-1.5 text-base-content/70 hover:text-primary rounded-lg transition-colors">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Homepage
            </a>
        </div>

        <!-- Two-column grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: Resolution Workflow & Info (order-2 lg:order-1) -->
            <div class="lg:col-span-6 order-2 lg:order-1 space-y-8">
                <div class="text-center lg:text-left space-y-2">
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-base-content flex items-center justify-center lg:justify-start gap-2.5">
                        <span class="p-2 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        </span>
                        {{ __('messages.grievance.title') }}
                    </h2>
                    <p class="text-xs sm:text-sm text-base-content/60">{{ __('messages.grievance.subtitle') }}</p>
                    <div class="w-16 h-1 bg-primary lg:mx-0 mx-auto mt-3 rounded-full"></div>
                </div>

                <!-- Premium Grievance Tracking Widget -->
                <div class="bg-base-100 card-base border border-base-300 rounded-3xl p-6 shadow-md space-y-4">
                    <h3 class="font-heading font-extrabold text-lg text-base-content flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass-chart text-primary"></i>
                        Track Grievance Status
                    </h3>
                    <p class="text-xs text-base-content/65">Enter your unique complaint tracking number (e.g. CMP-YYMMDDXXXX) to check resolution progress and logs in real-time.</p>
                    
                    <form id="grievance-track-form" onsubmit="trackGrievance(event)" class="flex gap-2">
                        <input type="text" id="track-number-input" placeholder="e.g. CMP-2605271032" required 
                               class="input input-md bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary flex-grow text-xs font-mono tracking-wider" />
                        <button type="submit" class="btn btn-md btn-primary text-white rounded-xl font-bold px-4 gap-1">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i> Track
                        </button>
                    </form>

                    <!-- Status Display Area (Hidden by default) -->
                    <div id="track-result-container" class="hidden mt-4 pt-4 border-t border-base-300 space-y-4 transition-all duration-300">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                            <div>
                                <h4 class="text-sm font-bold text-base-content" id="track-complainant-name">---</h4>
                                <p class="text-[10px] text-base-content/50" id="track-complaint-meta">Category: --- | Locality: ---</p>
                            </div>
                            <span class="badge font-bold text-[9px] uppercase p-2.5" id="track-status-badge">---</span>
                        </div>

                        <!-- Progress Logs Timeline -->
                        <div class="space-y-4 relative pl-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-[1.5px] before:bg-base-300" id="track-logs-timeline">
                            <!-- Dynamically loaded timeline elements -->
                        </div>
                    </div>
                </div>

                <!-- Info Cards: Grievance Categories -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-base-100 p-4 rounded-2xl border border-base-300 shadow-sm flex items-start gap-3 hover:-translate-y-0.5 transition-transform duration-200">
                        <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-droplet text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-base-content uppercase tracking-wider">{{ __('messages.grievance.categories.water') }}</h4>
                            <p class="text-[10px] text-base-content/50 mt-0.5 leading-relaxed">Report leakage, low pressure, or contaminated supply.</p>
                        </div>
                    </div>

                    <div class="bg-base-100 p-4 rounded-2xl border border-base-300 shadow-sm flex items-start gap-3 hover:-translate-y-0.5 transition-transform duration-200">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-base-content uppercase tracking-wider">{{ __('messages.grievance.categories.sanitation') }}</h4>
                            <p class="text-[10px] text-base-content/50 mt-0.5 leading-relaxed">Report choked drains, garbage dumping, or hygiene issues.</p>
                        </div>
                    </div>

                    <div class="bg-base-100 p-4 rounded-2xl border border-base-300 shadow-sm flex items-start gap-3 hover:-translate-y-0.5 transition-transform duration-200">
                        <div class="w-9 h-9 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-road text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-base-content uppercase tracking-wider">{{ __('messages.grievance.categories.road') }}</h4>
                            <p class="text-[10px] text-base-content/50 mt-0.5 leading-relaxed">Report potholes, broken pavements, or waterlogging.</p>
                        </div>
                    </div>

                    <div class="bg-base-100 p-4 rounded-2xl border border-base-300 shadow-sm flex items-start gap-3 hover:-translate-y-0.5 transition-transform duration-200">
                        <div class="w-9 h-9 rounded-xl bg-yellow-500/10 text-yellow-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-bolt text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-base-content uppercase tracking-wider">{{ __('messages.grievance.categories.electricity') }}</h4>
                            <p class="text-[10px] text-base-content/50 mt-0.5 leading-relaxed">Report dangerous overhead wires or power failures.</p>
                        </div>
                    </div>
                </div>

                <!-- Process Map Roadmap Timeline -->
                <div class="bg-base-100 card-base border border-base-300 rounded-3xl p-6 sm:p-8 shadow-md space-y-6">
                    <h3 class="font-heading font-extrabold text-lg text-base-content border-b border-base-300 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-diagram-project text-secondary"></i>
                        {{ __('messages.grievance.info_title') }}
                    </h3>

                    <!-- Custom vertical stepper -->
                    <div class="space-y-6 relative pl-8 before:absolute before:left-3.5 before:top-2 before:bottom-2 before:w-[2px] before:bg-base-300">
                        <!-- Step 1 -->
                        <div class="relative">
                            <div class="absolute -left-8 top-0.5 w-7 h-7 rounded-full bg-gradient-to-tr from-orange-400 to-primary text-white font-extrabold text-xs flex items-center justify-center border-4 border-base-100 shadow-sm z-10">1</div>
                            <h4 class="text-sm font-bold text-base-content leading-tight">{{ __('messages.grievance.info_step1') }}</h4>
                            <p class="text-xs text-base-content/60 mt-1">Your complaint is registered and instantly routed to the dedicated department officer for evaluation.</p>
                        </div>
                        <!-- Step 2 -->
                        <div class="relative">
                            <div class="absolute -left-8 top-0.5 w-7 h-7 rounded-full bg-gradient-to-tr from-secondary to-indigo-500 text-white font-extrabold text-xs flex items-center justify-center border-4 border-base-100 shadow-sm z-10">2</div>
                            <h4 class="text-sm font-bold text-base-content leading-tight">{{ __('messages.grievance.info_step2') }}</h4>
                            <p class="text-xs text-base-content/60 mt-1">Field engineers conduct an inspection, review uploaded photo evidence, and schedule corrective work.</p>
                        </div>
                        <!-- Step 3 -->
                        <div class="relative">
                            <div class="absolute -left-8 top-0.5 w-7 h-7 rounded-full bg-gradient-to-tr from-success to-emerald-400 text-white font-extrabold text-xs flex items-center justify-center border-4 border-base-100 shadow-sm z-10">3</div>
                            <h4 class="text-sm font-bold text-base-content leading-tight">{{ __('messages.grievance.info_step3') }}</h4>
                            <p class="text-xs text-base-content/60 mt-1">Action is completed, photos are documented, and status is logged as Resolved in the administrative tracker.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Interactive Grievance Form (order-1 lg:order-2) -->
            <div class="lg:col-span-6 order-1 lg:order-2 w-full">
                <div class="bg-base-100 card-base rounded-3xl overflow-hidden shadow-xl border border-base-300">
                    <!-- Saffron/Orange Accent Banner -->
                    <div class="h-2.5 w-full bg-primary"></div>

                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Header -->
                        <div class="text-center space-y-2">
                            <h1 class="font-heading font-extrabold text-2xl text-base-content leading-tight">
                                {{ __('messages.grievance.form_title') }}
                            </h1>
                            <p class="text-xs text-base-content/70 max-w-md mx-auto leading-relaxed">
                                {{ __('messages.grievance.form_subtitle') }}
                            </p>
                            <div class="w-12 h-0.5 bg-primary mx-auto mt-2 rounded-full"></div>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="public-grievance-form">
                            @csrf

                            <!-- Row 1: Name and Mobile Number -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="floating-label w-full block">
                                        <input type="text" name="complainant_name" id="complainant_name" value="{{ old('complainant_name') }}" placeholder="Full Name" required class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                        <span>{{ __('messages.form.name') }} <span class="text-error font-extrabold">*</span></span>
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Please enter your full name</div>
                                </div>

                                <div>
                                    <label class="floating-label w-full block">
                                        <input type="tel" name="complainant_mobile" id="complainant_mobile" value="{{ old('complainant_mobile') }}" placeholder="Mobile Number" required pattern="[0-9]{10}" class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                        <span>{{ __('messages.form.mobile') }} <span class="text-error font-extrabold">*</span></span>
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Enter a 10-digit mobile number (e.g. 9876543210)</div>
                                </div>
                            </div>

                            <!-- Row 2: Ward Area and Category Selection -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="floating-label w-full block">
                                        <input type="text" name="area" id="area" value="{{ old('area') }}" placeholder="Ward Area / Locality" required class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                        <span>{{ __('messages.form.area') }} <span class="text-error font-extrabold">*</span></span>
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Society, block, or lane locality is required</div>
                                </div>

                                <div>
                                    <label class="floating-label w-full block relative">
                                        <select name="category" id="category" required class="select select-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all appearance-none pr-10">
                                            <option value="" disabled selected>Select Category</option>
                                            <option value="water">{{ __('messages.grievance.categories.water') }}</option>
                                            <option value="sanitation">{{ __('messages.grievance.categories.sanitation') }}</option>
                                            <option value="road">{{ __('messages.grievance.categories.road') }}</option>
                                            <option value="electricity">{{ __('messages.grievance.categories.electricity') }}</option>
                                            <option value="street_light">{{ __('messages.grievance.categories.street_light') }}</option>
                                            <option value="other">{{ __('messages.grievance.categories.other') }}</option>
                                        </select>
                                        <span>Category <span class="text-error font-extrabold">*</span></span>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 pt-3 text-base-content/50">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Row 3: Description -->
                            <div>
                                <label class="floating-label w-full block">
                                    <textarea id="description" name="description" required placeholder="Describe the grievance details..." rows="4" class="textarea textarea-bordered w-full pt-5 pb-2 min-h-[6rem] bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all validator"></textarea>
                                    <span>Grievance Description <span class="text-error font-extrabold">*</span></span>
                                </label>
                                <div class="validator-hint text-[10px] font-semibold text-error/90 font-sans">Please describe your complaint or concern</div>
                            </div>

                            <!-- Photo evidence uploads -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end bg-base-200 p-4 rounded-xl border border-base-300">
                                <!-- Device Upload -->
                                <div class="form-control w-full sm:col-span-2">
                                    <label class="label py-0.5">
                                        <span class="label-text font-extrabold text-[10px] text-base-content/70 uppercase tracking-wider">Evidence Picture (Optional)</span>
                                    </label>
                                    <input type="file" name="attachment" id="attachment" accept="image/*" class="file-input file-input-bordered file-input-primary file-input-sm w-full rounded-xl bg-base-100 border-base-300 text-xs" />
                                </div>

                                <!-- Camera Button -->
                                <div class="w-full sm:col-span-1">
                                    <button type="button" onclick="openCameraModal()" class="btn btn-xs sm:btn-sm btn-outline btn-secondary w-full rounded-xl gap-1.5 font-bold h-8 sm:h-9">
                                        <i class="fa-solid fa-camera text-[10px]"></i> Live Photo
                                    </button>
                                </div>
                            </div>

                            <!-- Live Photo Preview Box (if captured) -->
                            <div id="camera-preview-container" class="hidden flex items-center justify-between bg-success/10 border border-success/30 px-3 py-2 rounded-xl text-success transition-all duration-200 animate-fade-in">
                                <div class="flex items-center gap-2">
                                    <img id="camera-preview-thumbnail" class="w-8 h-8 object-cover rounded-lg border border-success/35" src="" alt="Live Captured Attachment Preview">
                                    <span class="text-xs font-semibold">Live photo attached!</span>
                                </div>
                                <button type="button" onclick="removeCameraPhoto()" class="btn btn-xs btn-circle btn-ghost text-error hover:bg-error/10">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <!-- Hidden Base64 Field for Camera Input -->
                            <input type="hidden" name="camera_photo" id="camera-photo-input">

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-full text-white font-bold h-11 rounded-xl mt-3 hover:shadow-lg transition-all gap-1.5">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                {{ __('messages.grievance.cta_btn') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- WebRTC Camera Capture Dialog Modal -->
<dialog id="camera_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-3xl p-6 relative">
        <button type="button" onclick="closeCameraModal()" class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-base-content/60 hover:text-base-content">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="font-heading font-extrabold text-lg text-base-content flex items-center gap-2">
            <i class="fa-solid fa-camera text-primary"></i> Capture Issue Evidence
        </h3>
        <p class="text-xs text-base-content/60 mt-1 mb-4">Grant camera permissions to snap a high-resolution live photo of the ward issue.</p>

        <!-- Viewfinder Panel -->
        <div class="relative w-full aspect-video rounded-2xl bg-base-200 border border-base-300 overflow-hidden flex items-center justify-center">
            <video id="camera-video" autoplay playsinline class="hidden w-full h-full object-cover"></video>
            <canvas id="camera-canvas" class="hidden w-full h-full object-cover"></canvas>
            
            <div id="camera-placeholder" class="text-center p-6 space-y-2">
                <i class="fa-solid fa-circle-notch text-3xl text-base-content/30 animate-spin"></i>
                <p class="text-xs font-bold text-base-content/50">Accessing media devices...</p>
            </div>
        </div>

        <!-- Action Bars -->
        <div class="flex items-center justify-end gap-3 mt-6">
            <button type="button" onclick="closeCameraModal()" class="btn btn-sm btn-ghost rounded-xl">Cancel</button>
            <button type="button" id="capture-photo-btn" onclick="takeSnapshot()" class="btn btn-sm btn-primary text-white rounded-xl font-bold"><i class="fa-solid fa-circle-dot"></i> Capture Photo</button>
            <button type="button" id="retake-photo-btn" onclick="resetCamera()" class="btn btn-sm btn-warning rounded-xl hidden font-bold"><i class="fa-solid fa-rotate-left"></i> Retake</button>
            <button type="button" id="use-photo-btn" onclick="useCapturedPhoto()" class="btn btn-sm btn-success text-white rounded-xl hidden font-bold"><i class="fa-solid fa-check"></i> Attach Photo</button>
        </div>
    </div>
    <!-- Backdrop to close natively -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button onclick="closeCameraModal()">close</button>
    </form>
</dialog>

<!-- Success Native Modal dialog -->
<dialog id="success_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 border border-base-300 rounded-3xl p-8 max-w-sm text-center relative overflow-hidden shadow-2xl">
        <div class="absolute -top-12 -left-12 w-24 h-24 bg-success/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute -bottom-12 -right-12 w-24 h-24 bg-primary/10 rounded-full blur-xl animate-pulse"></div>

        <!-- Lotus gradient background ring with Success Check Icon -->
        <div class="mx-auto w-16 h-16 bg-gradient-to-tr from-success to-emerald-400 rounded-full flex items-center justify-center text-white text-3xl shadow-lg shadow-success/20 mb-4 animate-bounce">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h3 class="font-heading font-extrabold text-xl text-base-content">
            {{ __('messages.grievance.success_title') }}
        </h3>
        <p class="text-xs text-base-content/75 mt-2 leading-relaxed" id="success-modal-description">
            Your grievance has been successfully submitted and registered.
        </p>

        <!-- Development slogan / quote card -->
        <div class="bg-base-200/60 rounded-xl p-3 mt-4 text-[10px] text-base-content/60 italic border border-base-300/40">
            "Direct accountability for a safer, cleaner, and better developed Ward 7."
        </div>

        <div class="modal-action justify-center mt-6">
            <form method="dialog">
                <button class="btn btn-sm btn-primary text-white rounded-xl font-bold px-6 shadow-md hover:shadow-lg transition-all duration-200">
                    Jai Hind
                </button>
            </form>
        </div>
    </div>
    <!-- Backdrop to close natively -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<!-- JavaScript Engine: Camera Handling, client-side validation, Toast and AJAX submitting -->
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
    const successModal = document.getElementById('success_modal');
    const grievanceForm = document.getElementById('public-grievance-form');

    // Toaster Alert Engine
    function showToast(message, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'toast toast-end toast-bottom p-4 z-50';
            document.body.appendChild(toastContainer);
        }

        const alertEl = document.createElement('div');
        const alertClass = type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-error' : 'alert-warning');
        const icon = type === 'success' 
            ? '<i class="fa-solid fa-circle-check text-xs"></i>' 
            : (type === 'error' ? '<i class="fa-solid fa-triangle-exclamation text-xs"></i>' : '<i class="fa-solid fa-circle-info text-xs"></i>');

        alertEl.className = `alert ${alertClass} alert-soft shadow-lg rounded-2xl flex items-center gap-2 border-none transition-all duration-300 transform translate-y-4 opacity-0`;
        alertEl.innerHTML = `
            <span class="text-white shrink-0">${icon}</span>
            <span class="text-xs font-bold font-sans text-base-content/90">${message}</span>
        `;

        toastContainer.appendChild(alertEl);

        setTimeout(() => {
            alertEl.classList.remove('translate-y-4', 'opacity-0');
        }, 10);

        setTimeout(() => {
            alertEl.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                alertEl.remove();
                if (toastContainer.children.length === 0) {
                    toastContainer.remove();
                }
            }, 300);
        }, 4000);
    }

    async function openCameraModal() {
        modal.showModal();
        video.classList.add('hidden');
        canvas.classList.add('hidden');
        placeholder.classList.remove('hidden');
        
        captureBtn.classList.remove('hidden');
        retakeBtn.classList.add('hidden');
        useBtn.classList.add('hidden');

        try {
            localStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "environment" }, // Rear camera first
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
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        video.classList.add('hidden');
        canvas.classList.remove('hidden');
        
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');
        useBtn.classList.remove('hidden');
        stopCamera();
    }

    function resetCamera() {
        canvas.classList.add('hidden');
        video.classList.add('hidden');
        placeholder.classList.remove('hidden');
        openCameraModal();
    }

    function useCapturedPhoto() {
        const dataUrl = canvas.toDataURL('image/jpeg');
        photoInput.value = dataUrl;

        previewThumbnail.src = dataUrl;
        previewContainer.classList.remove('hidden');
        closeCameraModal();
    }

    function removeCameraPhoto() {
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

    window.addEventListener('beforeunload', stopCamera);

    // Form validation and AJAX processing
    document.addEventListener('DOMContentLoaded', function() {
        if (grievanceForm) {
            grievanceForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form inputs
                const name = document.getElementById('complainant_name').value.trim();
                const mobile = document.getElementById('complainant_mobile').value.trim();
                const area = document.getElementById('area').value.trim();
                const category = document.getElementById('category').value;
                const description = document.getElementById('description').value.trim();

                if (!name) {
                    showToast('Please enter your name.', 'error');
                    return;
                }
                if (!mobile || !/^[0-9]{10}$/.test(mobile)) {
                    showToast('Please enter a valid 10-digit mobile number.', 'error');
                    return;
                }
                if (!area) {
                    showToast('Please enter your locality/area.', 'error');
                    return;
                }
                if (!category) {
                    showToast('Please select a grievance category.', 'error');
                    return;
                }
                if (!description) {
                    showToast('Please enter grievance details.', 'error');
                    return;
                }

                // Show spinner loading state
                const submitBtn = grievanceForm.querySelector('button[type="submit"]');
                const originalBtnContent = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs mr-2"></span> Submitting Grievance...`;

                const formData = new FormData(grievanceForm);

                fetch(grievanceForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;

                    if (data.success) {
                        showToast('Grievance logged successfully!', 'success');

                        // Update success modal text & show
                        if (successModal) {
                            const desc = successModal.querySelector('#success-modal-description');
                            if (desc) {
                                desc.innerHTML = data.message || 'Your grievance has been successfully registered.';
                            }
                            successModal.showModal();
                        }

                        // Clean form inputs
                        grievanceForm.reset();
                        removeCameraPhoto();
                    } else {
                        showToast(data.message || 'Failed to submit. Please try again.', 'error');
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;
                    console.error('Submission error:', error);

                    if (error && error.errors) {
                        const firstKey = Object.keys(error.errors)[0];
                        const firstErrorMsg = error.errors[firstKey][0];
                        showToast(firstErrorMsg, 'error');
                    } else if (error && error.message) {
                        showToast(error.message, 'error');
                    } else {
                        showToast('A network error occurred. Please try again.', 'error');
                    }
                });
            });
        }
    });

    function trackGrievance(event) {
        event.preventDefault();
        const numberInput = document.getElementById('track-number-input');
        const number = numberInput.value.trim();
        if (!number) return;

        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalContent = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span>`;

        const resultContainer = document.getElementById('track-result-container');
        
        fetch(`/grievance/track?number=${encodeURIComponent(number)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalContent;

            if (data.success) {
                resultContainer.classList.remove('hidden');
                document.getElementById('track-complainant-name').textContent = data.complaint.complainant_name;
                document.getElementById('track-complaint-meta').textContent = `Category: ${data.complaint.category} | Area: ${data.complaint.area}`;
                
                const statusBadge = document.getElementById('track-status-badge');
                statusBadge.textContent = data.complaint.status_label;
                
                // Color badges based on status
                statusBadge.className = 'badge font-bold text-[9px] uppercase p-2.5';
                if (data.complaint.status === 'pending') {
                    statusBadge.classList.add('badge-warning');
                } else if (data.complaint.status === 'under_review') {
                    statusBadge.classList.add('badge-info');
                } else if (data.complaint.status === 'resolved') {
                    statusBadge.classList.add('badge-success', 'text-white');
                } else {
                    statusBadge.classList.add('badge-error', 'text-white');
                }

                // Render timeline logs
                const timeline = document.getElementById('track-logs-timeline');
                timeline.innerHTML = '';

                data.logs.forEach((log, index) => {
                    const activeStep = index === 0;
                    const stepDotBg = activeStep 
                        ? (log.status === 'resolved' ? 'bg-success' : (log.status === 'rejected' ? 'bg-error' : (log.status === 'under_review' ? 'bg-info' : 'bg-warning')))
                        : 'bg-base-300';
                    
                    const stepDotBorder = activeStep ? 'ring-4 ring-primary/20' : '';
                    
                    const logEl = document.createElement('div');
                    logEl.className = 'relative text-left';
                    logEl.innerHTML = `
                        <div class="absolute -left-[22px] top-1.5 w-3 h-3 rounded-full ${stepDotBg} ${stepDotBorder} border-2 border-base-100 z-10"></div>
                        <div class="bg-base-200/50 p-2.5 rounded-xl border border-base-300/40">
                            <div class="flex justify-between items-center gap-2">
                                <span class="text-[10px] font-bold text-base-content/80">${log.status_label}</span>
                                <span class="text-[9px] text-base-content/40 font-semibold">${log.timestamp}</span>
                            </div>
                            <p class="text-[11px] text-base-content/70 mt-1 leading-relaxed">${log.message}</p>
                        </div>
                    `;
                    timeline.appendChild(logEl);
                });
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalContent;
            console.error('Tracking error:', error);
            
            resultContainer.classList.add('hidden');
            const errMsg = error && error.message ? error.message : 'No records found matching this tracking number.';
            showToast(errMsg, 'error');
        });
    }
</script>
@endsection
