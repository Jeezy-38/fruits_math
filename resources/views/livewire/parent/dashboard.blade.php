<div class="relative overflow-hidden min-h-screen p-4 md:p-8">
    <x-animated-landscape world="fruit-garden" />

    <div class="relative z-10 max-w-6xl mx-auto">
        {{-- Top Navigation / Header --}}
        <header class="bg-white/85 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/60 mb-8 flex flex-wrap gap-4 items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <span class="text-4xl">👨‍👩‍👧‍👦</span>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black text-slate-800">
                            {{ app()->getLocale() === 'sw' ? 'Dashibodi ya Mzazi' : 'Parent Dashboard' }}
                        </h1>
                        <p class="text-sm md:text-base text-slate-600 font-medium">
                            {{ app()->getLocale() === 'sw' ? 'Fuatilia maendeleo ya mtoto kwa urahisi.' : 'Follow learning progress at a glance.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Language Switcher Toggle --}}
                <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
                   class="bg-white hover:bg-slate-50 text-slate-700 px-4 py-2.5 rounded-2xl font-black text-sm shadow-md border border-slate-200/80 hover:scale-105 active:scale-95 transition flex items-center gap-2"
                   title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
                    <span class="text-lg">🌐</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
                </a>

                {{-- Play Game Button --}}
                <a href="{{ route('players') }}"
                   class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white px-6 py-2.5 rounded-2xl font-black text-sm shadow-lg shadow-emerald-500/30 hover:scale-105 active:scale-95 transition flex items-center gap-2">
                    <span class="text-lg">🎮</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'Cheza' : 'Play' }}</span>
                </a>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-white hover:bg-rose-50 text-slate-600 hover:text-rose-600 px-4 py-2.5 rounded-2xl font-black text-sm shadow-md border border-slate-200/80 hover:scale-105 active:scale-95 transition flex items-center gap-1.5"
                            title="{{ app()->getLocale() === 'sw' ? 'Toka kwenye akaunti' : 'Log out' }}">
                        <span>🚪</span>
                        <span class="hidden sm:inline">{{ app()->getLocale() === 'sw' ? 'Toka' : 'Log out' }}</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Children Profiles Grid --}}
        <div class="grid md:grid-cols-2 gap-6">
            @forelse($children as $child)
                <div class="bg-white/90 backdrop-blur-md rounded-[2.5rem] p-6 md:p-8 shadow-xl border border-white/70 hover:shadow-2xl transition duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-100 to-orange-100 rounded-3xl grid place-items-center text-5xl shadow-md border-2 border-white">
                            {{ $child->avatar ?: '🧒🏾' }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-slate-800">{{ $child->name }}</h2>
                            <div class="flex flex-wrap items-center gap-2 mt-1 text-sm font-bold text-slate-600">
                                <span class="bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full">
                                    {{ app()->getLocale() === 'sw' ? 'Ngazi' : 'Level' }} {{ $child->current_level }}
                                </span>
                                <span class="bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded-full">
                                    ⭐ {{ $child->stars }}
                                </span>
                                <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full">
                                    ✨ {{ $child->xp }} XP
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Analytics Stats --}}
                    <div class="grid grid-cols-3 gap-3 mt-6 text-center">
                        <div class="bg-slate-50/80 backdrop-blur rounded-2xl p-4 border border-slate-100 shadow-sm">
                            <b class="text-2xl md:text-3xl font-black text-emerald-600">{{ $child->analytics['accuracy'] }}%</b>
                            <small class="block text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">
                                {{ app()->getLocale() === 'sw' ? 'Usahihi' : 'Accuracy' }}
                            </small>
                        </div>
                        <div class="bg-slate-50/80 backdrop-blur rounded-2xl p-4 border border-slate-100 shadow-sm">
                            <b class="text-2xl md:text-3xl font-black text-blue-600">{{ $child->analytics['questions'] }}</b>
                            <small class="block text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">
                                {{ app()->getLocale() === 'sw' ? 'Maswali' : 'Questions' }}
                            </small>
                        </div>
                        <div class="bg-slate-50/80 backdrop-blur rounded-2xl p-4 border border-slate-100 shadow-sm">
                            <b class="text-2xl md:text-3xl font-black text-orange-500">🔥 {{ $child->analytics['streak'] }}</b>
                            <small class="block text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">
                                {{ app()->getLocale() === 'sw' ? 'Mfululizo' : 'Streak' }}
                            </small>
                        </div>
                    </div>

                    {{-- History & Answers Link --}}
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('parent.history', $child) }}"
                           class="inline-flex items-center gap-2 font-black text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100/80 px-4 py-2 rounded-2xl text-sm transition">
                            <span>📊</span>
                            <span>Historia ya michezo na majibu →</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 bg-white/90 backdrop-blur-md rounded-[2.5rem] p-10 text-center shadow-xl border border-white">
                    <div class="text-6xl mb-3">👶</div>
                    <h3 class="text-xl font-black text-slate-800">
                        {{ app()->getLocale() === 'sw' ? 'Bado hakuna wasifu wa watoto.' : 'No child profiles yet.' }}
                    </h3>
                    <p class="text-slate-500 mt-2 text-sm font-medium">
                        {{ app()->getLocale() === 'sw' ? 'Anza kwa kuongeza mtoto ili aanze kujifunza hisabati kupitia michezo!' : 'Get started by adding a child to begin learning math through games!' }}
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>