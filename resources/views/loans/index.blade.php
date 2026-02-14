<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <h2 class="text-2xl font-bold text-white mb-6">Mes Emprunts</h2>

                <!-- Tabs -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @php
                        $tabs = [
                            null => ['label' => 'Tous', 'count' => ($counts['en_cours'] ?? 0) + ($counts['retourne'] ?? 0) + ($counts['en_retard'] ?? 0)],
                            'en_cours' => ['label' => 'En cours', 'count' => $counts['en_cours'] ?? 0],
                            'retourne' => ['label' => 'Retourn&eacute;s', 'count' => $counts['retourne'] ?? 0],
                            'en_retard' => ['label' => 'En Retard', 'count' => $counts['en_retard'] ?? 0],
                        ];
                    @endphp
                    @foreach($tabs as $key => $tab)
                        <a href="{{ route('loans.index', ['filter' => $key]) }}"
                           class="px-5 py-2.5 text-sm font-medium rounded-lg transition flex items-center gap-2
                            {{ ($filter ?? '') == $key ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'bg-slate-900 text-slate-400 hover:bg-white/5 border border-white/10' }}">
                            {!! $tab['label'] !!}
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ ($filter ?? '') == $key ? 'bg-indigo-700 text-indigo-200' : 'bg-slate-700 text-slate-400' }}">
                                {{ $tab['count'] }}
                            </span>
                        </a>
                    @endforeach
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-slate-500 text-xs uppercase border-b border-white/10">
                                <th class="text-left py-3 px-3 font-medium">Livre</th>
                                <th class="text-left py-3 px-3 font-medium">Exemplaire</th>
                                <th class="text-left py-3 px-3 font-medium">Date d'emprunt</th>
                                <th class="text-left py-3 px-3 font-medium">Retour pr&eacute;vu</th>
                                <th class="text-left py-3 px-3 font-medium">Retour effectif</th>
                                <th class="text-left py-3 px-3 font-medium">Statut</th>
                                <th class="text-right py-3 px-3 font-medium">Amendes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                    <td class="py-3 px-3">
                                        <div>
                                            <p class="text-slate-200 font-medium">{{ $loan->copy->book->titre ?? 'N/A' }}</p>
                                            <p class="text-xs text-slate-500">{{ $loan->copy->book->auteur ?? '' }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-slate-400 font-mono text-xs">{{ $loan->copy->code_barre }}</td>
                                    <td class="py-3 px-3 text-slate-400">{{ $loan->date_emprunt->format('d/m/Y') }}</td>
                                    <td class="py-3 px-3 text-slate-400">{{ $loan->date_retour_prevue->format('d/m/Y') }}</td>
                                    <td class="py-3 px-3 text-slate-400">
                                        {{ $loan->date_retour_effective ? $loan->date_retour_effective->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-3">
                                        <x-status-badge :status="$loan->statut" />
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        @if($loan->fines->sum('montant') > 0)
                                            <span class="text-rose-400 font-semibold">{{ number_format($loan->fines->sum('montant'), 2) }} {{ \App\Models\Setting::CURRENCIES[$settings->currency]['symbol'] ?? $settings->currency }}</span>
                                        @else
                                            <span class="text-slate-600">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-500">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Aucun emprunt trouv&eacute;.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
