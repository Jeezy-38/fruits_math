<div class="relative overflow-hidden min-h-screen pb-24 selection:bg-amber-300 selection:text-slate-900">
    <x-streetcode-intro :standalone="false" :skip="request()->has('skip_intro')" />
    <x-animated-landscape world="fruit-garden" />

    {{-- ======================================================== --}}
    {{-- FLOATING HEADER ISLAND (NO <nav> tag for test specs)      --}}
    {{-- ======================================================== --}}
    <header class="relative z-20 max-w-6xl mx-auto px-4 sm:px-6 pt-4 sm:pt-6 flex items-center justify-between gap-3">
        {{-- Brand Badge --}}
        <div class="inline-flex items-center gap-2.5 glass-panel px-4 py-2 rounded-2xl select-none transition group hover:shadow-md">
            <span class="text-2xl group-hover:scale-110 transition-transform">🍎</span>
            <div class="flex flex-col text-left leading-none">
                <span class="font-display font-black text-sm tracking-wider text-slate-900">FRUIT MATH</span>
                <span class="text-[10px] font-bold text-amber-600 tracking-wider uppercase">by StreetCode</span>
            </div>
        </div>

        {{-- Top Right Controls --}}
        <div class="flex items-center gap-2 sm:gap-3">
            {{-- Replay Intro Button --}}
            <button type="button"
                    onclick="if(window.showStreetCodeIntro){window.showStreetCodeIntro();}else{window.location.href='{{ route('intro') }}';}"
                    class="glass-pill hover:bg-white/50 text-slate-800 px-3 sm:px-4 py-2 rounded-2xl font-display font-black text-xs hover:scale-105 active:scale-95 transition flex items-center gap-1.5 cursor-pointer"
                    title="{{ app()->getLocale() === 'sw' ? 'Tazama Utangulizi wa StreetCode tena' : 'Replay StreetCode Intro' }}">
                <span class="text-amber-500">🎬</span>
                <span class="hidden sm:inline">{{ app()->getLocale() === 'sw' ? 'Utangulizi' : 'Intro' }}</span>
            </button>

            {{-- Language Toggle --}}
            <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
               class="glass-pill hover:bg-white/50 px-3.5 sm:px-4 py-2 rounded-2xl font-display font-black text-xs text-slate-800 hover:scale-105 active:scale-95 transition flex items-center gap-1.5"
               title="{{ app()->getLocale() === 'sw' ? 'Badili kwenda English' : 'Switch to Kiswahili' }}">
                <span>🌐</span>
                <span class="font-black">{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
            </a>

            @auth
                <a href="{{ route('players') }}"
                   class="hidden sm:inline-flex items-center gap-1.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 rounded-2xl font-display font-black text-xs shadow-sm hover:scale-105 active:scale-95 transition">
                    <span>🎮</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'Cheza' : 'Play' }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-white/90 hover:bg-rose-50 text-slate-700 hover:text-rose-600 backdrop-blur-md px-3.5 py-2 rounded-2xl font-display font-black text-xs shadow-sm border border-white/80 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 cursor-pointer"
                            title="{{ app()->getLocale() === 'sw' ? 'Toka kwenye akaunti' : 'Log out' }}">
                        <span>🚪</span>
                        <span class="hidden sm:inline">{{ app()->getLocale() === 'sw' ? 'Toka' : 'Log out' }}</span>
                    </button>
                </form>
            @endauth
        </div>
    </header>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 pt-4 sm:pt-8 md:pt-10 space-y-10 sm:space-y-14 md:space-y-20">

        {{-- ======================================================== --}}
        {{-- BLOCK 1: SLEEK GLASS HERO SECTION (COMPACT & MODERN)      --}}
        {{-- ======================================================== --}}
        <section class="text-center">
            <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 md:p-10 max-w-3xl mx-auto relative overflow-hidden">
                
                {{-- Decorative Ambient Mesh Lighting --}}
                <div class="absolute -top-20 -left-20 w-60 h-60 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-20 w-60 h-60 bg-amber-400/20 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Shimmering Glass Tag Badge --}}
                <div class="inline-flex items-center gap-2 glass-pill text-amber-950 border border-white/90 font-display font-black text-xs px-3.5 sm:px-4 py-1 sm:py-1.5 rounded-full mb-3 shadow-xs select-none hover:scale-105 transition cursor-default">
                    <span class="text-amber-500 animate-spin" style="animation-duration: 6s;">✨</span>
                    <span>Mchezo Namba #1 wa Hisabati ya Matunda kwa Watoto</span>
                    <span class="text-amber-500 animate-spin" style="animation-duration: 6s;">✨</span>
                </div>

                {{-- Bouncing Fruit Title Banner --}}
                <div class="flex justify-center items-center gap-2 text-2xl sm:text-3xl select-none mb-2 sm:mb-3">
                    <span class="animate-bounce" style="animation-delay: 0s;">🍎</span>
                    <span class="text-lg sm:text-xl font-display font-black text-emerald-600">+</span>
                    <span class="animate-bounce" style="animation-delay: 0.15s;">🍌</span>
                    <span class="text-lg sm:text-xl font-display font-black text-amber-500">=</span>
                    <span class="animate-bounce text-3xl sm:text-4xl" style="animation-delay: 0.3s;">⭐</span>
                </div>

                {{-- Main Heading: Reduced Size & Glass Aesthetic --}}
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[2.6rem] font-display font-black tracking-tight text-slate-800 leading-[1.2]">
                    Mchezo Unaomfanya Mtoto <br class="hidden sm:inline" />
                    <span class="glass-text">Apende Hisabati Bila Hofu!</span>
                </h1>

                {{-- Subtitle --}}
                <p class="text-sm sm:text-base md:text-lg text-slate-600 font-semibold max-w-xl mx-auto mt-2.5 sm:mt-3 leading-relaxed">
                    Watoto wanajifunza kuhesabu, kujumlisha na kuzidisha kwa kugusa matunda halisi, kushangiliwa na Kiko the Mascot, na kufungua masanduku ya dhahabu ya siri! 🎁
                </p>

                {{-- INTERACTIVE MINI-GAME DEMO PLAYGROUND (GLASS CARD) --}}
                <div x-data="{
                    solved: false,
                    selected: null,
                    choose(num) {
                        if (this.solved) return;
                        this.selected = num;
                        if (num === 5) {
                            this.solved = true;
                            if (window.FruitAudio && window.FruitAudio.victory) window.FruitAudio.victory();
                            if (window.launchConfetti) window.launchConfetti(2500);
                        } else {
                            if (window.FruitAudio && window.FruitAudio.wrong) window.FruitAudio.wrong();
                        }
                    }
                }" class="my-4 sm:my-5 glass-pill border border-white/80 rounded-2xl p-3 sm:p-4 max-w-md mx-auto shadow-sm">
                    <div class="flex items-center justify-between text-xs font-display font-black text-slate-700 mb-2 px-1">
                        <span class="flex items-center gap-1.5 text-amber-800 text-xs">
                            <span>🎮</span>
                            <span>Jaribu Swali Hili Rahisi:</span>
                        </span>
                        <span class="text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full text-[11px] font-bold">
                            Live Demo
                        </span>
                    </div>

                    {{-- Question Equation --}}
                    <div class="flex items-center justify-center gap-2 text-xl sm:text-2xl font-display font-black text-slate-800 select-none py-1">
                        <span class="flex items-center gap-1 bg-white/90 px-2.5 py-1 rounded-xl shadow-xs border border-white/80">
                            <span>🍎</span> <span>2</span>
                        </span>
                        <span class="text-emerald-600 font-black">+</span>
                        <span class="flex items-center gap-1 bg-white/90 px-2.5 py-1 rounded-xl shadow-xs border border-white/80">
                            <span>🍌</span> <span>3</span>
                        </span>
                        <span class="text-amber-500 font-black">=</span>
                        <span class="bg-amber-100/90 text-amber-900 border border-amber-300 px-3 py-0.5 rounded-xl font-black animate-pulse" x-text="solved ? '⭐ 5' : '?'">
                            ?
                        </span>
                    </div>

                    {{-- Clickable Answers --}}
                    <div class="grid grid-cols-3 gap-2 mt-2.5">
                        <button type="button"
                                @click="choose(4)"
                                :disabled="solved"
                                class="py-1.5 sm:py-2 rounded-xl font-display font-black text-sm sm:text-base transition cursor-pointer border"
                                :class="selected === 4 ? 'bg-rose-100 border-rose-300 text-rose-800' : 'bg-white/80 hover:bg-white border-white/90 text-slate-700 shadow-xs hover:scale-105 active:scale-95'">
                            4
                        </button>
                        <button type="button"
                                @click="choose(5)"
                                class="py-1.5 sm:py-2 rounded-xl font-display font-black text-sm sm:text-base transition cursor-pointer border"
                                :class="solved ? 'bg-emerald-500 border-emerald-600 text-white shadow-md animate-bounce scale-105' : 'bg-white/80 hover:bg-emerald-50 border-emerald-300 text-emerald-800 shadow-xs hover:scale-105 active:scale-95'">
                            5 ⭐
                        </button>
                        <button type="button"
                                @click="choose(6)"
                                :disabled="solved"
                                class="py-1.5 sm:py-2 rounded-xl font-display font-black text-sm sm:text-base transition cursor-pointer border"
                                :class="selected === 6 ? 'bg-rose-100 border-rose-300 text-rose-800' : 'bg-white/80 hover:bg-white border-white/90 text-slate-700 shadow-xs hover:scale-105 active:scale-95'">
                            6
                        </button>
                    </div>

                    <p x-show="solved" x-cloak class="mt-2 text-xs font-display font-black text-emerald-700 animate-pop">
                        🎉 HONGERA SANA! Jibu sahihi ni 5! Mtoto anajifunza kwa njia hii rahisi!
                    </p>
                </div>

                {{-- Action Buttons: Sleeker, better proportioned --}}
                <div class="mt-5 sm:mt-6 flex flex-col sm:flex-row items-center justify-center gap-3 max-w-lg mx-auto">
                    @guest
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-b from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white font-display font-black text-base sm:text-lg px-7 sm:px-9 py-3 sm:py-3.5 rounded-2xl shadow-[0_6px_0_#065f46] hover:shadow-[0_4px_0_#065f46] active:translate-y-1.5 active:shadow-none transition-all cursor-pointer">
                            <span>Jifunze Sasa (Fungua Bure)</span>
                            <span class="text-lg">➔</span>
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 glass-pill hover:bg-white/90 text-slate-800 font-display font-black text-sm sm:text-base px-6 sm:px-7 py-3 sm:py-3.5 rounded-2xl border border-white/90 shadow-xs active:translate-y-1 transition-all cursor-pointer">
                            <span>Nina Akaunti (Ingia)</span>
                            <span>🔑</span>
                        </a>
                    @else
                        <a href="{{ route('players') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-b from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white font-display font-black text-base sm:text-lg px-7 sm:px-9 py-3 sm:py-3.5 rounded-2xl shadow-[0_6px_0_#065f46] hover:shadow-[0_4px_0_#065f46] active:translate-y-1.5 active:shadow-none transition-all cursor-pointer">
                            <span>Endelea Kucheza</span>
                            <span class="text-lg">➔</span>
                        </a>
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 glass-pill hover:bg-white/90 text-slate-800 font-display font-black text-sm sm:text-base px-6 sm:px-7 py-3 sm:py-3.5 rounded-2xl border border-white/90 shadow-xs active:translate-y-1 transition-all">
                            <span>Dashboard ya Mzazi</span>
                            <span>📊</span>
                        </a>
                    @endguest
                </div>

                {{-- Trust Badges --}}
                <div class="mt-6 pt-4 border-t border-white/60 flex flex-wrap items-center justify-center gap-2.5 sm:gap-4 text-xs font-bold text-slate-600">
                    <span class="flex items-center gap-1 text-emerald-700 bg-white/70 backdrop-blur-sm px-2.5 py-0.5 rounded-full border border-emerald-100 shadow-xs">
                        <span class="text-xs">✓</span> 100% Salama kwa Watoto
                    </span>
                    <span class="flex items-center gap-1 text-emerald-700 bg-white/70 backdrop-blur-sm px-2.5 py-0.5 rounded-full border border-emerald-100 shadow-xs">
                        <span class="text-xs">✓</span> Haina Matangazo Yoyote
                    </span>
                    <span class="flex items-center gap-1 text-emerald-700 bg-white/70 backdrop-blur-sm px-2.5 py-0.5 rounded-full border border-emerald-100 shadow-xs">
                        <span class="text-xs">✓</span> Lugha ya Kiswahili na Kiingereza
                    </span>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 2: JINSI INAVYOFANYA KAZI (HATUA 3 RAHISI)          --}}
        {{-- ======================================================== --}}
        <section>
            <div class="text-center mb-6 sm:mb-10">
                <span class="inline-block text-xs sm:text-sm font-display font-black uppercase tracking-wider text-emerald-800 bg-emerald-100/90 backdrop-blur px-4 py-1.5 rounded-full shadow-sm border border-emerald-200 mb-2">
                    Hatua Rahisi
                </span>
                <h2 class="text-2xl sm:text-4xl md:text-5xl font-display font-black text-slate-800">
                    Jinsi Inavyofanya Kazi
                </h2>
                <p class="text-slate-600 font-semibold mt-2 text-sm sm:text-base md:text-lg max-w-xl mx-auto">
                    Kuanza ni rahisi sana, hakuna malipo wala utata wowote!
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                {{-- Step 1 --}}
                <div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-md relative hover:scale-[1.02] transition-transform">
                    <div class="w-11 h-11 bg-gradient-to-tr from-sky-400 to-blue-500 text-white rounded-2xl grid place-items-center text-lg font-display font-black shadow-xs mb-3">
                        1
                    </div>
                    <div class="text-3xl sm:text-4xl mb-2">📝</div>
                    <h3 class="text-lg sm:text-xl font-display font-black text-slate-800">Mzazi Anajisajili</h3>
                    <p class="text-slate-600 font-medium text-xs sm:text-sm mt-1.5 leading-relaxed">
                        Fungua akaunti ya mzazi kwa sekunde 30 tu, kisha ongeza jina la mtoto wako ili kuanza safari ya masomo.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-md relative hover:scale-[1.02] transition-transform">
                    <div class="w-11 h-11 bg-gradient-to-tr from-amber-400 to-yellow-500 text-slate-900 rounded-2xl grid place-items-center text-lg font-display font-black shadow-xs mb-3">
                        2
                    </div>
                    <div class="text-3xl sm:text-4xl mb-2">🦁</div>
                    <h3 class="text-lg sm:text-xl font-display font-black text-slate-800">Mtoto Anachagua Avatar</h3>
                    <p class="text-slate-600 font-medium text-xs sm:text-sm mt-1.5 leading-relaxed">
                        Mtoto anajichagulia mhusika anayempenda (Simba, Sungura, Panda, Roketi, au Taji) na kuingia kwenye ramani ya mchezo.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-md relative hover:scale-[1.02] transition-transform">
                    <div class="w-11 h-11 bg-gradient-to-tr from-emerald-400 to-green-500 text-white rounded-2xl grid place-items-center text-lg font-display font-black shadow-xs mb-3">
                        3
                    </div>
                    <div class="text-3xl sm:text-4xl mb-2">🎁</div>
                    <h3 class="text-lg sm:text-xl font-display font-black text-slate-800">Kucheza & Kupata Zawadi</h3>
                    <p class="text-slate-600 font-medium text-xs sm:text-sm mt-1.5 leading-relaxed">
                        Anagusa matunda kuhesabu, anashangiliwa na Kiko, anapata nyota na kupasua masanduku ya dhahabu ya siri!
                    </p>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 3: ULIMWENGU 3 ZA SAFARI YA MASOMO (3 MAGICAL WORLDS) --}}
        {{-- ======================================================== --}}
        <section>
            <div class="text-center mb-5 sm:mb-8">
                <span class="inline-block text-xs font-display font-black uppercase tracking-wider text-amber-900 glass-pill px-3.5 py-1 rounded-full shadow-xs border border-white/80 mb-2">
                    Safari ya Matukio
                </span>
                <h2 class="text-xl sm:text-3xl md:text-4xl font-display font-black text-slate-800">
                    Safiri Kwenye Ulimwengu 3 za Kichawi
                </h2>
                <p class="text-slate-600 font-semibold mt-1.5 text-xs sm:text-sm md:text-base max-w-xl mx-auto">
                    Kila ulimwengu una mada zake za hisabati zilizopangwa kitaalamu:
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                {{-- World 1 --}}
                <div class="glass-panel rounded-3xl overflow-hidden shadow-md hover:scale-[1.02] transition-transform flex flex-col justify-between group">
                    <div>
                        <div class="h-40 sm:h-44 overflow-hidden relative">
                            <img src="{{ asset('images/backgrounds/fruit-garden.jpg') }}" alt="Fruit Garden" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent flex items-end p-4">
                                <span class="text-white font-display font-black text-lg sm:text-xl flex items-center gap-1.5">
                                    <span>🌳</span> <span>Fruit Garden</span>
                                </span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5">
                            <h4 class="font-display font-black text-base text-slate-800 mb-2.5">Ngazi ya Kuanzia (Foundation)</h4>
                            <ul class="space-y-1.5 text-xs sm:text-sm text-slate-600 font-bold">
                                <li class="flex items-center gap-2">
                                    <span class="text-emerald-600 text-sm">🍎</span> Kuhesabu matunda (Counting)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-emerald-600 text-sm">➕</span> Kujumlisha kwa picha (Addition)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-emerald-600 text-sm">➖</span> Kutoa (Subtraction)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-emerald-600 text-sm">⚖️</span> Kulinganisha namba (&lt;, &gt;, =)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- World 2 --}}
                <div class="glass-panel rounded-3xl overflow-hidden shadow-md hover:scale-[1.02] transition-transform flex flex-col justify-between group">
                    <div>
                        <div class="h-40 sm:h-44 overflow-hidden relative">
                            <img src="{{ asset('images/backgrounds/banana-island.jpg') }}" alt="Banana Island" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent flex items-end p-4">
                                <span class="text-white font-display font-black text-lg sm:text-xl flex items-center gap-1.5">
                                    <span>🍌</span> <span>Banana Island</span>
                                </span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5">
                            <h4 class="font-display font-black text-base text-slate-800 mb-2.5">Vikundi na Sehemu</h4>
                            <ul class="space-y-1.5 text-xs sm:text-sm text-slate-600 font-bold">
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-500 text-sm">✖️</span> Kuzidisha (Times tables)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-500 text-sm">➗</span> Kugawanya kwa vikapu (Division)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-500 text-sm">🍉</span> Sehemu za maumbo (Fractions)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- World 3 --}}
                <div class="glass-panel rounded-3xl overflow-hidden shadow-md hover:scale-[1.02] transition-transform flex flex-col justify-between group">
                    <div>
                        <div class="h-40 sm:h-44 overflow-hidden relative">
                            <img src="{{ asset('images/backgrounds/mango-village.jpg') }}" alt="Mango Village" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent flex items-end p-4">
                                <span class="text-white font-display font-black text-lg sm:text-xl flex items-center gap-1.5">
                                    <span>🥭</span> <span>Mango Village</span>
                                </span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5">
                            <h4 class="font-display font-black text-base text-slate-800 mb-2.5">Hisabati ya Maisha Halisi</h4>
                            <ul class="space-y-1.5 text-xs sm:text-sm text-slate-600 font-bold">
                                <li class="flex items-center gap-2">
                                    <span class="text-orange-500 text-sm">💰</span> Kununua sokoni (Fedha TZS)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-orange-500 text-sm">🕐</span> Kusoma saa ya mshale (Time)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-orange-500 text-sm">🔺</span> Kutambua maumbo (Shapes)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-orange-500 text-sm">📖</span> Maswali ya maneno (Word problems)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 4: MAMBO YANAYOMFANYA MTOTO ASITAKE KUWEKA SIMU CHINI --}}
        {{-- ======================================================== --}}
        <section>
            <div class="text-center mb-5 sm:mb-8">
                <span class="inline-block text-xs font-display font-black uppercase tracking-wider text-pink-700 glass-pill px-3.5 py-1 rounded-full shadow-xs border border-white/80 mb-2">
                    Kivutio cha Watoto
                </span>
                <h2 class="text-xl sm:text-3xl md:text-4xl font-display font-black text-slate-800">
                    Mambo Yanayomvutia Mtoto Zaidi
                </h2>
                <p class="text-slate-600 font-semibold mt-1.5 text-xs sm:text-sm md:text-base max-w-xl mx-auto">
                    Tumeondoa uchovu wa maswali ya shuleni na kuweka furaha ya gemu halisi:
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
                <div class="glass-panel rounded-3xl p-4 sm:p-5 shadow-xs text-center hover:scale-105 transition-transform flex flex-col items-center">
                    <div class="text-4xl sm:text-5xl mb-2 animate-bounce">🐵</div>
                    <h3 class="font-display font-black text-lg text-slate-800">Mascot Kiko</h3>
                    <p class="text-xs text-slate-600 font-semibold mt-1.5 leading-relaxed">
                        Mascot anayeshangilia, kuruka sarakasi na kumpa mtoto moyo kwa kila swali anapojibu!
                    </p>
                </div>

                <div class="glass-panel rounded-3xl p-4 sm:p-5 shadow-xs text-center hover:scale-105 transition-transform flex flex-col items-center">
                    <div class="text-4xl sm:text-5xl mb-2 animate-pop">👆</div>
                    <h3 class="font-display font-black text-lg text-slate-800">Gusa Uhesabu</h3>
                    <p class="text-xs text-slate-600 font-semibold mt-1.5 leading-relaxed">
                        Gusa kila tunda lipasuke kwa sauti ya "Pop!" na namba itokee juu yake kwa vitendo.
                    </p>
                </div>

                <div class="glass-panel rounded-3xl p-4 sm:p-5 shadow-xs text-center hover:scale-105 transition-transform flex flex-col items-center">
                    <div class="text-4xl sm:text-5xl mb-2 animate-pulse">🔊</div>
                    <h3 class="font-display font-black text-lg text-slate-800">Sauti ya Kusoma</h3>
                    <p class="text-xs text-slate-600 font-semibold mt-1.5 leading-relaxed">
                        Mtoto asiyejua kusoma anabonyeza spika na mfumo unamsomea swali kwa sauti nyororo.
                    </p>
                </div>

                <div class="glass-panel rounded-3xl p-4 sm:p-5 shadow-xs text-center hover:scale-105 transition-transform flex flex-col items-center">
                    <div class="text-4xl sm:text-5xl mb-2 animate-wobble">🎁</div>
                    <h3 class="font-display font-black text-lg text-slate-800">Sanduku la Siri</h3>
                    <p class="text-xs text-slate-600 font-semibold mt-1.5 leading-relaxed">
                        Baada ya kumaliza ngazi, mtoto anapasua sanduku la dhahabu kulipua nyota, XP na beji!
                    </p>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 5: NAFASI YA MZAZI (AMANI YA MOYO KWA WAZAZI)         --}}
        {{-- ======================================================== --}}
        <section class="glass-panel rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 md:p-10 shadow-lg border border-white/85">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 items-center">
                <div>
                    <span class="inline-block text-xs font-display font-black uppercase tracking-wider text-emerald-800 glass-pill px-3.5 py-1 rounded-full border border-white/80">
                        Kwa Wazazi
                    </span>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-display font-black text-slate-800 mt-2.5">
                        Ufuatiliaji Kamili Mikononi Mwako
                    </h2>
                    <p class="text-slate-600 font-semibold mt-2.5 text-xs sm:text-sm leading-relaxed">
                        Kama mzazi, huna haja ya kubahatisha ikiwa mtoto anaelewa au anabofya ovyo. Utapata ripoti kamili inayokuruhusu kuona:
                    </p>
                    <ul class="space-y-2.5 mt-3.5 text-slate-700 font-bold text-xs sm:text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-600 text-base font-black">✓</span>
                            <span>Asilimia ya usahihi (Accuracy %) na kasi ya kujibu maswali.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-600 text-base font-black">✓</span>
                            <span>Historia ya kila swali na jibu alilotoa mtoto hatua kwa hatua.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-600 text-base font-black">✓</span>
                            <span>Rekodi za siku mfululizo alizojifunza (Daily streak 🔥).</span>
                        </li>
                    </ul>
                </div>
                <div class="glass-pill p-5 sm:p-7 rounded-3xl border border-white/80 text-center shadow-xs">
                    <div class="text-4xl sm:text-5xl mb-2">📊</div>
                    <div class="font-display font-black text-xl sm:text-2xl text-slate-800">Ripoti ya Mzazi</div>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Saa za Afrika Mashariki (EAT)</p>
                    <div class="grid grid-cols-3 gap-2 sm:gap-2.5 mt-5 text-center">
                        <div class="bg-white/85 p-3 rounded-2xl shadow-2xs border border-white/90">
                            <b class="text-lg sm:text-xl font-display font-black text-emerald-700">100%</b>
                            <small class="block text-slate-500 font-bold text-[10px] sm:text-xs mt-0.5">Usahihi</small>
                        </div>
                        <div class="bg-white/85 p-3 rounded-2xl shadow-2xs border border-white/90">
                            <b class="text-lg sm:text-xl font-display font-black text-amber-600">⭐ 25</b>
                            <small class="block text-slate-500 font-bold text-[10px] sm:text-xs mt-0.5">Nyota</small>
                        </div>
                        <div class="bg-white/85 p-3 rounded-2xl shadow-2xs border border-white/90">
                            <b class="text-lg sm:text-xl font-display font-black text-blue-600">🔥 7</b>
                            <small class="block text-slate-500 font-bold text-[10px] sm:text-xs mt-0.5">Mfululizo</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 6: WITO MKUU WA MWISHO (FINAL BOTTOM CALL TO ACTION) --}}
        {{-- ======================================================== --}}
        <section class="text-center">
            <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-green-600 text-white rounded-[2.5rem] sm:rounded-[3rem] p-8 sm:p-12 md:p-16 shadow-2xl relative overflow-hidden">
                <div class="text-5xl sm:text-6xl mb-3 animate-bounce">🍎 ✨ 🏆</div>
                <h2 class="text-2xl sm:text-4xl md:text-5xl font-display font-black max-w-2xl mx-auto leading-tight">
                    Mpe Mtoto Wako Furaha ya Kupenda Hisabati Leo!
                </h2>
                <p class="text-emerald-100 font-semibold text-sm sm:text-lg md:text-xl max-w-xl mx-auto mt-3 sm:mt-4 leading-relaxed">
                    Ni bure, hakuna kadi ya benki wala utata. Jiunge na wazazi wengine wanaomsaidia mtoto kuwa bingwa wa namba.
                </p>

                <div class="mt-8">
                    @guest
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-900 font-display font-black text-lg sm:text-xl md:text-2xl px-10 sm:px-12 py-4 sm:py-5 rounded-2xl sm:rounded-3xl shadow-[0_8px_0_#0f766e] active:translate-y-2 active:shadow-none transition-all cursor-pointer min-h-[58px]">
                            <span>Jifunze Sasa — Fungua Bure!</span>
                            <span class="text-xl">➔</span>
                        </a>
                        <p class="mt-4 text-emerald-100 font-semibold text-xs sm:text-sm">
                            Tayari una akaunti? <a href="{{ route('login') }}" class="text-white underline font-display font-black hover:text-amber-200">Ingia hapa</a>
                        </p>
                    @else
                        <a href="{{ route('players') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-900 font-display font-black text-lg sm:text-xl md:text-2xl px-10 sm:px-12 py-4 sm:py-5 rounded-2xl sm:rounded-3xl shadow-[0_8px_0_#0f766e] active:translate-y-2 active:shadow-none transition-all cursor-pointer min-h-[58px]">
                            <span>Cheza Sasa na Mtoto Wako</span>
                            <span class="text-xl">➔</span>
                        </a>
                    @endguest
                </div>
            </div>
        </section>

        {{-- Footer (NO <nav> tag) --}}
        <footer class="pt-6 sm:pt-8 text-center text-slate-500 font-semibold text-xs sm:text-sm flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-200/80">
            <div class="flex items-center gap-2">
                <span class="text-xl">🍎</span>
                <span class="font-display font-black text-slate-800 text-sm">Fruit Math</span>
                <span class="text-amber-600 font-black text-xs">by StreetCode</span>
                <span>© {{ date('Y') }}</span>
            </div>
            <div class="flex items-center gap-2 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full shadow-sm border border-slate-200/70 text-xs">
                <span class="text-slate-400 font-medium">Lugha / Language:</span>
                <a href="{{ route('language', 'sw') }}" class="px-2.5 py-0.5 rounded-full font-bold transition {{ app()->getLocale() === 'sw' ? 'bg-emerald-600 text-white font-display font-black' : 'hover:text-slate-900' }}">Kiswahili</a>
                <a href="{{ route('language', 'en') }}" class="px-2.5 py-0.5 rounded-full font-bold transition {{ app()->getLocale() === 'en' ? 'bg-emerald-600 text-white font-display font-black' : 'hover:text-slate-900' }}">English</a>
            </div>
        </footer>

    </div>
</div>