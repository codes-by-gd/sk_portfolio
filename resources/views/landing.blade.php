@extends('layouts.app')

@section('title', 'Sachin Khandelwal - Vadodara Ward No. 7')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden bg-gradient-to-b from-[#FFFDF8] via-[#FFFDF8] to-[#F3EFE6] py-16 lg:py-24">
        <!-- Background decorative elements -->
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-[#FF8A3D]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#53C58B]/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Info Column -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#FF8A3D]/10 text-[#FF8A3D] border border-[#FF8A3D]/20 uppercase tracking-widest">
                    <i class="fa-solid fa-star"></i> {{ $cms['hero_greeting'] ?? 'Namaste & Welcome' }}
                </span>
                
                <h1 class="font-heading font-extrabold text-4xl sm:text-5xl lg:text-6xl text-neutral leading-tight">
                    {{ $cms['hero_title'] ?? 'Serving the People of Vadodara Ward No. 7' }}
                </h1>
                
                <p class="text-lg text-neutral/80 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    {{ $cms['hero_mission'] ?? 'Committed to development, public welfare, and transparent leadership.' }}
                </p>

                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                    <a href="#feedback" class="btn btn-primary btn-md sm:btn-lg shadow-lg hover:shadow-primary/30 transition-all rounded-xl gap-2 text-white">
                        <i class="fa-solid fa-comment-dots"></i> {{ __('messages.hero.cta_feedback') }}
                    </a>
                    <a href="#development" class="btn btn-outline btn-secondary btn-md sm:btn-lg transition-all rounded-xl gap-2 hover:bg-secondary">
                        <i class="fa-solid fa-helmet-safety"></i> {{ __('messages.hero.cta_work') }}
                    </a>
                </div>
            </div>

            <!-- Right Portrait Image Column -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-72 h-72 sm:w-96 sm:h-96">
                    <!-- Elegant background glow shapes -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#FF8A3D]/20 to-[#3D5AFE]/10 rounded-[2.5rem] rotate-6 scale-95 -z-10"></div>
                    <div class="absolute inset-0 bg-[#FFFDF8] rounded-[2.5rem] border-2 border-base-300 -z-10 shadow-xl"></div>
                    
                    <!-- Portrait image -->
                    <img src="{{ asset('images/hero_portrait.png') }}" alt="Sachin Khandelwal" class="w-full h-full object-cover rounded-[2.5rem] shadow-inner p-3">
                </div>
            </div>
        </div>
    </section>

    <!-- Biography / Vision Section -->
    <section id="about" class="py-16 bg-[#FFFDF8] border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral">
                    {{ $cms['about_title'] ?? 'Biography & Vision' }}
                </h2>
                <div class="w-24 h-1 bg-[#FF8A3D] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Biography Card -->
                <div class="lg:col-span-7 bg-[#F6F3EB] p-8 rounded-2xl border border-base-300 shadow-sm space-y-6">
                    <h3 class="font-heading font-bold text-xl text-[#3D5AFE] flex items-center gap-2">
                        <i class="fa-solid fa-landmark"></i> Public Leadership
                    </h3>
                    <p class="text-neutral/80 leading-relaxed text-justify">
                        {{ $cms['about_bio'] ?? '' }}
                    </p>
                </div>

                <!-- Vision Card -->
                <div class="lg:col-span-5 bg-gradient-to-br from-[#3D5AFE]/5 to-[#FF8A3D]/5 p-8 rounded-2xl border border-[#3D5AFE]/10 shadow-sm space-y-6">
                    <h3 class="font-heading font-bold text-xl text-[#FF8A3D] flex items-center gap-2">
                        <i class="fa-solid fa-bullseye"></i> {{ __('messages.sections.about') }}
                    </h3>
                    <p class="text-neutral/80 leading-relaxed text-justify">
                        {{ $cms['about_vision'] ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Metrics / Achievements Section -->
    <section id="achievements" class="py-12 bg-secondary text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.05),transparent)]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <!-- Metric 1 -->
                <div class="space-y-2 p-4 bg-white/5 rounded-2xl backdrop-blur-sm border border-white/10 hover:scale-105 transition-transform duration-300">
                    <div class="text-3xl sm:text-4xl text-[#FF8A3D]"><i class="fa-solid fa-road"></i></div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white">{{ $cms['achievement_roads'] ?? '12+ km' }}</div>
                    <p class="text-xs sm:text-sm text-white/80">Roads Built</p>
                </div>
                <!-- Metric 2 -->
                <div class="space-y-2 p-4 bg-white/5 rounded-2xl backdrop-blur-sm border border-white/10 hover:scale-105 transition-transform duration-300">
                    <div class="text-3xl sm:text-4xl text-[#FF8A3D]"><i class="fa-solid fa-lightbulb"></i></div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white">{{ $cms['achievement_lights'] ?? '1,500+' }}</div>
                    <p class="text-xs sm:text-sm text-white/80">LED Lights</p>
                </div>
                <!-- Metric 3 -->
                <div class="space-y-2 p-4 bg-white/5 rounded-2xl backdrop-blur-sm border border-white/10 hover:scale-105 transition-transform duration-300">
                    <div class="text-3xl sm:text-4xl text-[#FF8A3D]"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white">{{ $cms['achievement_grievances'] ?? '98%' }}</div>
                    <p class="text-xs sm:text-sm text-white/80">Resolved Grievances</p>
                </div>
                <!-- Metric 4 -->
                <div class="space-y-2 p-4 bg-white/5 rounded-2xl backdrop-blur-sm border border-white/10 hover:scale-105 transition-transform duration-300">
                    <div class="text-3xl sm:text-4xl text-[#FF8A3D]"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white">{{ $cms['achievement_camps'] ?? '50+' }}</div>
                    <p class="text-xs sm:text-sm text-white/80">Health Camps</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Works Section -->
    <section id="development" class="py-16 bg-[#F3EFE6] border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral">
                    {{ __('messages.sections.development') }}
                </h2>
                <div class="w-24 h-1 bg-[#FF8A3D] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($developmentWorks as $work)
                    <div class="card bg-[#FFFDF8] border border-base-300 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 rounded-2xl overflow-hidden">
                        <!-- Before / After Side-by-side or stacked container -->
                        <div class="grid grid-cols-2 gap-0.5 bg-base-300 h-48 relative">
                            <!-- Before Container -->
                            <div class="relative overflow-hidden group">
                                <div class="absolute top-2 left-2 z-10 badge badge-warning text-[10px] uppercase font-bold tracking-wider">Before</div>
                                <div class="w-full h-full bg-[#1E1E1E] flex items-center justify-center text-white/50 text-xs font-semibold">
                                    <i class="fa-solid fa-image text-2xl opacity-40"></i>
                                </div>
                            </div>
                            <!-- After Container -->
                            <div class="relative overflow-hidden group">
                                <div class="absolute top-2 right-2 z-10 badge badge-success text-[10px] uppercase font-bold text-white tracking-wider">After</div>
                                <div class="w-full h-full bg-[#1E1E1E] flex items-center justify-center text-white/50 text-xs font-semibold">
                                    <i class="fa-solid fa-circle-check text-2xl text-accent opacity-65"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card Details -->
                        <div class="p-6 space-y-4">
                            <span class="inline-flex items-center gap-1 text-xs text-[#3D5AFE] font-bold">
                                <i class="fa-solid fa-location-dot"></i> {{ $work->location }}
                            </span>
                            <h3 class="font-heading font-bold text-lg text-neutral leading-snug">
                                {{ $work->title }}
                            </h3>
                            <p class="text-sm text-neutral/70 line-clamp-3">
                                {{ $work->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Citizens Feedback & Carousel Section -->
    <section id="feedback" class="py-16 bg-[#FFFDF8] border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral">
                    {{ __('messages.sections.feedback') }}
                </h2>
                <div class="w-24 h-1 bg-[#FF8A3D] mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Feedback Carousel Wrapper -->
            @if($feedbacks->isNotEmpty())
                <div class="relative max-w-4xl mx-auto mb-16 overflow-hidden bg-[#F6F3EB] rounded-3xl border border-base-300 p-8 sm:p-12 shadow-sm">
                    <div class="absolute top-6 left-6 text-[#FF8A3D]/25 text-5xl sm:text-7xl"><i class="fa-solid fa-quote-left"></i></div>
                    
                    <!-- Carousel Slider container -->
                    <div id="feedback-slider" class="relative min-h-[12rem] flex flex-col justify-center items-center text-center">
                        @foreach($feedbacks as $index => $fb)
                            <div class="feedback-slide {{ $index === 0 ? '' : 'hidden' }} space-y-6 transition-opacity duration-500" data-index="{{ $index }}">
                                <h3 class="font-heading font-bold text-xl text-neutral">{{ $fb->title }}</h3>
                                <p class="text-neutral/80 text-md sm:text-lg italic leading-relaxed max-w-2xl">
                                    "{!! nl2br(e($fb->message)) !!}"
                                </p>
                                
                                <!-- Rating Stars -->
                                <div class="flex justify-center text-warning text-lg gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $fb->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>

                                <!-- Feedback Images if present -->
                                @if($fb->images->isNotEmpty())
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        @foreach($fb->images as $img)
                                            <a href="{{ asset($img->image_path) }}" target="_blank" class="w-16 h-16 rounded-xl overflow-hidden border border-base-300 hover:scale-105 transition-transform duration-300">
                                                <img src="{{ asset($img->image_path) }}" class="object-cover w-full h-full" alt="Feedback media">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-neutral">{{ $fb->name }}</span>
                                    <span class="text-xs text-neutral/60 font-semibold uppercase tracking-wider">{{ $fb->area }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Slider Controls -->
                    <div class="flex justify-between items-center mt-8">
                        <button onclick="prevSlide()" class="btn btn-sm btn-circle btn-outline hover:bg-neutral hover:text-white border-base-300" aria-label="Previous Slide">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <div class="flex gap-1.5" id="slide-dots">
                            @foreach($feedbacks as $index => $fb)
                                <button onclick="setSlide({{ $index }})" class="w-2.5 h-2.5 rounded-full {{ $index === 0 ? 'bg-[#FF8A3D]' : 'bg-base-300' }} transition-colors" data-dot="{{ $index }}"></button>
                            @endforeach
                        </div>
                        <button onclick="nextSlide()" class="btn btn-sm btn-circle btn-outline hover:bg-neutral hover:text-white border-base-300" aria-label="Next Slide">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Quick Feedback Form Card -->
            <div id="quick-feedback-form" class="max-w-2xl mx-auto bg-[#FFFDF8] rounded-3xl border border-base-300 shadow-xl overflow-hidden mt-8">
                <!-- Top border accent -->
                <div class="h-2 bg-[#FF8A3D]"></div>
                
                <div class="p-8 sm:p-10 space-y-6">
                    <div class="text-center">
                        <h3 class="font-heading font-extrabold text-2xl text-neutral">{{ __('messages.form.quick_title') }}</h3>
                        <p class="text-sm text-neutral/70 mt-1">Submit your quick review. For file uploads and pictures, please use our <a href="{{ route('feedback.detailed') }}" class="text-[#3D5AFE] font-semibold hover:underline">detailed feedback page</a>.</p>
                    </div>

                    <!-- Alerts for Form Status -->
                    @if(session('success'))
                        <div class="alert alert-success shadow-sm rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-sm font-semibold text-white">{{ session('success') }}</span>
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

                    <!-- Form with DaisyUI Floating Labels -->
                    <form action="{{ route('feedback.store') }}" method="POST" class="space-y-5">
                        @csrf
                        
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
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
                            <textarea id="message" name="message" required placeholder=" " rows="3" 
                                class="peer textarea textarea-bordered w-full pt-5 pb-1 min-h-[5rem] bg-transparent border-base-300 focus:border-primary focus:outline-none rounded-xl text-neutral text-sm transition-all"></textarea>
                            <label for="message" 
                                class="absolute left-4 pointer-events-none transition-all duration-200 text-neutral/50 font-medium
                                top-5 -translate-y-1/2 text-sm
                                peer-placeholder-shown:top-5 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-sm
                                peer-focus:top-2 peer-focus:-translate-y-0 peer-focus:text-xs peer-focus:text-primary">
                                {{ __('messages.form.message') }}
                            </label>
                        </div>

                        <!-- Rating Selection (1-5 Stars) -->
                        <div class="flex flex-col gap-2">
                            <span class="text-xs font-bold text-neutral/70 uppercase tracking-wider">{{ __('messages.form.rating') }}</span>
                            <div class="rating rating-md gap-1">
                                <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-warning" checked />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-full text-white font-bold h-12 rounded-xl mt-2 hover:shadow-lg transition-all">
                            {{ __('messages.form.submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Photo Gallery Section with Tabs Filtering -->
    <section id="gallery" class="py-16 bg-[#F3EFE6] border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral">
                    {{ __('messages.sections.gallery') }}
                </h2>
                <div class="w-24 h-1 bg-[#FF8A3D] mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8" id="gallery-tabs">
                <button onclick="filterGallery('all')" class="btn btn-sm btn-active bg-primary hover:bg-primary/95 text-white border-none rounded-lg px-4 gallery-tab-btn" data-category="all">
                    {{ __('messages.gallery.all') }}
                </button>
                <button onclick="filterGallery('visits')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-neutral border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="visits">
                    {{ __('messages.gallery.visits') }}
                </button>
                <button onclick="filterGallery('events')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-neutral border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="events">
                    {{ __('messages.gallery.events') }}
                </button>
                <button onclick="filterGallery('works')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-neutral border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="works">
                    {{ __('messages.gallery.works') }}
                </button>
                <button onclick="filterGallery('community')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-neutral border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="community">
                    {{ __('messages.gallery.community') }}
                </button>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="gallery-grid">
                @foreach($galleryImages as $image)
                    <div class="gallery-item relative overflow-hidden rounded-2xl border border-base-300 shadow-md group h-64 bg-base-300 transition-all duration-300 hover:scale-[1.02]" data-category="{{ $image->category }}">
                        <!-- Placeholder graphic overlay since these are local Review seed tags -->
                        <div class="absolute inset-0 bg-neutral/80 flex flex-col justify-center items-center text-center p-4 opacity-100 group-hover:opacity-90 transition-opacity duration-300 z-10">
                            <span class="text-[#FF8A3D] text-xs font-bold uppercase tracking-widest mb-1">{{ $image->category }}</span>
                            <h4 class="text-white font-bold font-heading text-md px-2">{{ $image->caption }}</h4>
                            <div class="mt-3 text-white/50 text-xs"><i class="fa-solid fa-camera"></i> Photo Asset</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-[#FFFDF8] border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral">
                    {{ __('messages.sections.contact') }}
                </h2>
                <div class="w-24 h-1 bg-[#FF8A3D] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Contact info details card -->
                <div class="lg:col-span-5 bg-[#F6F3EB] rounded-2xl border border-base-300 p-8 flex flex-col justify-between space-y-6">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-primary/10 text-primary p-3 rounded-xl"><i class="fa-solid fa-location-dot text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-neutral">Office Address</h4>
                                <p class="text-sm text-neutral/70 mt-1">{{ $settings['office_address'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-[#3D5AFE]/10 text-[#3D5AFE] p-3 rounded-xl"><i class="fa-solid fa-phone text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-neutral">Phone Numbers</h4>
                                <p class="text-sm text-neutral/70 mt-1">{{ $settings['office_phone'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-[#53C58B]/10 text-[#53C58B] p-3 rounded-xl"><i class="fa-solid fa-envelope text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-neutral">Email Contact</h4>
                                <p class="text-sm text-neutral/70 mt-1">{{ $settings['office_email'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-[#FF8A3D]/10 text-[#FF8A3D] p-3 rounded-xl"><i class="fa-solid fa-calendar-days text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-neutral">Office Timings</h4>
                                <p class="text-sm text-neutral/70 mt-1">{{ $settings['office_timings'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Banner Info -->
                    <div class="border-t border-base-300 pt-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-neutral/50">Follow on Social Media</span>
                        <div class="flex gap-3 text-lg mt-3">
                            <a href="#" class="btn btn-sm btn-circle btn-primary text-white"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-sm btn-circle btn-info text-white"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="btn btn-sm btn-circle btn-error text-white"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="btn btn-sm btn-circle btn-ghost border-base-300 hover:border-red-600 text-red-600"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Google Map Placeholder Card -->
                <div class="lg:col-span-7 bg-base-200 rounded-2xl border border-base-300 overflow-hidden relative min-h-[300px] flex items-center justify-center">
                    <!-- Interactive styled SVG mock map -->
                    <div class="absolute inset-0 bg-[#EAE6DB] flex flex-col justify-center items-center text-center p-8">
                        <i class="fa-solid fa-map-location text-5xl text-neutral/30 mb-4 animate-bounce"></i>
                        <h4 class="font-heading font-bold text-neutral">Vadodara Ward Office Location Map</h4>
                        <p class="text-sm text-neutral/65 max-w-sm mt-1">Mock Interactive Map Center: Subhanpura Road, Ward 7, Vadodara, Gujarat</p>
                        <span class="btn btn-xs btn-outline btn-neutral mt-4 rounded-lg">Open in Google Maps</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Javascript -->
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.feedback-slide');
        const dots = document.querySelectorAll('#slide-dots button');

        function showSlide(index) {
            if (slides.length === 0) return;
            slides.forEach(slide => slide.classList.add('hidden'));
            dots.forEach(dot => {
                dot.classList.remove('bg-[#FF8A3D]');
                dot.classList.add('bg-base-300');
            });
            
            currentSlide = (index + slides.length) % slides.length;
            
            const activeSlide = document.querySelector(`.feedback-slide[data-index="${currentSlide}"]`);
            const activeDot = document.querySelector(`#slide-dots button[data-dot="${currentSlide}"]`);
            
            if (activeSlide) activeSlide.classList.remove('hidden');
            if (activeDot) {
                activeDot.classList.remove('bg-base-300');
                activeDot.classList.add('bg-[#FF8A3D]');
            }
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function setSlide(index) {
            showSlide(index);
        }

        // Auto rotate carousel every 6 seconds
        if (slides.length > 1) {
            setInterval(nextSlide, 6000);
        }

        // Gallery Filter Javascript
        function filterGallery(category) {
            // Update Active Tab styles
            const tabButtons = document.querySelectorAll('.gallery-tab-btn');
            tabButtons.forEach(btn => {
                btn.classList.remove('btn-active', 'bg-primary', 'text-white', 'border-none');
                btn.classList.add('bg-base-100', 'text-neutral', 'border', 'border-base-300');
            });
            
            const activeBtn = document.querySelector(`.gallery-tab-btn[data-category="${category}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-base-100', 'text-neutral', 'border', 'border-base-300');
                activeBtn.classList.add('btn-active', 'bg-primary', 'text-white', 'border-none');
            }

            // Hide/Show items
            const items = document.querySelectorAll('.gallery-item');
            items.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                if (category === 'all' || itemCategory === category) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        }
    </script>
@endsection
