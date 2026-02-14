<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Gestion des Emprunts</h2>
                    <a href="{{ route('admin.loans.create') }}" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-lg shadow-indigo-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nouvel emprunt
                    </a>
                </div>

                <!-- Search + Filter -->
                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <form method="GET" action="{{ route('admin.loans.index') }}" class="flex-1 flex gap-3">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher par nom, matricule ou titre..."
                               class="flex-1 bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 placeholder-slate-500 focus:border-indigo-500/50 focus:outline-none">
                        @if($filter)<input type="hidden" name="filter" value="{{ $filter }}">@endif
                        <button type="submit" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2.5 rounded-lg text-sm transition">Rechercher</button>
                    </form>
                </div>

                <!-- Tabs -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @php
                        $tabs = [
                            null => ['label' => 'Tous', 'count' => $counts['all']],
                            'en_cours' => ['label' => 'En cours', 'count' => $counts['en_cours']],
                            'en_retard' => ['label' => 'En retard', 'count' => $counts['en_retard']],
                            'retourne' => ['label' => 'Retourn&eacute;s', 'count' => $counts['retourne']],
                        ];
                    @endphp
                    @foreach($tabs as $key => $tab)
                        <a href="{{ route('admin.loans.index', array_merge(request()->only('search'), ['filter' => $key])) }}"
                           class="px-4 py-2 text-sm font-medium rounded-lg transition flex items-center gap-2
                            {{ ($filter ?? '') == $key ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'bg-slate-900 text-slate-400 hover:bg-white/5 border border-white/10' }}">
                            {!! $tab['label'] !!}
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ ($filter ?? '') == $key ? 'bg-indigo-700 text-indigo-200' : 'bg-slate-700 text-slate-400' }}">{{ $tab['count'] }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-slate-500 text-xs uppercase border-b border-white/10">
                                <th class="text-left py-3 px-3 font-medium">Utilisateur</th>
                                <th class="text-left py-3 px-3 font-medium">Livre</th>
                                <th class="text-left py-3 px-3 font-medium">Exemplaire</th>
                                <th class="text-left py-3 px-3 font-medium">Emprunt</th>
                                <th class="text-left py-3 px-3 font-medium">Retour pr&eacute;vu</th>
                                <th class="text-left py-3 px-3 font-medium">Statut</th>
                                <th class="text-right py-3 px-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                    <td class="py-3 px-3">
                                        <p class="text-slate-200 text-sm">{{ $loan->user->name }}</p>
                                        <p class="text-xs text-slate-500 font-mono">{{ $loan->user->matricule }}</p>
                                    </td>
                                    <td class="py-3 px-3 text-slate-300">{{ $loan->copy->book->titre ?? 'N/A' }}</td>
                                    <td class="py-3 px-3 text-slate-400 font-mono text-xs">{{ $loan->copy->code_barre }}</td>
                                    <td class="py-3 px-3 text-slate-400">{{ $loan->date_emprunt->format('d/m/Y') }}</td>
                                    <td class="py-3 px-3 text-slate-400">{{ $loan->date_retour_prevue->format('d/m/Y') }}</td>
                                    <td class="py-3 px-3">
                                        <x-status-badge :status="$loan->statut" />
                                        @if($loan->fines->sum('montant') > 0)
                                            <span class="text-rose-400 text-xs font-medium ml-1">{{ number_format($loan->fines->sum('montant'), 2) }} {{ \App\Models\Setting::CURRENCIES[$settings->currency]['symbol'] ?? $settings->currency }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        @if($loan->statut !== 'retourne')
                                            <form method="POST" action="{{ route('admin.loans.return', $loan) }}" onsubmit="return confirm('Confirmer le retour ?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-3 py-1.5 rounded text-xs font-medium transition">
                                                    Retour
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-600">{{ $loan->date_retour_effective?->format('d/m/Y') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="py-12 text-center text-slate-500">Aucun emprunt.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($loans->hasPages())
                    <div class="mt-4">{{ $loans->appends(request()->query())->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
