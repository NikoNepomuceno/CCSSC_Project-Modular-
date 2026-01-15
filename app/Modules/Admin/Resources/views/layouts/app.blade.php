<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Prevent confusing cache behaviour while iterating with Turbo --}}
    <meta name="turbo-cache-control" content="no-cache">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    {{-- Turbo will be loaded via Vite in resources/js/app.js --}}
</head>

<body class="bg-[#FDFDFC] h-screen overflow-hidden flex" x-data="{
        sidebarOpen: true,
        init() {
            const stored = localStorage.getItem('adminSidebarOpen');
            if (stored !== null) {
                this.sidebarOpen = stored === 'true';
            }
            this.$watch('sidebarOpen', value => {
                localStorage.setItem('adminSidebarOpen', value ? 'true' : 'false');
            });
        }
    }">
    <!-- Sidebar -->
    <aside class="bg-[#09090b] text-white transition-all duration-300 ease-in-out flex flex-col relative z-20"
        :class="sidebarOpen ? 'w-64' : 'w-20'">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-[#1f1f22]">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-transparent border-2 border-[#FF4400] flex items-center justify-center shrink-0">
                    <span class="text-[#FF4400] font-bold text-lg">C</span>
                </div>
                <span class="font-bold text-xl tracking-wide truncate transition-opacity duration-300"
                    x-show="sidebarOpen">CCSSC</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-6 px-3 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            @php
                $isDashboard = request()->routeIs('admin.dashboard');
                $isPosts = request()->routeIs('admin.posts.*');
                $isOrgUsers = request()->routeIs('admin.organization-users.*');
                $isCommittees = request()->routeIs('admin.committees.*');
            @endphp

            <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center gap-3 px-3 py-3 rounded-lg relative overflow-hidden
                    {{ $isDashboard ? 'bg-[#18181b] text-white' : 'text-gray-400 hover:text-white hover:bg-[#18181b] transition-colors' }}">
                @if ($isDashboard)
                    <!-- Active Indicator -->
                    <div
                        class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#FF4400] rounded-r-full shadow-[0_0_10px_#FF440050]">
                    </div>
                @endif

                <div class="w-6 h-6 flex items-center justify-center {{ $isDashboard ? 'text-[#FF4400]' : '' }}">
                    <!-- Dashboard Icon (Grid) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                </div>
                <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">Dashboard</span>
            </a>

            <!-- Posts -->
            <a href="{{ route('admin.posts.index') }}"
                class="group flex items-center gap-3 px-3 py-3 rounded-lg relative overflow-hidden
                    {{ $isPosts ? 'bg-[#18181b] text-white' : 'text-gray-400 hover:text-white hover:bg-[#18181b] transition-colors' }}">
                @if ($isPosts)
                    <!-- Active Indicator -->
                    <div
                        class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#FF4400] rounded-r-full shadow-[0_0_10px_#FF440050]">
                    </div>
                @endif

                <div class="w-6 h-6 flex items-center justify-center {{ $isPosts ? 'text-[#FF4400]' : '' }}">
                    <!-- File Text Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" x2="8" y1="13" y2="13" />
                        <line x1="16" x2="8" y1="17" y2="17" />
                        <line x1="10" x2="8" y1="9" y2="9" />
                    </svg>
                </div>
                <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">Posts</span>
            </a>

            <!-- Organization Users -->
            <a href="{{ route('admin.organization-users.index') }}"
                class="group flex items-center gap-3 px-3 py-3 rounded-lg relative overflow-hidden
                    {{ $isOrgUsers ? 'bg-[#18181b] text-white' : 'text-gray-400 hover:text-white hover:bg-[#18181b] transition-colors' }}">
                @if ($isOrgUsers)
                    <!-- Active Indicator -->
                    <div
                        class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#FF4400] rounded-r-full shadow-[0_0_10px_#FF440050]">
                    </div>
                @endif

                <div class="w-6 h-6 flex items-center justify-center">
                    <!-- Users Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">Organization Users</span>
            </a>

            <!-- Committees -->
             <a href="{{ route('admin.committees.index') }}"
                class="group flex items-center gap-3 px-3 py-3 rounded-lg relative overflow-hidden {{ $isCommittees ? 'bg-[#18181b] text-white' : 'text-gray-400 hover:text-white hover:bg-[#18181b] transition-colors' }}">
                @if ($isCommittees)
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#FF4400] rounded-r-full shadow-[0_0_10px_#FF440050]"></div>

                @endif
        
                <div class="w-6 h-6 flex items-center justify-center {{ $isCommittees ? 'text-[#FF4400]' : '' }}">
                    <!-- Users/Group Icon for Committee -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 21a8 8 0 0 0-16 0"/>
                        <circle cx="10" cy="8" r="5"/>
                        <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/>
                    </svg>
                </div>
                <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">Committees</span>
            </a>

            <!-- Profile (placeholder) -->
            <a href="#"
                class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:text-white hover:bg-[#18181b] transition-colors">
                <div class="w-6 h-6 flex items-center justify-center">
                    <!-- User Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">Profile</span>
            </a>

            <!-- Settings (placeholder) -->
            <a href="#"
                class="group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:text-white hover:bg-[#18181b] transition-colors">
                <div class="w-6 h-6 flex items-center justify-center">
                    <!-- Settings Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.38a2 2 0 0 0-.73-2.73l-.15-.1a2 2 0 0 1-1-1.72v-.51a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </div>
                <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">Settings</span>
            </a>
        </nav>

        <!-- Bottom Actions -->
        <div class="px-3 py-4 border-t border-[#1f1f22]">
            <div class="w-full">
                <button @click="$dispatch('open-confirmation-modal', {
                        title: 'Sign Out?',
                        message: 'Are you sure you want to end your session?',
                        confirmText: 'Sign Out',
                        actionUrl: '{{ route('admin.logout') }}',
                        actionMethod: 'POST'
                    })"
                    class="w-full group flex items-center gap-3 px-3 py-3 rounded-lg text-gray-400 hover:text-white hover:bg-[#18181b] transition-colors text-left">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <!-- Log Out Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" x2="9" y1="12" y2="12" />
                        </svg>
                    </div>
                    <span class="font-medium whitespace-nowrap transition-opacity duration-300"
                        x-show="sidebarOpen">Logout</span>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FDFDFC]">
        <!-- Header -->
        <header class="bg-white border-b border-[#e3e3e0] px-8 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-500 hover:text-[#1b1b18] transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold text-[#1b1b18]">@yield('header', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ Auth::guard('admin')->user()->email }}</span>
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
            </div>
        </header>

        <!-- Content Scrollable Area -->
        <main class="flex-1 overflow-auto p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Global Toast Component -->
    <div id="admin-toast-root">
        <x-toast />
    </div>

    <!-- Confirmation Modal (persist across Turbo visits) -->
    <div id="admin-confirmation-modal-root" data-turbo-permanent>
        <x-confirmation-modal />
    </div>
</body>

</html>