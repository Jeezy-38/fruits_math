<div class="relative overflow-hidden min-h-screen p-5">
    <x-animated-landscape world="fruit-garden" />

    <div class="relative z-10 max-w-3xl mx-auto pb-12">
        {{-- Header Bar (NO <nav> tag) --}}
        <header class="flex justify-between items-center">
            <a href="{{ route('child.home') }}" class="bg-white/90 backdrop-blur rounded-full w-12 h-12 grid place-items-center shadow font-bold hover:scale-105 transition" title="{{ app()->getLocale() === 'sw' ? 'Rudi Nyumbani' : 'Back Home' }}">
                ←
            </a>
            <h1 class="text-xl sm:text-2xl font-black bg-white/80 backdrop-blur px-6 py-2 rounded-full shadow-sm text-slate-800">
                🗺️ {{ app()->getLocale() === 'sw' ? 'Ramani ya Safari' : 'Adventure Map' }}
            </h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
                   class="bg-white/90 hover:bg-white backdrop-blur px-3.5 py-2 rounded-full shadow text-xs font-black text-slate-700 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 border border-white/60">
                    <span>🌐</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
                </a>
                <div class="bg-white/90 backdrop-blur px-4 sm:px-5 py-2 rounded-full font-black text-amber-500 shadow">
                    ⭐ {{ $child->stars }}
                </div>
            </div>
        </header>

        {{-- Adventure Worlds & Levels --}}
        @foreach($worlds as $world)
            <section class="py-10 text-center">
                <div class="text-6xl drop-shadow-md">{{ $world->icon }}</div>
                <h2 class="text-3xl font-black text-slate-900 mt-2">{{ $world->name }}</h2>
                <p class="text-slate-600 font-semibold mt-1">{{ $world->description }}</p>

                <div class="mt-8 flex flex-col items-center gap-5">
                    @foreach($world->levels as $level)
                        @php
                            $p = $level->progress->first();
                            $unlocked = $level->level_number <= $child->current_level;
                        @endphp
                        <a @if($unlocked) href="{{ route('game.level', $level) }}" @endif
                           class="{{ $unlocked ? 'bg-white/95 backdrop-blur shadow-xl hover:scale-105 border-2 border-white' : 'bg-slate-200/80 backdrop-blur opacity-60' }} w-64 rounded-3xl p-5 transition-all block">
                            <div class="text-5xl">{{ $unlocked ? $level->icon : '🔒' }}</div>
                            <div class="font-black text-xl mt-2 text-slate-800">{{ $level->name }}</div>
                            <div class="text-sm text-slate-500 font-bold">Level {{ $level->level_number }}</div>
                            @if($p)
                                <div class="mt-2 text-amber-400 text-lg">
                                    @for($i = 1; $i <= 3; $i++)
                                        {{ $i <= $p->stars ? '⭐' : '☆' }}
                                    @endfor
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach

        {{-- ======================================================== --}}
        {{-- SPECIAL ARENA: KISIWA CHA MITIHANI MCHANGANYIKO          --}}
        {{-- ======================================================== --}}
        <section class="py-10 text-center">
            <div class="text-6xl drop-shadow-md animate-bounce">🏰</div>
            <h2 class="text-3xl font-black text-slate-900 mt-2">
                {{ app()->getLocale() === 'sw' ? 'Kisiwa cha Mitihani Mchanganyiko' : 'Grand Quiz Arena' }}
            </h2>
            <p class="text-slate-600 font-semibold mt-1 max-w-lg mx-auto text-sm">
                {{ app()->getLocale() === 'sw'
                    ? 'Mitihani mikuu inayochanganya kadi zote 11 za mchezo kupima ubingwa wako!'
                    : 'The grand multi-card quizzes uniting all 11 fruit math cards to test your mastery!' }}
            </p>

            @if($hasCompletedAll)
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl mx-auto text-left">
                    @foreach($quizzes as $quiz)
                        @php
                            $sessions = $completedQuizzes[$quiz['key']] ?? collect();
                            $bestStars = 0;
                            if ($sessions->isNotEmpty()) {
                                foreach ($sessions as $s) {
                                    $pct = $s->total_questions > 0 ? round($s->correct_answers / $s->total_questions * 100) : 0;
                                    $stars = $pct >= 90 ? 3 : ($pct >= 75 ? 2 : ($pct >= 60 ? 1 : 0));
                                    $bestStars = max($bestStars, $stars);
                                }
                            }
                        @endphp
                        <a href="{{ route('game.quiz', $quiz['key']) }}"
                           class="bg-white/95 backdrop-blur shadow-xl hover:scale-105 border-2 border-white rounded-3xl p-5 transition-all block">
                            <div class="flex items-center gap-3">
                                <div class="text-4xl">{{ $quiz['icon'] }}</div>
                                <div>
                                    <div class="font-black text-base text-slate-800">{{ $quiz['title'] }}</div>
                                    <div class="text-[11px] text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded-full inline-block mt-0.5">
                                        {{ $quiz['badge'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-500">{{ $quiz['questions_count'] }} {{ app()->getLocale() === 'sw' ? 'maswali' : 'questions' }}</span>
                                @if($bestStars > 0)
                                    <div class="text-amber-400 text-sm">
                                        @for($i = 1; $i <= 3; $i++)
                                            {{ $i <= $bestStars ? '⭐' : '☆' }}
                                        @endfor
                                    </div>
                                @else
                                    <span class="text-xs font-black text-emerald-600">CHEZA ▶</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="mt-8 max-w-md mx-auto bg-slate-200/80 backdrop-blur rounded-3xl p-6 border-2 border-dashed border-slate-300 opacity-75">
                    <div class="text-4xl mb-2">🔒</div>
                    <div class="font-black text-lg text-slate-700">
                        {{ app()->getLocale() === 'sw' ? 'Kisiwa Kimefungwa' : 'Arena Locked' }}
                    </div>
                    <p class="text-xs text-slate-500 font-bold mt-1">
                        {{ app()->getLocale() === 'sw'
                            ? "Kamilisha michezo yote $totalCount ya matunda kwenye ramani ili kufungua Kisiwa cha Mitihani Mchanganyiko! ($completedCount / $totalCount)"
                            : "Complete all $totalCount fruit math games on the map to unlock the Grand Quiz Arena! ($completedCount / $totalCount)" }}
                    </p>
                </div>
            @endif
        </section>
    </div>
</div>
