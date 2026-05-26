@extends('layouts.app')

@section('title', 'Sachin Khandelwal - Vadodara Ward No. 7')

@section('content')
    @php
        if (!function_exists('parseMetric')) {
            function parseMetric($value, $defaultNumber = '', $defaultSuffix = '', $defaultLabel = '') {
                if (strpos($value, '|') !== false) {
                    $parts = explode('|', $value);
                    return [
                        'number' => trim($parts[0] ?? ''),
                        'suffix' => trim($parts[1] ?? ''),
                        'label'  => trim($parts[2] ?? ''),
                    ];
                }
                
                // Smart fallback for raw legacy values (e.g. "1,500+ LED Lights Installed")
                preg_match('/^([0-9,.]+)\s*(.*?)$/', $value, $matches);
                $number = trim($matches[1] ?? $value);
                $rem = trim($matches[2] ?? '');
                
                if (preg_match('/^([+%]|[+]\s*[a-zA-Z]+)\s*(.*?)$/', $rem, $submatches)) {
                    $suffix = trim($submatches[1]);
                    $label = trim($submatches[2] ?? $defaultLabel);
                } else {
                    $suffix = '';
                    $label = !empty($rem) ? $rem : $defaultLabel;
                }
                
                return [
                    'number' => $number,
                    'suffix' => $suffix,
                    'label'  => $label,
                ];
            }
        }
    @endphp
    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden bg-gradient-to-b from-base-100 via-base-100 to-base-200 py-24 lg:py-40">
        <!-- Background decorative blobs -->
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>
        <!-- Radial saffron hero glow top-right -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,138,61,0.07),transparent_55%)] pointer-events-none"></div>
        <!-- Laxmi Vilas Palace silhouette watermark -->
        <div class="absolute bottom-0 right-0 w-full h-full flex items-end justify-end pointer-events-none overflow-hidden opacity-[0.035] text-base-content">
            <svg class="w-[520px] h-[173px]" viewBox="0 0 600 200" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                <!-- Ground base -->
                <rect x="0" y="193" width="600" height="7" rx="3"/>
                <!-- Far left small tower -->
                <rect x="5" y="148" width="55" height="45"/>
                <path d="M5,152 Q32,128 60,152 Z"/>
                <rect x="30" y="120" width="5" height="18" rx="2"/><circle cx="32" cy="118" r="5"/>
                <!-- Left tower -->
                <rect x="72" y="118" width="88" height="75"/>
                <rect x="82" y="82" width="68" height="40"/>
                <path d="M82,87 Q116,55 150,87 Z"/>
                <rect x="113" y="48" width="6" height="22" rx="3"/><circle cx="116" cy="45" r="7"/>
                <!-- Main central building -->
                <rect x="170" y="88" width="260" height="105"/>
                <!-- Central main dome -->
                <rect x="210" y="52" width="180" height="42"/>
                <path d="M210,58 Q300,5 390,58 Z"/>
                <rect x="297" y="5" width="6" height="22" rx="3"/><circle cx="300" cy="3" r="7"/>
                <!-- Crenellations on central dome base -->
                <path d="M210,94 L210,88 L226,88 L226,94 L244,94 L244,88 L260,88 L260,94 L278,94 L278,88 L294,88 L294,94 L306,94 L306,88 L322,88 L322,94 L340,94 L340,88 L356,88 L356,94 L374,94 L374,88 L390,88 L390,94"/>
                <!-- Right tower -->
                <rect x="440" y="118" width="88" height="75"/>
                <rect x="450" y="82" width="68" height="40"/>
                <path d="M450,87 Q484,55 518,87 Z"/>
                <rect x="481" y="48" width="6" height="22" rx="3"/><circle cx="484" cy="45" r="7"/>
                <!-- Far right small tower -->
                <rect x="540" y="148" width="55" height="45"/>
                <path d="M540,152 Q567,128 595,152 Z"/>
                <rect x="565" y="120" width="5" height="18" rx="2"/><circle cx="568" cy="118" r="5"/>
                <!-- Central arched entrance -->
                <path d="M262,193 L262,148 Q300,118 338,148 L338,193 Z"/>
                <!-- Left arch windows -->
                <path d="M190,193 L190,155 Q208,138 226,155 L226,193 Z"/>
                <path d="M374,193 L374,155 Q392,138 410,155 L410,193 Z"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Info Column -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <!-- Greeting badge with lotus accent -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-widest">
                    <!-- Micro lotus SVG -->
                    <svg class="w-3 h-3 shrink-0" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(60 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(120 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(180 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(240 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(300 6 6)" />
                    </svg>
                    {{ $cms['hero_greeting'] ?? 'Namaste & Welcome' }}
                </span>
                
                <h1 class="font-heading font-extrabold text-4xl sm:text-5xl lg:text-6xl text-base-content leading-tight">
                    {{ $cms['hero_title'] ?? 'Serving the People of Vadodara Ward No. 7' }}
                </h1>

                <!-- BJP Designation pill — tasteful party association below the main title -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-primary/25 bg-primary/5 text-sm font-semibold text-primary">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(60 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(120 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(180 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(240 6 6)" />
                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(300 6 6)" />
                    </svg>
                    {{ __('messages.hero.designation') }}
                </div>
                
                <p class="text-lg text-base-content/85 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    {{ $cms['hero_mission'] ?? 'Committed to development, public welfare, and transparent leadership.' }}
                </p>

                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                    <a href="#feedback" class="btn btn-primary btn-md sm:btn-lg shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/35 hover:-translate-y-0.5 transition-all duration-200 rounded-xl gap-2 text-white">
                        <i class="fa-solid fa-comment-dots"></i> {{ __('messages.hero.cta_feedback') }}
                    </a>
                    <a href="#development" class="btn btn-outline btn-secondary btn-md sm:btn-lg transition-all duration-200 rounded-xl gap-2 hover:text-white hover:shadow-md hover:shadow-secondary/20">
                        <i class="fa-solid fa-helmet-safety"></i> {{ __('messages.hero.cta_work') }}
                    </a>
                </div>
            </div>

            <!-- Right Portrait Image Column -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-80 sm:w-[26rem] lg:w-[28rem] aspect-[3/4]">
                    <!-- Elegant background glow shapes -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-secondary/15 rounded-[2.5rem] rotate-6 scale-95 -z-10 animate-pulse"></div>
                    <div class="absolute inset-0 bg-base-100 rounded-[2.5rem] border-2 border-base-300 -z-10 shadow-xl"></div>
                    
                    @if(isset($settings['hero_image']) && !empty($settings['hero_image']))
                        <img src="{{ asset($settings['hero_image']) }}" alt="Sachin Khandelwal" class="w-full h-full object-cover rounded-[2.5rem] shadow-inner p-3">
                    @else
                        <img src="{{ asset('images/hero_portrait.webp') }}" alt="Sachin Khandelwal" class="w-full h-full object-cover rounded-[2.5rem] shadow-inner p-3" onerror="this.onerror=null; this.src='https://api.dicebear.com/7.x/initials/svg?seed=Sachin%20Khandelwal&backgroundColor=ff8a3d&textColor=ffffff&fontSize=35&bold=true'">
                    @endif
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
                <!-- Ashoka Chakra-inspired section divider -->
                <div class="flex items-center justify-center gap-3 mt-4">
                    <div class="h-px w-20 bg-gradient-to-r from-transparent to-primary/60 rounded-full"></div>
                    <svg class="w-5 h-5 text-secondary/50 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10.5"/>
                        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
                        <line x1="22.5" y1="12" x2="1.5" y2="12"/>
                        <line x1="21.1" y1="6.8" x2="2.9" y2="17.2"/>
                        <line x1="17.3" y1="2.9" x2="6.7" y2="21.1"/>
                        <line x1="12" y1="1.5" x2="12" y2="22.5"/>
                        <line x1="6.7" y1="2.9" x2="17.3" y2="21.1"/>
                        <line x1="2.9" y1="6.8" x2="21.1" y2="17.2"/>
                    </svg>
                    <div class="h-px w-20 bg-gradient-to-l from-transparent to-primary/60 rounded-full"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Biography Card -->
                <div class="lg:col-span-7 bg-base-200 p-8 rounded-2xl border border-base-300 shadow-sm space-y-6">
                    <h3 class="font-heading font-bold text-xl text-secondary flex items-center gap-2">
                        <i class="fa-solid fa-landmark"></i> {{ __('messages.sections.public_leadership') }}
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
                <div class="flex items-center justify-center gap-3 mt-3">
                    <div class="h-px w-16 bg-gradient-to-r from-transparent to-primary/60 rounded-full"></div>
                    <svg class="w-4 h-4 text-white/30 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10.5"/>
                        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
                        <line x1="22.5" y1="12" x2="1.5" y2="12"/>
                        <line x1="21.1" y1="6.8" x2="2.9" y2="17.2"/>
                        <line x1="17.3" y1="2.9" x2="6.7" y2="21.1"/>
                        <line x1="12" y1="1.5" x2="12" y2="22.5"/>
                        <line x1="6.7" y1="2.9" x2="17.3" y2="21.1"/>
                        <line x1="2.9" y1="6.8" x2="21.1" y2="17.2"/>
                    </svg>
                    <div class="h-px w-16 bg-gradient-to-l from-transparent to-primary/60 rounded-full"></div>
                </div>
            </div>

            <div class="stats stats-vertical lg:stats-horizontal shadow-xl bg-white/5 border border-white/10 w-full rounded-3xl overflow-hidden divide-y lg:divide-y-0 lg:divide-x divide-white/10">
                <!-- Metric 1 — Roads (Saffron) -->
                @php
                    $roads = parseMetric($cms['achievement_roads'] ?? '12 | + km | Roads Built', '12', '+ km', 'Roads Built');
                @endphp
                <div class="stat p-8 text-center flex flex-col items-center justify-center group hover:bg-white/[0.02] transition-all duration-300">
                    <div class="stat-figure text-primary mb-3">
                        <div class="w-16 h-16 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-primary/20 transition-all duration-300 shadow-md shadow-primary/5">
                            <i class="fa-solid fa-road text-2xl text-primary"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-center gap-1.5">
                        <span class="font-heading font-black text-4xl sm:text-5xl text-primary tracking-tight transition-transform duration-300 group-hover:scale-105">
                            {{ $roads['number'] }}
                        </span>
                        @if(!empty($roads['suffix']))
                            <span class="text-xl sm:text-2xl font-bold text-primary/75 font-heading">
                                {{ $roads['suffix'] }}
                            </span>
                        @endif
                    </div>
                    <div class="stat-desc text-xs sm:text-sm text-neutral-content/70 font-extrabold uppercase tracking-widest mt-2 font-heading">
                        {{ $roads['label'] }}
                    </div>
                </div>

                <!-- Metric 2 — LED Lights (Accent/Green) -->
                @php
                    $lights = parseMetric($cms['achievement_lights'] ?? '1,500 | + | LED Lights Installed', '1,500', '+', 'LED Lights Installed');
                @endphp
                <div class="stat p-8 text-center flex flex-col items-center justify-center group hover:bg-white/[0.02] transition-all duration-300">
                    <div class="stat-figure text-accent mb-3">
                        <div class="w-16 h-16 rounded-2xl bg-accent/10 border border-accent/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-accent/20 transition-all duration-300 shadow-md shadow-accent/5">
                            <i class="fa-solid fa-lightbulb text-2xl text-accent"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-center gap-1.5">
                        <span class="font-heading font-black text-4xl sm:text-5xl text-accent tracking-tight transition-transform duration-300 group-hover:scale-105">
                            {{ $lights['number'] }}
                        </span>
                        @if(!empty($lights['suffix']))
                            <span class="text-xl sm:text-2xl font-bold text-accent/75 font-heading">
                                {{ $lights['suffix'] }}
                            </span>
                        @endif
                    </div>
                    <div class="stat-desc text-xs sm:text-sm text-neutral-content/70 font-extrabold uppercase tracking-widest mt-2 font-heading">
                        {{ $lights['label'] }}
                    </div>
                </div>

                <!-- Metric 3 — Grievances (Success/Teal) -->
                @php
                    $grievances = parseMetric($cms['achievement_grievances'] ?? '98 | % | Grievances Resolved', '98', '%', 'Grievances Resolved');
                @endphp
                <div class="stat p-8 text-center flex flex-col items-center justify-center group hover:bg-white/[0.02] transition-all duration-300">
                    <div class="stat-figure text-success mb-3">
                        <div class="w-16 h-16 rounded-2xl bg-success/10 border border-success/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-success/20 transition-all duration-300 shadow-md shadow-success/5">
                            <i class="fa-solid fa-circle-check text-2xl text-success"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-center gap-1.5">
                        <span class="font-heading font-black text-4xl sm:text-5xl text-success tracking-tight transition-transform duration-300 group-hover:scale-105">
                            {{ $grievances['number'] }}
                        </span>
                        @if(!empty($grievances['suffix']))
                            <span class="text-xl sm:text-2xl font-bold text-success/75 font-heading">
                                {{ $grievances['suffix'] }}
                            </span>
                        @endif
                    </div>
                    <div class="stat-desc text-xs sm:text-sm text-neutral-content/70 font-extrabold uppercase tracking-widest mt-2 font-heading">
                        {{ $grievances['label'] }}
                    </div>
                </div>

                <!-- Metric 4 — Health Camps (Warning/Gold) -->
                @php
                    $camps = parseMetric($cms['achievement_camps'] ?? '50 | + | Health Camps Done', '50', '+', 'Health Camps Done');
                @endphp
                <div class="stat p-8 text-center flex flex-col items-center justify-center group hover:bg-white/[0.02] transition-all duration-300">
                    <div class="stat-figure text-warning mb-3">
                        <div class="w-16 h-16 rounded-2xl bg-warning/10 border border-warning/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-warning/20 transition-all duration-300 shadow-md shadow-warning/5">
                            <i class="fa-solid fa-hand-holding-heart text-2xl text-warning"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-center gap-1.5">
                        <span class="font-heading font-black text-4xl sm:text-5xl text-warning tracking-tight transition-transform duration-300 group-hover:scale-105">
                            {{ $camps['number'] }}
                        </span>
                        @if(!empty($camps['suffix']))
                            <span class="text-xl sm:text-2xl font-bold text-warning/75 font-heading">
                                {{ $camps['suffix'] }}
                            </span>
                        @endif
                    </div>
                    <div class="stat-desc text-xs sm:text-sm text-neutral-content/70 font-extrabold uppercase tracking-widest mt-2 font-heading">
                        {{ $camps['label'] }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Works Section -->
    <section id="development" class="relative overflow-hidden py-24 bg-base-200 border-t border-base-300">
        <!-- Decorative radial glows behind carousel -->
        <div class="absolute top-1/4 -left-20 w-[30rem] h-[30rem] bg-secondary/5 rounded-full blur-[120px] pointer-events-none -z-10 animate-pulse"></div>
        <div class="absolute bottom-1/4 -right-20 w-[30rem] h-[30rem] bg-primary/5 rounded-full blur-[120px] pointer-events-none -z-10 animate-pulse"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Centered Header matching other sections exactly -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-base-content">
                    {{ __('messages.sections.development') }}
                </h2>
                <div class="flex items-center justify-center gap-3 mt-4">
                    <div class="h-px w-20 bg-gradient-to-r from-transparent to-primary/60 rounded-full"></div>
                    <svg class="w-5 h-5 text-secondary/40 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10.5"/>
                        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
                        <line x1="22.5" y1="12" x2="1.5" y2="12"/>
                        <line x1="21.1" y1="6.8" x2="2.9" y2="17.2"/>
                        <line x1="17.3" y1="2.9" x2="6.7" y2="21.1"/>
                        <line x1="12" y1="1.5" x2="12" y2="22.5"/>
                        <line x1="6.7" y1="2.9" x2="17.3" y2="21.1"/>
                        <line x1="2.9" y1="6.8" x2="21.1" y2="17.2"/>
                    </svg>
                    <div class="h-px w-20 bg-gradient-to-l from-transparent to-primary/60 rounded-full"></div>
                </div>
            </div>

            <!-- Development Cards Sliding Container -->
            @if($developmentWorks->isNotEmpty())
                <div class="relative overflow-hidden w-full py-4 -mx-4 px-4 dev-slider-viewport">
                    <div id="development-track" class="flex flex-row gap-6 transition-transform duration-500 ease-out" style="transform: translateX(0px);">
                        @foreach($developmentWorks as $index => $work)
                            <div class="development-card cursor-pointer shrink-0 w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] bg-base-100 border border-base-300/60 rounded-3xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group flex flex-col justify-between" 
                                 data-index="{{ $index }}"
                                 data-title="{{ $work->title }}"
                                 data-location="{{ $work->location }}"
                                 data-description="{{ $work->description }}"
                                 data-before="{{ asset($work->before_image ?: 'images/before_road.jpg') }}"
                                 data-after="{{ asset($work->after_image ?: 'images/after_road.jpg') }}">
                                <!-- Saffron accent stripe -->
                                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-primary to-secondary opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                                    <!-- Card Thumbnail: two images side by side -->
                                    <div class="relative flex h-48 overflow-hidden">
                                        <!-- LEFT — Before -->
                                        <div class="relative w-1/2 overflow-hidden">
                                            <img src="{{ asset($work->before_image ?: 'images/before_road.jpg') }}"
                                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                 alt="Before"
                                                 loading="lazy"
                                                 onerror="this.onerror=null;this.src='{{ asset('images/before_road.jpg') }}'">
                                            <span class="absolute top-2 left-2 badge badge-warning text-[10px] font-bold shadow pointer-events-none">Before</span>
                                        </div>

                                        <!-- Vertical centre divider -->
                                        <div class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-0.5 bg-white/70 z-10 shadow"></div>

                                        <!-- RIGHT — After -->
                                        <div class="relative w-1/2 overflow-hidden">
                                            <img src="{{ asset($work->after_image ?: 'images/after_road.jpg') }}"
                                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                 alt="After"
                                                 loading="lazy"
                                                 onerror="this.onerror=null;this.src='{{ asset('images/after_road.jpg') }}'">
                                            <span class="absolute top-2 right-2 badge badge-success text-[10px] font-bold text-white shadow pointer-events-none">After</span>
                                        </div>

                                        <!-- Hover overlay -->
                                        <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/15 transition-all duration-300 flex items-end justify-center pb-3 opacity-0 group-hover:opacity-100 z-20">
                                            <span class="badge badge-primary gap-1.5 shadow-lg text-white border-none text-[11px]">
                                                <i class="fa-solid fa-expand text-[10px]"></i> View &amp; Compare
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Card Details -->
                                    <div class="p-6 space-y-3 flex-grow flex flex-col justify-between">
                                        <div class="space-y-2">
                                            <span class="inline-flex items-center gap-1.5 text-[10px] text-secondary font-extrabold uppercase tracking-wider">
                                                <i class="fa-solid fa-location-dot text-primary"></i> {{ $work->location }}
                                            </span>
                                            <h3 class="font-heading font-extrabold text-lg text-base-content leading-snug group-hover:text-primary transition-colors duration-200">
                                                {{ $work->title }}
                                            </h3>
                                            <p class="text-xs text-base-content/70 leading-relaxed line-clamp-3">
                                                {{ $work->description }}
                                            </p>
                                        </div>
                                    </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Modern Slider Progress & Controls Footer -->
                @if($developmentWorks->count() > 1)
                    <div class="flex items-center justify-between max-w-xl mx-auto mt-10 gap-6">
                        <button onclick="prevDevCard()" class="btn btn-sm btn-circle btn-outline border-base-300 hover:bg-primary hover:text-white transition-all shadow-sm shrink-0" aria-label="Previous Project">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        
                        <div class="flex-grow bg-base-300 h-1.5 rounded-full overflow-hidden relative">
                            <div id="dev-progress-bar" class="absolute top-0 left-0 h-full bg-gradient-to-r from-primary to-secondary transition-all duration-500" style="width: 33.333%;"></div>
                        </div>
                        
                        <button onclick="nextDevCard()" class="btn btn-sm btn-circle btn-outline border-base-300 hover:bg-primary hover:text-white transition-all shadow-sm shrink-0" aria-label="Next Project">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- Citizens Feedback & Carousel Section -->
    <section id="feedback" class="relative overflow-hidden py-20 bg-base-100 border-t border-base-300">
        <!-- Decorative radial glows behind carousel -->
        <div class="absolute top-1/4 left-1/4 w-[28rem] h-[28rem] bg-primary/5 rounded-full blur-[100px] pointer-events-none -z-10"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[36rem] h-[36rem] bg-secondary/5 rounded-full blur-[120px] pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-base-content">
                    {{ __('messages.sections.feedback') }}
                </h2>
                <div class="flex items-center justify-center gap-3 mt-4">
                    <div class="h-px w-20 bg-gradient-to-r from-transparent to-primary/60 rounded-full"></div>
                    <svg class="w-5 h-5 text-secondary/40 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10.5"/>
                        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
                        <line x1="22.5" y1="12" x2="1.5" y2="12"/>
                        <line x1="21.1" y1="6.8" x2="2.9" y2="17.2"/>
                        <line x1="17.3" y1="2.9" x2="6.7" y2="21.1"/>
                        <line x1="12" y1="1.5" x2="12" y2="22.5"/>
                        <line x1="6.7" y1="2.9" x2="17.3" y2="21.1"/>
                        <line x1="2.9" y1="6.8" x2="21.1" y2="17.2"/>
                    </svg>
                    <div class="h-px w-20 bg-gradient-to-l from-transparent to-primary/60 rounded-full"></div>
                </div>
            </div>

            <!-- Feedback Carousel Wrapper -->
            @if($feedbacks->isNotEmpty())
                <div class="relative max-w-6xl mx-auto mb-10 overflow-hidden bg-gradient-to-tr from-base-200 via-base-200/90 to-base-100/30 backdrop-blur-md rounded-[2.5rem] border border-base-300 p-8 sm:p-12 shadow-xl feedback-carousel-container z-10">
                    <!-- Saffron watermarked background quote icon (lower opacity, no overlay conflict) -->
                    <div class="absolute -top-12 -left-4 text-primary/5 text-[14rem] sm:text-[18rem] font-serif pointer-events-none select-none -z-10"><i class="fa-solid fa-quote-left"></i></div>
                    
                    <!-- Carousel Slider container -->
                    <div id="feedback-slider" class="relative w-full z-10">
                        @foreach($feedbacks->chunk(3) as $slideIndex => $chunk)
                            <div class="feedback-slide {{ $slideIndex === 0 ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-3 gap-6 transition-all duration-500" data-index="{{ $slideIndex }}">
                                @foreach($chunk as $fb)
                                    <div class="bg-base-100/90 backdrop-blur-sm border border-base-300/60 rounded-2xl p-6 flex flex-col justify-between space-y-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                                        <!-- Micro saffron accent top border on hover -->
                                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary to-secondary opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                        <!-- Corner decorative mini quote -->
                                        <div class="absolute top-6 right-6 text-secondary/15 text-2xl group-hover:text-primary/25 transition-colors duration-300"><i class="fa-solid fa-quote-right"></i></div>

                                        <div class="space-y-4 relative z-10">
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
                                            <div class="flex gap-1.5 flex-wrap pt-2 relative z-10">
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
                    <div class="flex justify-between items-center mt-8 relative z-10">
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
                <div class="flex items-center justify-center gap-3 mt-4">
                    <div class="h-px w-20 bg-gradient-to-r from-transparent to-primary/60 rounded-full"></div>
                    <svg class="w-5 h-5 text-secondary/40 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10.5"/>
                        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
                        <line x1="22.5" y1="12" x2="1.5" y2="12"/>
                        <line x1="21.1" y1="6.8" x2="2.9" y2="17.2"/>
                        <line x1="17.3" y1="2.9" x2="6.7" y2="21.1"/>
                        <line x1="12" y1="1.5" x2="12" y2="22.5"/>
                        <line x1="6.7" y1="2.9" x2="17.3" y2="21.1"/>
                        <line x1="2.9" y1="6.8" x2="21.1" y2="17.2"/>
                    </svg>
                    <div class="h-px w-20 bg-gradient-to-l from-transparent to-primary/60 rounded-full"></div>
                </div>
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
                @foreach($galleryImages as $index => $image)
                    <div class="gallery-item relative overflow-hidden rounded-2xl border border-base-300 shadow-md group h-64 bg-base-300 transition-all duration-300 hover:scale-[1.02] cursor-pointer" 
                         data-category="{{ $image->category }}"
                         data-image="{{ asset($image->image_path) }}"
                         data-caption="{{ $image->caption }}"
                         data-category-label="{{ __('messages.gallery.' . $image->category) }}"
                         onclick="openLightbox({{ $index }})">
                        <!-- Real Image with dynamic high-quality Unsplash fallbacks based on category -->
                        @php
                            $fallback = 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=600&auto=format&fit=crop';
                            if ($image->category === 'events') {
                                $fallback = 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=600&auto=format&fit=crop';
                            } elseif ($image->category === 'visits') {
                                $fallback = 'https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=600&auto=format&fit=crop';
                            } elseif ($image->category === 'community') {
                                $fallback = 'https://images.unsplash.com/photo-1469571486119-07551202826d?q=80&w=600&auto=format&fit=crop';
                            }
                        @endphp
                        <img src="{{ asset($image->image_path) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                             alt="{{ $image->caption }}" 
                             onerror="this.onerror=null; this.src='{{ $fallback }}';">

                        <!-- Saffron orange & dark gradient luxury overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-neutral/95 via-neutral/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6 z-10">
                            <span class="text-primary text-xs font-extrabold uppercase tracking-widest mb-1">
                                {{ __('messages.gallery.' . $image->category) }}
                            </span>
                            <h4 class="text-white font-bold font-heading text-md line-clamp-2">
                                {{ $image->caption }}
                            </h4>
                            <div class="mt-3 text-primary font-bold text-xs flex items-center gap-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <i class="fa-solid fa-maximize"></i> {{ __('messages.gallery.view_photo') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Interactive Gallery Pagination Controls -->
            <div id="gallery-pagination" class="flex justify-center items-center gap-2 mt-12 hidden">
                <button onclick="prevGalleryPage()" class="btn btn-sm btn-circle btn-outline border-base-300 hover:bg-primary hover:text-white" id="gallery-prev-btn">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <div class="flex gap-2" id="gallery-page-numbers"></div>
                <button onclick="nextGalleryPage()" class="btn btn-sm btn-circle btn-outline border-base-300 hover:bg-primary hover:text-white" id="gallery-next-btn">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
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
                <div class="flex items-center justify-center gap-3 mt-4">
                    <div class="h-px w-20 bg-gradient-to-r from-transparent to-primary/60 rounded-full"></div>
                    <svg class="w-5 h-5 text-secondary/40 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10.5"/>
                        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
                        <line x1="22.5" y1="12" x2="1.5" y2="12"/>
                        <line x1="21.1" y1="6.8" x2="2.9" y2="17.2"/>
                        <line x1="17.3" y1="2.9" x2="6.7" y2="21.1"/>
                        <line x1="12" y1="1.5" x2="12" y2="22.5"/>
                        <line x1="6.7" y1="2.9" x2="17.3" y2="21.1"/>
                        <line x1="2.9" y1="6.8" x2="21.1" y2="17.2"/>
                    </svg>
                    <div class="h-px w-20 bg-gradient-to-l from-transparent to-primary/60 rounded-full"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Contact info details card -->
                <div class="lg:col-span-5 bg-base-200 rounded-2xl border border-base-300 p-8 flex flex-col justify-between space-y-6">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-primary/10 text-primary p-3 rounded-xl"><i class="fa-solid fa-location-dot text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">{{ __('messages.contact.office_address') }}</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_address'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-secondary/10 text-secondary p-3 rounded-xl"><i class="fa-solid fa-phone text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">{{ __('messages.contact.phone') }}</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_phone'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-accent/10 text-accent p-3 rounded-xl"><i class="fa-solid fa-envelope text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">{{ __('messages.contact.email') }}</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_email'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-primary/10 text-primary p-3 rounded-xl"><i class="fa-solid fa-calendar-days text-xl"></i></div>
                            <div>
                                <h4 class="font-heading font-bold text-base-content">{{ __('messages.contact.timings') }}</h4>
                                <p class="text-sm text-base-content/70 mt-1">{{ $settings['office_timings'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Banner Info -->
                    <div class="border-t border-base-300 pt-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-base-content/50">{{ __('messages.contact.social') }}</span>
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
                        <h4 class="font-heading font-bold text-base-content">{{ __('messages.contact.map_title') }}</h4>
                        <p class="text-sm text-base-content/65 max-w-sm mt-1">{{ __('messages.contact.map_subtitle') }}</p>
                        <span class="btn btn-xs btn-outline btn-secondary hover:text-white mt-4 rounded-lg">{{ __('messages.contact.map_open') }}</span>
                    </div>
                </div>
            </div>
        </div>
    <!-- ============================================================ -->
    <!-- Development Project Compare Modal (DaisyUI <dialog> modal)  -->
    <!-- diff-item-1 = LEFT  = BEFORE  |  diff-item-2 = RIGHT = AFTER -->
    <!-- ============================================================ -->
    <dialog id="project_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-3xl p-0 overflow-hidden rounded-3xl shadow-2xl bg-base-100">

            <!-- DaisyUI close button (top-right) -->
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3 z-50 bg-base-300/80 backdrop-blur-sm hover:bg-error hover:text-white transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </form>

            <!-- Interactive Before / After Diff Slider (pure DaisyUI v5 markup) -->
            <figure class="diff aspect-[16/9] w-full">
                <!-- diff-item-1 = LEFT = BEFORE (clipped by the resizer width) -->
                <div class="diff-item-1">
                    <img id="modal-before-img" src="" alt="Before">
                </div>
                <!-- diff-item-2 = RIGHT background = AFTER -->
                <div class="diff-item-2">
                    <img id="modal-after-img" src="" alt="After">
                </div>
                <div class="diff-resizer"></div>
            </figure>

            <!-- Badge row sits just below the diff figure -->
            <div class="flex items-center justify-between px-4 py-2 bg-base-200 border-b border-base-300">
                <div class="badge badge-warning gap-1 font-bold">
                    <i class="fa-solid fa-backward text-[10px]"></i> Before
                </div>
                <span class="text-[11px] text-base-content/50 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-left-right text-primary animate-pulse"></i>
                    Drag the handle to compare
                </span>
                <div class="badge badge-success gap-1 font-bold text-white">
                    After <i class="fa-solid fa-forward text-[10px]"></i>
                </div>
            </div>

            <!-- Project meta -->
            <div class="p-6 space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge badge-outline badge-primary gap-1 font-bold">
                        <i class="fa-solid fa-location-dot"></i>
                        <span id="modal-location"></span>
                    </span>
                </div>
                <h3 id="modal-title"
                    class="font-heading font-extrabold text-xl sm:text-2xl text-base-content leading-snug"></h3>
                <div class="divider my-1"></div>
                <p class="text-xs font-bold uppercase tracking-widest text-base-content/40">Project Description</p>
                <p id="modal-desc"
                   class="text-sm text-base-content/80 leading-relaxed"></p>
            </div>

        </div>
        <!-- Clicking backdrop closes the modal -->
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Photo Gallery Lightbox Viewer (DaisyUI <dialog> modal) -->
    <dialog id="gallery_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-4xl p-0 overflow-hidden rounded-3xl shadow-2xl bg-base-100 border border-base-300">
            <!-- Close button (top-right) -->
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3 z-50 bg-base-300/80 backdrop-blur-sm hover:bg-error hover:text-white transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </form>

            <!-- Lightbox Main Frame (Image with Navigation Chevrons) -->
            <div class="relative w-full aspect-[4/3] sm:aspect-[16/10] bg-neutral flex items-center justify-center group/lightbox">
                <img id="lightbox-img" src="" class="max-w-full max-h-full object-contain select-none" alt="Gallery Lightbox Image">
                
                <!-- Left Control Button -->
                <button onclick="prevGalleryImage(event)" class="absolute left-4 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost bg-black/30 text-white hover:bg-primary border-none shadow-md" aria-label="Previous Photo">
                    <i class="fa-solid fa-chevron-left text-lg"></i>
                </button>

                <!-- Right Control Button -->
                <button onclick="nextGalleryImage(event)" class="absolute right-4 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost bg-black/30 text-white hover:bg-primary border-none shadow-md" aria-label="Next Photo">
                    <i class="fa-solid fa-chevron-right text-lg"></i>
                </button>
            </div>

            <!-- Meta Section underneath the image -->
            <div class="p-6 bg-base-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t border-base-300">
                <div class="space-y-1 flex-1">
                    <span id="lightbox-category" class="badge badge-primary font-bold uppercase tracking-widest text-[10px]"></span>
                    <h3 id="lightbox-caption" class="font-heading font-extrabold text-lg text-base-content leading-snug"></h3>
                </div>
                <!-- Close Dialog button -->
                <form method="dialog" class="shrink-0">
                    <button class="btn btn-sm btn-outline hover:bg-neutral hover:text-white rounded-xl gap-1">
                        <i class="fa-solid fa-circle-xmark"></i> {{ __('messages.gallery.close') }}
                    </button>
                </form>
            </div>
        </div>
        <!-- Backdrop click closes modal -->
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Carousel Javascript -->
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.feedback-slide');
        const dots = document.querySelectorAll('#slide-dots button');
        let slideInterval = null;
        const autoSlideDelay = 6000;

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
            resetAutoSlide();
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
            resetAutoSlide();
        }

        function setSlide(index) {
            showSlide(index);
            resetAutoSlide();
        }

        function startAutoSlide() {
            if (slides.length > 1 && !slideInterval) {
                slideInterval = setInterval(nextSlide, autoSlideDelay);
            }
        }

        function stopAutoSlide() {
            if (slideInterval) {
                clearInterval(slideInterval);
                slideInterval = null;
            }
        }

        function resetAutoSlide() {
            stopAutoSlide();
            startAutoSlide();
        }

        // Initialize Auto Slide
        startAutoSlide();

        // Pause on Hover
        const carouselContainer = document.querySelector('.feedback-carousel-container');
        if (carouselContainer) {
            carouselContainer.addEventListener('mouseenter', stopAutoSlide);
            carouselContainer.addEventListener('mouseleave', startAutoSlide);
        }

        // Gallery Filter & Interactive Pagination Logic
        let activeGalleryCategory = 'all';
        let currentGalleryPage = 1;
        const galleryItemsPerPage = 6;
        let filteredGalleryItems = [];

        let galleryTimeout = null;

        function initGalleryPagination() {
            const allItems = Array.from(document.querySelectorAll('.gallery-item'));
            if (allItems.length === 0) return;
            
            // Clear any active gallery timeout
            if (galleryTimeout) clearTimeout(galleryTimeout);
            
            const grid = document.getElementById('gallery-grid');
            
            // Remove any leftover skeleton elements
            document.querySelectorAll('.gallery-skeleton').forEach(el => el.remove());
            
            // Hide all real items immediately during transition
            allItems.forEach(item => {
                item.classList.add('hidden');
                item.classList.remove('animate-fade-in');
            });
            
            // Render beautiful daisyUI skeletons matches the category size
            const activeItems = allItems.filter(item => {
                const cat = item.getAttribute('data-category');
                return activeGalleryCategory === 'all' || cat === activeGalleryCategory;
            });
            
            const startIdx = (currentGalleryPage - 1) * galleryItemsPerPage;
            const endIdx = startIdx + galleryItemsPerPage;
            const pageItemsCount = activeItems.slice(startIdx, endIdx).length;
            
            for (let i = 0; i < pageItemsCount; i++) {
                const skeleton = document.createElement('div');
                skeleton.className = 'gallery-skeleton skeleton w-full h-64 rounded-2xl border border-base-300 shadow-md bg-base-300/40 animate-pulse';
                grid.appendChild(skeleton);
            }
            
            // Filter based on active category
            filteredGalleryItems = activeItems;

            const totalPages = Math.ceil(filteredGalleryItems.length / galleryItemsPerPage);
            const paginationContainer = document.getElementById('gallery-pagination');
            const pageNumbersContainer = document.getElementById('gallery-page-numbers');

            if (totalPages > 1) {
                if (paginationContainer) paginationContainer.classList.remove('hidden');
                
                // Render page numbers
                if (pageNumbersContainer) {
                    pageNumbersContainer.innerHTML = '';
                    for (let i = 1; i <= totalPages; i++) {
                        const activeClass = i === currentGalleryPage ? 'btn-primary text-white border-none' : 'bg-base-100 text-base-content border border-base-300';
                        pageNumbersContainer.innerHTML += `
                            <button onclick="setGalleryPage(${i})" class="btn btn-xs sm:btn-sm ${activeClass} rounded-lg font-bold px-3">
                                ${i}
                            </button>
                        `;
                    }
                }
            } else {
                if (paginationContainer) paginationContainer.classList.add('hidden');
            }

            // Disable/Enable chevron buttons
            const prevBtn = document.getElementById('gallery-prev-btn');
            const nextBtn = document.getElementById('gallery-next-btn');
            if (prevBtn) prevBtn.disabled = currentGalleryPage === 1;
            if (nextBtn) nextBtn.disabled = currentGalleryPage === totalPages || totalPages === 0;

            // Wait 250ms for skeleton pulse visual indicator, then fade in real items
            galleryTimeout = setTimeout(() => {
                document.querySelectorAll('.gallery-skeleton').forEach(el => el.remove());
                
                const pageItems = filteredGalleryItems.slice(startIdx, endIdx);
                pageItems.forEach(item => {
                    item.classList.remove('hidden');
                    item.classList.add('animate-fade-in');
                });
            }, 250);
        }

        function filterGallery(category) {
            activeGalleryCategory = category;
            currentGalleryPage = 1;

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

            initGalleryPagination();
        }

        function setGalleryPage(page) {
            currentGalleryPage = page;
            initGalleryPagination();
            
            // Scroll to gallery container top smoothly
            const gallerySection = document.getElementById('gallery');
            if (gallerySection) {
                gallerySection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function prevGalleryPage() {
            if (currentGalleryPage > 1) {
                setGalleryPage(currentGalleryPage - 1);
            }
        }

        function nextGalleryPage() {
            const totalPages = Math.ceil(filteredGalleryItems.length / galleryItemsPerPage);
            if (currentGalleryPage < totalPages) {
                setGalleryPage(currentGalleryPage + 1);
            }
        }

        // Development Slider Logic (Horizontal card-by-card fluid slider)
        let devIndex = 0;
        let devInterval = null;
        const devCards = document.querySelectorAll('.development-card');
        const devTrack = document.getElementById('development-track');
        const devProgress = document.getElementById('dev-progress-bar');
        const devAutoSlideDelay = 6000;

        function getVisibleCardsCount() {
            if (window.innerWidth >= 1024) return 3;
            if (window.innerWidth >= 640) return 2;
            return 1;
        }

        function updateDevSlider() {
            if (devCards.length === 0 || !devTrack) return;
            
            const visibleCards = getVisibleCardsCount();
            const maxIndex = Math.max(0, devCards.length - visibleCards);
            
            // Clamp index
            if (devIndex > maxIndex) devIndex = 0;
            if (devIndex < 0) devIndex = maxIndex;

            // Calculate translate position
            const cardEl = devCards[0];
            const cardWidth = cardEl.getBoundingClientRect().width;
            const gap = 24; // gap-6 matches 24px
            
            const translateX = devIndex * (cardWidth + gap);
            devTrack.style.transform = `translateX(-${translateX}px)`;

            // Update modern progress bar
            if (devProgress) {
                const progressPercent = devCards.length > visibleCards 
                    ? ((devIndex + visibleCards) / devCards.length) * 100 
                    : 100;
                devProgress.style.width = `${progressPercent}%`;
            }
        }

        function nextDevCard() {
            const visibleCards = getVisibleCardsCount();
            const maxIndex = Math.max(0, devCards.length - visibleCards);
            if (devIndex >= maxIndex) {
                devIndex = 0;
            } else {
                devIndex++;
            }
            updateDevSlider();
            resetDevAutoSlide();
        }

        function prevDevCard() {
            const visibleCards = getVisibleCardsCount();
            const maxIndex = Math.max(0, devCards.length - visibleCards);
            if (devIndex <= 0) {
                devIndex = maxIndex;
            } else {
                devIndex--;
            }
            updateDevSlider();
            resetDevAutoSlide();
        }

        function startDevAutoSlide() {
            const visibleCards = getVisibleCardsCount();
            if (devCards.length > visibleCards && !devInterval) {
                devInterval = setInterval(nextDevCard, devAutoSlideDelay);
            }
        }

        function stopDevAutoSlide() {
            if (devInterval) {
                clearInterval(devInterval);
                devInterval = null;
            }
        }

        function resetDevAutoSlide() {
            stopDevAutoSlide();
            startDevAutoSlide();
        }

        // ── Photo Gallery Lightbox Viewer Logic ──
        let currentLightboxIndex = 0;

        function openLightbox(index) {
            currentLightboxIndex = index;
            const allItems = Array.from(document.querySelectorAll('.gallery-item'));
            const item = allItems[index];
            if (!item) return;

            document.getElementById('lightbox-img').src = item.dataset.image || '';
            document.getElementById('lightbox-caption').textContent = item.dataset.caption || '';
            document.getElementById('lightbox-category').textContent = item.dataset.categoryLabel || '';

            const modal = document.getElementById('gallery_modal');
            if (modal) modal.showModal();
        }

        function prevGalleryImage(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            navigateLightbox(-1);
        }

        function nextGalleryImage(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            navigateLightbox(1);
        }

        function navigateLightbox(direction) {
            // Find all currently visible (not hidden by category tabs/pagination) gallery items
            const visibleItems = Array.from(document.querySelectorAll('.gallery-item:not(.hidden)'));
            if (visibleItems.length === 0) return;

            const allItems = Array.from(document.querySelectorAll('.gallery-item'));
            const currentItem = allItems[currentLightboxIndex];
            let visibleIndex = visibleItems.indexOf(currentItem);

            if (visibleIndex === -1) {
                visibleIndex = 0;
            }

            // Cycle index
            visibleIndex = (visibleIndex + direction + visibleItems.length) % visibleItems.length;

            const nextItem = visibleItems[visibleIndex];
            currentLightboxIndex = allItems.indexOf(nextItem);

            // Update modal fields
            document.getElementById('lightbox-img').src = nextItem.dataset.image || '';
            document.getElementById('lightbox-caption').textContent = nextItem.dataset.caption || '';
            document.getElementById('lightbox-category').textContent = nextItem.dataset.categoryLabel || '';
        }

        // Support Arrow keys for Lightbox navigation
        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('gallery_modal');
            if (modal && modal.open) {
                if (e.key === 'ArrowLeft') {
                    prevGalleryImage();
                } else if (e.key === 'ArrowRight') {
                    nextGalleryImage();
                }
            }
        });

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            initGalleryPagination();
            
            // Initial render and timer
            setTimeout(() => {
                updateDevSlider();
                startDevAutoSlide();
            }, 100);

            // Responsive listener
            window.addEventListener('resize', updateDevSlider);
            
            // Pause on hover
            const viewport = document.querySelector('.dev-slider-viewport');
            if (viewport) {
                viewport.addEventListener('mouseenter', stopDevAutoSlide);
                viewport.addEventListener('mouseleave', startDevAutoSlide);
            }

            // ── Development card click → open compare modal ──
            document.querySelectorAll('.development-card').forEach(card => {
                card.addEventListener('click', () => {
                    // Populate modal fields from data-* attributes
                    document.getElementById('modal-title').textContent    = card.dataset.title       || '';
                    document.getElementById('modal-location').textContent = card.dataset.location    || '';
                    document.getElementById('modal-desc').textContent     = card.dataset.description || '';

                    // Set images — diff-item-1 (left) = BEFORE, diff-item-2 (right) = AFTER
                    document.getElementById('modal-before-img').src = card.dataset.before || '';
                    document.getElementById('modal-after-img').src  = card.dataset.after  || '';

                    // Open the DaisyUI <dialog> modal
                    const modal = document.getElementById('project_modal');
                    if (modal) modal.showModal();
                });
            });
        });
    </script>
@endsection
