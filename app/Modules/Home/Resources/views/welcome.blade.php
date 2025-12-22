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

<body class="bg-[#B13407] min-h-screen flex flex-col font-sans antialiased">
    <section class="flex flex-col w-full flex-grow px-10 pt-10">
        <x-navbar class="mb-16" />
    </section>
    <section class="relative flex-grow w-full px-10 pb-24">
        <div class="relative min-h-[1200px]">
            <div class="p-6 space-y-4">
                <h1 class="font-bold text-3xl">Soaring beyond limits.</h1>
                <div class="w-96 justify-start text-Text text-base font-normal font-['Inter'] leading-6">The
                    official website of Gordon College - College of Computer Studies Student Council.</div>
                <button class="bg-[#800000] text-white font-bold px-4 py-2 rounded-xl">Visit Us</button>
            </div>
            <div>
                <div>
                    <div
                        class="w-80 h-9 left-[1419px] top-[861px] absolute justify-start text-White-Text text-4xl font-extrabold font-['Inter'] leading-10">
                        GGs CCS team in SkyDev’s MLBB compe</div>
                    <div
                        class="w-40 h-0 left-[1420px] top-[1001px] absolute outline outline-[3px] outline-offset-[-1.50px] outline-white">
                    </div>
                    <div
                        class="w-80 left-[1419px] top-[1020.50px] absolute justify-start text-White-Text text-2xl font-medium font-['Inter'] leading-6">
                        Read more →</div>
                    <div
                        class="w-80 h-9 left-[1004px] top-[861px] absolute justify-start text-White-Text text-4xl font-extrabold font-['Inter'] leading-10">
                        CCS bags medal in SkyDev’s hackathon</div>
                    <div
                        class="w-40 h-0 left-[1005px] top-[1001px] absolute outline outline-[3px] outline-offset-[-1.50px] outline-white">
                    </div>
                    <div
                        class="w-80 left-[1004px] top-[1020.50px] absolute justify-start text-White-Text text-2xl font-medium font-['Inter'] leading-6">
                        Read more →</div>
                    <div
                        class="w-96 h-64 left-[557px] top-[827px] absolute bg-Color-2 rounded-tl-[40px] rounded-tr-[40px]">
                    </div>
                    <div
                        class="w-80 h-9 left-[589px] top-[861px] absolute justify-start text-White-Text text-4xl font-extrabold font-['Inter'] leading-10">
                        Sa Pagitan microfilm got 1st in RAITE</div>
                    <div
                        class="w-40 h-0 left-[590px] top-[1000.50px] absolute outline outline-[3px] outline-offset-[-1.50px] outline-white">
                    </div>
                    <div
                        class="w-80 left-[589px] top-[1020px] absolute justify-start text-White-Text text-2xl font-medium font-['Inter'] leading-6">
                        Read more →</div>
                    <div class="w-64 h-14 left-[141px] top-[702px] absolute bg-orange-900 rounded-[80px]"></div>
                    <div
                        class="w-44 left-[176px] top-[720px] absolute text-center justif-start text-white-Text text-2xl font bold font-['Inter'] leading-6">
                        Visit us</div>
                </div>
            </div>
        </div>
    </section>
    <x-footer />
</body>

</html>