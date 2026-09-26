<x-layouts.app>
    <div class="relative overflow-hidden min-h-screen flex items-center justify-center px-4 py-8 sm:py-12">
        <x-animated-landscape world="fruit-garden" />

        <form method="POST" action="{{ route('register') }}" class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-xl rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border-4 border-white/90">
            @csrf
            <div class="text-center mb-6 sm:mb-8">
                <div class="text-5xl sm:text-6xl select-none animate-bounce mb-2">🚀</div>
                <h1 class="text-2xl sm:text-3xl font-display font-black text-slate-800 tracking-tight">
                    Jiunge na Fruit Math!
                </h1>
                <p class="text-slate-500 font-semibold text-xs sm:text-sm mt-1">
                    Fungua akaunti ya mzazi kwa sekunde chache.
                </p>
            </div>

            <div class="space-y-3.5">
                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-700 mb-1">Jina Lako (Your Name)</label>
                    <input name="name" value="{{ old('name') }}" placeholder="Mfano: Mzazi Juma" class="w-full min-h-[52px] px-4 py-3 rounded-2xl border-2 border-slate-200/90 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-400/20 focus:outline-none bg-slate-50/80 font-bold text-slate-800 text-base placeholder:font-normal placeholder:text-slate-400 transition" required>
                </div>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-700 mb-1">Barua Pepe (Email)</label>
                    <input name="email" value="{{ old('email') }}" type="email" placeholder="mzazi@mfano.test" class="w-full min-h-[52px] px-4 py-3 rounded-2xl border-2 border-slate-200/90 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-400/20 focus:outline-none bg-slate-50/80 font-bold text-slate-800 text-base placeholder:font-normal placeholder:text-slate-400 transition" required>
                </div>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-700 mb-1">Nenosiri (Password)</label>
                    <input name="password" type="password" placeholder="Angalau herufi 8" class="w-full min-h-[52px] px-4 py-3 rounded-2xl border-2 border-slate-200/90 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-400/20 focus:outline-none bg-slate-50/80 font-bold text-slate-800 text-base placeholder:font-normal placeholder:text-slate-400 transition" required>
                </div>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-700 mb-1">Thibitisha Nenosiri (Confirm Password)</label>
                    <input name="password_confirmation" type="password" placeholder="Rudia nenosiri lako" class="w-full min-h-[52px] px-4 py-3 rounded-2xl border-2 border-slate-200/90 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-400/20 focus:outline-none bg-slate-50/80 font-bold text-slate-800 text-base placeholder:font-normal placeholder:text-slate-400 transition" required>
                </div>
            </div>

            @if($errors->any())
                <div class="text-rose-700 font-bold text-xs sm:text-sm mt-3.5 bg-rose-50 border border-rose-200 p-3 rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="w-full mt-6 sm:mt-7 min-h-[56px] px-6 py-3.5 rounded-2xl bg-gradient-to-b from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white font-display font-black text-lg sm:text-xl shadow-[0_6px_0_#065f46] active:translate-y-1.5 active:shadow-none transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Fungua Akaunti (Create Account)</span>
                <span class="text-xl">➔</span>
            </button>

            <a href="{{ route('login') }}" class="block text-center mt-5 text-emerald-700 hover:text-emerald-800 font-bold text-xs sm:text-sm">
                Tayari una akaunti? <span class="underline font-black">Ingia hapa</span>
            </a>

            <a href="{{ route('home') }}" class="block text-center mt-3 text-slate-400 hover:text-slate-600 font-bold text-xs transition">
                ← Rudi Nyumbani (Home)
            </a>
        </form>
    </div>
</x-layouts.app>