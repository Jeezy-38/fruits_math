<div class="max-w-6xl mx-auto p-6">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800">Fruit Math Admin</h1>
            <p class="text-slate-500">Platform overview and curriculum status.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.curriculum') }}" class="inline-block font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-2xl transition">Manage curriculum →</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-white hover:bg-rose-50 border border-slate-200 text-slate-600 hover:text-rose-600 font-bold px-4 py-2 rounded-2xl transition shadow-sm">Log out</button>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($stats as $label=>$value)
            <div class="bg-white rounded-3xl p-6 shadow">
                <div class="text-3xl font-black text-slate-800">{{ number_format($value) }}</div>
                <div class="capitalize text-slate-500 font-bold text-sm">{{ $label }}</div>
            </div>
        @endforeach
    </div>
</div>