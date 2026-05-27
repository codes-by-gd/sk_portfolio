<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" data-theme="patriotic-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sachin Khandelwal - Vadodara Ward No. 7')</title>
    <meta name="description" content="@yield('meta_description', 'Official website of Sachin Khandelwal, Corporator &amp; BJP Adhyaksh for Vadodara Ward No. 7. Share feedback and view development projects.')">

    <!-- Anti-Flash Theme Restoration Script -->
    <script>
        (function() {
            var theme = localStorage.getItem('sk-theme') || 'patriotic-theme';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <!-- Fonts - preconnect for speed, display=swap to prevent FOIT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"></noscript>

    <!-- FontAwesome Icons - non-blocking async load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-base-100 text-base-content min-h-screen flex flex-col transition-colors duration-300">
    <!-- Top Patriotic Ribbon -->
    <div class="h-1.5 w-full ribbon-gradient"></div>

    <!-- Header & Sticky Navbar -->
    <header id="site-header" class="sticky top-0 z-50 transition-all duration-300 border-b border-base-300/0">
        <div class="navbar max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="navbar-start">
                <!-- Mobile Hamburger — triggers full-screen drawer -->
                <button id="mobile-menu-btn" class="btn btn-ghost btn-sm lg:hidden p-1.5" aria-label="Open Menu" onclick="openMobileDrawer()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </button>
                <!-- Brand / Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-2.5 group">
                    <!-- SK Monogram Badge — saffron gradient + lotus ring glow -->
                    <div class="relative flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl font-bold text-lg text-white group-hover:scale-105 transition-transform duration-300 shadow-lg shadow-orange-400/30 shrink-0"
                         style="background: linear-gradient(135deg, #FF8A3D 0%, #e8651a 100%)">
                        SK
                        <!-- Subtle lotus petal SVG ring -->
                        <svg class="absolute inset-0 w-full h-full opacity-[0.18] pointer-events-none" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(0 20 20)"/>
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(45 20 20)"/>
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(90 20 20)"/>
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(135 20 20)"/>
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(180 20 20)"/>
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(225 20 20)"/>
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(270 20 20)"/>
                            <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(315 20 20)"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-heading font-extrabold text-base sm:text-lg tracking-tight text-base-content leading-tight">Sachin Khandelwal</span>
                        <span class="hidden sm:flex items-center gap-1 text-[10px] font-extrabold tracking-wide text-primary leading-tight">
                            <!-- Tiny lotus SVG accent -->
                            <svg class="w-2.5 h-2.5 shrink-0" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(60 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(120 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(180 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(240 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(300 6 6)" />
                            </svg>
                            BJP Adhyaksh &middot; Ward 7
                        </span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1 gap-1 font-medium" id="desktop-nav-links">
                    <li><a href="{{ route('home') }}#home" data-section="home" class="nav-link rounded-lg transition-all duration-200 hover:text-primary hover:bg-primary/5">{{ __('messages.nav.home') }}</a></li>
                    <li><a href="{{ route('home') }}#about" data-section="about" class="nav-link rounded-lg transition-all duration-200 hover:text-primary hover:bg-primary/5">{{ __('messages.nav.about') }}</a></li>
                    <li><a href="{{ route('home') }}#development" data-section="development" class="nav-link rounded-lg transition-all duration-200 hover:text-primary hover:bg-primary/5">{{ __('messages.nav.development') }}</a></li>
                    <li><a href="{{ route('home') }}#achievements" data-section="achievements" class="nav-link rounded-lg transition-all duration-200 hover:text-primary hover:bg-primary/5">{{ __('messages.nav.achievements') }}</a></li>
                    <li><a href="{{ route('home') }}#gallery" data-section="gallery" class="nav-link rounded-lg transition-all duration-200 hover:text-primary hover:bg-primary/5">{{ __('messages.nav.gallery') }}</a></li>
                    <li><a href="{{ route('home') }}#contact" data-section="contact" class="nav-link rounded-lg transition-all duration-200 hover:text-primary hover:bg-primary/5">{{ __('messages.nav.contact') }}</a></li>
                </ul>
            </div>

            <!-- Language Switcher & Call to Action -->
            <div class="navbar-end gap-1 sm:gap-2">
                <!-- Language Selector -->
                <div class="dropdown dropdown-end">
                    <button tabindex="0" class="btn btn-sm btn-ghost border border-base-300 hover:border-primary gap-1 px-2.5 rounded-lg">
                        <i class="fa-solid fa-language text-lg text-secondary"></i>
                        <span class="hidden lg:inline font-semibold">
                            @if(app()->getLocale() == 'gu') ગુજરાતી
                            @elseif(app()->getLocale() == 'hi') हिंदी
                            @else English
                            @endif
                        </span>
                    </button>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-xl bg-base-100 rounded-box w-36 border border-base-300 font-semibold mt-2">
                        <li><a href="?lang=gu" class="{{ app()->getLocale() == 'gu' ? 'active bg-primary/10 text-primary' : '' }}">ગુજરાતી</a></li>
                        <li><a href="?lang=hi" class="{{ app()->getLocale() == 'hi' ? 'active bg-primary/10 text-primary' : '' }}">हिंदी</a></li>
                        <li><a href="?lang=en" class="{{ app()->getLocale() == 'en' ? 'active bg-primary/10 text-primary' : '' }}">English</a></li>
                    </ul>
                </div>

                <!-- Theme Toggle Button -->
                <label class="swap swap-rotate btn btn-sm btn-ghost border border-base-300 hover:border-primary rounded-lg p-0 w-8 h-8 shrink-0" title="Toggle Dark Mode">
                    <input type="checkbox" class="theme-controller" value="patriotic-dark" id="theme-toggle" />
                    <!-- Sun icon -->
                    <i class="swap-on fa-solid fa-sun text-warning text-base"></i>
                    <!-- Moon icon -->
                    <i class="swap-off fa-solid fa-moon text-base-content/60 text-base"></i>
                </label>



            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-neutral text-neutral-content pt-8 md:pt-12 pb-4 md:pb-6 border-t-2 border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- ── Mobile Layout: brand+social row, then 2-col links ── -->
            <!-- ── Desktop Layout: 3-column grid (unchanged)          ── -->

            <!-- Top area: 3-col on md+, single-col stack on mobile -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">

                <!-- Col 1: Brand -->
                <div class="space-y-3 md:space-y-4">
                    <!-- Brand + social icons on one row for mobile -->
                    <div class="flex items-center justify-between md:block">
                        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                            <div class="relative flex items-center justify-center w-10 h-10 rounded-xl font-bold text-lg text-white group-hover:scale-105 transition-transform duration-300 shadow-lg shadow-orange-400/30 shrink-0"
                                 style="background: linear-gradient(135deg, #FF8A3D 0%, #e8651a 100%)">
                                SK
                                <svg class="absolute inset-0 w-full h-full opacity-[0.18] pointer-events-none" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(0 20 20)"/>
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(45 20 20)"/>
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(90 20 20)"/>
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(135 20 20)"/>
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(180 20 20)"/>
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(225 20 20)"/>
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(270 20 20)"/>
                                    <ellipse cx="20" cy="8"  rx="3.5" ry="7" fill="white" transform="rotate(315 20 20)"/>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-heading font-extrabold text-base sm:text-xl tracking-tight text-white leading-tight">Sachin Khandelwal</span>
                                <span class="flex items-center gap-1 text-[10px] font-extrabold tracking-wide text-primary leading-tight">
                                    <svg class="w-2.5 h-2.5 shrink-0" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" />
                                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(60 6 6)" />
                                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(120 6 6)" />
                                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(180 6 6)" />
                                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(240 6 6)" />
                                        <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(300 6 6)" />
                                    </svg>
                                    BJP Adhyaksh &middot; Ward 7
                                </span>
                            </div>
                        </a>
                        <!-- Social icons — inline on mobile (right side), block below on desktop -->
                        <div class="flex gap-3 text-lg md:hidden">
                            <a href="#" class="hover:text-primary transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                            <a href="#" class="hover:text-primary transition-colors" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="hover:text-primary transition-colors" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="hover:text-primary transition-colors" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                    <!-- Designation — hidden on mobile to save space, shown on desktop -->
                    <p class="hidden md:block text-sm text-neutral-content/75 leading-relaxed">
                        {{ __('messages.hero.designation') }}
                    </p>
                    <!-- Social icons desktop version -->
                    <div class="hidden md:flex gap-4 text-lg">
                        <a href="#" class="hover:text-primary transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="hover:text-primary transition-colors" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="hover:text-primary transition-colors" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="hover:text-primary transition-colors" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Col 2 + Col 3: side-by-side 2-col grid on mobile, separate cols on desktop -->
                <div class="grid grid-cols-2 md:contents gap-6">
                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-heading font-bold text-white mb-2 md:mb-4 text-sm md:text-lg">Quick Links</h4>
                        <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm text-neutral-content/75">
                            <li><a href="{{ route('home') }}#home" class="hover:text-white transition-colors">{{ __('messages.nav.home') }}</a></li>
                            <li><a href="{{ route('home') }}#about" class="hover:text-white transition-colors">{{ __('messages.nav.about') }}</a></li>
                            <li><a href="{{ route('home') }}#development" class="hover:text-white transition-colors">{{ __('messages.nav.development') }}</a></li>
                            <li><a href="{{ route('home') }}#achievements" class="hover:text-white transition-colors">{{ __('messages.nav.achievements') }}</a></li>
                            <li><a href="{{ route('home') }}#gallery" class="hover:text-white transition-colors">{{ __('messages.nav.gallery') }}</a></li>
                            <li><a href="{{ route('complaint.create') }}" class="hover:text-white transition-colors">{{ __('messages.nav.grievance') }}</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div class="space-y-1.5 md:space-y-3">
                        <h4 class="font-heading font-bold text-white mb-2 md:mb-4 text-sm md:text-lg">{{ __('messages.sections.contact') }}</h4>
                        <p class="text-xs md:text-sm text-neutral-content/75"><i class="fa-solid fa-map-location-dot text-primary mr-1.5"></i> {{ App\Models\Setting::getValue('office_address', 'Vadodara') }}</p>
                        <p class="text-xs md:text-sm text-neutral-content/75"><i class="fa-solid fa-phone text-primary mr-1.5"></i> {{ App\Models\Setting::getValue('office_phone', '') }}</p>
                        <p class="text-xs md:text-sm text-neutral-content/75 break-all"><i class="fa-solid fa-envelope text-primary mr-1.5"></i> {{ App\Models\Setting::getValue('office_email', '') }}</p>
                    </div>
                </div>
            </div>

            <!-- Copyright bar -->
            <div class="mt-6 md:mt-12 pt-4 md:pt-6 border-t border-neutral-content/10 flex flex-col sm:flex-row justify-between items-center text-xs text-neutral-content/50 gap-1 md:gap-4">
                <p>&copy; {{ date('Y') }} Sachin Khandelwal. All Rights Reserved.</p>
                <p class="hidden sm:block">Designed with patriotism and dedication.</p>
            </div>
        </div>
    </footer>

    <!-- ═══════════════════════════════════════════════════════════ -->
    <!-- Full-Screen Mobile Navigation Drawer                        -->
    <!-- ═══════════════════════════════════════════════════════════ -->

    <!-- Backdrop overlay -->
    <div id="drawer-backdrop"
         class="fixed inset-0 bg-neutral/60 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"
         onclick="closeMobileDrawer()"
         aria-hidden="true">
    </div>

    <!-- Drawer Panel -->
    <div id="mobile-drawer"
         class="fixed top-0 left-0 h-full w-[82vw] max-w-[320px] bg-base-100 z-[70] shadow-2xl flex flex-col -translate-x-full transition-transform duration-300 ease-out"
         aria-label="Mobile navigation menu"
         role="dialog">

        <!-- Drawer Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-base-300 shrink-0">
            <!-- SK Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" onclick="closeMobileDrawer()">
                <div class="relative flex items-center justify-center w-10 h-10 rounded-xl font-bold text-lg text-white shadow-lg shadow-orange-400/30 shrink-0"
                     style="background: linear-gradient(135deg, #FF8A3D 0%, #e8651a 100%)">
                    SK
                    <svg class="absolute inset-0 w-full h-full opacity-[0.18] pointer-events-none" viewBox="0 0 40 40" fill="none">
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(0 20 20)"/>
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(45 20 20)"/>
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(90 20 20)"/>
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(135 20 20)"/>
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(180 20 20)"/>
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(225 20 20)"/>
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(270 20 20)"/>
                        <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(315 20 20)"/>
                    </svg>
                </div>
                <div>
                    <span class="font-heading font-extrabold text-base text-base-content tracking-tight leading-tight block">Sachin Khandelwal</span>
                    <span class="text-[10px] font-extrabold tracking-wide text-primary leading-tight">BJP Adhyaksh &middot; Ward 7</span>
                </div>
            </a>
            <!-- Close Button -->
            <button onclick="closeMobileDrawer()" class="btn btn-sm btn-circle btn-ghost text-base-content/60 hover:text-error hover:bg-error/10 transition-colors" aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Nav Links -->
        <nav class="flex-grow overflow-y-auto py-4 px-3">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('home') }}#home" onclick="closeMobileDrawer()"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-base-content hover:bg-primary/8 hover:text-primary transition-all duration-150 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-base-200 group-hover:bg-primary/15 transition-colors shrink-0">
                            <i class="fa-solid fa-house text-sm text-base-content/50 group-hover:text-primary"></i>
                        </span>
                        {{ __('messages.nav.home') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#about" onclick="closeMobileDrawer()"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-base-content hover:bg-primary/8 hover:text-primary transition-all duration-150 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-base-200 group-hover:bg-primary/15 transition-colors shrink-0">
                            <i class="fa-solid fa-user text-sm text-base-content/50 group-hover:text-primary"></i>
                        </span>
                        {{ __('messages.nav.about') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#development" onclick="closeMobileDrawer()"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-base-content hover:bg-primary/8 hover:text-primary transition-all duration-150 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-base-200 group-hover:bg-primary/15 transition-colors shrink-0">
                            <i class="fa-solid fa-helmet-safety text-sm text-base-content/50 group-hover:text-primary"></i>
                        </span>
                        {{ __('messages.nav.development') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#achievements" onclick="closeMobileDrawer()"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-base-content hover:bg-primary/8 hover:text-primary transition-all duration-150 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-base-200 group-hover:bg-primary/15 transition-colors shrink-0">
                            <i class="fa-solid fa-trophy text-sm text-base-content/50 group-hover:text-primary"></i>
                        </span>
                        {{ __('messages.nav.achievements') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#gallery" onclick="closeMobileDrawer()"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-base-content hover:bg-primary/8 hover:text-primary transition-all duration-150 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-base-200 group-hover:bg-primary/15 transition-colors shrink-0">
                            <i class="fa-solid fa-images text-sm text-base-content/50 group-hover:text-primary"></i>
                        </span>
                        {{ __('messages.nav.gallery') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#contact" onclick="closeMobileDrawer()"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-base-content hover:bg-primary/8 hover:text-primary transition-all duration-150 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-base-200 group-hover:bg-primary/15 transition-colors shrink-0">
                            <i class="fa-solid fa-phone text-sm text-base-content/50 group-hover:text-primary"></i>
                        </span>
                        {{ __('messages.nav.contact') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('complaint.create') }}" onclick="closeMobileDrawer()"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-base-content hover:bg-primary/8 hover:text-primary transition-all duration-150 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-base-200 group-hover:bg-primary/15 transition-colors shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-sm text-base-content/50 group-hover:text-primary"></i>
                        </span>
                        {{ __('messages.nav.grievance') }}
                    </a>
                </li>
            </ul>

            <!-- Language Switcher in Drawer -->
            <div class="mt-6 px-4">
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-base-content/40 mb-2">Language</p>
                <div class="flex gap-2">
                    <a href="?lang=gu" class="flex-1 btn btn-xs rounded-lg {{ app()->getLocale() == 'gu' ? 'btn-primary text-white' : 'btn-ghost border border-base-300' }}">ગુ</a>
                    <a href="?lang=hi" class="flex-1 btn btn-xs rounded-lg {{ app()->getLocale() == 'hi' ? 'btn-primary text-white' : 'btn-ghost border border-base-300' }}">हि</a>
                    <a href="?lang=en" class="flex-1 btn btn-xs rounded-lg {{ app()->getLocale() == 'en' ? 'btn-primary text-white' : 'btn-ghost border border-base-300' }}">EN</a>
                </div>
            </div>

            <!-- Theme Toggle in Drawer -->
            <div class="mt-4 px-4 flex items-center justify-between py-3 bg-base-200 rounded-xl">
                <span class="text-sm font-semibold text-base-content/70">Dark Mode</span>
                <label class="swap swap-rotate btn btn-sm btn-ghost border border-base-300 rounded-lg p-0 w-9 h-9">
                    <input type="checkbox" class="theme-controller" value="patriotic-dark" id="drawer-theme-toggle" />
                    <i class="swap-on fa-solid fa-sun text-warning"></i>
                    <i class="swap-off fa-solid fa-moon text-base-content/60"></i>
                </label>
            </div>
        </nav>

        <!-- Drawer Footer CTA -->
        <div class="px-4 py-5 border-t border-base-300 shrink-0">
            <a href="{{ route('feedback.detailed') }}" onclick="closeMobileDrawer()"
               class="btn btn-primary w-full text-white font-bold rounded-xl gap-2 shadow-md shadow-primary/25">
                <i class="fa-solid fa-comments"></i>
                {{ __('messages.nav.give_feedback') }}
            </a>
        </div>
    </div>

    <!-- Sync checkbox state, localStorage updates, scroll effects & scroll-spy -->
    <script>
        // ── Mobile Drawer ────────────────────────────────────────────────────
        function openMobileDrawer() {
            var drawer   = document.getElementById('mobile-drawer');
            var backdrop = document.getElementById('drawer-backdrop');
            drawer.classList.remove('-translate-x-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100');
            document.body.style.overflow = 'hidden';
            // Sync drawer theme toggle with current theme
            var drawerToggle = document.getElementById('drawer-theme-toggle');
            if (drawerToggle) {
                drawerToggle.checked = document.documentElement.getAttribute('data-theme') === 'patriotic-dark';
                drawerToggle.addEventListener('change', function() {
                    var newTheme = this.checked ? 'patriotic-dark' : 'patriotic-theme';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('sk-theme', newTheme);
                    // Sync the navbar toggle too
                    var navToggle = document.getElementById('theme-toggle');
                    if (navToggle) navToggle.checked = this.checked;
                }, { once: true });
            }
        }

        function closeMobileDrawer() {
            var drawer   = document.getElementById('mobile-drawer');
            var backdrop = document.getElementById('drawer-backdrop');
            drawer.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            backdrop.classList.remove('opacity-100');
            document.body.style.overflow = '';
        }

        document.addEventListener('DOMContentLoaded', function () {

            // ── Theme toggle (navbar) ────────────────────────────────────────
            var toggle = document.getElementById('theme-toggle');
            if (toggle) {
                var currentTheme = document.documentElement.getAttribute('data-theme') || 'patriotic-theme';
                toggle.checked = (currentTheme === 'patriotic-dark');
                toggle.addEventListener('change', function () {
                    var newTheme = this.checked ? 'patriotic-dark' : 'patriotic-theme';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('sk-theme', newTheme);
                });
            }

            // Close drawer on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeMobileDrawer();
            });

            // ── Scroll-triggered navbar glass effect ─────────────────────────
            var header = document.getElementById('site-header');
            function updateHeader() {
                if (window.scrollY > 50) {
                    header.classList.add('bg-base-100/90', 'backdrop-blur-md', 'shadow-sm', 'border-base-300');
                    header.classList.remove('border-base-300/0');
                } else {
                    header.classList.remove('bg-base-100/90', 'backdrop-blur-md', 'shadow-sm', 'border-base-300');
                    header.classList.add('border-base-300/0');
                }
            }
            window.addEventListener('scroll', updateHeader, { passive: true });
            updateHeader();

            // ── Scroll-spy: highlight active section in desktop nav ───────────
            var sections = document.querySelectorAll('section[id], div[id]');
            var navLinks = document.querySelectorAll('#desktop-nav-links .nav-link');

            if (navLinks.length > 0 && sections.length > 0) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            var id = entry.target.getAttribute('id');
                            navLinks.forEach(function (link) {
                                var isActive = link.getAttribute('data-section') === id;
                                link.classList.toggle('text-primary', isActive);
                                link.classList.toggle('font-semibold', isActive);
                                link.classList.toggle('bg-primary/8', isActive);
                            });
                        }
                    });
                }, { rootMargin: '-30% 0px -60% 0px', threshold: 0 });

                sections.forEach(function (section) {
                    var id = section.getAttribute('id');
                    if (Array.from(navLinks).some(function (l) { return l.getAttribute('data-section') === id; })) {
                        observer.observe(section);
                    }
                });
            }
        });
    </script>
    <!-- Global Stock DaisyUI Dropdown Speed Dial Citizen Interaction Panel -->
    <div class="dropdown dropdown-top dropdown-end dropdown-hover fixed right-6 bottom-6 z-50 group">
        <!-- Trigger Button -->
        <div tabindex="0" role="button" class="btn btn-md sm:btn-lg btn-circle btn-primary shadow-2xl animate-fab-pulse flex items-center justify-center focus:outline-none transition-all duration-300" title="Quick Actions">
            <i class="fa-solid fa-plus text-base sm:text-lg text-white transition-transform duration-300 group-focus-within:rotate-45"></i>
        </div>

        <!-- Dropdown Speed Dial Menu (appears above the trigger button, right-aligned) -->
        <div tabindex="0" class="dropdown-content mb-4 flex flex-col items-end gap-3 pointer-events-auto">
            <!-- Action 1: File a Grievance -->
            <div class="flex items-center gap-3">
                <span class="bg-base-100 border border-base-300 px-3 py-1.5 rounded-xl text-xs font-extrabold shadow-md text-base-content select-none">
                    {{ __('messages.nav.grievance') }}
                </span>
                <a href="{{ route('complaint.create') }}" class="btn btn-circle btn-md btn-secondary shadow-lg hover:scale-105 transition-transform duration-200" title="{{ __('messages.nav.grievance') }}">
                    <i class="fa-solid fa-circle-exclamation text-sm text-white"></i>
                </a>
            </div>

            <!-- Action 2: Give Detailed Feedback -->
            <div class="flex items-center gap-3">
                <span class="bg-base-100 border border-base-300 px-3 py-1.5 rounded-xl text-xs font-extrabold shadow-md text-base-content select-none">
                    {{ __('messages.nav.give_feedback') }}
                </span>
                <a href="{{ route('feedback.detailed') }}" class="btn btn-circle btn-md btn-primary shadow-lg hover:scale-105 transition-transform duration-200" title="{{ __('messages.nav.give_feedback') }}">
                    <i class="fa-solid fa-comments text-sm text-white"></i>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
