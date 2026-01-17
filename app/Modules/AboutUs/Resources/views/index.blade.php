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
<body class=" min-h-screen flex flex-col font-sans antialiased">
<div class="bg-cover bg-bottom bg-no-repeat" style="background-image: linear-gradient(to bottom, rgba(249,115,22,1), rgba(255,255,255,0)), url('{{ asset('images/about-us/background.png') }}');">
      <section class="flex flex-col w-full flex-grow px-10 pt-10">
        <x-navbar class="mb-16" />
    </section>
    <section
        class="relative w-full px-4 md:px-10 pb-0 max-w-[1920px] mx-auto min-h-[calc(100vh-80px)] flex flex-col justify-between items-center">

        {{-- About Us Content Section --}}
        <div class=" mt-auto p-4 lg:pl-10 max-w-4xl z-10">
            <h1
                class="text-center font-bold  text-5xl md:text-6xl lg:text-7xl text-black tracking-tighter leading-[0.9] mb-8">
                About Us
            </h1>
            <div
                class="max-w-3xl text-black/90 text-lg md:text-xl font-normal font-sans leading-relaxed mb-10">
                Welcome to the official website of the Gordon College - College of Computer Studies Student Council.
                We are dedicated to representing and serving the student body, fostering a vibrant community, and
                promoting academic excellence within the College of Computer Studies. Our council is committed to
                organizing events, advocating for student interests, and providing resources to enhance your college
                experience. Join us as we work together to create a supportive and engaging environment for all CCS
                students.
            </div>
        </div>
    </section>
</div>
   <section class="bg-white w-full px-10 pb-6 mt-auto">
   <div class="h-[1080px] relative bg-white"></div>
  
    </section>
    <section class="w-full">
    
        <x-footer />
    </section>
</body>
</html>


