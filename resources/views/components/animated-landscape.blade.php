@props(['world' => 'fruit-garden'])

@php
    $bgImages = [
        'banana-island' => [
            'src' => asset('images/backgrounds/banana-island.jpg'),
            'overlay' => 'from-sky-900/10 via-transparent to-amber-900/15',
            'fruits' => [['🍌','7%','12%','0s','6.5s'],['🥥','90%','15%','1.2s','7.8s'],['🍉','10%','75%','2.1s','6s'],['🍌','86%','70%','0.4s','8s']]
        ],
        'mango-village' => [
            'src' => asset('images/backgrounds/mango-village.jpg'),
            'overlay' => 'from-orange-950/10 via-transparent to-emerald-950/20',
            'fruits' => [['🥭','6%','14%','0s','6s'],['🍍','88%','10%','1.5s','7.2s'],['🍇','8%','72%','2s','6.8s'],['🥭','85%','66%','0.7s','8.5s']]
        ],
        'fruit-garden' => [
            'src' => asset('images/backgrounds/fruit-garden.jpg'),
            'overlay' => 'from-sky-950/10 via-transparent to-emerald-950/20',
            'fruits' => [['🍎','6%','10%','0s','6s'],['🍓','88%','12%','1.3s','7.5s'],['🍊','8%','76%','2s','6.5s'],['🍏','90%','70%','0.5s','8s']]
        ]
    ];

    $current = $bgImages[$world] ?? $bgImages['fruit-garden'];
@endphp

<div class="pointer-events-none fixed inset-0 overflow-hidden select-none z-0" aria-hidden="true">
    {{-- High-Resolution 3D Cartoon World Illustration with Ken Burns Pan/Zoom Animation --}}
    <img
        src="{{ $current['src'] }}"
        alt="Fruit Math World Background"
        class="absolute inset-0 w-full h-full object-cover object-center scale-105 animate-kenburns transition-all duration-1000"
    />

    {{-- Atmospheric Ambient Vignette Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-b {{ $current['overlay'] }} backdrop-brightness-[1.02]"></div>

    {{-- Subtle Frosted Dimmer for Center Readability --}}
    <div class="absolute inset-0 bg-white/10 backdrop-blur-[0.5px]"></div>

    {{-- Drifting Cartoon Clouds in Upper Sky --}}
    <div class="absolute top-6 left-0 animate-drift-slow opacity-75">
        <svg width="190" height="70" viewBox="0 0 180 70" fill="#ffffff" class="drop-shadow-md">
            <path d="M 25 55 Q 10 55 10 40 Q 10 28 22 25 Q 26 10 42 10 Q 55 10 62 18 Q 72 8 92 8 Q 112 8 120 22 Q 135 15 150 24 Q 165 30 165 42 Q 165 55 145 55 Z"/>
        </svg>
    </div>
    <div class="absolute top-20 left-0 animate-drift-mid opacity-60 hidden md:block" style="animation-delay: -15s;">
        <svg width="150" height="55" viewBox="0 0 140 55" fill="#ffffff" class="drop-shadow-md">
            <path d="M 20 45 Q 8 45 8 32 Q 8 20 22 18 Q 30 6 45 8 Q 58 8 65 16 Q 78 8 95 12 Q 110 16 115 26 Q 130 25 130 38 Q 130 45 115 45 Z"/>
        </svg>
    </div>

    {{-- Floating Magical Sparkles and Fruit Particles on Edges --}}
    <div class="absolute top-1/4 left-1/5 text-2xl animate-pop opacity-80" style="animation-delay: 1s;">✨</div>
    <div class="absolute top-1/3 right-1/4 text-2xl animate-pop opacity-80" style="animation-delay: 2.5s;">⭐</div>
    <div class="absolute top-1/2 left-1/6 text-xl animate-pop opacity-70" style="animation-delay: 4s;">✨</div>

    @foreach ($current['fruits'] as [$fruit,$left,$top,$delay,$duration])
        <span class="absolute text-5xl md:text-6xl opacity-50 animate-float select-none drop-shadow-lg" style="left:{{ $left }};top:{{ $top }};animation-delay:{{ $delay }};animation-duration:{{ $duration }}">{{ $fruit }}</span>
    @endforeach
</div>
