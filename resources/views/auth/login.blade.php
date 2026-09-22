<x-layouts.app>
    <div class="relative overflow-hidden min-h-screen flex items-center justify-center px-4 py-8">
        <x-animated-landscape world="fruit-garden" />

        <form method="POST" action="{{ route('login') }}" class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur-md rounded-[2.5rem] p-8 md:p-10 shadow-2xl border-4 border-white/90">
            @csrf
            <div class="text-center mb-6">
                <div class="text-5xl select-none animate-bounce">🍎</div>
                <h1 class="text-3xl font-black text-slate-800 mt-2">Karibu Tena! 👋</h1>
                <p class="text-slate-500 font-semibold text-sm">Ingia kwenye akaunti ya Fruit Math.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block font-bold text-sm text-slate-700 mb-1">Barua Pepe (Email)</label>
                    <input name="email" value="{{ old('email') }}" class="w-full p-4 rounded-2xl border-2 border-slate-200 focus:border-emerald-500 focus:outline-none bg-slate-50/80 font-medium" type="email" required placeholder="mzazi@mfano.test">
                </div>

                <div>
                    <label class="block font-bold text-sm text-slate-700 mb-1">Nenosiri (Password)</label>
                    <input name="password" class="w-full p-4 rounded-2xl border-2 border-slate-200 focus:border-emerald-500 focus:outline-none bg-slate-50/80 font-medium" type="password" required placeholder="••••••••">
                </div>
            </div>

            @error('email')
                <p class="text-red-500 font-bold text-sm mt-3 bg-red-50 p-3 rounded-xl">{{ $message }}</p>
            @enderror

            <button class="w-full mt-6 p-4 rounded-2xl bg-gradient-to-b from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white font-black text-xl shadow-[0_6px_0_#059669] active:translate-y-1.5 active:shadow-none transition-all">
                Ingia (Sign In) ➔
            </button>

            <a href="{{ route('register') }}" class="block text-center mt-5 text-emerald-700 hover:text-emerald-800 font-bold text-sm">
                Huna akaunti? Fungua akaunti hapa
            </a>

            <a href="{{ route('home') }}" class="block text-center mt-3 text-slate-400 hover:text-slate-600 font-bold text-xs">
                ← Rudi Nyumbani (Home)
            </a>
        </form>
    </div>
</x-layouts.app>