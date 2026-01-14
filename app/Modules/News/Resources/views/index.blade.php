<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>News | {{ config('app.name', 'Phoenixes') }}</title>

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
            {{-- Section Header --}}
            <div class="mb-10">
                <p class="text-sm text-gray-600 font-medium tracking-wide mb-1">Our Articles</p>
                <h1 class="text-4xl md:text-5xl font-bold italic text-[#8B0000]" style="font-family: 'Instrument Sans', serif;">
                    Trending now
                </h1>
            </div>

            @if($featured)
                {{-- Articles Grid --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Featured Article (Left - Large) --}}
                    <a href="{{ route('news.show', $featured) }}" class="block">
                        <x-article-card-featured :post="$featured" />
                    </a>

                    {{-- Secondary Articles (Right - Stacked) --}}
                    <div class="space-y-6">
                        @forelse($articles as $index => $article)
                            <a href="{{ route('news.show', $article) }}" class="block hover:bg-white/50 rounded-xl p-2 -m-2 transition-colors">
                                <x-article-card-small 
                                    :post="$article" 
                                    :badge="$index === 0 ? '2ND PLACE' : ($index === 1 ? '3RD PLACE' : null)" 
                                />
                            </a>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <p>No more articles available.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- All Articles Section --}}
                @if($articles->count() > 0)
                    <div class="mt-16">
                        <h2 class="text-2xl font-bold text-[#8B0000] mb-8">More Articles</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {{-- Include all posts in a grid layout --}}
                            @foreach($articles as $article)
                                <a href="{{ route('news.show', $article) }}" 
                                   class="block bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow group">
                                    {{-- Thumbnail --}}
                                    <div class="aspect-video bg-gradient-to-br from-[#8B0000] to-[#B13407] relative">
                                        @if($article->image ?? false)
                                            <img src="{{ $article->image }}" alt="{{ $article->title }}" class="w-full h-full object-cover" />
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    {{-- Content --}}
                                    <div class="p-4">
                                        <p class="text-xs text-gray-500 mb-2">{{ $article->created_at->format('F d, Y') }}</p>
                                        <h3 class="font-bold text-[#8B0000] group-hover:text-[#B13407] transition-colors line-clamp-2 mb-2 break-words">
                                            {{ $article->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 line-clamp-2 break-words">
                                            {{ Str::limit(strip_tags($article->content), 100) }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">No Articles Yet</h2>
                    <p class="text-gray-500">Check back soon for the latest news and updates!</p>
                </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <x-footer />
</body>

</html>
