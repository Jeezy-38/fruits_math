<div class="relative overflow-hidden min-h-screen p-4 md:p-8">
    <x-animated-landscape world="fruit-garden" />

    <div class="relative z-10 max-w-3xl mx-auto text-center pt-6 md:pt-10">
        <div class="flex justify-end mb-2">
            <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
               class="bg-white/90 hover:bg-white backdrop-blur px-4 py-2 rounded-2xl font-black text-xs text-slate-700 shadow border border-white/60 hover:scale-105 active:scale-95 transition flex items-center gap-1.5"
               title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
                <span>🌐</span>
                <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
            </a>
        </div>
        <div class="text-6xl select-none animate-bounce mb-2">🍎</div>
        <h1 class="text-4xl md:text-5xl font-black text-slate-800">{{ app()->getLocale() === 'sw' ? 'Nani anayecheza? 👋' : 'Who is playing? 👋' }}</h1>
        <p class="text-slate-600 font-bold mt-1">{{ app()->getLocale() === 'sw' ? 'Chagua mtoto au ongeza mchezaji mpya!' : 'Select a child or add a new player!' }}</p>

        {{-- Child Player Selection Cards --}}
        <div class="grid sm:grid-cols-2 gap-6 mt-8">
            @foreach($children as $child)
                <button wire:click="select({{ $child->id }})" class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-8 shadow-2xl border-4 border-white/90 hover:scale-105 active:scale-95 transition-all cursor-pointer group text-center">
                    <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-tr from-amber-100 to-yellow-200 grid place-items-center text-7xl shadow-inner group-hover:scale-110 transition-transform">
                        {{ $child->avatar ?: '🧒🏾' }}
                    </div>
                    <div class="text-2xl md:text-3xl font-black text-slate-800 mt-4">{{ $child->name }}</div>
                    <div class="text-slate-500 font-bold mt-2 text-sm bg-slate-50 py-1.5 px-4 rounded-full inline-block">
                        Level {{ $child->current_level }} · <span class="text-amber-500">⭐ {{ $child->stars }}</span> · <span class="text-emerald-600">{{ $child->xp }} XP</span>
                    </div>
                    <div class="mt-5 text-emerald-600 font-black text-sm group-hover:translate-x-1 transition-transform">
                        Cheza Sasa ➔
                    </div>
                </button>
            @endforeach
        </div>

        {{-- Add Child Profile Form --}}
        <form wire:submit="addChild" class="bg-white/90 backdrop-blur-md rounded-[2.5rem] p-6 md:p-8 shadow-xl border-4 border-white/80 mt-8 max-w-xl mx-auto text-left">
            <h2 class="text-xl font-black text-slate-800 mb-3 flex items-center gap-2">
                <span>➕</span>
                <span>Ongeza Mtoto (Add a child)</span>
            </h2>
            <div class="flex flex-col sm:flex-row gap-3">
                <input wire:model="name" placeholder="Jina la mtoto (Child’s name)" aria-label="Child’s name" class="flex-1 p-3.5 rounded-2xl border-2 border-slate-200 focus:border-emerald-500 focus:outline-none bg-slate-50/80 font-medium" required>
                <select wire:model="language" aria-label="Language" class="p-3.5 rounded-2xl border-2 border-slate-200 focus:border-emerald-500 focus:outline-none bg-slate-50/80 font-bold text-slate-700">
                    <option value="en">English</option>
                    <option value="sw">Kiswahili</option>
                </select>
            </div>
            <button class="w-full mt-4 p-4 rounded-2xl bg-gradient-to-b from-green-500 to-green-600 hover:from-green-400 hover:to-green-500 text-white font-black text-lg shadow-[0_6px_0_#15803d] active:translate-y-1.5 active:shadow-none transition-all">
                Ongeza Mtoto ➔
            </button>
        </form>
    </div>
</div>
