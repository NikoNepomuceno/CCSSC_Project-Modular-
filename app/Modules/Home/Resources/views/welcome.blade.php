<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
        </style>
    @endif
</head>

<body class="bg-cover bg-center bg-no-repeat min-h-screen flex flex-col font-sans antialiased" style="background-image: linear-gradient(to bottom, rgba(194, 65, 12, 0.85), rgba(250, 250, 250, 0)), url('{{ asset('images/homepage/background.png') }}');">
    <section class="flex flex-col w-full flex-grow px-10 pt-10">
        <x-navbar class="mb-16" />
    </section>
    <section
        class="relative w-full px-4 md:px-10 pb-0 max-w-[1920px] mx-auto min-h-[calc(100vh-80px)] flex flex-col justify-between">

        {{-- Hero Text Section --}}
        <div class="pt-20 lg:pt-32 p-4 lg:pl-10 max-w-4xl z-10 pointer-events-none">
            <h1
                class="font-bold text-6xl md:text-8xl lg:text-[7rem] text-white tracking-tighter leading-[0.9] mb-8 pointer-events-auto">
                Soaring beyond<br>limits.
            </h1>
            <div
                class="max-w-md text-white/90 text-lg md:text-xl font-normal font-sans leading-relaxed mb-10 pointer-events-auto">
                The official website of Gordon College - College of Computer Studies Student Council.
            </div>
            <button
                class="pointer-events-auto bg-[#800000] text-white font-bold px-10 py-4 rounded-full text-xl hover:bg-[#600000] transition-colors shadow-lg hover:scale-105 active:scale-95 duration-300">
                Visit Us
            </button>
        </div>

        {{-- Cards Grid Section --}}
        <div class="w-full mt-10 lg:mt-0 z-10">
            {{-- Offset the grid to start from the middle/right --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 w-full items-end">
                {{-- Spacer columns for large screens --}}
                <div class="hidden lg:block lg:col-span-4 xl:col-span-3"></div>

                {{-- Actual Cards --}}
                <div
                    class="col-span-1 md:col-span-12 lg:col-span-8 xl:col-span-9 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
                    <x-breaking-card title="Sa Pagitan microfilm got 1st in RAITE" link="#" class="bg-[#8F2203]" />
                    <x-breaking-card title="CCS bags medal in SkyDev’s hackathon" link="#" class="bg-[#8F2203]" />
                    <x-breaking-card title="GGs CCS team in SkyDev’s MLBB compe" link="#" class="bg-[#8F2203]" />
                </div>
            </div>
        </div>
    </section>

    {{-- Know More Section --}}
    <section class="w-full bg-white py-24 px-4 md:px-10">
        <div class="max-w-[1920px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12">
            {{-- Left Content: Title + Image --}}
            <div class="col-span-1 lg:col-span-8 space-y-12 pl-4 lg:pl-10">
                {{-- Title --}}
                <div>
                    <h2
                        class="text-6xl md:text-7xl font-bold font-['Instrument_Sans'] tracking-tight leading-none text-[#2A2A2A]">
                        Know more <br>
                        <span class="text-[#B13407]">about us.</span>
                    </h2>
                    <p class="mt-6 text-[#B13407] text-lg font-medium tracking-wide">
                        Highlighting innovation and excellence, every step of the way.
                    </p>
                </div>

                {{-- Content Area: Image + Text --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    {{-- Image Placeholder --}}
                    <div class="relative aspect-square bg-[#B13407] rounded-3xl overflow-hidden shadow-2xl p-1">
                        <div class="w-full h-full bg-cover bg-center rounded-2xl"
                            style="background-image: url('https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg'); background-size: contain; background-repeat: no-repeat; background-position: center; background-color: #2a2a2a;">
                            {{-- Placeholder visual until user provides real asset --}}
                        </div>
                    </div>

                    {{-- Text Content --}}
                    <div class="space-y-6 text-[#2A2A2A] text-lg leading-relaxed font-sans mt-4">
                        <p>The College of Computer Studies proudly congratulates its student filmmakers for securing
                            First Runner-Up in the Micro Short Film Contest at the Regional Assembly on Information
                            Technology Education in Cabanatuan City, Nueva Ecija.</p>
                        <p>The entry “Sa Pagitan (Sumpa Kita)”, directed by Eizen Rodriguez, also received the People’s
                            Choice Award and earned recognition for Best Actress, awarded to Ms. Erica Mae Camintoy
                            (BSCS 2).</p>
                        <p>These achievements highlight the talent and dedication of the cast and crew, bringing pride
                            to the CCS community and the institution.</p>
                    </div>
                </div>
            </div>

            {{-- Right Side: Navigation Buttons --}}
            <div class="col-span-1 lg:col-span-4 lg:pl-12 flex flex-col gap-4 mt-8 lg:mt-0">
                <x-committee-button label="Executives" />
                <x-committee-button label="Canaries" />
                <x-committee-button label="Falcons" />
                <x-committee-button label="Herons" />
                <x-committee-button label="Nightingales" />
                <x-committee-button label="Ravens" />
            </div>
        </div>
    </section>
</body>

