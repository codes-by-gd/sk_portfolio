<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" data-theme="patriotic-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Portal - Sachin Khandelwal')</title>
    <meta name="description" content="Admin Control Panel for Sachin Khandelwal Portal.">

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
<body class="font-sans bg-base-200 text-base-content h-screen overflow-hidden flex flex-col transition-colors duration-300">
    <!-- Top Patriotic Ribbon (fixed, part of the fixed header block) -->
    <div class="fixed top-0 left-0 right-0 z-[60] h-1.5 w-full ribbon-gradient"></div>

    <!-- Admin Top Navbar -->
    <header class="fixed top-1.5 left-0 right-0 z-50 bg-neutral text-neutral-content border-b border-white/10 shadow-md">
        <div class="navbar w-full px-4 sm:px-6 lg:px-8">
            <div class="navbar-start">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                    <!-- SK Monogram Badge — saffron gradient + lotus ring glow -->
                    <div class="relative flex items-center justify-center w-10 h-10 rounded-xl font-bold text-lg text-white group-hover:scale-105 transition-transform duration-300 shadow-lg shadow-orange-400/30 shrink-0"
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
                        <span class="font-heading font-extrabold text-sm sm:text-base tracking-tight text-white leading-tight">Sachin Khandelwal</span>
                        <span class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider text-neutral-content/70 leading-tight">
                            <!-- Tiny lotus SVG accent -->
                            <svg class="w-2.5 h-2.5 shrink-0" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(60 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(120 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(180 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(240 6 6)" />
                                <ellipse cx="6" cy="2.5" rx="1.5" ry="3" transform="rotate(300 6 6)" />
                            </svg>
                            Admin Office Portal
                        </span>
                    </div>
                </a>
            </div>

            <!-- Middle indicator/Title -->
            <div class="navbar-center hidden sm:flex">
                <span class="badge badge-outline border-white/20 text-xs font-bold text-primary uppercase tracking-wider px-3 py-2.5">
                    <i class="fa-solid fa-lock mr-1.5"></i> Secure Admin Panel
                </span>
            </div>

            <div class="navbar-end gap-3">
                <!-- Language Selector -->
                <div class="dropdown dropdown-end">
                    <button tabindex="0" class="btn btn-xs sm:btn-sm btn-ghost border border-white/20 hover:border-white/50 gap-1 px-2.5 rounded-lg text-white">
                        <i class="fa-solid fa-language text-base text-accent"></i>
                        <span class="hidden sm:inline font-semibold">
                            @if(app()->getLocale() == 'gu') ગુજરાતી
                            @elseif(app()->getLocale() == 'hi') हिंदी
                            @else English
                            @endif
                        </span>
                    </button>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-xl bg-neutral rounded-box w-36 border border-white/10 font-semibold mt-2 text-white">
                        <li><a href="?lang=gu" class="{{ app()->getLocale() == 'gu' ? 'active bg-primary/20 text-primary' : 'hover:bg-white/10' }}">ગુજરાતી</a></li>
                        <li><a href="?lang=hi" class="{{ app()->getLocale() == 'hi' ? 'active bg-primary/20 text-primary' : 'hover:bg-white/10' }}">हिंदी</a></li>
                        <li><a href="?lang=en" class="{{ app()->getLocale() == 'en' ? 'active bg-primary/20 text-primary' : 'hover:bg-white/10' }}">English</a></li>
                    </ul>
                </div>

                <!-- Theme Toggle Button -->
                <label class="swap swap-rotate btn btn-xs sm:btn-sm btn-ghost border border-white/20 hover:border-white/50 rounded-lg p-0 w-8 h-8 shrink-0 text-white" title="Toggle Dark Mode">
                    <input type="checkbox" class="theme-controller" value="patriotic-dark" id="theme-toggle" />
                    <!-- Sun icon -->
                    <i class="swap-on fa-solid fa-sun text-warning text-base"></i>
                    <!-- Moon icon -->
                    <i class="swap-off fa-solid fa-moon text-neutral-content/60 text-base"></i>
                </label>

                <!-- Back to Public Site -->
                <a href="{{ route('home') }}" class="btn btn-xs sm:btn-sm btn-primary text-white rounded-lg font-bold gap-1 px-3" title="View Public Website">
                    <i class="fa-solid fa-up-right-from-square text-[10px]"></i> <span class="hidden md:inline">View Site</span>
                </a>
            </div>
        </div>
    </header>

    @auth
        {{-- Authenticated Layout: full viewport height, fixed sidebar + scrollable content only --}}
        {{-- Spacer to push content below the fixed ribbon (1.5) + navbar (~4rem) --}}
        <div class="pt-[calc(0.375rem+4rem)] flex flex-row w-full" style="height: calc(100vh - 0.375rem);">

            <!-- Sidebar: fixed height = full remaining viewport, no page scroll -->
            <aside class="hidden lg:flex w-64 shrink-0 bg-neutral text-neutral-content flex-col border-r border-white/10 overflow-y-auto">
                <div class="p-6 space-y-6 flex-grow flex flex-col">
                    <!-- User block -->
                    <div class="border-b border-white/10 pb-4">
                        <span class="text-xs uppercase font-extrabold tracking-widest text-primary block px-3 mb-1">Logged In As</span>
                        <a href="{{ route('admin.profile.edit') }}" class="group flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.profile*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all duration-200" title="Edit Profile">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="avatar placeholder shrink-0">
                                    <div class="bg-primary/20 text-primary group-hover:bg-primary group-hover:text-white {{ request()->routeIs('admin.profile*') ? 'bg-white text-primary' : '' }} rounded-full w-8 h-8 flex items-center justify-center font-bold font-heading text-xs ring-1 ring-primary/30 overflow-hidden transition-all duration-200">
                                        @if(Auth::user()->avatar_path)
                                            <img src="{{ asset(Auth::user()->avatar_path) }}" alt="{{ Auth::user()->name }}" class="object-cover w-full h-full" />
                                        @else
                                            {{ strtoupper(substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1)) }}
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-sm font-bold truncate leading-tight">{{ Auth::user()->first_name }}</span>
                                    <span class="text-xs font-semibold opacity-75 truncate leading-tight mt-0.5">{{ Auth::user()->last_name }}</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-pen-to-square text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-primary {{ request()->routeIs('admin.profile*') ? 'text-white' : '' }}"></i>
                        </a>
                    </div>

                    <!-- Sidebar navigation -->
                    <div class="space-y-6 text-sm">
                        <!-- Group 1: Frontend-Connected -->
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-primary/75 px-3 block">Frontend-Connected</span>
                            <ul class="space-y-1 font-semibold">
                                @can('moderate-content')
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-comments text-lg shrink-0 w-5 text-center"></i>
                                        <span>Feedback Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.complaint.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.complaint*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-circle-exclamation text-lg shrink-0 w-5 text-center"></i>
                                        <span>Citizen Grievances</span>
                                    </a>
                                </li>
                                @endcan

                                @can('edit-content')
                                <li>
                                    <a href="{{ route('admin.development.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.development*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-helmet-safety text-lg shrink-0 w-5 text-center"></i>
                                        <span>Development Works</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.gallery*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-images text-lg shrink-0 w-5 text-center"></i>
                                        <span>Gallery</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.cms.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.cms*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-pen-nib text-lg shrink-0 w-5 text-center"></i>
                                        <span>CMS Content</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>

                        <!-- Divider line -->
                        <div class="border-t border-white/10 my-4"></div>

                        <!-- Group 2: Admin-Only Features -->
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-primary/75 px-3 block">Admin-Only Features</span>
                            <ul class="space-y-1 font-semibold">
                                @can('edit-content')
                                <li>
                                    <a href="{{ route('admin.timeline.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.timeline*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-timeline text-lg shrink-0 w-5 text-center"></i>
                                        <span>Project Timelines</span>
                                    </a>
                                </li>
                                @endcan

                                @can('moderate-content')
                                <li>
                                    <a href="{{ route('admin.contact.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.contact*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-address-book text-lg shrink-0 w-5 text-center"></i>
                                        <span>Contacts Directory</span>
                                    </a>
                                </li>
                                @endcan

                                @can('super-admin')
                                <li>
                                    <a href="{{ route('admin.user.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.user*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-users-gear text-lg shrink-0 w-5 text-center"></i>
                                        <span>User Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.settings*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                        <i class="fa-solid fa-gear text-lg shrink-0 w-5 text-center"></i>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>

                    <!-- Logout pinned to bottom of sidebar -->
                    <div class="mt-auto pt-6 border-t border-white/10">
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-error btn-sm w-full rounded-lg gap-2">
                                <i class="fa-solid fa-power-off"></i> {{ __('messages.admin.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Content column: fills remaining width, ONLY this area scrolls -->
            <div class="flex-grow flex flex-col min-w-0 overflow-hidden">
                <main class="flex-grow overflow-y-auto p-6 lg:p-8 space-y-6">
                    @yield('content')
                </main>

                <!-- Footer: scoped to content column only, never below sidebar -->
                <footer class="bg-neutral text-neutral-content/50 py-4 border-t border-white/10 text-xs shrink-0">
                    <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
                        <p>&copy; {{ date('Y') }} Sachin Khandelwal Office Admin Portal. All Rights Reserved.</p>
                        <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-accent"></i> Secured and optimized</p>
                    </div>
                </footer>
            </div>

        </div>
    @else
        <!-- Guest Layout (e.g. Login page) -->
        <main class="flex-grow flex items-center justify-center p-6 bg-gradient-to-br from-base-100 via-base-200 to-base-100 overflow-y-auto" style="padding-top: calc(0.375rem + 4rem + 1.5rem);">
            @yield('content')
        </main>

        <!-- Footer for guest/login page -->
        <footer class="bg-neutral text-neutral-content/50 py-4 border-t border-white/10 text-xs">
            <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p>&copy; {{ date('Y') }} Sachin Khandelwal Office Admin Portal. All Rights Reserved.</p>
                <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-accent"></i> Secured and optimized</p>
            </div>
        </footer>
    @endauth

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
