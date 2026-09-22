@props(['mood' => 'idle'])

<div id="game-mascot-container" class="flex items-center justify-center gap-3 my-2 select-none" data-mood="{{ $mood }}">
    {{-- Animated Mascot Character --}}
    <div id="game-mascot-character" class="relative w-20 h-20 md:w-24 md:h-24 animate-mascot-breathe cursor-pointer transition-transform duration-300 hover:scale-110 active:scale-95" title="Mascot Kiko!">
        <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-lg">
            {{-- Ears --}}
            <circle cx="20" cy="40" r="14" fill="#d97706"/>
            <circle cx="20" cy="40" r="9" fill="#fde68a"/>
            <circle cx="80" cy="40" r="14" fill="#d97706"/>
            <circle cx="80" cy="40" r="9" fill="#fde68a"/>

            {{-- Main Head (Warm Friendly Monkey / Bear Character) --}}
            <ellipse cx="50" cy="50" rx="38" ry="36" fill="#f59e0b"/>

            {{-- Cheerful Face Patch --}}
            <ellipse cx="50" cy="58" rx="26" ry="22" fill="#fef3c7"/>
            <circle cx="40" cy="42" r="16" fill="#fef3c7"/>
            <circle cx="60" cy="42" r="16" fill="#fef3c7"/>

            {{-- Big Expressive Eyes --}}
            <g id="mascot-eyes">
                <ellipse cx="42" cy="42" rx="6" ry="8" fill="#1e293b"/>
                <circle cx="40" cy="39" r="2.5" fill="#ffffff"/>
                <circle cx="44" cy="45" r="1" fill="#ffffff"/>

                <ellipse cx="58" cy="42" rx="6" ry="8" fill="#1e293b"/>
                <circle cx="56" cy="39" r="2.5" fill="#ffffff"/>
                <circle cx="60" cy="45" r="1" fill="#ffffff"/>
            </g>

            {{-- Star Eyes (Hidden by default, shown during celebration) --}}
            <g id="mascot-star-eyes" class="hidden">
                <text x="36" y="47" font-size="16" text-anchor="middle">⭐</text>
                <text x="64" y="47" font-size="16" text-anchor="middle">⭐</text>
            </g>

            {{-- Cute Nose & Smile --}}
            <ellipse cx="50" cy="54" rx="4" ry="2.8" fill="#78350f"/>
            <path id="mascot-mouth" d="M 44 60 Q 50 67 56 60" stroke="#78350f" stroke-width="2.5" fill="#f43f5e" stroke-linecap="round"/>

            {{-- Rosy Cheeks --}}
            <circle cx="32" cy="56" r="4.5" fill="#f43f5e" opacity="0.45"/>
            <circle cx="68" cy="56" r="4.5" fill="#f43f5e" opacity="0.45"/>

            {{-- Little Fruit Hat / Leaf --}}
            <path d="M 50 14 Q 58 4 68 10 Q 58 20 50 16 Z" fill="#22c55e"/>
            <circle cx="50" cy="15" r="3.5" fill="#dc2626"/>
        </svg>

        {{-- Jump / Sparkle Particles --}}
        <div id="mascot-sparkle" class="hidden absolute -top-2 -right-2 text-2xl animate-pop">✨</div>
    </div>

    {{-- Mascot Interactive Speech Bubble --}}
    <div class="relative bg-white/95 backdrop-blur-md border-2 border-amber-300 rounded-2xl px-4 py-2.5 shadow-md max-w-xs transition-all duration-300">
        {{-- Triangle indicator pointing to mascot --}}
        <div class="absolute top-1/2 -left-2 -translate-y-1/2 w-0 h-0 border-t-[7px] border-t-transparent border-b-[7px] border-b-transparent border-r-[8px] border-r-amber-300"></div>
        <p id="mascot-speech" class="text-sm md:text-base font-black text-slate-800 leading-tight">
            Tupige hesabu! Hesabu vizuri! 🍎✨
        </p>
    </div>
</div>

<script>
(() => {
    const praises = [
        "💥 WOW! Safi sana! 🚀",
        "🌟 BINGWA! Umepatia! 🏆",
        "🎉 Noma sana! Una akili! 🧠",
        "⭐ SUPER! Kazi nzuri mno! ✨"
    ];
    const encourages = [
        "💪 Uko karibu! Jaribu tena! 💛",
        "🌱 Usijali, jaribu hesabu tena! ✨",
        "🧐 Angalia vizuri, unaweza! 🍎"
    ];

    function updateMascot(type) {
        const mascot = document.getElementById('game-mascot-character');
        const speech = document.getElementById('mascot-speech');
        const normalEyes = document.getElementById('mascot-eyes');
        const starEyes = document.getElementById('mascot-star-eyes');
        const sparkle = document.getElementById('mascot-sparkle');
        if (!mascot || !speech) return;

        if (type === 'correct') {
            mascot.classList.remove('animate-mascot-breathe');
            mascot.classList.add('animate-mascot-jump');
            if (normalEyes) normalEyes.classList.add('hidden');
            if (starEyes) starEyes.classList.remove('hidden');
            if (sparkle) sparkle.classList.remove('hidden');
            speech.textContent = praises[Math.floor(Math.random() * praises.length)];
            speech.className = "text-sm md:text-base font-black text-emerald-700 leading-tight animate-pop";

            setTimeout(() => {
                mascot.classList.remove('animate-mascot-jump');
                mascot.classList.add('animate-mascot-breathe');
                if (normalEyes) normalEyes.classList.remove('hidden');
                if (starEyes) starEyes.classList.add('hidden');
                if (sparkle) sparkle.classList.add('hidden');
            }, 1800);
        } else if (type === 'wrong') {
            speech.textContent = encourages[Math.floor(Math.random() * encourages.length)];
            speech.className = "text-sm md:text-base font-black text-amber-700 leading-tight animate-pop";
        }
    }

    window.addEventListener('fx:correct', () => updateMascot('correct'));
    window.addEventListener('fx:wrong', () => updateMascot('wrong'));
    window.addEventListener('fx:victory', () => updateMascot('correct'));
})();
</script>
