{{-- Decorative floating fruits for the background. Purely visual: not focusable,
     not announced to screen readers, and never placed over anything a child
     needs to count (counting/addition visuals stay static on purpose). --}}
<div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
    @foreach ([['🍎','6%','8%','0s','6s'],['🍌','78%','6%','1.1s','7.5s'],['🍊','12%','72%','2s','6.5s'],['🥭','86%','68%','0.5s','8s'],['🍓','46%','14%','1.6s','5.5s'],['🍇','58%','82%','2.4s','7s']] as [$fruit,$left,$top,$delay,$duration])
        <span class="absolute text-4xl md:text-5xl opacity-30 animate-float select-none" style="left:{{ $left }};top:{{ $top }};animation-delay:{{ $delay }};animation-duration:{{ $duration }}">{{ $fruit }}</span>
    @endforeach
</div>
