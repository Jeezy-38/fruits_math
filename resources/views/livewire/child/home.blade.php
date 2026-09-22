<div class="relative overflow-hidden min-h-screen p-5">
    <x-animated-landscape world="fruit-garden" />
    <div class="relative z-10 max-w-4xl mx-auto pb-12">
        <header class="flex justify-between items-center py-4">
            <div class="font-black text-2xl flex items-center gap-2">
                <span>🍎</span>
                <span>Fruit Math</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
                   class="bg-white/90 hover:bg-white backdrop-blur px-3.5 py-2 rounded-full shadow text-xs font-black text-slate-700 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 border border-white/60"
                   title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
                    <span>🌐</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
                </a>
                <div class="bg-white/90 backdrop-blur px-5 py-2 rounded-full shadow font-black flex items-center gap-3 border border-white/60">
                    <span title="Daily streak">🔥 {{ $child->current_streak }}</span>
                    <span class="text-slate-300">|</span>
                    <span title="Total stars" class="text-amber-500">⭐ {{ $child->stars }}</span>
                </div>
            </div>
        </header>

        {{-- Profile Header & Avatar Picker --}}
        <div class="mt-8 bg-white/90 backdrop-blur rounded-[2rem] p-6 md:p-8 shadow-xl">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button wire:click="toggleAvatarPicker" type="button" class="relative group cursor-pointer focus:outline-none" title="Bonyeza kubadili avatar">
                        <div class="w-20 h-20 bg-gradient-to-tr from-yellow-200 to-amber-100 rounded-3xl grid place-items-center text-5xl shadow-md group-hover:scale-105 transition-transform">
                            {{ $child->avatar ?: '🧒🏾' }}
                        </div>
                        <span class="absolute -bottom-1 -right-1 bg-emerald-600 text-white text-xs px-2 py-0.5 rounded-full font-bold shadow">
                            ✏️
                        </span>
                    </button>
                    <div>
                        <p class="text-slate-500 text-sm font-semibold">Welcome back,</p>
                        <h1 class="text-3xl md:text-4xl font-black text-slate-800">{{ $child->name }}! 👋</h1>
                    </div>
                </div>
                <button wire:click="toggleAvatarPicker" type="button" class="bg-amber-100 hover:bg-amber-200 text-amber-900 px-4 py-2 rounded-2xl text-sm font-black transition active:scale-95">
                    Badili Avatar ✨
                </button>
            </div>

            {{-- Avatar Selection Popover / Modal --}}
            @if($showAvatarPicker)
                <div class="mt-6 pt-6 border-t border-slate-100 animate-pop">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-black text-slate-700">Chagua mhusika wako unayempenda:</h3>
                        <button wire:click="toggleAvatarPicker" type="button" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕ Funga</button>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach(App\Livewire\Child\ChildHome::AVATARS as $av)
                            <button wire:click="selectAvatar('{{ $av }}')" type="button" class="w-14 h-14 text-3xl rounded-2xl grid place-items-center transition-all duration-150 active:scale-90 {{ $child->avatar === $av ? 'bg-amber-200 ring-4 ring-amber-400 scale-110 shadow' : 'bg-slate-50 hover:bg-amber-50 hover:scale-105' }}">
                                {{ $av }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-6">
                <div class="flex justify-between font-bold text-sm text-slate-700">
                    <span>Level {{ $child->current_level }}</span>
                    <span class="text-emerald-600 font-black">{{ $child->xp }} XP</span>
                </div>
                <div class="h-4 bg-slate-100 rounded-full mt-2 overflow-hidden shadow-inner">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-green-500 rounded-full transition-all duration-500" style="width:{{ min(100, $child->xp % 100) }}%"></div>
                </div>
            </div>
        </div>

        {{-- Next Level Card --}}
        @if($next)
            <div class="mt-8 bg-gradient-to-r from-yellow-300 via-amber-300 to-yellow-400 rounded-[2rem] p-8 shadow-xl relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="text-xs font-black uppercase tracking-wider text-amber-900 bg-white/40 inline-block px-3 py-1 rounded-full">Continue your journey</div>
                        <div class="flex items-center gap-4 mt-3">
                            <div class="text-6xl drop-shadow-md animate-bounce">{{ $next->icon }}</div>
                            <div>
                                <h2 class="text-3xl font-black text-slate-900">{{ $next->name }}</h2>
                                <p class="text-amber-900 font-bold">Level {{ $next->level_number }} · Shinda nyota na XP mpya!</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('game.level', $next) }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-black text-xl px-10 py-5 rounded-2xl shadow-xl transition-all duration-150 active:scale-95">
                            PLAY ▶
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Adventure Map Link --}}
        <a href="{{ route('world.map') }}" class="block mt-6 bg-white/90 hover:bg-white p-5 rounded-3xl shadow font-black text-center text-slate-800 text-lg transition-transform hover:scale-[1.01] active:scale-95">
            🗺️ View Adventure Map
        </a>

        {{-- 🏆 Kabati la Vikombe na Beji (Badges & Trophies Showcase) --}}
        <section class="mt-10">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 flex items-center gap-2">
                        <span>🏆</span>
                        <span>Kabati la Tuzo na Beji</span>
                    </h2>
                    <p class="text-slate-600 text-sm">Beji ulizoshinda na malengo ya kufungua beji mpya!</p>
                </div>
                <div class="bg-white/80 px-4 py-1.5 rounded-full text-xs font-black text-slate-700 shadow-sm">
                    {{ count($earnedIds) }} / {{ $achievements->count() }} Zimefunguliwa
                </div>
            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($achievements as $ach)
                    @php($isEarned = in_array($ach->id, $earnedIds, true))
                    <div class="rounded-3xl p-5 shadow transition-all {{ $isEarned ? 'bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 border-2 border-yellow-300' : 'bg-white/60 border border-slate-200 opacity-60' }}">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl p-3 rounded-2xl {{ $isEarned ? 'bg-white shadow-sm' : 'bg-slate-100 grayscale' }}">
                                {{ $ach->icon }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-black text-base text-slate-800 truncate">
                                    {{ $ach->name }}
                                </div>
                                <div class="text-xs text-slate-500 mt-1 leading-snug">
                                    {{ $ach->description }}
                                </div>
                                @if($isEarned)
                                    <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-black text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">
                                        <span>✓ Imefunguliwa!</span>
                                        <span>+{{ $ach->xp_reward }} XP</span>
                                    </div>
                                @else
                                    <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
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