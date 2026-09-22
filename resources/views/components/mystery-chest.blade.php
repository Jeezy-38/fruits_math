@props(['passed' => true, 'stars' => 3, 'xp' => 100, 'score' => 100, 'correctCount' => 10, 'totalQuestions' => 10, 'newAchievements' => []])

<div x-data="{
    taps: 0,
    opened: false,
    crack() {
        if (this.opened) return;
        this.taps++;
        if (window.FruitAudio) window.FruitAudio.pop();
        if (this.taps >= 3) {
            this.opened = true;
            window.dispatchEvent(new CustomEvent('fx:victory'));
            window.dispatchEvent(new CustomEvent('fx:confetti'));
        }
    },
    quickOpen() {
        this.opened = true;
        window.dispatchEvent(new CustomEvent('fx:victory'));
        window.dispatchEvent(new CustomEvent('fx:confetti'));
    }
}" class="w-full">
    {{-- UNOPENED MYSTERY CHEST STATE --}}
    <div x-show="!opened" class="py-6 flex flex-col items-center justify-center text-center">
        <div class="inline-block bg-amber-100 text-amber-900 border-2 border-amber-300 font-black text-sm md:text-base px-5 py-2 rounded-full mb-4 shadow-sm animate-bounce">
            🎁 Gusa sanduku mara 3 kulifungua! (Tap to open!)
        </div>

        {{-- Interactive Wobbling Treasure Chest --}}
        <button @click="crack()" type="button" class="relative group cursor-pointer focus:outline-none transition-transform active:scale-90" :class="{ 'animate-wobble': taps > 0 }">
            <div class="text-8xl md:text-9xl drop-shadow-2xl select-none transition-all duration-200 group-hover:scale-105">
                <template x-if="taps === 0"><span>🎁</span></template>
                <template x-if="taps === 1"><span class="animate-pop">📦</span></template>
                <template x-if="taps === 2"><span class="animate-wobble">✨🎁✨</span></template>
            </div>

            {{-- Crack sparks --}}
            <div x-show="taps > 0" class="absolute -top-3 -right-3 text-3xl animate-pop">💥</div>
            <div x-show="taps > 1" class="absolute -bottom-2 -left-3 text-3xl animate-pop">⭐</div>
        </button>

        {{-- Progress Dots --}}
        <div class="flex items-center gap-3 mt-6">
            <span class="w-7 h-7 rounded-full grid place-items-center text-sm font-bold shadow-md transition-all duration-300" :class="taps >= 1 ? 'bg-amber-400 text-amber-950 scale-110' : 'bg-slate-200 text-slate-400'">⭐</span>
            <span class="w-7 h-7 rounded-full grid place-items-center text-sm font-bold shadow-md transition-all duration-300" :class="taps >= 2 ? 'bg-amber-400 text-amber-950 scale-110' : 'bg-slate-200 text-slate-400'">⭐</span>
            <span class="w-7 h-7 rounded-full grid place-items-center text-sm font-bold shadow-md transition-all duration-300" :class="taps >= 3 ? 'bg-amber-400 text-amber-950 scale-110' : 'bg-slate-200 text-slate-400'">⭐</span>
        </div>

        <button @click="quickOpen()" type="button" class="mt-5 text-xs text-slate-400 hover:text-slate-600 underline font-semibold">
            Fungua mara moja (Skip)
        </button>
    </div>

    {{-- OPENED TREASURE CHEST RESULTS --}}
    <div x-show="opened" x-cloak class="animate-pop text-center">
        <div class="text-7xl mb-1 animate-rubber-band">{{ $passed ? '🏆' : '💪' }}</div>
        <h1 class="text-3xl md:text-4xl font-black mt-1 text-slate-800">{{ $passed ? 'Hongera Sana! Umefanikiwa! 🎉' : 'Umejaribu vizuri! Endelea! 💪' }}</h1>

        {{-- Animated Stars Reveal with bouncing drop-depth --}}
        <div class="flex justify-center items-center gap-2 my-4">
            @for($i = 1; $i <= 3; $i++)
                <span class="text-5xl md:text-6xl transition-transform duration-500 select-none {{ $i <= $stars ? 'text-amber-400 drop-shadow-lg animate-pop' : 'text-slate-200' }}" style="animation-delay: {{ $i * 150 }}ms">
                    {{ $i <= $stars ? '⭐' : '☆' }}
                </span>
            @endfor
        </div>

        <div class="text-2xl font-black text-slate-800">{{ $correctCount }}/{{ $totalQuestions }} Sahihi (Correct)</div>
        <div class="text-xl text-slate-600 mt-1 font-bold">Alama: {{ $score }} · <span class="text-emerald-600 font-black">+{{ $xp }} XP</span></div>

        @if($newAchievements)
            <div class="mt-5 flex flex-col items-center gap-2">
                @foreach($newAchievements as $badge)
                    <div class="bg-gradient-to-r from-yellow-200 via-amber-200 to-yellow-300 border-2 border-yellow-400 rounded-2xl px-6 py-3 font-black text-amber-950 shadow-md animate-pop">
                        {{ $badge['icon'] }} {{ $badge['name'] }} imefunguliwa! +{{ $badge['xp_reward'] }} XP
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('child.home') }}" class="inline-block mt-7 bg-gradient-to-b from-green-500 to-green-600 hover:from-green-400 hover:to-green-500 text-white font-black text-xl px-10 py-5 rounded-2xl shadow-[0_8px_0_#15803d] active:translate-y-2 active:shadow-none transition-all">
            Endelea na Safari →
        </a>
    </div>
</div>
