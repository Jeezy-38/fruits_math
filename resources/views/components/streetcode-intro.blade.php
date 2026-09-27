@props(['standalone' => false, 'skip' => false])

@php
    $isSw = app()->getLocale() === 'sw';
@endphp

<div id="streetcode-intro-screen"
     data-standalone="{{ $standalone ? 'true' : 'false' }}"
     data-skip="{{ $skip ? 'true' : 'false' }}"
     class="{{ $standalone ? 'relative min-h-screen sm:h-screen sm:max-h-screen w-full' : 'fixed inset-0 z-[100] min-h-screen sm:h-screen sm:max-h-screen w-full' }} {{ $skip ? 'hidden' : '' }} flex flex-col justify-between overflow-x-hidden overflow-y-auto text-slate-800 selection:bg-amber-400 selection:text-slate-900 transition-all duration-700 font-sans select-none"
     @if($skip) style="display: none;" @endif>

    {{-- 1. BALANCED CARTOON GAME WORLD BACKGROUND --}}
    <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden">
        <img src="{{ asset('images/backgrounds/fruit-garden.jpg') }}"
             alt="Fruit Math Cartoon World"
             class="absolute inset-0 w-full h-full object-cover object-center scale-105 animate-kenburns transition-all duration-1000" />

        <div class="absolute inset-0 bg-gradient-to-b from-sky-950/10 via-transparent to-emerald-950/20 backdrop-brightness-[1.02]"></div>
        <div class="absolute inset-0 bg-white/10 backdrop-blur-[0.5px]"></div>
    </div>

    {{-- 2. INTERACTIVE CANVAS FOR JUICE SPLATTERS & PARTICLES --}}
    <canvas id="streetcode-juice-canvas" class="pointer-events-none absolute inset-0 w-full h-full z-10"></canvas>

    {{-- 3. FLOATING INTERACTIVE CARTOON FRUITS (TAP TO POP & SPLASH JUICE) --}}
    <div class="intro-pop-fruit absolute top-16 left-[6%] sm:left-[10%] text-3xl sm:text-5xl cursor-pointer select-none transition-transform duration-300 hover:scale-130 active:scale-90 animate-float-fruit z-20 drop-shadow-[0_6px_12px_rgba(0,0,0,0.18)]"
         data-color="#ef4444"
         style="animation-delay: 0s; animation-duration: 4.5s;"
         title="{{ $isSw ? 'Gusa kupasua na kumwaga maji ya tufaa!' : 'Tap to pop apple!' }}">
        🍎
    </div>
    <div class="intro-pop-fruit absolute top-20 right-[6%] sm:right-[10%] text-3xl sm:text-5xl cursor-pointer select-none transition-transform duration-300 hover:scale-130 active:scale-90 animate-float-fruit z-20 drop-shadow-[0_6px_12px_rgba(0,0,0,0.18)]"
         data-color="#f59e0b"
         style="animation-delay: 1.2s; animation-duration: 5.2s;"
         title="{{ $isSw ? 'Gusa kupasua na kumwaga maji ya ndizi!' : 'Tap to pop banana!' }}">
        🍌
    </div>
    <div class="intro-pop-fruit absolute bottom-16 left-[8%] sm:left-[12%] text-3xl sm:text-5xl cursor-pointer select-none transition-transform duration-300 hover:scale-130 active:scale-90 animate-float-fruit z-20 drop-shadow-[0_6px_12px_rgba(0,0,0,0.18)]"
         data-color="#10b981"
         style="animation-delay: 2s; animation-duration: 4.8s;"
         title="{{ $isSw ? 'Gusa kupasua tikiti maji!' : 'Tap to pop watermelon!' }}">
        🍉
    </div>
    <div class="intro-pop-fruit absolute bottom-20 right-[8%] sm:right-[12%] text-3xl sm:text-5xl cursor-pointer select-none transition-transform duration-300 hover:scale-130 active:scale-90 animate-float-fruit z-20 drop-shadow-[0_6px_12px_rgba(0,0,0,0.18)]"
         data-color="#f97316"
         style="animation-delay: 0.7s; animation-duration: 5.6s;"
         title="{{ $isSw ? 'Gusa kupasua chungwa!' : 'Tap to pop orange!' }}">
        🍊
    </div>
    <div class="intro-pop-fruit hidden md:block absolute top-1/2 left-[3%] text-3xl sm:text-4xl cursor-pointer select-none transition-transform duration-300 hover:scale-130 active:scale-90 animate-float-fruit z-20 drop-shadow-[0_6px_12px_rgba(0,0,0,0.18)]"
         data-color="#ec4899"
         style="animation-delay: 1.8s; animation-duration: 6s;"
         title="{{ $isSw ? 'Gusa kupasua strawberry!' : 'Tap to pop strawberry!' }}">
        🍓
    </div>

    {{-- 4. TOP CONTROLS & UTILITY BAR --}}
    <header class="relative z-30 max-w-5xl w-full mx-auto px-4 sm:px-6 pt-3 sm:pt-4 flex items-center justify-between gap-3">
        {{-- StreetCode Badge --}}
        <div class="inline-flex items-center gap-2 glass-pill px-3.5 sm:px-4 py-1.5 text-slate-900 border border-white/80 shadow-xs">
            <span class="text-amber-500 text-sm sm:text-base animate-pulse">⚡</span>
            <span class="font-display font-black text-xs sm:text-sm tracking-wider text-amber-900 uppercase">StreetCode Studios</span>
        </div>

        {{-- Right Controls: Star Popped Badge, Audio Toggle, Skip --}}
        <div class="flex items-center gap-2 sm:gap-2.5">
            {{-- Star Score Pill --}}
            <div class="inline-flex items-center gap-1.5 glass-pill border border-white/80 px-3 sm:px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-display font-black text-amber-950 shadow-xs">
                <span>⭐</span>
                <span class="hidden sm:inline text-slate-700">{{ $isSw ? 'Nyota:' : 'Stars:' }}</span>
                <span id="streetcode-pop-count" class="text-amber-700 font-black text-xs sm:text-sm">0</span>
            </div>

            {{-- Sound Toggle --}}
            <button type="button"
                    id="streetcode-sound-toggle"
                    class="glass-pill hover:bg-white/70 active:scale-90 w-9 h-9 sm:w-10 sm:h-10 rounded-2xl flex items-center justify-center text-slate-800 text-base border border-white/80 shadow-xs transition cursor-pointer"
                    title="{{ $isSw ? 'Washa au Zima Sauti' : 'Toggle Audio' }}">
                <span>🔊</span>
            </button>

            {{-- Skip Intro Button --}}
            <button type="button"
                    id="streetcode-skip-btn"
                    class="group inline-flex items-center gap-1.5 glass-pill hover:bg-white/80 active:scale-95 text-slate-900 font-display font-black text-xs sm:text-sm px-3.5 sm:px-4 py-1.5 rounded-2xl border border-white/90 shadow-xs transition-all cursor-pointer">
                <span>{{ $isSw ? 'Ruka' : 'Skip' }}</span>
                <span class="group-hover:translate-x-0.5 transition-transform text-xs">➔</span>
            </button>
        </div>
    </header>

    {{-- 5. MAIN STAGE: BALANCED & CLEARLY LEGIBLE CONTENT --}}
    <main class="relative z-20 max-w-3xl w-full mx-auto px-4 py-2 sm:py-3 flex flex-col items-center text-center my-auto">

        {{-- StreetCode Presenting Pill Banner --}}
        <div class="inline-flex items-center gap-2 glass-pill border border-white/80 px-4 sm:px-5 py-1 rounded-full text-xs sm:text-sm font-display font-black text-amber-950 tracking-wider uppercase shadow-xs">
            <span class="text-amber-500 animate-spin text-xs" style="animation-duration: 6s;">✦</span>
            <span>{{ $isSw ? 'STREETCODE INATAMBULISHA' : 'STREETCODE PRESENTS' }}</span>
            <span class="text-amber-500 animate-spin text-xs" style="animation-duration: 6s;">✦</span>
        </div>

        {{-- StreetCode Logo in Crystal Transparent Glass Frame --}}
        <div class="relative group my-1.5 sm:my-2">
            {{-- Golden Back Aura --}}
            <div class="absolute -inset-2 bg-gradient-to-r from-amber-300/30 via-yellow-200/40 to-amber-400/30 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition duration-500 animate-pulse"></div>

            <div class="relative overflow-hidden rounded-2xl glass-panel px-4 py-1.5 sm:px-5 sm:py-2 shadow-xs border border-white/90 animate-gold-pulse">
                {{-- Shimmer Light Sweep --}}
                <div class="pointer-events-none absolute -inset-full w-[200%] h-full bg-gradient-to-r from-transparent via-white/30 to-transparent animate-gold-shimmer"></div>

                <video id="streetcode-logo-video"
                       autoplay muted loop playsinline
                       preload="metadata"
                       poster="{{ asset('images/streetcode-logo-poster.png') }}"
                       aria-label="StreetCode"
                       class="w-44 h-24 sm:w-52 sm:h-28 object-cover object-center rounded-lg mx-auto transition-transform duration-300 group-hover:scale-105">
                    <source src="{{ asset('videos/streetcode-logo.mp4') }}" type="video/mp4" />
                    <img src="{{ asset('images/streetcode-logo-poster.png') }}" alt="StreetCode" />
                </video>
            </div>
        </div>

        {{-- 6. GAME TITLE: BOLD, LIVELY CARTOON TYPOGRAPHY --}}
        <div class="space-y-1 mt-0.5">
            {{-- Bouncing Fruit Title Decor --}}
            <div class="flex items-center justify-center gap-2.5">
                <span class="text-2xl sm:text-4xl animate-bounce" style="animation-delay: 0s;">🍎</span>
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-display font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-yellow-300 via-amber-400 to-amber-600 cartoon-title-shadow filter drop-shadow-[0_3px_10px_rgba(245,158,11,0.35)] leading-tight">
                    FRUIT MATH
                </h1>
                <span class="text-2xl sm:text-4xl animate-bounce" style="animation-delay: 0.2s;">🍌</span>
            </div>

            <p class="text-sm sm:text-base md:text-lg font-display font-extrabold text-amber-950 cartoon-text-shadow max-w-xl mx-auto leading-snug">
                {{ $isSw
                    ? 'Mchezo wa Kwanza wa Hisabati ya Matunda wenye Furaha na Rangi!'
                    : 'The #1 Kid-Favorite Fruit Math Game Full of Fun & Adventure!' }}
            </p>
        </div>

        {{-- 7. MASCOT KIKO STAGE (FRIENDLY CHARACTER & GLASS SPEECH BUBBLE) --}}
        <div class="mt-2 sm:mt-2.5 flex items-center justify-center gap-3 max-w-lg mx-auto">
            {{-- Animated Character SVG with Fruit Hat --}}
            <div id="intro-mascot-char"
                 class="relative w-13 h-13 sm:w-16 sm:h-16 shrink-0 cursor-pointer select-none transition-transform duration-300 hover:scale-115 active:scale-90 animate-mascot-breathe"
                 title="{{ $isSw ? 'Mimi ni Kiko! Niguse nicheze!' : 'I am Kiko! Tap me!' }}">
                <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[0_4px_8px_rgba(0,0,0,0.18)]">
                    {{-- Big Ears --}}
                    <circle cx="18" cy="38" r="15" fill="#d97706"/>
                    <circle cx="18" cy="38" r="9" fill="#fde68a"/>
                    <circle cx="82" cy="38" r="15" fill="#d97706"/>
                    <circle cx="82" cy="38" r="9" fill="#fde68a"/>

                    {{-- Face --}}
                    <ellipse cx="50" cy="50" rx="38" ry="36" fill="#f59e0b"/>
                    <ellipse cx="50" cy="58" rx="26" ry="22" fill="#fef3c7"/>
                    <circle cx="40" cy="42" r="16" fill="#fef3c7"/>
                    <circle cx="60" cy="42" r="16" fill="#fef3c7"/>

                    {{-- Eyes --}}
                    <g id="mascot-eyes">
                        <ellipse cx="42" cy="42" rx="6.5" ry="8.5" fill="#0f172a"/>
                        <circle cx="40" cy="39" r="3" fill="#ffffff"/>
                        <circle cx="44" cy="45" r="1.5" fill="#ffffff"/>

                        <ellipse cx="58" cy="42" rx="6.5" ry="8.5" fill="#0f172a"/>
                        <circle cx="56" cy="39" r="3" fill="#ffffff"/>
                        <circle cx="60" cy="45" r="1.5" fill="#ffffff"/>
                    </g>

                    {{-- Star Eyes (Shown on Victory) --}}
                    <g id="mascot-star-eyes" class="hidden">
                        <text x="36" y="47" font-size="18" text-anchor="middle">⭐</text>
                        <text x="64" y="47" font-size="18" text-anchor="middle">⭐</text>
                    </g>

                    {{-- Cute Nose & Big Happy Smile --}}
                    <ellipse cx="50" cy="53" rx="4.5" ry="3" fill="#78350f"/>
                    <path id="mascot-mouth" d="M 42 59 Q 50 68 58 59" stroke="#78350f" stroke-width="3" fill="#f43f5e" stroke-linecap="round"/>

                    {{-- Rosy Cheeks --}}
                    <circle cx="30" cy="56" r="5" fill="#f43f5e" opacity="0.6"/>
                    <circle cx="70" cy="56" r="5" fill="#f43f5e" opacity="0.6"/>

                    {{-- Fruit Hat / Green Leaf --}}
                    <path d="M 50 14 Q 58 4 68 10 Q 58 20 50 16 Z" fill="#22c55e"/>
                    <circle cx="50" cy="15" r="4" fill="#dc2626"/>
                </svg>

                {{-- Interactive Hint Icon --}}
                <div class="absolute -top-1 -right-1 bg-amber-400 text-slate-950 font-black text-[10px] w-5 h-5 rounded-full flex items-center justify-center shadow-xs animate-bounce">
                    👆
                </div>
            </div>

            {{-- Transparent Glass Speech Bubble for Kids --}}
            <div class="relative glass-panel text-slate-800 border border-white/90 rounded-2xl px-4 py-2 shadow-xs max-w-sm transition-all duration-300">
                <div class="hidden sm:block absolute top-1/2 -left-2 -translate-y-1/2 w-0 h-0 border-t-[6px] border-t-transparent border-b-[6px] border-b-transparent border-r-[8px] border-r-white/90"></div>
                <p id="intro-mascot-speech" class="text-xs sm:text-sm font-display font-extrabold leading-snug text-slate-800">
                    {{ $isSw ? 'Mambo vipi! Mimi ni Kiko! Karibu kwenye Fruit Math! 🍎' : 'Hey friend! I am Kiko! Welcome to Fruit Math! 🍎' }}
                </p>
            </div>
        </div>

        {{-- 8. COMPACT VISUAL GAME HIGHLIGHTS (PILL BADGES WITH CLEAR FONTS) --}}
        <div class="mt-2 sm:mt-2.5 flex flex-wrap items-center justify-center gap-2 max-w-xl mx-auto">
            <div class="glass-pill border border-white/80 px-3 py-1 rounded-full flex items-center gap-1.5 text-xs sm:text-sm font-display font-extrabold text-amber-950 shadow-xs">
                <span class="text-base sm:text-lg">🍎</span>
                <span>{{ $isSw ? 'Hesabu za Matunda' : 'Fruit Math' }}</span>
            </div>
            <div class="glass-pill border border-white/80 px-3 py-1 rounded-full flex items-center gap-1.5 text-xs sm:text-sm font-display font-extrabold text-amber-950 shadow-xs">
                <span class="text-base sm:text-lg">🎁</span>
                <span>{{ $isSw ? 'Masanduku ya Zawadi' : 'Chests & Gems' }}</span>
            </div>
            <div class="glass-pill border border-white/80 px-3 py-1 rounded-full flex items-center gap-1.5 text-xs sm:text-sm font-display font-extrabold text-amber-950 shadow-xs">
                <span class="text-base sm:text-lg">🏆</span>
                <span>{{ $isSw ? 'Mataji na Nyota' : 'Trophies & Stars' }}</span>
            </div>
        </div>

        {{-- 9. JUICY ARCADE PROGRESS METER (CLEAR & PROMINENT) --}}
        <div class="mt-2.5 sm:mt-3.5 w-full max-w-lg mx-auto space-y-1.5 sm:space-y-2">
            {{-- Big 3D Glowing Percent Number --}}
            <div class="flex items-center justify-center">
                <span id="streetcode-progress-percent"
                      class="text-5xl sm:text-6xl md:text-7xl font-display font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-yellow-300 via-amber-400 to-amber-600 cartoon-title-shadow filter drop-shadow-[0_3px_10px_rgba(245,158,11,0.4)] leading-none">
                    0%
                </span>
            </div>

            {{-- Translucent Glass Progress Tube --}}
            <div class="relative w-full h-6 sm:h-7 glass-panel border-2 border-white/90 rounded-full p-0.5 sm:p-1 shadow-xs overflow-visible">
                {{-- Liquid Fruit Juice Fill Bar --}}
                <div id="streetcode-progress-bar"
                     class="h-full bg-gradient-to-r from-rose-500 via-amber-400 to-yellow-300 rounded-full shadow-[0_0_15px_rgba(245,158,11,0.6)] transition-all duration-75 relative overflow-hidden"
                     style="width: 0%;">
                    {{-- Rising Bubbles --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-gold-shimmer"></div>
                </div>

                {{-- Bouncing Fruit Runner Icon on the Edge --}}
                <div id="streetcode-fruit-runner"
                     class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 text-2xl sm:text-3xl select-none pointer-events-none drop-shadow-[0_2px_6px_rgba(0,0,0,0.2)] transition-all duration-75 animate-bounce"
                     style="left: 0%;">
                    🍎
                </div>
            </div>

            {{-- Playful Status Message --}}
            <div class="min-h-[24px] flex items-center justify-center">
                <p id="streetcode-progress-status"
                   class="text-sm sm:text-base md:text-lg font-display font-black text-slate-900 tracking-wide transition-opacity duration-150">
                    {{ $isSw ? '⚡ StreetCode inawasha injini ya mchezo...' : '⚡ StreetCode is starting up the game engine...' }}
                </p>
            </div>

            {{-- Fun Interactive Hint for Kids --}}
            <p class="text-xs sm:text-sm text-amber-950 font-extrabold">
                🍉 {{ $isSw ? 'Gusa matunda yanayoelea hapo juu kumwaga maji na kupata nyota!' : 'Tap floating fruits to splash juicy droplets and earn stars!' }}
            </p>

            {{-- 10. 3D CANDY PLAY BUTTON (APPEARS AT 100%) --}}
            <div class="pt-1">
                <button type="button"
                        id="streetcode-enter-btn"
                        class="hidden inline-flex items-center justify-center gap-2.5 bg-gradient-to-b from-emerald-400 via-emerald-500 to-green-600 hover:from-emerald-300 hover:to-emerald-500 text-white font-display font-black text-base sm:text-xl md:text-2xl px-8 sm:px-12 py-3 sm:py-3.5 rounded-2xl shadow-[0_6px_0_#15803d,0_14px_28px_rgba(22,163,74,0.45)] active:translate-y-1 active:shadow-[0_2px_0_#15803d] transition-all duration-200 cursor-pointer border-2 border-emerald-300/70 animate-jelly-bounce">
                    <span class="text-2xl sm:text-3xl animate-bounce">🎮</span>
                    <span>{{ $isSw ? 'ANZA KUCHEZA SASA!' : 'PLAY FRUIT MATH NOW!' }}</span>
                    <span class="text-2xl sm:text-3xl">➔</span>
                </button>
                <p id="streetcode-auto-timer" class="text-xs sm:text-sm text-amber-900 font-extrabold mt-1.5 drop-shadow-xs"></p>
            </div>
        </div>

    </main>

    {{-- FOOTER CREDITS --}}
    <footer class="relative z-20 max-w-5xl w-full mx-auto px-4 py-2 text-center border-t border-white/30">
        <p class="text-xs sm:text-sm text-slate-700 font-bold tracking-wide">
            © {{ date('Y') }} <span class="text-amber-700 font-black">StreetCode</span>.
            <span class="text-amber-800">DREAM ◆ CODE ◆ BUILD</span> —
            {{ $isSw ? 'Mchezo wa Watoto wa Hisabati ya Matunda.' : 'The Ultimate Kids Fruit Math Game.' }}
        </p>
    </footer>

</div>
