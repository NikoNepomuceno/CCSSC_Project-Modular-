@props(['post', 'badge' => null, 'class' => ''])

<article {{ $attributes->merge(['class' => 'group flex gap-4 ' . $class]) }}>
    {{-- Thumbnail --}}
    <div class="relative flex-shrink-0 w-36 h-28 rounded-xl overflow-hidden shadow-md">
        @if($post->image ?? false)
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover" />
        @else
            {{-- Placeholder gradient --}}
            <div class="w-full h-full bg-gradient-to-br from-[#8B0000] via-[#A52A2A] to-[#B13407] relative">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            </div>
        @endif
        
        {{-- Badge (e.g., "2ND PLACE") --}}
        @if($badge)
            <div class="absolute top-2 right-2 bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                {{ $badge }}
            </div>
        @endif
    </div>
    
    {{-- Content --}}
    <div class="flex-1 flex flex-col justify-center min-w-0">
        {{-- Meta: Badge + Date --}}
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
            @if($badge)
                <span class="font-semibold text-[#8B0000]">{{ $badge }}</span>
                <span>|</span>
            @endif
            <span>{{ $post->created_at->format('F d, Y') }}</span>
        </div>
        
        {{-- Title --}}
        <h4 class="text-base font-bold text-[#8B0000] leading-snug mb-1 group-hover:text-[#B13407] transition-colors line-clamp-2 break-words">
            {{ $post->title }}
        </h4>
        
        {{-- Excerpt --}}
        <p class="text-xs text-gray-600 line-clamp-2 break-words">
            {{ Str::limit(strip_tags($post->content), 80) }}
        </p>
    </div>
</article>
