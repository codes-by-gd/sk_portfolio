@extends('layouts.app')

@section('title', 'Sachin Khandelwal - Vadodara Ward No. 7')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden bg-gradient-to-b from-base-100 via-base-100 to-base-200 py-16 lg:py-24">
        <!-- Background decorative elements -->
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Info Column -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-widest">
                    <i class="fa-solid fa-star"></i> {{ $cms['hero_greeting'] ?? 'Namaste & Welcome' }}
                </span>
                
                <h1 class="font-heading font-extrabold text-4xl sm:text-5xl lg:text-6xl text-base-content leading-tight">
                    {{ $cms['hero_title'] ?? 'Serving the People of Vadodara Ward No. 7' }}
                </h1>
                
                <p class="text-lg text-base-content/85 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    {{ $cms['hero_mission'] ?? 'Committed to development, public welfare, and transparent leadership.' }}
                </p>

                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                    <a href="#feedback" class="btn btn-primary btn-md sm:btn-lg shadow-lg hover:shadow-primary/30 transition-all rounded-xl gap-2 text-white">
                        <i class="fa-solid fa-comment-dots"></i> {{ __('messages.hero.cta_feedback') }}
                    </a>
                    <a href="#development" class="btn btn-outline btn-secondary btn-md sm:btn-lg transition-all rounded-xl gap-2 hover:text-white">
                        <i class="fa-solid fa-helmet-safety"></i> {{ __('messages.hero.cta_work') }}
                    </a>
                </div>
            </div>

            <!-- Right Portrait Image Column -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-72 h-72 sm:w-96 sm:h-96">
                    <!-- Elegant background glow shapes -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-secondary/15 rounded-[2.5rem] rotate-6 scale-95 -z-10 animate-pulse"></div>
                    <div class="absolute inset-0 bg-base-100 rounded-[2.5rem] border-2 border-base-300 -z-10 shadow-xl"></div>
                    
                    <!-- Portrait image with robust placeholder fallback -->
                    <img src="{{ asset('images/hero_portrait.png') }}" alt="Sachin Khandelwal" class="w-full h-full object-cover rounded-[2.5rem] shadow-inner p-3" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=Sachin%20Khandelwal&backgroundColor=ff8a3d&textColor=ffffff&fontSize=35&bold=true'">
                </div>
            </div>
        </div>
    </section>

    <!-- Biography / Vision Section -->
    <section id="about" class="py-16 bg-base-100 border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-base-content">
                    {{ $cms['about_title'] ?? 'Biography & Vision' }}
                </h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Biography Card -->
                <div class="lg:col-span-7 bg-base-200 p-8 rounded-2xl border border-base-300 shadow-sm space-y-6">
                    <h3 class="font-heading font-bold text-xl text-secondary flex items-center gap-2">
                        <i class="fa-solid fa-landmark"></i> Public Leadership
                    </h3>
                    <p class="text-base-content/80 leading-relaxed text-justify">
                        {{ $cms['about_bio'] ?? '' }}
                    </p>
                </div>

                <!-- Vision Card -->
                <div class="lg:col-span-5 bg-gradient-to-br from-secondary/5 to-primary/5 p-8 rounded-2xl border border-secondary/10 shadow-sm space-y-6">
                    <h3 class="font-heading font-bold text-xl text-primary flex items-center gap-2">
                        <i class="fa-solid fa-bullseye"></i> {{ __('messages.sections.about') }}
                    </h3>
                    <p class="text-base-content/80 leading-relaxed text-justify">
                        {{ $cms['about_vision'] ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Metrics / Achievements Section -->
    <section id="achievements" class="py-14 bg-neutral text-neutral-content relative overflow-hidden">
        <!-- Warm saffron-to-green diagonal gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-accent/10 pointer-events-none"></div>
        <!-- Subtle radial highlight top-right -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,138,61,0.08),transparent_60%)] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section heading -->
            <div class="text-center mb-10">
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-neutral-content">{{ __('messages.sections.achievements') }}</h2>
                <div class="w-16 h-0.5 bg-primary mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <!-- Metric 1 — Roads (Saffron) -->
                <div class="group space-y-3 p-5 bg-white/5 rounded-2xl border border-white/10 hover:border-primary/40 hover:bg-primary/10 hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-primary/15 flex items-center justify-center group-hover:bg-primary/25 transition-colors duration-300">
                        <i class="fa-solid fa-road text-2xl text-primary"></i>
                    </div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-neutral-content">{{ $cms['achievement_roads'] ?? '12+ km' }}</div>
                    <p class="text-xs sm:text-sm text-neutral-content/65 font-semibold uppercase tracking-wider">Roads Built</p>
                </div>
                <!-- Metric 2 — LED Lights (Accent/Green) -->
                <div class="group space-y-3 p-5 bg-white/5 rounded-2xl border border-white/10 hover:border-accent/40 hover:bg-accent/10 hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-accent/15 flex items-center justify-center group-hover:bg-accent/25 transition-colors duration-300">
                        <i class="fa-solid fa-lightbulb text-2xl text-accent"></i>
                    </div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-neutral-content">{{ $cms['achievement_lights'] ?? '1,500+' }}</div>
                    <p class="text-xs sm:text-sm text-neutral-content/65 font-semibold uppercase tracking-wider">LED Lights</p>
                </div>
                <!-- Metric 3 — Grievances (Secondary/Blue) -->
                <div class="group space-y-3 p-5 bg-white/5 rounded-2xl border border-white/10 hover:border-secondary/40 hover:bg-secondary/10 hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-secondary/15 flex items-center justify-center group-hover:bg-secondary/25 transition-colors duration-300">
                        <i class="fa-solid fa-circle-check text-2xl text-secondary"></i>
                    </div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-neutral-content">{{ $cms['achievement_grievances'] ?? '98%' }}</div>
                    <p class="text-xs sm:text-sm text-neutral-content/65 font-semibold uppercase tracking-wider">Resolved Grievances</p>
                </div>
                <!-- Metric 4 — Health Camps (Warning/Gold) -->
                <div class="group space-y-3 p-5 bg-white/5 rounded-2xl border border-white/10 hover:border-warning/40 hover:bg-warning/10 hover:scale-105 transition-all duration-300">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-warning/15 flex items-center justify-center group-hover:bg-warning/25 transition-colors duration-300">
                        <i class="fa-solid fa-hand-holding-heart text-2xl text-warning"></i>
                    </div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-neutral-content">{{ $cms['achievement_camps'] ?? '50+' }}</div>
                    <p class="text-xs sm:text-sm text-neutral-content/65 font-semibold uppercase tracking-wider">Health Camps</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Works Section -->
    <section id="development" class="py-16 bg-base-200 border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-base-content">
                    {{ __('messages.sections.development') }}
                </h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($developmentWorks as $work)
                    <div class="card bg-base-100 card-base card-base-hover hover:-translate-y-1 transition-all duration-300 rounded-2xl overflow-hidden">
                        <!-- Before / After Side-by-side or stacked container -->
                        <div class="grid grid-cols-2 gap-0.5 bg-base-300 h-48 relative">
                            <!-- Before Container -->
                            <div class="relative overflow-hidden group">
                                <div class="absolute top-2 left-2 z-10 badge badge-warning text-[10px] uppercase font-bold tracking-wider">Before</div>
                                @if($work->before_image)
                                    <img src="{{ asset($work->before_image) }}" class="object-cover w-full h-full" alt="Before" loading="lazy" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=Before&backgroundColor=d1d5db&textColor=1f2937'">
                                @else
                                    <div class="w-full h-full bg-[#1E1E1E] flex items-center justify-center text-white/50 text-xs font-semibold">
                                        <i class="fa-solid fa-image text-2xl opacity-40"></i>
                                    </div>
                                @endif
                            </div>
                            <!-- After Container -->
                            <div class="relative overflow-hidden group">
                                <div class="absolute top-2 right-2 z-10 badge badge-success text-[10px] uppercase font-bold text-white tracking-wider">After</div>
                                @if($work->after_image)
                                    <img src="{{ asset($work->after_image) }}" class="object-cover w-full h-full" alt="After" loading="lazy" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=After&backgroundColor=53C58B&textColor=ffffff'">
                                @else
                                    <div class="w-full h-full bg-[#1E1E1E] flex items-center justify-center text-white/50 text-xs font-semibold">
                                        <i class="fa-solid fa-circle-check text-2xl text-accent opacity-65"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Details -->
                        <div class="p-6 space-y-4">
                            <span class="inline-flex items-center gap-1 text-xs text-secondary font-extrabold">
                                <i class="fa-solid fa-location-dot"></i> {{ $work->location }}
                            </span>
                            <h3 class="font-heading font-bold text-lg text-base-content leading-snug">
                                {{ $work->title }}
                            </h3>
                            <p class="text-sm text-base-content/75 line-clamp-3">
                                {{ $work->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Citizens Feedback & Carousel Section -->
    <section id="feedback" class="py-16 bg-base-100 border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-base-content">
                    {{ __('messages.sections.feedback') }}
                </h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Feedback Carousel Wrapper -->
            @if($feedbacks->isNotEmpty())
                <div class="relative max-w-6xl mx-auto mb-10 overflow-hidden bg-base-200 rounded-3xl border border-base-300 p-8 sm:p-10 shadow-sm">
                    <div class="absolute top-6 left-6 text-primary/25 text-5xl sm:text-7xl pointer-events-none"><i class="fa-solid fa-quote-left"></i></div>
                    
                    <!-- Carousel Slider container -->
                    <div id="feedback-slider" class="relative w-full">
                        @foreach($feedbacks->chunk(3) as $slideIndex => $chunk)
                            <div class="feedback-slide {{ $slideIndex === 0 ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-3 gap-6 transition-all duration-500" data-index="{{ $slideIndex }}">
                                @foreach($chunk as $fb)
                                    <div class="bg-base-100 card-base rounded-2xl p-6 flex flex-col justify-between space-y-4">
                                        <div class="space-y-4">
                                            <!-- Submitter Avatar & Details -->
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-full overflow-hidden border border-base-300 bg-base-200 shrink-0 shadow-sm">
                                                    @if($fb->avatar_path)
                                                        <img src="{{ asset($fb->avatar_path) }}" class="object-cover w-full h-full" alt="{{ $fb->name }}" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed='+encodeURIComponent('{{ $fb->name }}')+'&backgroundColor=ff8a3d&textColor=ffffff'">
                                                    @else
                                                        <div class="w-full h-full bg-base-300 flex items-center justify-center text-base-content/50 font-heading font-extrabold text-xs uppercase">
                                                            {{ substr($fb->name, 0, 2) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-left">
                                                    <h4 class="font-bold text-base-content text-sm leading-snug">{{ $fb->name }}</h4>
                                                    <p class="text-[10px] text-secondary font-extrabold uppercase tracking-wider">{{ $fb->area }}</p>
                                                </div>
                                            </div>

                                            <!-- Rating Stars -->
                                            <div class="flex text-warning text-xs gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-{{ $i <= $fb->rating ? 'solid' : 'regular' }} fa-star"></i>
                                                @endfor
                                            </div>

                                            <!-- Title & Message -->
                                            <div>
                                                <h5 class="font-bold text-base-content text-sm leading-snug mb-1">{{ $fb->title }}</h5>
                                                <p class="text-base-content/75 text-xs leading-relaxed line-clamp-4 italic">
                                                    "{!! nl2br(e($fb->message)) !!}"
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Media Attachments -->
                                        @if($fb->images->isNotEmpty())
                                            <div class="flex gap-1.5 flex-wrap pt-2">
                                                @foreach($fb->images as $img)
                                                    <a href="{{ asset($img->image_path) }}" target="_blank" class="w-8 h-8 rounded-lg overflow-hidden border border-base-300 hover:scale-105 transition-transform duration-200 block bg-base-300">
                                                        <img src="{{ asset($img->image_path) }}" class="object-cover w-full h-full" alt="Feedback media" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=Media&backgroundColor=e2e8f0&textColor=1f2937'">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <!-- Slider Controls -->
                    <div class="flex justify-between items-center mt-8">
                        <button onclick="prevSlide()" class="btn btn-sm btn-circle btn-outline hover:bg-neutral hover:text-white border-base-300" aria-label="Previous Slide">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <div class="flex gap-1.5" id="slide-dots">
                            @foreach($feedbacks->chunk(3) as $slideIndex => $chunk)
                                <button onclick="setSlide({{ $slideIndex }})" class="w-2.5 h-2.5 rounded-full {{ $slideIndex === 0 ? 'bg-primary' : 'bg-base-300' }} transition-colors" data-dot="{{ $slideIndex }}"></button>
                            @endforeach
                        </div>
                        <button onclick="nextSlide()" class="btn btn-sm btn-circle btn-outline hover:bg-neutral hover:text-white border-base-300" aria-label="Next Slide">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- CTA Button to Detailed Feedback Page -->
            <div class="text-center mt-8">
                <a href="{{ route('feedback.detailed') }}" class="btn btn-primary text-white font-bold rounded-xl shadow-md px-8 py-3.5 hover:shadow-lg transition-all gap-2">
                    <i class="fa-solid fa-file-pen text-lg"></i> {{ __('messages.hero.cta_feedback') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Photo Gallery Section with Tabs Filtering -->
    <section id="gallery" class="py-16 bg-base-200 border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-base-content">
                    {{ __('messages.sections.gallery') }}
                </h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8" id="gallery-tabs">
                <button onclick="filterGallery('all')" class="btn btn-sm btn-active bg-primary hover:bg-primary/95 text-white border-none rounded-lg px-4 gallery-tab-btn" data-category="all">
                    {{ __('messages.gallery.all') }}
                </button>
                <button onclick="filterGallery('visits')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-base-content border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="visits">
                    {{ __('messages.gallery.visits') }}
                </button>
                <button onclick="filterGallery('events')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-base-content border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="events">
                    {{ __('messages.gallery.events') }}
                </button>
                <button onclick="filterGallery('works')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-base-content border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="works">
                    {{ __('messages.gallery.works') }}
                </button>
                <button onclick="filterGallery('community')" class="btn btn-sm bg-base-100 hover:bg-base-200 text-base-content border border-base-300 rounded-lg px-4 gallery-tab-btn" data-category="community">
                    {{ __('messages.gallery.community') }}
                </button>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="gallery-grid">
                @foreach($galleryImages as $image)
                    <div class="gallery-item relative overflow-hidden rounded-2xl border border-base-300 shadow-md group h-64 bg-base-300 transition-all duration-300 hover:scale-[1.02]" data-category="{{ $image->category }}">
                        <!-- Placeholder graphic overlay since these are local Review seed tags -->
                        <div class="absolute inset-0 bg-neutral/85 flex flex-col justify-center items-center text-center p-4 opacity-100 group-hover:opacity-90 transition-opacity duration-300 z-10">
                            <span class="text-primary text-xs font-bold uppercase tracking-widest mb-1">{{ $image->category }}</span>
                            <h4 class="text-white font-bold font-heading text-md px-2">{{ $image->caption }}</h4>
                            <div class="mt-3 text-white/50 text-xs"><i class="fa-solid fa-camera"></i> Photo Asset</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-base-100 border-t border-base-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-base-content">
                    {{ __('messages.sections.contact') }}
                </h2>
                <div class="w-24 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Contact info details card -->
                <div class="lg:col-span-5 bg-base-200 rounded-2xl border border-base-300 p-8 flex flex-col justify-between space-y-6">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-primary/10 text-primary p-3 rounded-xl"><i class="fa-solid fa-location-dot text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">Office Address</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_address'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-secondary/10 text-secondary p-3 rounded-xl"><i class="fa-solid fa-phone text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">Phone Numbers</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_phone'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-accent/10 text-accent p-3 rounded-xl"><i class="fa-solid fa-envelope text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">Email Contact</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_email'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-primary/10 text-primary p-3 rounded-xl"><i class="fa-solid fa-calendar-days text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">Office Timings</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_timings'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Banner Info -->
                    <div class="border-t border-base-300 pt-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-base-content/50">Follow on Social Media</span>
                        <div class="flex gap-3 text-lg mt-3">
                            <a href="{{ $settings['facebook_url'] ?? '#' }}" target="_blank" rel="noopener" class="btn btn-sm btn-circle btn-primary text-white"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="{{ $settings['twitter_url'] ?? '#' }}" target="_blank" rel="noopener" class="btn btn-sm btn-circle btn-info text-white"><i class="fa-brands fa-twitter"></i></a>
                            <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank" rel="noopener" class="btn btn-sm btn-circle btn-error text-white"><i class="fa-brands fa-instagram"></i></a>
                            <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" rel="noopener" class="btn btn-sm btn-circle btn-ghost border-error/20 hover:border-error text-error"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Google Map Placeholder Card -->
                <div class="lg:col-span-7 bg-base-200 rounded-2xl border border-base-300 overflow-hidden relative min-h-[300px] flex items-center justify-center">
                    <!-- Interactive styled SVG mock map -->
                    <div class="absolute inset-0 bg-base-300/30 flex flex-col justify-center items-center text-center p-8">
                        <i class="fa-solid fa-map-location text-5xl text-base-content/30 mb-4 animate-bounce"></i>
                        <h4 class="font-heading font-bold text-base-content">Vadodara Ward Office Location Map</h4>
                        <p class="text-sm text-base-content/65 max-w-sm mt-1">Mock Interactive Map Center: Subhanpura Road, Ward 7, Vadodara, Gujarat</p>
                        <span class="btn btn-xs btn-outline btn-secondary hover:text-white mt-4 rounded-lg">Open in Google Maps</span>
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
                dot.classList.remove('bg-primary');
                dot.classList.add('bg-base-300');
            });
            
            currentSlide = (index + slides.length) % slides.length;
            
            const activeSlide = document.querySelector(`.feedback-slide[data-index="${currentSlide}"]`);
            const activeDot = document.querySelector(`#slide-dots button[data-dot="${currentSlide}"]`);
            
            if (activeSlide) activeSlide.classList.remove('hidden');
            if (activeDot) {
                activeDot.classList.remove('bg-base-300');
                activeDot.classList.add('bg-primary');
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
                btn.classList.add('bg-base-100', 'text-base-content', 'border', 'border-base-300');
            });
            
            const activeBtn = document.querySelector(`.gallery-tab-btn[data-category="${category}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-base-100', 'text-base-content', 'border', 'border-base-300');
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
