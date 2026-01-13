@props(['title', 'link' => '#'])

<div {{ $attributes->merge(['class' => 'group relative w-full h-auto bg-[#8F2203] rounded-tl-[40px] rounded-tr-[40px] p-8 flex flex-col justify-end transition-all duration-300 hover:-translate-y-2 hover:shadow-xl overflow-hidden']) }}>

    {{-- Content Container --}}
    <div class="relative z-10 flex flex-col gap-4 justify-end h-full">

        {{-- Title --}}
        <h3 class="text-white text-3xl font-extrabold font-['Instrument_Sans'] leading-tight tracking-tight">
            {{ $title }}
        </h3>

        {{-- Bottom Section --}}
        <div>
            {{-- Divider --}}
            <div class="w-12 h-[3px] bg-white/80 mb-4 rounded-full"></div>

            {{-- Link --}}
            <a href="{{ $link }}"
                class="inline-flex items-center text-white/90 text-lg font-bold font-['Instrument_Sans'] group-hover:text-white group-hover:underline underline-offset-4 decoration-2 transition-all duration-300">
                Read more
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</div>
