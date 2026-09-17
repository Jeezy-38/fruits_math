<div class="max-w-5xl mx-auto p-4 md:p-6">
    <a href="{{ route('parent.dashboard') }}" class="font-bold text-emerald-700">← Parent Dashboard</a>
    <h1 class="text-3xl font-black mt-5">{{ $child->name }} — Historia ya michezo</h1>
    <p class="text-slate-600 mt-2">Maswali yaliyojibiwa na majibu yaliyohifadhiwa. Saa zinaonyeshwa kwa Afrika Mashariki (EAT).</p>
    <div class="space-y-5 mt-6">
        @forelse($sessions as $session)
            <section wire:key="history-{{ $session->id }}" class="bg-white rounded-3xl p-5 shadow">
                <div class="flex flex-wrap justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold">{{ $session->settings['title'] ?? ucfirst($session->operation) }}</h2>
                        <p class="text-sm text-slate-500">{{ $session->started_at->timezone('Africa/Dar_es_Salaam')->format('d M Y, H:i') }} EAT</p>
                    </div>
                    <span class="font-bold {{ $session->completed_at ? 'text-emerald-700' : 'text-amber-700' }}">{{ $session->completed_at ? 'Umekamilika' : 'Haujakamilika' }}</span>
                </div>
                <p class="mt-3">Majibu: <strong>{{ $session->attempts->count() }}/{{ $session->total_questions }}</strong> · Sahihi: <strong>{{ $session->attempts->where('is_correct', true)->count() }}</strong>
                    @if($session->completed_at) · Alama: <strong>{{ $session->score }}</strong> · XP: <strong>{{ $session->xp_earned }}</strong>@endif
                </p>
                <details class="mt-4">
                    <summary class="cursor-pointer font-bold text-emerald-700">Angalia maswali na majibu</summary>
                    @if($session->attempts->isEmpty())
                        <p class="mt-3 text-slate-500">Hakuna jibu lililohifadhiwa kwenye mchezo huu.</p>
                    @else
                        <div class="overflow-x-auto mt-3">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50"><tr><th class="p-3">#</th><th class="p-3">Swali</th><th class="p-3">Jibu la mtoto</th><th class="p-3">Jibu sahihi</th><th class="p-3">Matokeo</th></tr></thead>
                                <tbody>
                                    @foreach($session->attempts as $attempt)
                                        @php
                                            $q = $attempt->question_data ?? [];
                                            $symbols = ['addition' => '+', 'subtraction' => '−', 'multiplication' => '×', 'division' => '÷', 'comparison' => '?'];
                                        @endphp
                                        <tr class="border-t border-slate-100">
                                            <td class="p-3">{{ $attempt->question_number ?? $loop->iteration }}</td>
                                            <td class="p-3 min-w-48">
                                                <div>{{ $q['instruction'] ?? ucfirst($attempt->operation) }}</div>
                                                <div class="font-bold mt-1">
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
                                            <td class="p-3 font-bold">{{ $attempt->given_answer ?? '—' }}</td>
                                            <td class="p-3">{{ $attempt->expected_answer }}</td>
                                            <td class="p-3 font-bold {{ $attempt->is_correct ? 'text-emerald-700' : 'text-red-700' }}">{{ $attempt->is_correct ? '✓ Sahihi' : '✗ Si sahihi' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </details>
            </section>
        @empty
            <p class="bg-white p-6 rounded-3xl">Mtoto huyu bado hajaanza mchezo.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $sessions->links() }}</div>
</div>
