@props(['post', 'class' => ''])

<article {{ $attributes->merge(['class' => 'group relative rounded-2xl overflow-hidden shadow-lg ' . $class]) }}>
    {{-- Background Image or Placeholder --}}
    <div class="aspect-[4/5] w-full bg-gradient-to-br from-[#8B0000] to-[#B13407] relative">
        @if($post->image ?? false)
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover" />
        @else
            {{-- Placeholder gradient with decorative elements --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#8B0000] via-[#A52A2A] to-[#B13407]">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-1/3 right-1/4 w-24 h-24 bg-orange-300/20 rounded-full blur-xl"></div>
                </div>
            </div>
        @endif
        
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        
        {{-- Content Overlay --}}
        <div class="absolute inset-0 p-6 flex flex-col justify-end">
            {{-- Badge/Label --}}
            @if($post->organizationUser)
                <span class="inline-flex items-center gap-1 text-xs font-medium text-white/80 mb-2">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                    {{ $post->organizationUser->name }}
                </span>
            @endif
            
            {{-- Title --}}
            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight mb-3 group-hover:text-orange-200 transition-colors break-words">
                {{ $post->title }}
            </h3>
            
            {{-- Excerpt --}}
            <p class="text-sm text-white/80 line-clamp-3 mb-4 break-words">
                {{ Str::limit(strip_tags($post->content), 120) }}
            </p>
        </div>
    </div>
    
    {{-- Date Badge --}}
    <div class="absolute top-4 left-4 bg-white rounded-lg px-3 py-2 shadow-lg text-center min-w-[60px]">
        <span class="block text-2xl font-bold text-[#8B0000] leading-none">{{ $post->created_at->format('d') }}</span>
        <span class="block text-xs font-medium text-gray-600 uppercase">{{ $post->created_at->format('M') }}</span>
    </div>
    
    {{-- Hover Effect --}}
    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
</article>
