<div class="relative overflow-hidden min-h-screen p-4 md:p-8">
    <x-animated-landscape world="fruit-garden" />

    <div class="relative z-10 max-w-5xl mx-auto">
        {{-- Header Card --}}
        <header class="bg-white/90 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-xl border border-white/70 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('parent.dashboard') }}"
                   class="inline-flex items-center gap-2 font-black text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100/80 px-4 py-2 rounded-2xl text-sm transition">
                    <span>←</span>
                    <span>Parent Dashboard</span>
                </a>

                {{-- Language Switcher --}}
                <a href="{{ route('language', app()->getLocale() === 'sw' ? 'en' : 'sw') }}"
                   class="bg-white hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-2xl font-black text-xs shadow border border-slate-200/80 hover:scale-105 active:scale-95 transition flex items-center gap-1.5">
                    <span>🌐</span>
                    <span>{{ app()->getLocale() === 'sw' ? 'English' : 'Kiswahili' }}</span>
                </a>
            </div>

            <div class="mt-4 flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-2xl grid place-items-center text-4xl shadow-sm border-2 border-white">
                    {{ $child->avatar ?: '🧒🏾' }}
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-800">
                        {{ $child->name }} — Historia ya michezo
                    </h1>
                    <p class="text-slate-600 text-sm mt-1">
                        Maswali yaliyojibiwa na majibu yaliyohifadhiwa. Saa zinaonyeshwa kwa Afrika Mashariki (EAT).
                    </p>
                </div>
            </div>
        </header>

        {{-- Game Sessions List --}}
        <div class="space-y-5">
            @forelse($sessions as $session)
                <section wire:key="history-{{ $session->id }}" class="bg-white/95 backdrop-blur-md rounded-3xl p-6 shadow-lg border border-white/80 hover:shadow-xl transition">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-3 border-b border-slate-100">
                        <div>
                            <h2 class="text-lg md:text-xl font-black text-slate-800">
                                {{ $session->settings['title'] ?? ucfirst($session->operation) }}
                            </h2>
                            <p class="text-xs font-semibold text-slate-500 mt-0.5">
                                🕒 {{ $session->started_at->timezone('Africa/Dar_es_Salaam')->format('d M Y, H:i') }} EAT
                            </p>
                        </div>
                        <span class="font-black px-3 py-1 rounded-full text-xs {{ $session->completed_at ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                            {{ $session->completed_at ? 'Umekamilika' : 'Haujakamilika' }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 mt-4 text-sm text-slate-700">
                        <span class="bg-slate-100 px-3 py-1 rounded-xl">
                            Majibu: <strong>{{ $session->attempts->count() }}/{{ $session->total_questions }}</strong>
                        </span>
                        <span class="bg-emerald-50 text-emerald-800 px-3 py-1 rounded-xl">
                            Sahihi: <strong>{{ $session->attempts->where('is_correct', true)->count() }}</strong>
                        </span>
                        @if($session->completed_at)
                            <span class="bg-amber-50 text-amber-800 px-3 py-1 rounded-xl">
                                Alama: <strong>{{ $session->score }}</strong>
                            </span>
                            <span class="bg-purple-50 text-purple-800 px-3 py-1 rounded-xl">
                                XP: <strong>{{ $session->xp_earned }}</strong>
                            </span>
                        @endif
                    </div>

                    <details class="mt-4 pt-3 border-t border-slate-100 group">
                        <summary class="cursor-pointer font-black text-emerald-700 hover:text-emerald-800 text-sm flex items-center gap-2 select-none">
                            <span>🔍</span>
                            <span>Angalia maswali na majibu</span>
                        </summary>

                        @if($session->attempts->isEmpty())
                            <p class="mt-3 text-slate-500 text-sm italic">
                                Hakuna jibu lililohifadhiwa kwenye mchezo huu.
                            </p>
                        @else
                            <div class="overflow-x-auto mt-4 rounded-2xl border border-slate-100">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-50 font-black text-slate-600 text-xs uppercase tracking-wider">
                                        <tr>
                                            <th class="p-3">#</th>
                                            <th class="p-3">Swali</th>
                                            <th class="p-3">Jibu la mtoto</th>
                                            <th class="p-3">Jibu sahihi</th>
                                            <th class="p-3">Matokeo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($session->attempts as $attempt)
                                            @php
                                                $q = $attempt->question_data ?? [];
                                                $symbols = ['addition' => '+', 'subtraction' => '−', 'multiplication' => '×', 'division' => '÷', 'comparison' => '?'];
                                            @endphp
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="p-3 font-bold text-slate-500">{{ $attempt->question_number ?? $loop->iteration }}</td>
                                                <td class="p-3 min-w-48">
                                                    <div class="text-slate-700 text-xs">{{ $q['instruction'] ?? ucfirst($attempt->operation) }}</div>
                                                    <div class="font-black text-slate-900 mt-1">
                                                        @if(isset($symbols[$attempt->operation]))
                                                            {{ $q['left'] ?? '—' }} {{ $symbols[$attempt->operation] }} {{ $q['right'] ?? '—' }}
                                                        @elseif($attempt->operation === 'counting')
                                                            Matunda: {{ $q['left'] ?? '—' }}
                                                        @elseif($attempt->operation === 'fractions')
                                                            Sehemu zilizopakwa: {{ $q['numerator'] ?? '—' }} / {{ $q['denominator'] ?? '—' }}
                                                        @elseif($attempt->operation === 'time')
                                                            Saa: {{ $q['hour'] ?? '—' }}:{{ sprintf('%02d', $q['minute'] ?? 0) }}
                                                        @elseif($attempt->operation === 'shapes')
                                                            {{ $q['shape'] ?? '—' }}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="p-3 font-black text-slate-800">{{ $attempt->given_answer ?? '—' }}</td>
                                                <td class="p-3 font-bold text-slate-600">{{ $attempt->expected_answer }}</td>
                                                <td class="p-3 font-black {{ $attempt->is_correct ? 'text-emerald-700' : 'text-red-600' }}">
                                                    {{ $attempt->is_correct ? '✓ Sahihi' : '✗ Si sahihi' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </details>
                </section>
            @empty
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 text-center shadow-lg border border-white">
                    <p class="font-bold text-slate-600">Mtoto huyu bado hajaanza mchezo.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $sessions->links() }}</div>
    </div>
</div>
