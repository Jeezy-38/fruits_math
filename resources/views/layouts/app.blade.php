<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Fruit Math</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#10b981">
</head>
<body class="bg-sky-50 text-slate-800 antialiased selection:bg-amber-300 selection:text-slate-900">


    @if($errors->any())
        <div role="alert" class="relative z-50 m-4 p-4 bg-red-100/90 backdrop-blur border-2 border-red-300 text-red-800 rounded-2xl shadow">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{ $slot }}

    {{-- Floating Global Music Controller (Bottom Left) --}}
    @if(!request()->routeIs('game.level'))
        <div id="fruit-global-music-container" class="fixed bottom-4 left-4 z-50">
            <button type="button"
                    data-global-music-toggle
                    class="bg-white/95 hover:bg-white backdrop-blur-md px-3.5 py-2 rounded-full shadow-lg border-2 border-white/90 font-black text-xs text-slate-700 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 cursor-pointer group"
                    title="{{ app()->getLocale() === 'sw' ? 'Washa au zima muziki' : 'Toggle background music' }}">
                <span class="music-icon text-sm group-hover:rotate-12 transition-transform">🎵</span>
                <span class="music-label">{{ app()->getLocale() === 'sw' ? 'Muziki' : 'Music' }}</span>
            </button>
        </div>
    @endif

    @livewireScripts
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => navigator.serviceWorker.register('/service-worker.js'));
        }
    </script>
</body>
</html>
