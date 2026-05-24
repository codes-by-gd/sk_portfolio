@extends('layouts.admin')

@section('title', 'CMS Content Management - Admin Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-heading font-extrabold text-3xl text-base-content">CMS Content</h1>
        <p class="text-xs text-base-content/50 font-bold uppercase tracking-wider mt-1">Manage multilingual website text content side-by-side</p>
    </div>
</div>

<!-- Alerts Panel -->
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

<!-- Tab boxed switcher -->
<div class="tabs tabs-boxed bg-base-300/50 p-1.5 rounded-2xl mb-8 flex gap-2 w-full max-w-2xl mx-auto shadow-inner">
    <button type="button" onclick="switchCmsTab('hero')" class="tab tab-lg flex-1 rounded-xl font-heading font-extrabold text-sm gap-2 transition-all tab-active bg-primary text-white shadow-sm" id="tab-btn-hero">
        <i class="fa-solid fa-rocket text-base"></i> <span class="hidden sm:inline">Hero Section</span><span class="sm:hidden">Hero</span>
    </button>
    <button type="button" onclick="switchCmsTab('about')" class="tab tab-lg flex-1 rounded-xl font-heading font-extrabold text-sm gap-2 transition-all text-base-content/60" id="tab-btn-about">
        <i class="fa-solid fa-circle-user text-base"></i> <span class="hidden sm:inline">About &amp; Vision</span><span class="sm:hidden">About</span>
    </button>
    <button type="button" onclick="switchCmsTab('achievements')" class="tab tab-lg flex-1 rounded-xl font-heading font-extrabold text-sm gap-2 transition-all text-base-content/60" id="tab-btn-achievements">
        <i class="fa-solid fa-trophy text-base"></i> <span class="hidden sm:inline">Achievements</span><span class="sm:hidden">Stats</span>
    </button>
</div>

<!-- Dynamic CMS Tab Panels -->
<div class="space-y-6">

    <!-- 1. HERO TAB SECTION -->
    <div id="cms-tab-hero" class="cms-tab-content space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Hero text content fields -->
            <div class="lg:col-span-8 bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 space-y-6">
                <div class="flex items-center gap-2 pb-4 border-b border-base-200">
                    <div class="bg-primary/10 text-primary p-2.5 rounded-xl"><i class="fa-solid fa-file-signature text-xl"></i></div>
                    <div>
                        <h2 class="font-heading font-bold text-lg text-base-content">Hero Text Elements</h2>
                        <p class="text-xs text-base-content/50">Edit introductory greetings, homepage titles, and ward mission statements.</p>
                    </div>
                </div>

                <form action="{{ route('admin.cms.update-section') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <!-- Hero Greeting Field Group -->
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-base-content/70 uppercase tracking-widest">1. Greeting Subtitle</label>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- English -->
                            <div class="relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                                <x-float-input type="text" name="content[hero_greeting][content_en]" label="Greeting (English)" value="{{ $pages['hero_greeting']->content_en ?? '' }}" required="true" />
                            </div>
                            <!-- Gujarati -->
                            <div class="relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                                <x-float-input type="text" name="content[hero_greeting][content_gu]" label="Greeting (ગુજરાતી)" value="{{ $pages['hero_greeting']->content_gu ?? '' }}" />
                            </div>
                            <!-- Hindi -->
                            <div class="relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                                <x-float-input type="text" name="content[hero_greeting][content_hi]" label="Greeting (हिंदी)" value="{{ $pages['hero_greeting']->content_hi ?? '' }}" />
                            </div>
                        </div>
                    </div>

                    <!-- Hero Title Field Group -->
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-base-content/70 uppercase tracking-widest">2. Main Heading Title</label>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- English -->
                            <div class="relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                                <x-float-input type="text" name="content[hero_title][content_en]" label="Main Title (English)" value="{{ $pages['hero_title']->content_en ?? '' }}" required="true" />
                            </div>
                            <!-- Gujarati -->
                            <div class="relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                                <x-float-input type="text" name="content[hero_title][content_gu]" label="Main Title (ગુજરાતી)" value="{{ $pages['hero_title']->content_gu ?? '' }}" />
                            </div>
                            <!-- Hindi -->
                            <div class="relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                                <x-float-input type="text" name="content[hero_title][content_hi]" label="Main Title (हिंदी)" value="{{ $pages['hero_title']->content_hi ?? '' }}" />
                            </div>
                        </div>
                    </div>

                    <!-- Hero Mission statement Field Group (Textareas) -->
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-base-content/70 uppercase tracking-widest">3. Mission / Subtitle Paragraph</label>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- English -->
                            <div class="form-control relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                                <label class="floating-label w-full block">
                                    <span>Mission Statement (EN) <span class="text-error font-extrabold">*</span></span>
                                    <textarea name="content[hero_mission][content_en]" required rows="3" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-28">{{ $pages['hero_mission']->content_en ?? '' }}</textarea>
                                </label>
                            </div>
                            <!-- Gujarati -->
                            <div class="form-control relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                                <label class="floating-label w-full block">
                                    <span>Mission Statement (ગુજ)</span>
                                    <textarea name="content[hero_mission][content_gu]" rows="3" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-secondary transition-all h-28">{{ $pages['hero_mission']->content_gu ?? '' }}</textarea>
                                </label>
                            </div>
                            <!-- Hindi -->
                            <div class="form-control relative">
                                <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                                <label class="floating-label w-full block">
                                    <span>Mission Statement (हिं)</span>
                                    <textarea name="content[hero_mission][content_hi]" rows="3" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-accent transition-all h-28">{{ $pages['hero_mission']->content_hi ?? '' }}</textarea>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-base-200 flex justify-end">
                        <button type="submit" class="btn btn-sm btn-primary text-white font-bold rounded-xl gap-2 shadow-md px-6 py-2.5 h-auto">
                            <i class="fa-solid fa-floppy-disk"></i> Save Hero Text Elements
                        </button>
                    </div>
                </form>
            </div>

            <!-- Hero Portrait branding block (4 cols) -->
            <div class="lg:col-span-4 bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-base-200">
                    <h2 class="font-heading font-bold text-md text-base-content flex items-center gap-2">
                        <i class="fa-solid fa-image text-primary"></i> Hero Portrait Branding
                    </h2>
                    
                    <!-- Guidelines Popover -->
                    <div class="dropdown dropdown-hover dropdown-left">
                        <div tabindex="0" role="button" class="btn btn-circle btn-ghost btn-xs text-info hover:bg-info/10">
                            <i class="fa-solid fa-circle-info text-base"></i>
                        </div>
                        <div tabindex="0" class="dropdown-content card compact bg-base-200 border border-base-300 rounded-xl z-[50] w-72 shadow-xl p-5 mt-[-10px] mr-2">
                            <div class="card-body p-0">
                                <h3 class="font-bold text-xs uppercase tracking-wider text-secondary mb-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> Optimization rules
                                </h3>
                                <ul class="text-[11px] text-base-content/85 list-disc pl-4 space-y-2 leading-relaxed font-semibold">
                                    <li><strong>Aspect Ratio:</strong> Portrait <code class="text-primary font-bold">3:4</code> (e.g. <code class="text-primary font-bold">768x1024px</code>) fits the front-end layout perfectly.</li>
                                    <li><strong>Compression:</strong> Auto-compresses and converts uploads to highly efficient WebP format.</li>
                                    <li><strong>Size:</strong> Max <code class="text-error font-bold">10 MB</code>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.cms.update-hero') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="form-control">
                        <label class="block text-xs font-bold text-base-content/70 uppercase tracking-wider mb-2">Upload Portrait Asset</label>
                        <input 
                            type="file" 
                            name="hero_image" 
                            id="hero_image_file"
                            accept="image/*"
                            required
                            class="file-input file-input-bordered file-input-primary w-full bg-base-100 text-base-content rounded-xl border-base-300 focus:outline-none transition-all text-xs"
                            onchange="previewHeroImage(this)"
                        >
                    </div>

                    <!-- Live Thumbnail Preview panel -->
                    <div class="flex flex-col items-center justify-center bg-base-200/50 rounded-2xl p-4 border border-base-300">
                        <span class="text-[10px] font-bold text-base-content/50 uppercase tracking-wider mb-3">Live Portrait Preview</span>
                        <div class="relative w-36 aspect-[3/4] rounded-2xl border border-base-300 shadow-md bg-base-100 overflow-hidden flex items-center justify-center p-1.5">
                            <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-secondary/5 rounded-2xl rotate-3 scale-95 -z-10 animate-pulse"></div>
                            
                            <img 
                                id="hero-preview-img"
                                src="{{ isset($heroImage) && !empty($heroImage) ? asset($heroImage) : asset('images/hero_portrait.webp') }}" 
                                alt="Sachin Khandelwal" 
                                class="w-full h-full object-cover rounded-xl shadow-inner"
                            >
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary w-full text-white font-bold rounded-xl gap-2 shadow-md">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Portrait
                    </button>
                </form>
            </div>

        </div>
    </div>


    <!-- 2. ABOUT TAB SECTION -->
    <div id="cms-tab-about" class="cms-tab-content space-y-6 hidden">
        <div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 space-y-6">
            
            <div class="flex items-center gap-2 pb-4 border-b border-base-200">
                <div class="bg-primary/10 text-primary p-2.5 rounded-xl"><i class="fa-solid fa-address-card text-xl"></i></div>
                <div>
                    <h2 class="font-heading font-bold text-lg text-base-content">Biography &amp; Leadership Vision</h2>
                    <p class="text-xs text-base-content/50">Manage the leadership credentials, personal descriptions, and political vision statement.</p>
                </div>
            </div>

            <form action="{{ route('admin.cms.update-section') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- About Title Field Group -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-base-content/70 uppercase tracking-widest">1. About Section Header</label>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- English -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                            <x-float-input type="text" name="content[about_title][content_en]" label="Title (English)" value="{{ $pages['about_title']->content_en ?? '' }}" required="true" />
                        </div>
                        <!-- Gujarati -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                            <x-float-input type="text" name="content[about_title][content_gu]" label="Title (ગુજરાતી)" value="{{ $pages['about_title']->content_gu ?? '' }}" />
                        </div>
                        <!-- Hindi -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                            <x-float-input type="text" name="content[about_title][content_hi]" label="Title (हिंदी)" value="{{ $pages['about_title']->content_hi ?? '' }}" />
                        </div>
                    </div>
                </div>

                <!-- Biography Bio Field Group -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-base-content/70 uppercase tracking-widest">2. Detailed Biography (Editorial Bio)</label>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- English -->
                        <div class="form-control relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                            <label class="floating-label w-full block">
                                <span>Biography (English) <span class="text-error font-extrabold">*</span></span>
                                <textarea name="content[about_bio][content_en]" required rows="6" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-44 text-justify">{!! e($pages['about_bio']->content_en ?? '') !!}</textarea>
                            </label>
                        </div>
                        <!-- Gujarati -->
                        <div class="form-control relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                            <label class="floating-label w-full block">
                                <span>Biography (ગુજરાતી)</span>
                                <textarea name="content[about_bio][content_gu]" rows="6" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-secondary transition-all h-44 text-justify">{!! e($pages['about_bio']->content_gu ?? '') !!}</textarea>
                            </label>
                        </div>
                        <!-- Hindi -->
                        <div class="form-control relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                            <label class="floating-label w-full block">
                                <span>Biography (हिंदी)</span>
                                <textarea name="content[about_bio][content_hi]" rows="6" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-accent transition-all h-44 text-justify">{!! e($pages['about_bio']->content_hi ?? '') !!}</textarea>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Biography Vision Field Group -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-base-content/70 uppercase tracking-widest">3. Leadership Vision Statement</label>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- English -->
                        <div class="form-control relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                            <label class="floating-label w-full block">
                                <span>Vision (English) <span class="text-error font-extrabold">*</span></span>
                                <textarea name="content[about_vision][content_en]" required rows="6" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-44 text-justify">{!! e($pages['about_vision']->content_en ?? '') !!}</textarea>
                            </label>
                        </div>
                        <!-- Gujarati -->
                        <div class="form-control relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                            <label class="floating-label w-full block">
                                <span>Vision (ગુજરાતી)</span>
                                <textarea name="content[about_vision][content_gu]" rows="6" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-secondary transition-all h-44 text-justify">{!! e($pages['about_vision']->content_gu ?? '') !!}</textarea>
                            </label>
                        </div>
                        <!-- Hindi -->
                        <div class="form-control relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                            <label class="floating-label w-full block">
                                <span>Vision (हिंदी)</span>
                                <textarea name="content[about_vision][content_hi]" rows="6" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-accent transition-all h-44 text-justify">{!! e($pages['about_vision']->content_hi ?? '') !!}</textarea>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-base-200 flex justify-end">
                    <button type="submit" class="btn btn-sm btn-primary text-white font-bold rounded-xl gap-2 shadow-md px-6 py-2.5 h-auto">
                        <i class="fa-solid fa-floppy-disk"></i> Save About Section
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- 3. ACHIEVEMENTS TAB SECTION -->
    <div id="cms-tab-achievements" class="cms-tab-content space-y-6 hidden">
        <div class="bg-base-100 card-base border border-base-300 rounded-2xl shadow-sm p-6 space-y-6">
            
            <div class="flex items-center gap-2 pb-4 border-b border-base-200">
                <div class="bg-primary/10 text-primary p-2.5 rounded-xl"><i class="fa-solid fa-trophy text-xl"></i></div>
                <div>
                    <h2 class="font-heading font-bold text-lg text-base-content">Key Achievements &amp; Metrics</h2>
                    <p class="text-xs text-base-content/50">Edit statistical highlight elements displayed on the public home achievements banner.</p>
                </div>
            </div>

            <form action="{{ route('admin.cms.update-section') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Metric 1: Roads counter title -->
                <div class="space-y-3 pb-6 border-b border-base-200">
                    <div class="flex items-center gap-2 text-primary font-bold">
                        <i class="fa-solid fa-road text-base"></i>
                        <span class="text-xs uppercase tracking-wider font-extrabold text-base-content/85">Metric 1: Roads Built Banner Title</span>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- English -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                            <x-float-input type="text" name="content[achievement_roads][content_en]" label="Roads Stat (English)" value="{{ $pages['achievement_roads']->content_en ?? '' }}" required="true" />
                        </div>
                        <!-- Gujarati -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                            <x-float-input type="text" name="content[achievement_roads][content_gu]" label="Roads Stat (ગુજરાતી)" value="{{ $pages['achievement_roads']->content_gu ?? '' }}" />
                        </div>
                        <!-- Hindi -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                            <x-float-input type="text" name="content[achievement_roads][content_hi]" label="Roads Stat (हिंदी)" value="{{ $pages['achievement_roads']->content_hi ?? '' }}" />
                        </div>
                    </div>
                </div>

                <!-- Metric 2: Lights counter title -->
                <div class="space-y-3 pb-6 border-b border-base-200">
                    <div class="flex items-center gap-2 text-accent font-bold">
                        <i class="fa-solid fa-lightbulb text-base"></i>
                        <span class="text-xs uppercase tracking-wider font-extrabold text-base-content/85">Metric 2: LED Lights Installed Title</span>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- English -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                            <x-float-input type="text" name="content[achievement_lights][content_en]" label="LED Lights Stat (English)" value="{{ $pages['achievement_lights']->content_en ?? '' }}" required="true" />
                        </div>
                        <!-- Gujarati -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                            <x-float-input type="text" name="content[achievement_lights][content_gu]" label="LED Lights Stat (ગુજરાતી)" value="{{ $pages['achievement_lights']->content_gu ?? '' }}" />
                        </div>
                        <!-- Hindi -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                            <x-float-input type="text" name="content[achievement_lights][content_hi]" label="LED Lights Stat (हिंदी)" value="{{ $pages['achievement_lights']->content_hi ?? '' }}" />
                        </div>
                    </div>
                </div>

                <!-- Metric 3: Grievance resolution title -->
                <div class="space-y-3 pb-6 border-b border-base-200">
                    <div class="flex items-center gap-2 text-success font-bold">
                        <i class="fa-solid fa-circle-check text-base"></i>
                        <span class="text-xs uppercase tracking-wider font-extrabold text-base-content/85">Metric 3: Grievances Resolved Title</span>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- English -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                            <x-float-input type="text" name="content[achievement_grievances][content_en]" label="Grievances Stat (English)" value="{{ $pages['achievement_grievances']->content_en ?? '' }}" required="true" />
                        </div>
                        <!-- Gujarati -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                            <x-float-input type="text" name="content[achievement_grievances][content_gu]" label="Grievances Stat (ગુજરાતી)" value="{{ $pages['achievement_grievances']->content_gu ?? '' }}" />
                        </div>
                        <!-- Hindi -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                            <x-float-input type="text" name="content[achievement_grievances][content_hi]" label="Grievances Stat (हिंदी)" value="{{ $pages['achievement_grievances']->content_hi ?? '' }}" />
                        </div>
                    </div>
                </div>

                <!-- Metric 4: Health counter title -->
                <div class="space-y-3 pb-2">
                    <div class="flex items-center gap-2 text-warning font-bold">
                        <i class="fa-solid fa-hand-holding-heart text-base"></i>
                        <span class="text-xs uppercase tracking-wider font-extrabold text-base-content/85">Metric 4: Health Camps Done Title</span>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- English -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
                            <x-float-input type="text" name="content[achievement_camps][content_en]" label="Health Camps Stat (English)" value="{{ $pages['achievement_camps']->content_en ?? '' }}" required="true" />
                        </div>
                        <!-- Gujarati -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]">GU</span>
                            <x-float-input type="text" name="content[achievement_camps][content_gu]" label="Health Camps Stat (ગુજરાતી)" value="{{ $pages['achievement_camps']->content_gu ?? '' }}" />
                        </div>
                        <!-- Hindi -->
                        <div class="relative">
                            <span class="absolute top-2 right-3 z-10 badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]">HI</span>
                            <x-float-input type="text" name="content[achievement_camps][content_hi]" label="Health Camps Stat (हिंदी)" value="{{ $pages['achievement_camps']->content_hi ?? '' }}" />
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-base-200 flex justify-end">
                    <button type="submit" class="btn btn-sm btn-primary text-white font-bold rounded-xl gap-2 shadow-md px-6 py-2.5 h-auto">
                        <i class="fa-solid fa-floppy-disk"></i> Save Achievements Section
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Vanilla Javascript for CMS UI interactions -->
<script>
    /**
     * Switch content tabs in Admin CMS Panel
     */
    function switchCmsTab(tabName) {
        // Find and iterate through standard sections
        const cmsTabs = ['hero', 'about', 'achievements'];
        cmsTabs.forEach(tab => {
            const panel = document.getElementById(`cms-tab-${tab}`);
            const btn = document.getElementById(`tab-btn-${tab}`);
            if (panel) {
                panel.classList.add('hidden');
            }
            if (btn) {
                btn.classList.remove('tab-active', 'bg-primary', 'text-white', 'shadow-sm');
                btn.classList.add('text-base-content/60');
            }
        });

        // Activate active panel and button styling
        const activePanel = document.getElementById(`cms-tab-${tabName}`);
        const activeBtn = document.getElementById(`tab-btn-${tabName}`);
        if (activePanel) {
            activePanel.classList.remove('hidden');
        }
        if (activeBtn) {
            activeBtn.classList.remove('text-base-content/60');
            activeBtn.classList.add('tab-active', 'bg-primary', 'text-white', 'shadow-sm');
        }

        // Save active tab state in sessionStorage to retain tabs during forms update submit
        sessionStorage.setItem('sk_active_cms_tab', tabName);
    }

    /**
     * Preview portrait branding uploads instantly in client browser
     */
    function previewHeroImage(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const targetPreview = document.getElementById('hero-preview-img');
                if (targetPreview) {
                    targetPreview.src = event.target.result;
                }
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    // Auto-restore tab selection on redirect/refresh page sessions
    document.addEventListener('DOMContentLoaded', function() {
        const lastSelectedTab = sessionStorage.getItem('sk_active_cms_tab') || 'hero';
        switchCmsTab(lastSelectedTab);
    });
</script>
@endsection
