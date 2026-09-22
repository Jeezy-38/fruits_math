<div data-game-active="{{ $finished ? 'false' : 'true' }}" class="relative overflow-hidden min-h-screen p-3 md:p-5">
    <x-animated-landscape :world="$worldSlug" />

    <div class="relative z-10 max-w-3xl mx-auto">
        {{-- Game Header --}}
        <header class="flex items-center justify-between py-2">
            <a href="{{ route('child.home') }}" class="w-12 h-12 bg-white/90 backdrop-blur rounded-2xl grid place-items-center shadow-md font-black text-slate-700 hover:scale-105 active:scale-95 transition" title="Rudi nyumbani">
                ←
            </a>
            <div class="text-center bg-white/90 backdrop-blur px-6 py-2 rounded-2xl shadow-md border border-white/60">
                <div class="font-black text-xl text-slate-800 flex items-center justify-center gap-1.5">
                    <span>{{ $icon }}</span>
                    <span>{{ $title }}</span>
                </div>
                <div class="text-xs text-slate-500 font-bold tracking-wide">
                    {{ __('game.question') }} {{ $questionNumber }} / {{ $totalQuestions }}
                </div>
            </div>
            <div class="bg-white/90 backdrop-blur px-5 py-2.5 rounded-2xl shadow-md font-black text-amber-500 border border-white/60 flex items-center gap-1 text-lg">
                <span>⭐</span>
                <span>{{ $score }}</span>
            </div>
        </header>

        {{-- Game Controls (Language Switcher & Music) --}}
        <div class="flex items-center justify-between mt-2">
            <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
               class="bg-white/90 hover:bg-white backdrop-blur px-3.5 py-1.5 rounded-full shadow text-xs font-black text-slate-700 hover:scale-105 active:scale-95 transition flex items-center gap-1.5 border border-white/60"
               title="{{ app()->getLocale() === 'sw' ? 'Switch to English' : 'Badili kwenda Kiswahili' }}">
                <span>🌐</span>
                <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
            </a>

            <div wire:ignore class="flex items-center">
                <button type="button" data-music-toggle aria-label="Play background music" aria-pressed="false" class="bg-white/90 backdrop-blur px-4 py-1.5 rounded-full shadow text-xs font-bold text-slate-700 hover:bg-white transition flex items-center gap-1 border border-white/60">
                    <span class="music-icon">🎵</span>
                    <span class="music-label">{{ __('game.music') }}</span>
                </button>
            </div>
        </div>

        {{-- Animated Smooth Progress Bar --}}
        <div class="h-4 bg-white/80 backdrop-blur rounded-full overflow-hidden mt-2 shadow-inner p-0.5 border border-white/60">
            <div class="h-full bg-gradient-to-r from-emerald-400 via-green-500 to-teal-400 rounded-full transition-all duration-500 ease-out shadow-sm" style="width:{{ ($questionNumber/$totalQuestions)*100 }}%"></div>
        </div>

        {{-- Animated Interactive Mascot (Kiko) --}}
        @if(!$finished)
            <div class="mt-4">
                <x-game-mascot />
            </div>
        @endif

        {{-- Main Game Board / Mystery Chest --}}
        @if($finished)
            <div @if($passed) data-celebrate="true" @endif class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-6 md:p-10 shadow-2xl border-4 border-white/90 mt-4">
                <x-mystery-chest
                    :passed="$passed"
                    :stars="$starsEarned"
                    :xp="$xpEarned"
                    :score="$score"
                    :correctCount="$correctCount"
                    :totalQuestions="$totalQuestions"
                    :newAchievements="$newAchievements"
                />
            </div>
        @else
            <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-6 md:p-10 shadow-2xl border-4 border-white/90 mt-3 text-center">
                {{-- Question Instruction with Voice Narration Button 🔊 --}}
                <div class="flex items-center justify-center gap-3">
                    <h2 class="text-xl md:text-2xl font-black text-slate-800">{{ $instruction }}</h2>
                    <button type="button" onclick="window.speakQuestion(@js($instruction))" class="w-10 h-10 rounded-2xl bg-amber-100 hover:bg-amber-200 text-amber-900 grid place-items-center text-lg shadow-sm hover:scale-110 active:scale-90 transition cursor-pointer" title="Sikiliza swali likisomwa">
                        🔊
                    </button>
                </div>

                {{-- Interactive Math Visual Display (Manipulatives) --}}
                <div class="min-h-52 flex flex-col items-center justify-center py-6 text-5xl">
                    @if($operation==='counting')
                        {{-- Interactive Tap-to-Count Fruit Manipulatives --}}
                        <div class="flex flex-col items-center gap-2" x-data="{
                            counts: {},
                            toggle(idx) {
                                if (this.counts[idx]) {
                                    delete this.counts[idx];
                                } else {
                                    this.counts[idx] = Object.keys(this.counts).length + 1;
                                    if (window.FruitAudio) window.FruitAudio.pop();
                                }
                            }
                        }">
                            <div class="flex flex-wrap justify-center gap-4 py-2">
                                @for($i = 0; $i < $left; $i++)
                                    <button type="button" @click="toggle({{ $i }})"
                                        class="relative group cursor-pointer focus:outline-none transition-transform duration-150 active:scale-125"
                                        :class="counts[{{ $i }}] ? 'scale-110' : 'hover:scale-105'">
                                        <span class="text-6xl md:text-7xl block select-none drop-shadow-md">
                                            {{ ['apple'=>'🍎','banana'=>'🍌','orange'=>'🍊','mango'=>'🥭','strawberry'=>'🍓'][$fruit] }}
                                        </span>
                                        <span x-show="counts[{{ $i }}]" x-cloak
                                            class="absolute -top-3 -right-2 bg-gradient-to-tr from-amber-400 to-yellow-300 border-2 border-white text-slate-900 text-xs font-black w-7 h-7 rounded-full shadow-lg grid place-items-center animate-pop"
                                            x-text="counts[{{ $i }}]">
                                        </span>
                                    </button>
                                @endfor
                            </div>
                            <span class="text-xs text-slate-400 font-bold mt-1">{{ __('game.tap_to_count') }}</span>
                        </div>
                    @elseif(in_array($operation,['addition','subtraction']))
                        <div class="flex flex-col items-center gap-2" x-data="{
                            counts: {},
                            toggle(idx) {
                                if (this.counts[idx]) {
                                    delete this.counts[idx];
                                } else {
                                    this.counts[idx] = Object.keys(this.counts).length + 1;
                                    if (window.FruitAudio) window.FruitAudio.pop();
                                }
                            }
                        }">
                            <div class="flex flex-wrap justify-center gap-3">
                                @for($i = 0; $i < $left; $i++)
                                    <button type="button" @click="toggle({{ $i }})" class="relative cursor-pointer transition-transform active:scale-125">
                                        <span class="text-5xl md:text-6xl block select-none drop-shadow-md">
                                            {{ ['apple'=>'🍎','banana'=>'🍌','orange'=>'🍊','mango'=>'🥭','strawberry'=>'🍓'][$fruit] }}
                                        </span>
                                        <span x-show="counts[{{ $i }}]" x-cloak class="absolute -top-2 -right-1 bg-amber-400 text-slate-900 text-[11px] font-black w-6 h-6 rounded-full border border-white shadow grid place-items-center animate-pop" x-text="counts[{{ $i }}]"></span>
                                    </button>
                                @endfor
                            </div>
                            <div class="text-4xl font-black my-2 text-slate-800">{{ $operation==='addition'?'+':'−' }} {{ $right }}</div>
                        </div>
                    @elseif($operation==='multiplication')
                        <div class="flex flex-wrap justify-center gap-4">
                            @for($g=0;$g<$left;$g++)
                                <div class="border-4 border-dashed border-amber-300 rounded-3xl p-3 text-3xl bg-amber-50/60 shadow-inner flex flex-wrap gap-1">
                                    @for($i=0;$i<$right;$i++)
                                        <span class="hover:scale-125 transition-transform">🍓</span>
                                    @endfor
                                </div>
                            @endfor
                        </div>
                    @elseif($operation==='division')
                        <div class="flex flex-col items-center gap-3">
                            <div class="text-5xl drop-shadow-md">🥭 × {{ $left }}</div>
                            <div class="text-3xl font-black text-slate-700">🧺 × {{ $right }} {{ app()->getLocale() === 'sw' ? 'vikapu' : 'baskets' }}</div>
                        </div>
                    @elseif($operation==='fractions')
                        <div class="flex w-full max-w-md h-24 border-4 border-green-700 rounded-2xl overflow-hidden shadow-inner bg-white" role="img" aria-label="{{ $question['numerator'] }} of {{ $question['denominator'] }} equal parts shaded">
                            @for($part=0;$part<$question['denominator'];$part++)
                                <div class="flex-1 border-r-2 last:border-r-0 border-green-700 transition-colors duration-300 {{ $part<$question['numerator']?'bg-gradient-to-b from-red-400 to-red-500':'bg-white' }}"></div>
                            @endfor
                        </div>
                    @elseif($operation==='money')
                        <div>
                            <div class="text-7xl drop-shadow-md">{{ ['apple'=>'🍎','banana'=>'🍌','orange'=>'🍊','mango'=>'🥭','strawberry'=>'🍓'][$fruit] }}</div>
                            <div class="text-3xl font-black mt-3 text-slate-800">TZS {{ number_format($question['price']) }} × {{ $question['quantity'] }}</div>
                        </div>
                    @elseif($operation==='time')
                        <svg viewBox="0 0 200 200" class="w-52 h-52 drop-shadow-lg" role="img" aria-label="Analogue clock: {{ $question['hour'] }}:{{ sprintf('%02d',$question['minute']) }}">
                            <circle cx="100" cy="100" r="94" fill="#fff" stroke="#334155" stroke-width="5"/>
                            @for($tick=1;$tick<=12;$tick++)
                                <text x="{{ 100+76*sin(deg2rad($tick*30)) }}" y="{{ 106-76*cos(deg2rad($tick*30)) }}" text-anchor="middle" font-size="17" font-weight="900" fill="#334155">{{ $tick }}</text>
                            @endfor
                            <line x1="100" y1="100" x2="100" y2="48" stroke="#334155" stroke-width="7" stroke-linecap="round" transform="rotate({{ $question['hour']*30+$question['minute']/2 }} 100 100)"/>
                            <line x1="100" y1="100" x2="100" y2="25" stroke="#059669" stroke-width="4" stroke-linecap="round" transform="rotate({{ $question['minute']*6 }} 100 100)"/>
                            <circle cx="100" cy="100" r="5" fill="#334155"/>
                        </svg>
                    @elseif($operation==='shapes')
                        <div class="text-8xl drop-shadow-md animate-float">{{ ['circle'=>'⚪','triangle'=>'🔺','square'=>'⬜','rectangle'=>'▭','pentagon'=>'⬠','hexagon'=>'⬡'][$question['shape']] ?? '🔷' }}</div>
                    @elseif($operation==='comparison')
                        <div class="font-black text-6xl text-slate-800">{{ $left }} &nbsp; ? &nbsp; {{ $right }}</div>
                    @endif
                </div>

                {{-- Chunky 3D Arcade Buttons --}}
                <div class="grid grid-cols-2 gap-4 max-w-xl mx-auto mt-4">
                    @php
                        $buttonStyles = [
                            0 => ['bg' => 'from-sky-400 to-sky-500', 'border' => 'border-sky-600', 'shadow' => 'shadow-[0_8px_0_#0284c7]'],
                            1 => ['bg' => 'from-purple-400 to-purple-500', 'border' => 'border-purple-600', 'shadow' => 'shadow-[0_8px_0_#7c3aed]'],
                            2 => ['bg' => 'from-emerald-400 to-emerald-500', 'border' => 'border-emerald-600', 'shadow' => 'shadow-[0_8px_0_#059669]'],
                            3 => ['bg' => 'from-amber-400 to-amber-500', 'border' => 'border-amber-600', 'shadow' => 'shadow-[0_8px_0_#d97706]'],
                        ];
                    @endphp
                    @foreach($options as $idx => $option)
                        @php
                            $isSelected = (string)$selectedAnswer === (string)$option;
                            $st = $buttonStyles[$idx % 4];
                        @endphp
                        <button wire:click="answer(@js($option))" @disabled($correct!==null)
                            class="relative p-5 rounded-3xl text-3xl font-black text-white transition-all duration-150 border-2
                            @if($isSelected)
                                {{ $correct ? 'bg-gradient-to-b from-green-400 to-green-600 border-green-700 shadow-[0_8px_0_#15803d] scale-105 animate-pop ring-4 ring-green-300' : 'bg-gradient-to-b from-red-400 to-red-600 border-red-700 shadow-[0_8px_0_#b91c1c] animate-wobble' }}
                            @else
                                bg-gradient-to-b {{ $st['bg'] }} {{ $st['border'] }} {{ $st['shadow'] }} hover:brightness-105 active:translate-y-2 active:shadow-none
                            @endif">
                            @if($operation==='money')
                                TZS {{ number_format((int)$option) }}
                            @else
                                {{ $option }}
                            @endif
                        </button>
                    @endforeach
                </div>

                {{-- Feedback Celebration & Next Question Button --}}
                @if($correct!==null)
                    <div class="mt-6 text-2xl font-black animate-pop {{ $correct?'text-green-600':'text-orange-600' }}">
                        {{ $correct ? '🎉 Excellent! Safi sana! 🌟' : '💪 Almost! The answer is '.$answer }}
                    </div>
                    <button wire:click="nextQuestion" class="mt-5 bg-gradient-to-b from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-slate-900 font-black text-2xl px-10 py-5 rounded-3xl shadow-[0_8px_0_#b45309] active:translate-y-2 active:shadow-none transition-all">
                        {{ $questionNumber===$totalQuestions ? '🎁 Maliza & Fungua Zawadi! ➔' : 'Swali Linalofuata ➔' }}
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
