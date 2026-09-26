<div class="relative overflow-hidden min-h-screen p-4 sm:p-6 md:p-8">
    <x-animated-landscape world="fruit-garden" />
    <div class="relative z-10 max-w-4xl mx-auto pb-16">
        {{-- Child Header (NO <nav> tag) --}}
        <header class="flex flex-wrap justify-between items-center py-3 sm:py-4 gap-3">
            <div class="font-display font-black text-xl sm:text-2xl flex items-center gap-2 text-slate-800">
                <a href="{{ route('players') }}" class="hover:opacity-80 transition flex items-center gap-2" title="{{ app()->getLocale() === 'sw' ? 'Badili mchezaji' : 'Switch player' }}">
                    <span class="text-2xl">🍎</span>
                    <span>Fruit Math</span>
                </a>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
                   class="bg-white/95 hover:bg-white backdrop-blur px-3 sm:px-3.5 py-1.5 sm:py-2 rounded-full shadow text-xs font-display font-black text-slate-700 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 border border-white/80"
                   title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
                    <span>🌐</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
                </a>
                <div class="bg-white/95 backdrop-blur px-4 sm:px-5 py-1.5 sm:py-2 rounded-full shadow font-display font-black text-xs sm:text-sm flex items-center gap-2.5 sm:gap-3 border border-white/80">
                    <span title="Daily streak" class="text-orange-600">🔥 {{ $child->current_streak }}</span>
                    <span class="text-slate-200">|</span>
                    <span title="Total stars" class="text-amber-500">⭐ {{ $child->stars }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-white/95 hover:bg-rose-50 text-slate-700 hover:text-rose-600 backdrop-blur px-3 py-1.5 sm:py-2 rounded-full shadow text-xs font-display font-black border border-white/80 hover:scale-105 active:scale-95 transition flex items-center gap-1 cursor-pointer"
                            title="{{ app()->getLocale() === 'sw' ? 'Toka kwenye akaunti' : 'Log out' }}">
                        <span>🚪</span>
                        <span class="hidden sm:inline">{{ app()->getLocale() === 'sw' ? 'Toka' : 'Log out' }}</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Profile Header & Avatar Picker --}}
        <div class="mt-4 sm:mt-6 bg-white/95 backdrop-blur-xl rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 shadow-xl border-4 border-white/90">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3.5 sm:gap-4">
                    <button wire:click="toggleAvatarPicker" type="button" class="relative group cursor-pointer focus:outline-none" title="Bonyeza kubadili avatar">
                        <div class="w-18 h-18 sm:w-22 sm:h-22 bg-gradient-to-tr from-yellow-200 via-amber-100 to-yellow-100 rounded-3xl grid place-items-center text-4xl sm:text-5xl shadow-md border-2 border-white group-hover:scale-105 transition-transform">
                            {{ $child->avatar ?: '🧒🏾' }}
                        </div>
                        <span class="absolute -bottom-1 -right-1 bg-emerald-600 text-white text-xs px-2 py-0.5 rounded-full font-display font-black shadow border border-white">
                            ✏️
                        </span>
                    </button>
                    <div>
                        <p class="text-slate-500 text-xs sm:text-sm font-semibold">Welcome back,</p>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-display font-black text-slate-800 tracking-tight">{{ $child->name }}! 👋</h1>
                    </div>
                </div>
                <button wire:click="toggleAvatarPicker" type="button" class="bg-amber-100 hover:bg-amber-200 text-amber-950 px-4 py-2 rounded-2xl text-xs sm:text-sm font-display font-black transition active:scale-95 cursor-pointer border border-amber-200">
                    Badili Avatar ✨
                </button>
            </div>

            {{-- Avatar Selection Popover / Modal --}}
            @if($showAvatarPicker)
                <div class="mt-6 pt-6 border-t border-slate-100 animate-pop">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-display font-black text-slate-700 text-sm sm:text-base">Chagua mhusika wako unayempenda:</h3>
                        <button wire:click="toggleAvatarPicker" type="button" class="text-slate-400 hover:text-slate-600 font-bold text-xs sm:text-sm cursor-pointer">✕ Funga</button>
                    </div>
                    <div class="flex flex-wrap gap-2.5 sm:gap-3">
                        @foreach(App\Livewire\Child\ChildHome::AVATARS as $av)
                            <button wire:click="selectAvatar('{{ $av }}')" type="button" class="w-12 h-12 sm:w-14 sm:h-14 text-2xl sm:text-3xl rounded-2xl grid place-items-center transition-all duration-150 active:scale-90 cursor-pointer {{ $child->avatar === $av ? 'bg-amber-200 ring-4 ring-amber-400 scale-110 shadow' : 'bg-slate-50 hover:bg-amber-50 hover:scale-105' }}">
                                {{ $av }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- XP Progress Bar --}}
            <div class="mt-6">
                <div class="flex justify-between font-display font-black text-xs sm:text-sm text-slate-700">
                    <span>Level {{ $child->current_level }}</span>
                    <span class="text-emerald-600">{{ $child->xp }} XP</span>
                </div>
                <div class="h-3.5 sm:h-4 bg-slate-100 rounded-full mt-2 overflow-hidden shadow-inner border border-slate-200/50">
                    <div class="h-full bg-gradient-to-r from-emerald-400 via-teal-400 to-green-500 rounded-full transition-all duration-500" style="width:{{ min(100, $child->xp % 100) }}%"></div>
                </div>
            </div>
        </div>

        {{-- Next Level Card (If still progressing) --}}
        @if($next)
            <div class="mt-6 sm:mt-8 bg-gradient-to-r from-amber-300 via-yellow-300 to-amber-400 rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl relative overflow-hidden border-4 border-yellow-200">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6">
                    <div>
                        <div class="text-[11px] sm:text-xs font-display font-black uppercase tracking-wider text-amber-950 bg-white/50 inline-block px-3 py-1 rounded-full border border-white/60">
                            {{ app()->getLocale() === 'sw' ? 'Endelea na safari yako' : 'Continue your journey' }}
                        </div>
                        <div class="flex items-center gap-3.5 sm:gap-4 mt-3">
                            <div class="text-5xl sm:text-6xl drop-shadow-md animate-bounce">{{ $next->icon }}</div>
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-display font-black text-slate-900">{{ $next->name }}</h2>
                                <p class="text-amber-950 font-bold text-xs sm:text-sm mt-0.5">Level {{ $next->level_number }} · {{ app()->getLocale() === 'sw' ? 'Shinda nyota na XP mpya!' : 'Win stars and XP!' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('game.level', $next) }}" class="w-full md:w-auto inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white font-display font-black text-lg sm:text-xl px-8 sm:px-10 py-4 sm:py-5 rounded-2xl sm:rounded-3xl shadow-xl transition-all duration-150 active:scale-95 cursor-pointer">
                            PLAY ▶
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- ======================================================== --}}
        {{-- GRAND MIXED QUIZZES SECTION (COMBINES ALL CARDS)        --}}
        {{-- ======================================================== --}}
        <section class="mt-8 sm:mt-10">
            @if($hasCompletedAll)
                {{-- Champion Congratulations Hero Banner --}}
                <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-green-600 rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl text-white relative overflow-hidden border-4 border-emerald-300 animate-pop">
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
                        <div class="space-y-2">
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur px-3.5 py-1 rounded-full text-xs font-display font-black tracking-wider uppercase">
                                <span>🏆</span>
                                <span>{{ app()->getLocale() === 'sw' ? 'Bingwa Mkuu wa Fruit Math!' : 'Grand Fruit Math Champion!' }}</span>
                            </div>
                            <h2 class="text-2xl sm:text-3xl md:text-4xl font-display font-black tracking-tight leading-snug">
                                {{ app()->getLocale() === 'sw' ? 'Hureee! Umecheza Michezo Yote!' : 'Hooray! You Played All Games!' }} 🎉
                            </h2>
                            <p class="text-emerald-100 font-semibold text-xs sm:text-sm max-w-xl">
                                {{ app()->getLocale() === 'sw'
                                    ? 'Sasa jaribu mitihani hii mikuu mchanganyiko inayounganisha maswali ya kadi zote 11 za mchezo kupima ubingwa wako!'
                                    : 'Now challenge yourself with these grand mixed quizzes combining questions from all 11 fruit math cards!' }}
                            </p>
                        </div>
                        <div class="text-6xl sm:text-7xl animate-bounce">
                            👑
                        </div>
                    </div>
                </div>
            @else
                {{-- Teaser / Milestone Card when Incomplete --}}
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-7 shadow-lg border-2 border-white/80">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-amber-100 grid place-items-center text-3xl sm:text-4xl shadow-inner">
                                🔒
                            </div>
                            <div>
                                <h3 class="font-display font-black text-lg sm:text-xl text-slate-800">
                                    {{ app()->getLocale() === 'sw' ? 'Mitihani Mchanganyiko ya Kadi Zote' : 'Grand Multi-Card Mixed Quizzes' }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-0.5">
                                    {{ app()->getLocale() === 'sw'
                                        ? "Cheza michezo yote $totalCount ili kufungua mitihani hii inayochanganya kadi zote!"
                                        : "Complete all $totalCount games to unlock multi-card mixed quizzes!" }}
                                </p>
                            </div>
                        </div>
                        <div class="bg-amber-50 px-4 py-2 rounded-2xl border border-amber-200 text-center">
                            <span class="text-xs font-bold text-slate-500 block">{{ app()->getLocale() === 'sw' ? 'Maendeleo:' : 'Progress:' }}</span>
                            <span class="font-display font-black text-amber-700 text-base sm:text-lg">{{ $completedCount }} / {{ $totalCount }}</span>
                        </div>
                    </div>
                    <div class="mt-4 h-3 bg-slate-100 rounded-full overflow-hidden shadow-inner border border-slate-200/50">
                        <div class="h-full bg-gradient-to-r from-amber-400 to-yellow-400 rounded-full transition-all duration-500" style="width:{{ ($completedCount / max(1, $totalCount)) * 100 }}%"></div>
                    </div>
                </div>
            @endif

            {{-- 4 Combined Quizzes Grid --}}
            <div class="mt-4 sm:mt-6">
                <div class="flex items-center justify-between mb-3 px-1">
                    <h3 class="font-display font-black text-slate-800 text-lg sm:text-xl flex items-center gap-2">
                        <span>🎯</span>
                        <span>{{ app()->getLocale() === 'sw' ? 'Chagua Mtihani Mchanganyiko:' : 'Select a Mixed Quiz:' }}</span>
                    </h3>
                    <span class="text-xs font-bold text-slate-500">
                        {{ count($quizzes) }} {{ app()->getLocale() === 'sw' ? 'Mitihani Tofauti' : 'Quizzes' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                    @foreach($quizzes as $quiz)
                        @php
                            $sessions = $completedQuizzes[$quiz['key']] ?? collect();
                            $bestStars = 0;
                            $bestScore = 0;
                            if ($sessions->isNotEmpty()) {
                                foreach ($sessions as $s) {
                                    $pct = $s->total_questions > 0 ? round($s->correct_answers / $s->total_questions * 100) : 0;
                                    $stars = $pct >= 90 ? 3 : ($pct >= 75 ? 2 : ($pct >= 60 ? 1 : 0));
                                    $bestStars = max($bestStars, $stars);
                                    $bestScore = max($bestScore, $pct);
                                }
                            }
                        @endphp

                        <div class="bg-white/95 backdrop-blur-xl rounded-3xl p-5 sm:p-6 shadow-md border-2 border-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between {{ $hasCompletedAll ? 'hover:scale-[1.02]' : 'opacity-75' }}">
                            <div>
                                <div class="flex items-start justify-between gap-3">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-tr {{ $quiz['theme']['card_bg'] }} shadow-md grid place-items-center text-3xl sm:text-4xl border-2 border-white">
                                        {{ $quiz['icon'] }}
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-display font-black bg-amber-100 text-amber-900 border border-amber-200 shadow-xs">
                                            {{ $quiz['badge'] }}
                                        </span>
                                        @if($bestStars > 0)
                                            <div class="mt-1.5 text-amber-500 font-bold text-sm">
                                                @for($i = 1; $i <= 3; $i++)
                                                    {{ $i <= $bestStars ? '⭐' : '☆' }}
                                                @endfor
                                                <span class="text-xs text-slate-500 ml-1">({{ $bestScore }}%)</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3.5">
                                    <h4 class="font-display font-black text-lg sm:text-xl text-slate-900">
                                        {{ $quiz['title'] }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1 leading-relaxed">
                                        {{ $quiz['description'] }}
                                    </p>
                                </div>

                                <div class="mt-3 flex flex-wrap gap-1.5 text-[11px] font-bold text-slate-700">
                                    <span class="bg-slate-100 px-2.5 py-1 rounded-xl">📝 {{ $quiz['questions_count'] }} {{ app()->getLocale() === 'sw' ? 'Maswali' : 'Questions' }}</span>
                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-xl font-black">+{{ $quiz['reward'] }} XP</span>
                                    <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-xl font-black">⭐ {{ $quiz['stars'] }} Nyota</span>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-slate-100">
                                @if($hasCompletedAll)
                                    <a href="{{ route('game.quiz', $quiz['key']) }}"
                                       class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r {{ $quiz['theme']['card_bg'] }} text-slate-950 font-display font-black text-sm sm:text-base py-3 sm:py-3.5 rounded-2xl shadow-md hover:brightness-105 active:scale-95 transition cursor-pointer border border-white/60">
                                        <span>🎮 {{ app()->getLocale() === 'sw' ? 'CHEZA QUIZ' : 'PLAY QUIZ' }}</span>
                                        <span>➔</span>
                                    </a>
                                @else
                                    <button type="button" disabled
                                            class="w-full inline-flex items-center justify-center gap-2 bg-slate-100 text-slate-400 font-display font-bold text-sm py-3 rounded-2xl cursor-not-allowed">
                                        <span>🔒 {{ app()->getLocale() === 'sw' ? 'Imefungwa (Kamilisha michezo yote)' : 'Locked (Finish all games)' }}</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Adventure Map Link --}}
        <a href="{{ route('world.map') }}" class="block mt-6 sm:mt-8 bg-white/95 hover:bg-white p-4 sm:p-5 rounded-3xl shadow-md font-display font-black text-center text-slate-800 text-base sm:text-lg border-2 border-white/90 transition-transform hover:scale-[1.01] active:scale-95">
            🗺️ {{ app()->getLocale() === 'sw' ? 'Tazama Ramani ya Safari (Adventure Map)' : 'View Adventure Map' }}
        </a>

        {{-- 🏆 Kabati la Vikombe na Beji (Badges & Trophies Showcase) --}}
        <section class="mt-8 sm:mt-10">
            <div class="flex flex-wrap items-center justify-between mb-4 gap-2">
                <div>
                    <h2 class="text-xl sm:text-2xl font-display font-black text-slate-800 flex items-center gap-2">
                        <span>🏆</span>
                        <span>Kabati la Tuzo na Beji</span>
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm font-semibold">Beji ulizoshinda na malengo ya kufungua beji mpya!</p>
                </div>
                <div class="bg-white/90 px-3.5 py-1.5 rounded-full text-xs font-display font-black text-slate-700 shadow-sm border border-slate-200/60">
                    {{ count($earnedIds) }} / {{ $achievements->count() }} Zimefunguliwa
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5 sm:gap-4">
                @foreach($achievements as $ach)
                    @php($isEarned = in_array($ach->id, $earnedIds, true))
                    <div class="rounded-3xl p-4 sm:p-5 shadow transition-all {{ $isEarned ? 'bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 border-2 border-yellow-300' : 'bg-white/70 border border-slate-200 opacity-65' }}">
                        <div class="flex items-start gap-3.5">
                            <div class="text-3xl sm:text-4xl p-2.5 sm:p-3 rounded-2xl {{ $isEarned ? 'bg-white shadow-sm border border-yellow-200' : 'bg-slate-100 grayscale' }}">
                                {{ $ach->icon }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-display font-black text-sm sm:text-base text-slate-800 truncate">
                                    {{ $ach->name }}
                                </div>
                                <div class="text-xs text-slate-600 font-semibold mt-0.5 leading-snug">
                                    {{ $ach->description }}
                                </div>
                                @if($isEarned)
                                    <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-display font-black text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                        <span>✓ Imefunguliwa!</span>
                                        <span>+{{ $ach->xp_reward }} XP</span>
                                    </div>
                                @else
                                    <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                        <span>🔒 Lengo: {{ $ach->target }} {{ $ach->type === 'stars' ? 'Nyota' : 'Ngazi' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>