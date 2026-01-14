<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $post->title }} | {{ config('app.name', 'Phoenixes') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-[#FDF5F0] min-h-screen flex flex-col font-sans antialiased">
    {{-- Header Section with Navbar --}}
    <header class="bg-gradient-to-b from-orange-700 to-orange-600 px-6 md:px-10 py-6">
        <x-navbar />
    </header>

    {{-- Main Content --}}
    <main class="flex-grow px-6 md:px-10 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Article Content (Left - Main) --}}
                <article class="lg:col-span-2">
                    {{-- Back Link --}}
                    <a href="{{ route('news.index') }}" 
                       class="inline-flex items-center gap-2 text-[#B13407] hover:text-[#8B0000] font-medium mb-6 transition-colors group">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to News
                    </a>

                    {{-- Article Header --}}
                    <header class="mb-8">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#8B0000] leading-tight mb-4 break-words [overflow-wrap:anywhere]">
                            {{ $post->title }}
                        </h1>
                        
                        {{-- Meta Information --}}
                        <div class="flex flex-wrap items-center gap-4 text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#B13407]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $post->created_at->format('F d, Y') }}</span>
                            </div>
                            
                            @if($post->organizationUser)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#B13407]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>{{ $post->organizationUser->name }}</span>
                                </div>
                            @endif
                        </div>
                    </header>

                    {{-- Featured Image --}}
                    <div class="aspect-video bg-gradient-to-br from-[#8B0000] to-[#B13407] rounded-2xl overflow-hidden shadow-lg mb-8 relative">
                        @if($post->image ?? false)
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover" />
                        @else
                            {{-- Placeholder with decorative elements --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-white/30 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-white/40 text-sm">Article Image</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Article Content --}}
                    <div class="bg-white rounded-2xl shadow-md p-6 md:p-10 overflow-hidden">
                        <div class="prose prose-lg max-w-none prose-headings:text-[#8B0000] prose-a:text-[#B13407] prose-a:no-underline hover:prose-a:underline break-words [overflow-wrap:anywhere] [word-break:break-word]">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>

                    {{-- Share Section --}}
                    <div class="mt-8 p-6 bg-white rounded-2xl shadow-md">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Share this article</h3>
                        <div class="flex items-center gap-3">
                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            
                            {{-- Twitter/X --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                               target="_blank"
                               class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center hover:bg-gray-800 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            
                            {{-- Copy Link --}}
                            <button onclick="navigator.clipboard.writeText('{{ request()->url() }}'); alert('Link copied!');"
                                    class="w-10 h-10 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center hover:bg-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                {{-- Sidebar (Right) --}}
                <aside class="lg:col-span-1">
                    <div class="sticky top-6">
                        <h2 class="text-xl font-bold text-[#8B0000] mb-6">Related Articles</h2>
                        
                        @forelse($relatedArticles as $article)
                            <a href="{{ route('news.show', $article) }}" 
                               class="block mb-4 p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow group">
                                {{-- Thumbnail --}}
                                <div class="aspect-video bg-gradient-to-br from-[#8B0000] to-[#B13407] rounded-lg overflow-hidden mb-3 relative">
                                    @if($article->image ?? false)
                                        <img src="{{ $article->image }}" alt="{{ $article->title }}" class="w-full h-full object-cover" />
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Content --}}
                                <p class="text-xs text-gray-500 mb-1">{{ $article->created_at->format('F d, Y') }}</p>
                                <h3 class="font-bold text-[#8B0000] group-hover:text-[#B13407] transition-colors line-clamp-2 break-words">
                                    {{ $article->title }}
                                </h3>
                            </a>
                        @empty
                            <div class="text-center py-8 text-gray-500 bg-white rounded-xl">
                                <p>No related articles yet.</p>
                            </div>
                        @endforelse

                        {{-- Back to All Articles Button --}}
                        <a href="{{ route('news.index') }}" 
                           class="block w-full mt-6 py-3 px-4 bg-[#8B0000] text-white text-center font-semibold rounded-xl hover:bg-[#6B0000] transition-colors">
                            View All Articles
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <x-footer />
</body>

</html>
