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
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('messages.form.name') }}" required class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                        <span>{{ __('messages.form.name') }} <span class="text-error font-extrabold">*</span></span>
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Please enter your name</div>
                                </div>

                                <div>
                                    <label class="floating-label w-full block">
                                        <input type="tel" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="{{ __('messages.form.mobile') }}" required pattern="[0-9]{10}" class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                        <span>{{ __('messages.form.mobile') }} <span class="text-error font-extrabold">*</span></span>
                                    </label>
                                    <div class="validator-hint text-[10px] font-semibold text-error/90">Enter a 10-digit mobile number (e.g. 9876543210)</div>
                                </div>
                            </div>

                            <!-- Row 2: Ward Area -->
                            <div>
                                <label class="floating-label w-full block">
                                    <input type="text" name="area" id="area" value="{{ old('area') }}" placeholder="{{ __('messages.form.area') }}" required class="input input-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator" />
                                    <span>{{ __('messages.form.area') }} <span class="text-error font-extrabold">*</span></span>
                                </label>
                                <div class="validator-hint text-[10px] font-semibold text-error/90">Ward Area or Block is required</div>
                            </div>

                            <!-- DaisyUI Star Rating Input block nested perfectly -->
                            <div class="flex items-center gap-3 bg-base-200 px-4 py-2 border border-base-300 rounded-xl justify-between h-[3.25rem]">
                                <span class="text-xs font-extrabold text-base-content/65 uppercase tracking-wider">{{ __('messages.form.rating') }}</span>
                                <div class="rating rating-md gap-0.5">
                                    <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-warning" required />
                                    <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-warning" />
                                    <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-warning" />
                                    <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-warning" checked />
                                    <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-warning" />
                                </div>
                            </div>

                            <!-- Message / Comments Textarea -->
                            <div class="relative">
                                <label class="floating-label w-full block">
                                    <textarea name="message" id="message" placeholder="{{ __('messages.form.message') }}" required class="textarea textarea-bordered textarea-md h-24 w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all validator"></textarea>
                                    <span>{{ __('messages.form.message') }} <span class="text-error font-extrabold">*</span></span>
                                </label>
                                <div class="validator-hint text-[10px] font-semibold text-error/90 font-sans">Please share your feedback details</div>
                            </div>

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

<!-- Success Modal Popup (Standard Dialog Markup) -->
<dialog id="success_modal" class="modal modal-bottom sm:modal-middle">
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
            {{ session('success') ?? 'Your feedback has been submitted successfully.' }}
        </p>

        <!-- Dynamic development quote or thank you note -->
        <div class="bg-base-200/60 rounded-xl p-3 mt-4 text-[10px] text-base-content/60 italic border border-base-300/40">
            "Your feedback is a valuable brick in building a stronger, safer, and cleaner Vadodara Ward 7."
        </div>

        <div class="modal-action justify-center mt-6">
            <form method="dialog">
                <button class="btn btn-sm btn-primary text-white rounded-xl font-bold px-6 shadow-md hover:shadow-lg transition-all duration-200">
                    Jai Hind
                </button>
            </form>
        </div>
    </div>
    <!-- Backdrop to close on click natively -->
    <form method="dialog" class="modal-backdrop bg-black/45 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

<!-- Toaster Alert & AJAX Form Submission Script -->
<script>
    // Universal DaisyUI Toaster Engine
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

        // Slide and fade in
        setTimeout(() => {
            alertEl.classList.remove('translate-y-4', 'opacity-0');
        }, 10);

        // Slide/fade out and remove after 4 seconds
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

    document.addEventListener('DOMContentLoaded', function() {
        // Trigger success dialog on redirect load if session exists
        @if(session('success'))
            const successModal = document.getElementById('success_modal');
            if (successModal) {
                successModal.showModal();
            }
        @endif

        const form = document.getElementById('detailed-feedback-form');
        const successModal = document.getElementById('success_modal');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Client-side validations
                const name = document.getElementById('name').value.trim();
                const mobile = document.getElementById('mobile_number').value.trim();
                const area = document.getElementById('area').value.trim();
                const message = document.getElementById('message').value.trim();

                if (!name) {
                    showToast('Please enter your name.', 'error');
                    return;
                }
                if (!mobile || !/^[0-9]{10}$/.test(mobile)) {
                    showToast('Please enter a valid 10-digit mobile number.', 'error');
                    return;
                }
                if (!area) {
                    showToast('Please enter your block/area.', 'error');
                    return;
                }
                if (!message) {
                    showToast('Please enter your feedback details.', 'error');
                    return;
                }

                // Show submitting loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnContent = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs mr-2"></span> Submitting...`;

                const formData = new FormData(form);

                fetch(form.action, {
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
                        showToast(data.message || 'Feedback submitted successfully!', 'success');

                        // Show success modal natively
                        if (successModal) {
                            const descEl = successModal.querySelector('.modal-box p');
                            if (descEl) {
                                descEl.textContent = data.message || 'Your feedback has been submitted successfully.';
                            }
                            successModal.showModal();
                        }

                        // Reset form
                        form.reset();

                        // Reload feedback list asynchronously using the listing fetcher
                        const container = document.getElementById('feedback-listing-container');
                        if (container) {
                            const activePageLink = container.querySelector('.join-item.btn-primary');
                            const url = activePageLink ? activePageLink.getAttribute('href') : window.location.href;
                            
                            // Re-fetch using internal AJAX function
                            container.classList.add('relative');
                            const oldOverlay = container.querySelector('.feedback-loader-overlay');
                            if (oldOverlay) oldOverlay.remove();
                            
                            const loader = document.createElement('div');
                            loader.className = 'feedback-loader-overlay absolute inset-0 bg-base-100/75 backdrop-blur-[2px] flex items-center justify-center z-50 min-h-[300px] transition-opacity duration-300';
                            loader.innerHTML = `
                                <div class="flex flex-col items-center gap-3 bg-base-100 border border-base-300 shadow-2xl px-6 py-4 rounded-3xl animate-pulse">
                                    <span class="loading loading-spinner loading-md text-primary"></span>
                                    <span class="text-[10px] font-extrabold text-base-content/75 uppercase tracking-wider">Refreshing listing...</span>
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
                            })
                            .catch(error => {
                                console.error('Error refreshing listing:', error);
                                const overlay = container.querySelector('.feedback-loader-overlay');
                                if (overlay) overlay.remove();
                            });
                        }
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
</script>
@endsection
