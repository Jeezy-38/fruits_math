<div class="relative overflow-hidden min-h-screen pb-20">
    <x-animated-landscape world="fruit-garden" />

    {{-- Floating Language Switcher (Corner) --}}
    <div class="absolute top-4 right-4 md:top-6 md:right-8 z-30">
        <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
           class="bg-white/90 hover:bg-white backdrop-blur-md px-4 py-2 rounded-2xl font-black text-xs text-slate-700 shadow-md border border-white/80 hover:scale-105 active:scale-95 transition flex items-center gap-1.5"
           title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
            <span>🌐</span>
            <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
        </a>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 md:px-6 pt-8 md:pt-14 space-y-16 md:space-y-24">

        {{-- ======================================================== --}}
        {{-- BLOCK 1: HERO SECTION (UTAMBULISHO MKUU NA WITO WA KWANZA) --}}
        {{-- ======================================================== --}}
        <section class="text-center">
            <div class="bg-white/95 backdrop-blur-md rounded-[3rem] p-8 md:p-14 shadow-2xl border-4 border-white/90 max-w-4xl mx-auto">
                {{-- Bouncing Fruit Banner --}}
                <div class="flex justify-center items-center gap-2 md:gap-4 text-5xl md:text-7xl select-none mb-3">
                    <span class="animate-bounce" style="animation-delay: 0s;">🍎</span>
                    <span class="text-3xl md:text-5xl font-black text-emerald-600">+</span>
                    <span class="animate-bounce" style="animation-delay: 0.2s;">🍌</span>
                    <span class="text-3xl md:text-5xl font-black text-amber-500">=</span>
                    <span class="animate-bounce text-6xl md:text-8xl" style="animation-delay: 0.4s;">⭐</span>
                </div>

                {{-- 3D Fruit Math Logo Badge --}}
                <div class="inline-flex items-center gap-2.5 bg-gradient-to-r from-emerald-500 via-green-500 to-teal-600 text-white font-black text-sm md:text-base px-6 py-2 rounded-full mb-4 shadow-lg border-2 border-white/80 select-none">
                    <span class="text-xl">🍎</span>
                    <span class="tracking-widest">FRUIT MATH</span>
                    <span class="text-xl">🍌</span>
                </div>

                <div class="block">
                    <div class="inline-block bg-amber-100 text-amber-900 border-2 border-amber-300 font-black text-xs md:text-sm px-4 py-1.5 rounded-full mb-3 shadow-sm">
                        ✨ Mchezo Namba #1 wa Hisabati ya Matunda kwa Watoto
                    </div>
                </div>

                <h1 class="text-4xl sm:text-6xl md:text-7xl font-black tracking-tight text-slate-800 leading-tight">
                    Mchezo Unaomfanya Mtoto <span class="bg-gradient-to-r from-emerald-600 via-green-500 to-teal-500 bg-clip-text text-transparent">Apende Hisabati!</span>
                </h1>

                <p class="text-lg md:text-2xl text-slate-600 font-bold max-w-2xl mx-auto mt-4 leading-relaxed">
                    Watoto wanajifunza kuhesabu, kujumlisha na kuzidisha kwa kugusa matunda, kushangiliwa na Kiko (Mascot), na kufungua masanduku ya dhahabu ya siri! 🎁
                </p>

                {{-- Action Logic: Kama hana akaunti anapelekwa Register; akiwa nayo anapelekwa kucheza --}}
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    @guest
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-block bg-gradient-to-b from-green-500 to-green-600 hover:from-green-400 hover:to-green-500 text-white font-black text-xl md:text-2xl px-10 py-5 rounded-3xl shadow-[0_8px_0_#15803d] active:translate-y-2 active:shadow-none transition-all cursor-pointer">
                            Jifunze Sasa (Fungua Bure) ➔
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto inline-block bg-white hover:bg-slate-50 text-slate-800 font-black text-lg md:text-xl px-8 py-5 rounded-3xl shadow-[0_6px_0_#cbd5e1] border-2 border-slate-200 active:translate-y-1.5 active:shadow-none transition-all cursor-pointer">
                            Nina Akaunti (Ingia) 🔑
                        </a>
                    @else
                        <a href="{{ route('players') }}" class="w-full sm:w-auto inline-block bg-gradient-to-b from-green-500 to-green-600 hover:from-green-400 hover:to-green-500 text-white font-black text-xl md:text-2xl px-12 py-5 rounded-3xl shadow-[0_8px_0_#15803d] active:translate-y-2 active:shadow-none transition-all cursor-pointer">
                            Endelea Kucheza Sasa ➔
                        </a>
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="w-full sm:w-auto inline-block bg-white hover:bg-slate-50 text-slate-800 font-black text-lg px-8 py-5 rounded-3xl shadow-[0_6px_0_#cbd5e1] border-2 border-slate-200 active:translate-y-1.5 active:shadow-none transition-all">
                            Dashboard ya Mzazi 📊
                        </a>
                    @endguest
                </div>

                {{-- Trust Badges --}}
                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-center gap-4 md:gap-8 text-xs md:text-sm font-black text-slate-500">
                    <span class="flex items-center gap-1.5 text-emerald-700">✓ 100% Salama kwa Watoto</span>
                    <span class="flex items-center gap-1.5 text-emerald-700">✓ Haina Matangazo Yoyote</span>
                    <span class="flex items-center gap-1.5 text-emerald-700">✓ Lugha ya Kiswahili na Kiingereza</span>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 2: JINSI INAVYOFANYA KAZI (HATUA 3 RAHISI)          --}}
        {{-- ======================================================== --}}
        <section>
            <div class="text-center mb-8">
                <span class="text-xs md:text-sm font-black uppercase tracking-wider text-emerald-800 bg-white/80 backdrop-blur px-4 py-1.5 rounded-full shadow-sm">
                    Hatua Rahisi
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-800 mt-3">Jinsi Inavyofanya Kazi</h2>
                <p class="text-slate-600 font-bold mt-2 text-base md:text-lg">Kuanza ni rahisi, hakuna malipo wala utata wowote!</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                {{-- Step 1 --}}
                <div class="bg-white/90 backdrop-blur-md rounded-[2.5rem] p-8 shadow-xl border-4 border-white/80 relative hover:scale-105 transition-transform">
                    <div class="w-14 h-14 bg-gradient-to-tr from-sky-400 to-blue-500 text-white rounded-2xl grid place-items-center text-2xl font-black shadow-md mb-4">
                        1
                    </div>
                    <div class="text-5xl mb-3">📝</div>
                    <h3 class="text-2xl font-black text-slate-800">Mzazi Anajisajili</h3>
                    <p class="text-slate-600 font-medium text-sm mt-2 leading-relaxed">
                        Fungua akaunti ya mzazi kwa sekunde 30 tu, kisha ongeza jina la mtoto wako ili kuanza safari ya masomo.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="bg-white/90 backdrop-blur-md rounded-[2.5rem] p-8 shadow-xl border-4 border-white/80 relative hover:scale-105 transition-transform">
                    <div class="w-14 h-14 bg-gradient-to-tr from-amber-400 to-yellow-500 text-slate-900 rounded-2xl grid place-items-center text-2xl font-black shadow-md mb-4">
                        2
                    </div>
                    <div class="text-5xl mb-3">🦁</div>
                    <h3 class="text-2xl font-black text-slate-800">Mtoto Anachagua Avatar</h3>
                    <p class="text-slate-600 font-medium text-sm mt-2 leading-relaxed">
                        Mtoto anajichagulia mhusika anayempenda (Simba, Sungura, Panda, Roketi, au Taji) na kuingia kwenye ramani ya mchezo.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="bg-white/90 backdrop-blur-md rounded-[2.5rem] p-8 shadow-xl border-4 border-white/80 relative hover:scale-105 transition-transform">
                    <div class="w-14 h-14 bg-gradient-to-tr from-emerald-400 to-green-500 text-white rounded-2xl grid place-items-center text-2xl font-black shadow-md mb-4">
                        3
                    </div>
                    <div class="text-5xl mb-3">🎁</div>
                    <h3 class="text-2xl font-black text-slate-800">Kucheza & Kupata Zawadi</h3>
                    <p class="text-slate-600 font-medium text-sm mt-2 leading-relaxed">
                        Anagusa matunda kuhesabu, anashangiliwa na Kiko, anapata nyota na kupasua masanduku ya dhahabu ya siri!
                    </p>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 3: ULIMWENGU 3 ZA SAFARI YA MASOMO (3 MAGICAL WORLDS) --}}
        {{-- ======================================================== --}}
        <section>
            <div class="text-center mb-8">
                <span class="text-xs md:text-sm font-black uppercase tracking-wider text-amber-800 bg-white/80 backdrop-blur px-4 py-1.5 rounded-full shadow-sm">
                    Safari ya Matukio
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-800 mt-3">Safiri Kwenye Ulimwengu 3 za Kichawi</h2>
                <p class="text-slate-600 font-bold mt-2 text-base md:text-lg">Kila ulimwengu una mada zake za hisabati zilizopangwa kitaalamu:</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                {{-- World 1 --}}
                <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white/90 hover:scale-105 transition-transform">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ asset('images/backgrounds/fruit-garden.jpg') }}" alt="Fruit Garden" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-5">
                            <span class="text-white font-black text-xl flex items-center gap-2">
                                <span>🌳</span> <span>Fruit Garden</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-black text-lg text-slate-800 mb-2">Ngazi ya Kuanzia (Foundation)</h4>
                        <ul class="space-y-1.5 text-sm text-slate-600 font-semibold">
                            <li class="flex items-center gap-2"><span>🍎</span> Kuhesabu matunda (Counting)</li>
                            <li class="flex items-center gap-2"><span>➕</span> Kujumlisha kwa picha (Addition)</li>
                            <li class="flex items-center gap-2"><span>➖</span> Kutoa (Subtraction)</li>
                            <li class="flex items-center gap-2"><span>⚖️</span> Kulinganisha namba (&lt;, &gt;, =)</li>
                        </ul>
                    </div>
                </div>

                {{-- World 2 --}}
                <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white/90 hover:scale-105 transition-transform">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ asset('images/backgrounds/banana-island.jpg') }}" alt="Banana Island" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-5">
                            <span class="text-white font-black text-xl flex items-center gap-2">
                                <span>🍌</span> <span>Banana Island</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-black text-lg text-slate-800 mb-2">Vikundi na Sehemu</h4>
                        <ul class="space-y-1.5 text-sm text-slate-600 font-semibold">
                            <li class="flex items-center gap-2"><span>✖️</span> Kuzidisha (Times tables)</li>
                            <li class="flex items-center gap-2"><span>➗</span> Kugawanya kwa vikapu (Division)</li>
                            <li class="flex items-center gap-2"><span>🍉</span> Sehemu za maumbo (Fractions)</li>
                        </ul>
                    </div>
                </div>

                {{-- World 3 --}}
                <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white/90 hover:scale-105 transition-transform">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ asset('images/backgrounds/mango-village.jpg') }}" alt="Mango Village" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-5">
                            <span class="text-white font-black text-xl flex items-center gap-2">
                                <span>🥭</span> <span>Mango Village</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-black text-lg text-slate-800 mb-2">Hisabati ya Maisha Halisi</h4>
                        <ul class="space-y-1.5 text-sm text-slate-600 font-semibold">
                            <li class="flex items-center gap-2"><span>💰</span> Kununua sokoni (Fedha TZS)</li>
                            <li class="flex items-center gap-2"><span>🕐</span> Kusoma saa ya mshale (Time)</li>
                            <li class="flex items-center gap-2"><span>🔺</span> Kutambua maumbo (Shapes)</li>
                            <li class="flex items-center gap-2"><span>📖</span> Maswali ya maneno (Word problems)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 4: MAMBO YANAYOMFANYA MTOTO ASITAKE KUWEKA SIMU CHINI --}}
        {{-- ======================================================== --}}
        <section>
            <div class="text-center mb-8">
                <span class="text-xs md:text-sm font-black uppercase tracking-wider text-pink-700 bg-white/80 backdrop-blur px-4 py-1.5 rounded-full shadow-sm">
                    Kivutio cha Watoto
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-800 mt-3">Mambo Yanayomvutia Mtoto Zaidi</h2>
                <p class="text-slate-600 font-bold mt-2 text-base md:text-lg">Tumeondoa uchovu wa maswali ya shuleni na kuweka furaha ya gemu halisi:</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border-4 border-white/80 text-center hover:scale-105 transition-transform">
                    <div class="text-5xl mb-2 animate-bounce">🐵</div>
                    <h3 class="font-black text-xl text-slate-800">Mascot Kiko</h3>
                    <p class="text-xs text-slate-500 font-bold mt-2 leading-relaxed">
                        Mascot anayeshangilia, kuruka sarakasi na kumpa mtoto moyo kwa kila swali anapojibu!
                    </p>
                </div>

                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border-4 border-white/80 text-center hover:scale-105 transition-transform">
                    <div class="text-5xl mb-2 animate-pop">👆</div>
                    <h3 class="font-black text-xl text-slate-800">Gusa Uhesabu</h3>
                    <p class="text-xs text-slate-500 font-bold mt-2 leading-relaxed">
                        Gusa kila tunda lipasuke kwa sauti ya "Pop!" na namba itokee juu yake. Kuhesabu kunakuwa kwa vitendo.
                    </p>
                </div>

                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border-4 border-white/80 text-center hover:scale-105 transition-transform">
                    <div class="text-5xl mb-2 animate-pulse">🔊</div>
                    <h3 class="font-black text-xl text-slate-800">Sauti ya Kusoma</h3>
                    <p class="text-xs text-slate-500 font-bold mt-2 leading-relaxed">
                        Mtoto asiyejua kusoma herufi anabonyeza spika na mfumo unamsomea swali kwa sauti nyororo.
                    </p>
                </div>

                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border-4 border-white/80 text-center hover:scale-105 transition-transform">
                    <div class="text-5xl mb-2 animate-wobble">🎁</div>
                    <h3 class="font-black text-xl text-slate-800">Sanduku la Siri</h3>
                    <p class="text-xs text-slate-500 font-bold mt-2 leading-relaxed">
                        Baada ya kumaliza ngazi, mtoto anapasua sanduku la dhahabu mara 3 kulipua nyota, XP na beji!
                    </p>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 5: NAFASI YA MZAZI (AMANI YA MOYO KWA WAZAZI)         --}}
        {{-- ======================================================== --}}
        <section class="bg-white/90 backdrop-blur-md rounded-[3rem] p-8 md:p-12 shadow-2xl border-4 border-white/80">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full">
                        Kwa Wazazi
                    </span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-800 mt-3">Ufuatiliaji Kamili Mikononi Mwako</h2>
                    <p class="text-slate-600 font-semibold mt-3 text-base leading-relaxed">
                        Kama mzazi, huna haja ya kubahatisha ikiwa mtoto anaelewa au anabofya ovyo. Utapata ripoti kamili inayokuruhusu kuona:
                    </p>
                    <ul class="space-y-2.5 mt-4 text-slate-700 font-bold text-sm">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 text-lg">✓</span> Asilimia ya usahihi (Accuracy %) na kasi ya kujibu.
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 text-lg">✓</span> Historia ya kila swali na jibu alilotoa mtoto hatua kwa hatua.
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 text-lg">✓</span> Rekodi za siku mfululizo alizojifunza (Daily streak 🔥).
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-emerald-50 to-green-100 p-6 rounded-3xl border-2 border-emerald-200 text-center shadow-inner">
                    <div class="text-6xl mb-2">📊</div>
                    <div class="font-black text-2xl text-slate-800">Ripoti ya Mzazi</div>
                    <p class="text-xs text-slate-500 font-semibold mt-1">Saa za Afrika Mashariki (EAT)</p>
                    <div class="grid grid-cols-3 gap-2 mt-5 text-center">
                        <div class="bg-white p-3 rounded-2xl shadow-sm"><b class="text-xl text-emerald-700">100%</b><small class="block text-slate-400 text-[10px]">Usahihi</small></div>
                        <div class="bg-white p-3 rounded-2xl shadow-sm"><b class="text-xl text-amber-600">⭐ 25</b><small class="block text-slate-400 text-[10px]">Nyota</small></div>
                        <div class="bg-white p-3 rounded-2xl shadow-sm"><b class="text-xl text-blue-600">🔥 7</b><small class="block text-slate-400 text-[10px]">Siku mfululizo</small></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- BLOCK 6: WITO MKUU WA MWISHO (FINAL BOTTOM CALL TO ACTION) --}}
        {{-- ======================================================== --}}
        <section class="text-center">
            <div class="bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500 text-white rounded-[3rem] p-10 md:p-14 shadow-2xl relative overflow-hidden">
                <div class="text-6xl mb-3 animate-bounce">🍎 ✨ 🏆</div>
                <h2 class="text-3xl md:text-5xl font-black max-w-2xl mx-auto leading-tight">
                    Mpe Mtoto Wako Furaha ya Kupenda Hisabati Leo!
                </h2>
                <p class="text-emerald-100 font-bold text-base md:text-xl max-w-xl mx-auto mt-3">
                    Ni bure, hakuna kadi ya benki wala utata. Jiunge na wazazi wengine wanaomsaidia mtoto kuwa bingwa wa namba.
                </p>

                <div class="mt-8">
                    @guest
                        <a href="{{ route('register') }}" class="inline-block bg-white hover:bg-slate-50 text-slate-900 font-black text-xl md:text-2xl px-12 py-5 rounded-3xl shadow-[0_8px_0_#0f766e] active:translate-y-2 active:shadow-none transition-all cursor-pointer">
                            Jifunze Sasa — Fungua Bure! ➔
                        </a>
                        <p class="mt-4 text-emerald-100 font-semibold text-sm">
                            Tayari una akaunti? <a href="{{ route('login') }}" class="text-white underline font-black">Ingia hapa</a>
                        </p>
                    @else
                        <a href="{{ route('players') }}" class="inline-block bg-white hover:bg-slate-50 text-slate-900 font-black text-xl md:text-2xl px-12 py-5 rounded-3xl shadow-[0_8px_0_#0f766e] active:translate-y-2 active:shadow-none transition-all cursor-pointer">
                            Cheza Sasa na Mtoto Wako ➔
                        </a>
                    @endguest
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="pt-8 text-center text-slate-500 font-bold text-sm flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-200/60">
            <div class="flex items-center gap-2">
                <span class="text-xl">🍎</span>
                <span class="font-black text-slate-700">Fruit Math</span>
                <span>© {{ date('Y') }}</span>
            </div>
            <div class="flex items-center gap-2 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full shadow-sm border border-slate-200/60 text-xs">
                <span class="text-slate-400">Lugha / Language:</span>
                <a href="{{ route('language', 'sw') }}" class="px-2.5 py-0.5 rounded-full {{ app()->getLocale() === 'sw' ? 'bg-emerald-600 text-white font-black' : 'hover:text-slate-900' }}">Kiswahili</a>
                <a href="{{ route('language', 'en') }}" class="px-2.5 py-0.5 rounded-full {{ app()->getLocale() === 'en' ? 'bg-emerald-600 text-white font-black' : 'hover:text-slate-900' }}">English</a>
            </div>
        </footer>

    </div>
</div>