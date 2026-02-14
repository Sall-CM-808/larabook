<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.loans.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-400 hover:text-white mb-6 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour
            </a>
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <h2 class="text-xl font-bold text-white mb-6">Cr&eacute;er un emprunt</h2>

                @if($errors->any())
                    <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm mb-6">
                        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.loans.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm text-slate-400 mb-1">&Eacute;tudiant *</label>
                        <select name="user_id" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                            <option value="">S&eacute;lectionner un &eacute;tudiant...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->matricule }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-1">Livre &amp; Exemplaire *</label>
                        <select name="copy_id" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                            <option value="">S&eacute;lectionner un exemplaire disponible...</option>
                            @foreach($books as $book)
                                @foreach($book->copies as $copy)
                                    <option value="{{ $copy->id }}" {{ old('copy_id') == $copy->id ? 'selected' : '' }}>
                                        {{ $book->titre }} - {{ $copy->code_barre }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="bg-slate-900 border border-white/5 rounded-xl p-4">
                        <p class="text-xs text-slate-500">Dur&eacute;e de l'emprunt : <span class="text-slate-300">{{ $settings->loan_duration_days }} jours</span></p>
                        <p class="text-xs text-slate-500">Maximum d'emprunts actifs : <span class="text-slate-300">{{ $settings->max_active_loans }} par &eacute;tudiant</span></p>
                        <p class="text-xs text-slate-500">P&eacute;nalit&eacute; de retard : <span class="text-slate-300">{{ number_format($settings->fine_per_day, 2, ',', ' ') }} {{ \App\Models\Setting::CURRENCIES[$settings->currency]['symbol'] ?? $settings->currency }} / jour</span></p>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.loans.index') }}" class="px-5 py-2.5 text-sm text-slate-400 hover:text-white transition">Annuler</a>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-lg shadow-indigo-500/25">Cr&eacute;er l'emprunt</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
