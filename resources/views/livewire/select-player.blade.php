<div class="relative overflow-hidden min-h-screen p-4 sm:p-6 md:p-8">
    <x-animated-landscape world="fruit-garden" />

    <div class="relative z-10 max-w-3xl mx-auto text-center pt-4 sm:pt-8 md:pt-10">
        {{-- Top Bar with Home, Language Switcher & Logout --}}
        <div class="flex items-center justify-between mb-3 sm:mb-4">
            <a href="{{ route('home') }}"
               class="bg-white/90 hover:bg-white backdrop-blur px-3.5 sm:px-4 py-2 rounded-2xl font-display font-black text-xs text-slate-700 shadow-sm border border-white/80 hover:scale-105 active:scale-95 transition flex items-center gap-1.5">
                <span>🏠</span>
                <span>{{ app()->getLocale() === 'sw' ? 'Mwanzo' : 'Home' }}</span>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
                   class="bg-white/90 hover:bg-white backdrop-blur px-3.5 sm:px-4 py-2 rounded-2xl font-display font-black text-xs text-slate-700 shadow-sm border border-white/80 hover:scale-105 active:scale-95 transition flex items-center gap-1.5"
                   title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
                    <span>🌐</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-white/90 hover:bg-rose-50 text-slate-700 hover:text-rose-600 backdrop-blur px-3.5 sm:px-4 py-2 rounded-2xl font-display font-black text-xs shadow-sm border border-white/80 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 cursor-pointer"
                            title="{{ app()->getLocale() === 'sw' ? 'Toka kwenye akaunti' : 'Log out' }}">
                        <span>🚪</span>
                        <span>{{ app()->getLocale() === 'sw' ? 'Toka' : 'Log out' }}</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="text-5xl sm:text-6xl select-none animate-bounce mb-3">🍎</div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-display font-black text-slate-800 tracking-tight">
            {{ app()->getLocale() === 'sw' ? 'Nani anayecheza? 👋' : 'Who is playing? 👋' }}
        </h1>
        <p class="text-slate-600 font-semibold text-sm sm:text-base mt-2">
            {{ app()->getLocale() === 'sw' ? 'Chagua mtoto kuanza au ongeza mchezaji mpya!' : 'Select a child or add a new player!' }}
        </p>

        {{-- Child Player Selection Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mt-6 sm:mt-8">
            @foreach($children as $child)
                <button wire:click="select({{ $child->id }})" class="bg-white/95 backdrop-blur-md rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl border-4 border-white/90 hover:scale-[1.03] active:scale-95 transition-all cursor-pointer group text-center flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-gradient-to-tr from-amber-100 to-yellow-200 grid place-items-center text-5xl sm:text-6xl shadow-inner group-hover:scale-110 transition-transform">
                        {{ $child->avatar ?: '🧒🏾' }}
                    </div>
                    <div class="text-2xl sm:text-3xl font-display font-black text-slate-800 mt-4">{{ $child->name }}</div>
                    <div class="text-slate-600 font-bold mt-2 text-xs sm:text-sm bg-slate-100/90 py-1.5 px-4 rounded-full inline-block border border-slate-200/60">
                        Level {{ $child->current_level }} · <span class="text-amber-500">⭐ {{ $child->stars }}</span> · <span class="text-emerald-600 font-black">{{ $child->xp }} XP</span>
                    </div>
                    <div class="mt-4 sm:mt-5 text-emerald-600 font-display font-black text-sm sm:text-base group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                        <span>Cheza Sasa</span>
                        <span>➔</span>
                    </div>
                </button>
            @endforeach
        </div>

        {{-- Add Child Profile Form --}}
        <form wire:submit="addChild" class="bg-white/95 backdrop-blur-xl rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl border-4 border-white/90 mt-8 max-w-xl mx-auto text-left">
            <h2 class="text-lg sm:text-xl font-display font-black text-slate-800 mb-3 sm:mb-4 flex items-center gap-2">
                <span class="text-xl">➕</span>
                <span>Ongeza Mtoto (Add a child)</span>
            </h2>
            <div class="flex flex-col sm:flex-row gap-3">
                <input wire:model="name" placeholder="Jina la mtoto (Child’s name)" aria-label="Child’s name" class="flex-1 min-h-[50px] px-4 py-3 rounded-2xl border-2 border-slate-200/90 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-400/20 focus:outline-none bg-slate-50/80 font-bold text-slate-800 text-sm sm:text-base placeholder:font-normal" required>
                <select wire:model="language" aria-label="Language" class="min-h-[50px] px-4 py-3 rounded-2xl border-2 border-slate-200/90 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-400/20 focus:outline-none bg-slate-50/80 font-display font-black text-slate-700 text-sm sm:text-base">
                    <option value="en">English</option>
                    <option value="sw">Kiswahili</option>
                </select>
            </div>
            <button type="submit" class="w-full mt-4 min-h-[54px] px-6 py-3 rounded-2xl bg-gradient-to-b from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white font-display font-black text-base sm:text-lg shadow-[0_6px_0_#065f46] active:translate-y-1.5 active:shadow-none transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Ongeza Mtoto</span>
                <span class="text-lg">➔</span>
            </button>
        </form>
    </div>
</div>
