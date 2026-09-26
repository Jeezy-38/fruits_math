<div class="relative overflow-hidden min-h-screen p-4 sm:p-6 md:p-8">
    <x-animated-landscape world="fruit-garden" />

    <div class="relative z-10 max-w-6xl mx-auto pb-12">
        {{-- Top Header (NO <nav> tag) --}}
        <header class="bg-white/95 backdrop-blur-xl rounded-3xl p-5 sm:p-6 shadow-xl border-2 border-white/80 mb-6 sm:mb-8 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-3.5 text-center sm:text-left">
                <span class="text-4xl sm:text-5xl">👨‍👩‍👧‍👦</span>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-display font-black text-slate-800">
                        {{ app()->getLocale() === 'sw' ? 'Dashibodi ya Mzazi' : 'Parent Dashboard' }}
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 font-semibold mt-0.5">
                        {{ app()->getLocale() === 'sw' ? 'Fuatilia maendeleo ya mtoto kwa urahisi.' : 'Follow learning progress at a glance.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 w-full sm:w-auto">
                {{-- Language Switcher Toggle --}}
                <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
                   class="bg-white hover:bg-slate-50 text-slate-700 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-2xl font-display font-black text-xs sm:text-sm shadow-sm border border-slate-200 hover:scale-105 active:scale-95 transition flex items-center gap-1.5"
                   title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
                    <span class="text-base sm:text-lg">🌐</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
                </a>

                {{-- Play Game Button --}}
                <a href="{{ route('players') }}"
                   class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white px-5 sm:px-6 py-2 sm:py-2.5 rounded-2xl font-display font-black text-xs sm:text-sm shadow-md shadow-emerald-500/20 hover:scale-105 active:scale-95 transition flex items-center gap-1.5">
                    <span class="text-base sm:text-lg">🎮</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'Cheza' : 'Play' }}</span>
                </a>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-white hover:bg-rose-50 text-slate-600 hover:text-rose-600 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-2xl font-display font-black text-xs sm:text-sm shadow-sm border border-slate-200 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 cursor-pointer"
                            title="{{ app()->getLocale() === 'sw' ? 'Toka kwenye akaunti' : 'Log out' }}">
                        <span>🚪</span>
                        <span>{{ app()->getLocale() === 'sw' ? 'Toka' : 'Log out' }}</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Children Profiles Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
            @forelse($children as $child)
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl border-4 border-white/90 hover:shadow-2xl transition duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-18 h-18 sm:w-20 sm:h-20 bg-gradient-to-br from-amber-100 to-orange-100 rounded-3xl grid place-items-center text-4xl sm:text-5xl shadow-md border-2 border-white">
                            {{ $child->avatar ?: '🧒🏾' }}
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-black text-slate-800">{{ $child->name }}</h2>
                            <div class="flex flex-wrap items-center gap-2 mt-1.5 text-xs sm:text-sm font-bold text-slate-600">
                                <span class="bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                    {{ app()->getLocale() === 'sw' ? 'Ngazi' : 'Level' }} {{ $child->current_level }}
                                </span>
                                <span class="bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded-full border border-amber-200">
                                    ⭐ {{ $child->stars }}
                                </span>
                                <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full border border-purple-200 font-display font-black">
                                    ✨ {{ $child->xp }} XP
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Analytics Stats --}}
                    <div class="grid grid-cols-3 gap-2.5 sm:gap-3 mt-6 text-center">
                        <div class="bg-slate-50/90 backdrop-blur rounded-2xl p-3 sm:p-4 border border-slate-200/60 shadow-sm">
                            <b class="text-xl sm:text-2xl md:text-3xl font-display font-black text-emerald-600">{{ $child->analytics['accuracy'] }}%</b>
                            <small class="block text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">
                                {{ app()->getLocale() === 'sw' ? 'Usahihi' : 'Accuracy' }}
                            </small>
                        </div>
                        <div class="bg-slate-50/90 backdrop-blur rounded-2xl p-3 sm:p-4 border border-slate-200/60 shadow-sm">
                            <b class="text-xl sm:text-2xl md:text-3xl font-display font-black text-blue-600">{{ $child->analytics['questions'] }}</b>
                            <small class="block text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">
                                {{ app()->getLocale() === 'sw' ? 'Maswali' : 'Questions' }}
                            </small>
                        </div>
                        <div class="bg-slate-50/90 backdrop-blur rounded-2xl p-3 sm:p-4 border border-slate-200/60 shadow-sm">
                            <b class="text-xl sm:text-2xl md:text-3xl font-display font-black text-orange-500">🔥 {{ $child->analytics['streak'] }}</b>
                            <small class="block text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">
                                {{ app()->getLocale() === 'sw' ? 'Mfululizo' : 'Streak' }}
                            </small>
                        </div>
                    </div>

                    {{-- History & Answers Link --}}
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('parent.history', $child) }}"
                           class="inline-flex items-center gap-2 font-display font-black text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100/80 px-4 py-2 rounded-2xl text-xs sm:text-sm transition">
                            <span>📊</span>
                            <span>Historia ya michezo na majibu →</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 bg-white/95 backdrop-blur-xl rounded-3xl sm:rounded-[2.5rem] p-8 sm:p-12 text-center shadow-xl border-4 border-white/90">
                    <div class="text-5xl sm:text-6xl mb-3">👶</div>
                    <h3 class="text-xl sm:text-2xl font-display font-black text-slate-800">
                        {{ app()->getLocale() === 'sw' ? 'Bado hakuna wasifu wa watoto.' : 'No child profiles yet.' }}
                    </h3>
                    <p class="text-slate-600 mt-2 text-sm sm:text-base font-semibold max-w-md mx-auto">
                        {{ app()->getLocale() === 'sw' ? 'Anza kwa kuongeza mtoto ili aanze kujifunza hisabati kupitia michezo!' : 'Get started by adding a child to begin learning math through games!' }}
                    </p>
                    <a href="{{ route('players') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 rounded-2xl bg-emerald-600 text-white font-display font-black text-sm sm:text-base shadow-md hover:bg-emerald-500 transition">
                        <span>➕ Ongeza Mchezaji Sasa</span>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>