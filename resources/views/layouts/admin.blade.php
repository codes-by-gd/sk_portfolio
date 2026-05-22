<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Portal - Sachin Khandelwal')</title>
    <meta name="description" content="Admin Control Panel for Sachin Khandelwal Portal.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-base-200 text-base-content min-h-screen flex flex-col">
    <!-- Top Patriotic Ribbon -->
    <div class="h-1.5 w-full bg-gradient-to-r from-[#FF8A3D] via-[#FFFDF8] to-[#53C58B]"></div>

    <!-- Admin Top Navbar -->
    <header class="sticky top-0 z-50 bg-neutral text-neutral-content border-b border-white/10 shadow-md">
        <div class="navbar w-full px-4 sm:px-6 lg:px-8">
            <div class="navbar-start">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                    <div class="bg-[#FF8A3D] text-white p-2 rounded-xl flex items-center justify-center font-bold text-sm shadow-md">
                        SK
                    </div>
                    <div class="flex flex-col">
                        <span class="font-heading font-extrabold text-sm sm:text-base tracking-tight text-white">Sachin Khandelwal</span>
                        <span class="text-[9px] uppercase font-bold tracking-widest text-[#FFFDF8]/70">Admin Office Portal</span>
                    </div>
                </a>
            </div>

            <!-- Middle indicator/Title -->
            <div class="navbar-center hidden sm:flex">
                <span class="badge badge-outline border-white/20 text-xs font-bold text-[#FF8A3D] uppercase tracking-wider px-3 py-2.5">
                    <i class="fa-solid fa-lock mr-1.5"></i> Secure Admin Panel
                </span>
            </div>

            <div class="navbar-end gap-3">
                <!-- Language Selector (For admin panel translation convenience) -->
                <div class="dropdown dropdown-end">
                    <button tabindex="0" class="btn btn-xs sm:btn-sm btn-ghost border border-white/20 hover:border-white/50 gap-1 px-2.5 rounded-lg text-white">
                        <i class="fa-solid fa-language text-base text-[#53C58B]"></i>
                        <span class="hidden sm:inline font-semibold">
                            @if(app()->getLocale() == 'gu') ગુજરાતી
                            @elseif(app()->getLocale() == 'hi') हिंदी
                            @else English
                            @endif
                        </span>
                    </button>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-xl bg-neutral rounded-box w-36 border border-white/10 font-semibold mt-2 text-white">
                        <li><a href="?lang=gu" class="{{ app()->getLocale() == 'gu' ? 'active bg-primary/20 text-[#FF8A3D]' : 'hover:bg-white/10' }}">ગુજરાતી</a></li>
                        <li><a href="?lang=hi" class="{{ app()->getLocale() == 'hi' ? 'active bg-primary/20 text-[#FF8A3D]' : 'hover:bg-white/10' }}">हिंदी</a></li>
                        <li><a href="?lang=en" class="{{ app()->getLocale() == 'en' ? 'active bg-primary/20 text-[#FF8A3D]' : 'hover:bg-white/10' }}">English</a></li>
                    </ul>
                </div>

                <!-- Back to Public Site -->
                <a href="{{ route('home') }}" class="btn btn-xs sm:btn-sm btn-primary text-white rounded-lg font-bold gap-1 px-3" title="View Public Website">
                    <i class="fa-solid fa-up-right-from-square text-[10px]"></i> <span class="hidden md:inline">View Site</span>
                </a>
            </div>
        </div>
    </header>

    @auth
        <!-- Authenticated Layout: sidebar + content column side by side -->
        <div class="flex-grow flex flex-col lg:flex-row w-full overflow-hidden">

            <!-- Sidebar: fixed viewport height, sticky below navbar, scrollable internally -->
            <aside class="w-full lg:w-64 bg-neutral text-neutral-content p-6 flex flex-col border-r border-white/10 lg:sticky lg:top-16 lg:h-[calc(100vh-4rem)] lg:overflow-y-auto shrink-0">
                <div class="space-y-6">
                    <!-- User block -->
                    <div class="border-b border-white/10 pb-4">
                        <span class="text-xs uppercase font-extrabold tracking-widest text-[#FF8A3D] block">Logged In As</span>
                        <span class="text-sm font-semibold text-white/95 truncate block mt-0.5">{{ Auth::user()->name }}</span>
                    </div>

                    <!-- Sidebar navigation -->
                    <ul class="space-y-1 font-semibold text-sm">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                <i class="fa-solid fa-comments text-lg"></i>
                                <span>Feedback Management</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.gallery*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                <i class="fa-solid fa-images text-lg"></i>
                                <span>Gallery</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.development.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.development*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                <i class="fa-solid fa-helmet-safety text-lg"></i>
                                <span>Development Works</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.cms.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.cms*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                <i class="fa-solid fa-pen-nib text-lg"></i>
                                <span>CMS Content</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.settings*') ? 'bg-primary text-white shadow-md' : 'hover:bg-white/5 text-neutral-content/85 hover:text-white' }} transition-all">
                                <i class="fa-solid fa-gear text-lg"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
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
            </aside>

            <!-- Content column: grows to fill remaining width, footer scoped here only -->
            <div class="flex-grow flex flex-col min-w-0">
                <main class="flex-grow p-6 lg:p-8 space-y-6">
                    @yield('content')
                </main>

                <!-- Footer inside content column — does NOT appear below sidebar -->
                <footer class="bg-neutral text-neutral-content/50 py-4 border-t border-white/10 text-xs shrink-0">
                    <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
                        <p>&copy; {{ date('Y') }} Sachin Khandelwal Office Admin Portal. All Rights Reserved.</p>
                        <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-[#53C58B]"></i> Secured and optimized</p>
                    </div>
                </footer>
            </div>

        </div>
    @else
        <!-- Guest Layout (e.g. Login page) -->
        <main class="flex-grow flex items-center justify-center p-6 bg-gradient-to-br from-[#FFFDF8] via-[#EAE5D9] to-[#FFFDF8] min-h-[calc(100vh-8.5rem)]">
            @yield('content')
        </main>

        <!-- Footer for guest/login page -->
        <footer class="bg-neutral text-neutral-content/50 py-4 border-t border-white/10 text-xs">
            <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p>&copy; {{ date('Y') }} Sachin Khandelwal Office Admin Portal. All Rights Reserved.</p>
                <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-[#53C58B]"></i> Secured and optimized</p>
            </div>
        </footer>
    @endauth
</body>
</html>
