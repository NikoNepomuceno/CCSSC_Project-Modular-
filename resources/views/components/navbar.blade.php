<nav {{ $attributes->merge(['class' => 'relative flex items-center justify-between w-full font-sans']) }}>
    <!-- Logo Section -->
    <div class="flex items-center gap-3 z-10 shrink-0">
        <!-- Placeholder for Logo Image -->
        <div class="h-10 w-10 relative rounded-full overflow-hidden shadow-md bg-gradient-to-br from-amber-500 to-red-600 flex items-center justify-center text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.177 7.547 7.547 0 0 1-1.705 1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
            </svg>
        </div>
        <span class="text-white text-2xl font-bold tracking-tight drop-shadow-sm">Phoenixes</span>
    </div>

    <!-- Navigation Links -->
    <div class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
        <ul class="flex items-center justify-between gap-12 border border-white rounded-full px-10 py-3 w-max backdrop-blur-sm bg-white/5">
            <li>
                <a href="#" class="text-white font-medium text-base hover:text-orange-100 transition-all duration-300 tracking-wide">Home</a>
            </li>
            <li>
                <a href="#" class="text-white font-medium text-base hover:text-orange-100 transition-all duration-300 tracking-wide">About Us</a>
            </li>
            <li>
                <a href="#" class="text-white font-medium text-base hover:text-orange-100 transition-all duration-300 tracking-wide">Committees</a>
            </li>
            <li>
                <a href="#" class="text-white font-medium text-base hover:text-orange-100 transition-all duration-300 tracking-wide">News</a>
            </li>
        </ul>
    </div>

    <!-- Search Section -->
    <div class="hidden sm:flex items-center z-10 shrink-0">
        <div class="relative group">
            <input 
                type="text" 
                placeholder="Search Phoenixes" 
                class="bg-[#FDFDFC]/95 text-[#B13407] placeholder-[#B13407]/60 text-base font-medium rounded-full py-2.5 pl-6 pr-12 w-64 focus:outline-none focus:ring-2 focus:ring-orange-300/50 shadow-lg transition-all ease-in-out duration-300 group-hover:w-72"
            >
            <button class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 hover:bg-orange-100 rounded-full text-[#B13407] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
        </div>
    </div>
</nav>