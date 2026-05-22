<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" data-theme="patriotic-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sachin Khandelwal - Vadodara Ward No. 7')</title>
    <meta name="description" content="Official website of Sachin Khandelwal, Corporator & BJP Adhyaksh for Vadodara Ward No. 7. Share feedback and view development projects.">

    <!-- Anti-Flash Theme Restoration Script -->
    <script>
        (function() {
            var theme = localStorage.getItem('sk-theme') || 'patriotic-theme';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-base-100 text-base-content min-h-screen flex flex-col transition-colors duration-300">
    <!-- Top Patriotic Ribbon -->
    <div class="h-1.5 w-full ribbon-gradient"></div>

    <!-- Header & Sticky Navbar -->
    <header class="sticky top-0 z-50 bg-base-100/90 backdrop-blur-md border-b border-base-300">
        <div class="navbar max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="navbar-start">
                <!-- Mobile Drawer / Menu Toggle -->
                <div class="dropdown">
                    <button tabindex="0" class="btn btn-ghost lg:hidden" aria-label="Toggle Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0/0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </button>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300 font-medium">
                        <li><a href="{{ route('home') }}#home">{{ __('messages.nav.home') }}</a></li>
                        <li><a href="{{ route('home') }}#about">{{ __('messages.nav.about') }}</a></li>
                        <li><a href="{{ route('home') }}#development">{{ __('messages.nav.development') }}</a></li>
                        <li><a href="{{ route('home') }}#achievements">{{ __('messages.nav.achievements') }}</a></li>
                        <li><a href="{{ route('home') }}#gallery">{{ __('messages.nav.gallery') }}</a></li>
                        <li><a href="{{ route('home') }}#contact">{{ __('messages.nav.contact') }}</a></li>
                        <li><a href="{{ route('feedback.detailed') }}" class="bg-primary text-white font-bold rounded-lg py-2 mt-2 text-center flex justify-center items-center gap-1.5"><i class="fa-solid fa-comments"></i> {{ __('messages.nav.give_feedback') }}</a></li>
                    </ul>
                </div>
                <!-- Brand / Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="bg-primary text-white p-2 rounded-xl flex items-center justify-center font-bold text-lg shadow-md group-hover:scale-105 transition-transform duration-300">
                        SK
                    </div>
                    <div class="flex flex-col">
                        <span class="font-heading font-extrabold text-lg sm:text-xl tracking-tight text-base-content">Sachin Khandelwal</span>
                        <span class="text-[10px] uppercase font-extrabold tracking-widest text-primary">Vadodara Ward 7</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1 gap-1 font-medium">
                    <li><a href="{{ route('home') }}#home" class="hover:text-primary transition-colors">{{ __('messages.nav.home') }}</a></li>
                    <li><a href="{{ route('home') }}#about" class="hover:text-primary transition-colors">{{ __('messages.nav.about') }}</a></li>
                    <li><a href="{{ route('home') }}#development" class="hover:text-primary transition-colors">{{ __('messages.nav.development') }}</a></li>
                    <li><a href="{{ route('home') }}#achievements" class="hover:text-primary transition-colors">{{ __('messages.nav.achievements') }}</a></li>
                    <li><a href="{{ route('home') }}#gallery" class="hover:text-primary transition-colors">{{ __('messages.nav.gallery') }}</a></li>
                    <li><a href="{{ route('home') }}#contact" class="hover:text-primary transition-colors">{{ __('messages.nav.contact') }}</a></li>
                </ul>
            </div>

            <!-- Language Switcher & Call to Action -->
            <div class="navbar-end gap-2 sm:gap-4">
                <!-- Language Selector -->
                <div class="dropdown dropdown-end">
                    <button tabindex="0" class="btn btn-sm btn-ghost border border-base-300 hover:border-primary gap-1 px-2.5 rounded-lg">
                        <i class="fa-solid fa-language text-lg text-secondary"></i>
                        <span class="hidden sm:inline font-semibold">
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

                <!-- Give Feedback CTA Button -->
                <a href="{{ route('feedback.detailed') }}" class="btn btn-sm btn-primary text-white font-bold rounded-lg shadow-sm gap-1.5 hidden md:inline-flex">
                    <i class="fa-solid fa-comments text-xs"></i> {{ __('messages.nav.give_feedback') }}
                </a>

                <!-- Admin Link -->
                <a href="{{ route('admin.login') }}" class="btn btn-sm btn-circle btn-ghost text-base-content/75 hover:text-primary" title="{{ __('messages.nav.admin') }}">
                    <i class="fa-solid fa-user-shield text-base"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-neutral text-neutral-content pt-12 pb-6 border-t-2 border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="bg-primary text-white p-2 rounded-xl flex items-center justify-center font-bold text-lg">
                        SK
                    </div>
                    <span class="font-heading font-extrabold text-xl tracking-tight text-white">Sachin Khandelwal</span>
                </div>
                <p class="text-sm text-neutral-content/75 leading-relaxed">
                    {{ __('messages.hero.designation') }}
                </p>
                <div class="flex gap-4 text-lg">
                    <a href="#" class="hover:text-primary transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="hover:text-primary transition-colors" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="hover:text-primary transition-colors" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-primary transition-colors" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            
            <div>
                <h4 class="font-heading font-bold text-white mb-4 text-lg">Quick Links</h4>
                <ul class="space-y-2 text-sm text-neutral-content/75">
                    <li><a href="{{ route('home') }}#home" class="hover:text-white transition-colors">{{ __('messages.nav.home') }}</a></li>
                    <li><a href="{{ route('home') }}#about" class="hover:text-white transition-colors">{{ __('messages.nav.about') }}</a></li>
                    <li><a href="{{ route('home') }}#development" class="hover:text-white transition-colors">{{ __('messages.nav.development') }}</a></li>
                    <li><a href="{{ route('home') }}#achievements" class="hover:text-white transition-colors">{{ __('messages.nav.achievements') }}</a></li>
                    <li><a href="{{ route('home') }}#gallery" class="hover:text-white transition-colors">{{ __('messages.nav.gallery') }}</a></li>
                </ul>
            </div>

            <div class="space-y-3">
                <h4 class="font-heading font-bold text-white mb-4 text-lg">{{ __('messages.sections.contact') }}</h4>
                <p class="text-sm text-neutral-content/75"><i class="fa-solid fa-map-location-dot text-primary mr-2"></i> {{ App\Models\Setting::getValue('office_address', 'Vadodara') }}</p>
                <p class="text-sm text-neutral-content/75"><i class="fa-solid fa-phone text-primary mr-2"></i> {{ App\Models\Setting::getValue('office_phone', '') }}</p>
                <p class="text-sm text-neutral-content/75"><i class="fa-solid fa-envelope text-primary mr-2"></i> {{ App\Models\Setting::getValue('office_email', '') }}</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-neutral-content/10 flex flex-col sm:flex-row justify-between items-center text-xs text-neutral-content/50 gap-4">
            <p>&copy; {{ date('Y') }} Sachin Khandelwal. All Rights Reserved.</p>
            <p>Designed with patriotism and dedication.</p>
        </div>
    </footer>

    <!-- Sync checkbox state & handle localStorage updates -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
</body>
</html>
