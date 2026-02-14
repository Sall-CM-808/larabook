<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Param&egrave;tres des emprunts</h2>
                        <p class="text-sm text-slate-400">Configurez les r&egrave;gles d'emprunt pour votre biblioth&egrave;que</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm mb-6">
                        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                    @csrf @method('PUT')

                    <!-- Durée d'emprunt -->
                    <div class="bg-slate-900 rounded-xl p-5 border border-white/5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-white mb-1">Dur&eacute;e de l'emprunt</label>
                                <p class="text-xs text-slate-500 mb-3">Nombre de jours accord&eacute;s pour chaque emprunt</p>
                                <div class="flex items-center gap-3">
                                    <input type="number" name="loan_duration_days" value="{{ old('loan_duration_days', $settings->loan_duration_days) }}" min="1" max="365" required
                                           class="w-24 bg-slate-800 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white text-center focus:border-indigo-500/50 focus:outline-none">
                                    <span class="text-sm text-slate-400">jours</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Max emprunts actifs -->
                    <div class="bg-slate-900 rounded-xl p-5 border border-white/5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-violet-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-white mb-1">Maximum d'emprunts actifs</label>
                                <p class="text-xs text-slate-500 mb-3">Nombre maximum d'emprunts simultan&eacute;s par &eacute;tudiant</p>
                                <div class="flex items-center gap-3">
                                    <input type="number" name="max_active_loans" value="{{ old('max_active_loans', $settings->max_active_loans) }}" min="1" max="50" required
                                           class="w-24 bg-slate-800 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white text-center focus:border-indigo-500/50 focus:outline-none">
                                    <span class="text-sm text-slate-400">par &eacute;tudiant</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Devise -->
                    <div class="bg-slate-900 rounded-xl p-5 border border-white/5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-white mb-1">Devise</label>
                                <p class="text-xs text-slate-500 mb-3">Devise utilis&eacute;e pour les amendes et p&eacute;nalit&eacute;s</p>
                                <select name="currency" required
                                        class="w-full bg-slate-800 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:border-indigo-500/50 focus:outline-none">
                                    @foreach(\App\Models\Setting::CURRENCIES as $code => $info)
                                        <option value="{{ $code }}" {{ old('currency', $settings->currency) === $code ? 'selected' : '' }}>
                                            {{ $info['symbol'] }} &mdash; {{ $info['name'] }} ({{ $code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pénalité de retard -->
                    <div class="bg-slate-900 rounded-xl p-5 border border-white/5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-white mb-1">P&eacute;nalit&eacute; de retard</label>
                                <p class="text-xs text-slate-500 mb-3">Montant factur&eacute; par jour de retard</p>
                                <div class="flex items-center gap-3">
                                    <input type="number" name="fine_per_day" value="{{ old('fine_per_day', $settings->fine_per_day) }}" min="0" max="999999" step="0.01" required
                                           class="w-32 bg-slate-800 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white text-center focus:border-indigo-500/50 focus:outline-none">
                                    <span class="text-sm text-slate-400">{{ \App\Models\Setting::CURRENCIES[$settings->currency]['symbol'] ?? $settings->currency }} / jour</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-lg shadow-indigo-500/25">
                            Enregistrer les param&egrave;tres
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
