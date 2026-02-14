<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                <!-- ════════ LEFT: Catalogue des Livres ════════ -->
                <div class="lg:col-span-3 bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                    <h2 class="text-xl font-bold text-white mb-4">Catalogue des Livres</h2>

                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher..."
                                   class="w-full bg-slate-900 border border-white/10 rounded-lg pl-10 pr-10 py-2.5 text-sm text-slate-300 placeholder-slate-500 focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/30 focus:outline-none">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4 text-slate-500 hover:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="hidden" name="filter_by" value="{{ $filterBy ?? 'titre' }}">
                        @if(isset($filter))
                            <input type="hidden" name="loan_filter" value="{{ $filter }}">
                        @endif
                    </form>

                    <!-- Filter Tabs: Titre / Auteur / Catégorie -->
                    <div class="flex gap-4 mb-5">
                        @foreach(['titre' => 'Titre', 'auteur' => 'Auteur', 'categorie' => 'Cat&eacute;gorie'] as $key => $label)
                            <a href="{{ route('dashboard', array_merge(request()->query(), ['filter_by' => $key])) }}"
                               class="text-sm font-medium pb-1 border-b-2 transition {{ ($filterBy ?? 'titre') === $key ? 'text-indigo-400 border-indigo-400' : 'text-slate-500 border-transparent hover:text-slate-300' }}">
                                {!! $label !!}
                            </a>
                        @endforeach
                    </div>

                    <!-- Books Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @forelse($books as $book)
                            <x-book-card :book="$book" />
                        @empty
                            <div class="col-span-full text-center py-8 text-slate-500">
                                Aucun livre trouv&eacute;.
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                        <div class="mt-4 flex justify-center">
                            {{ $books->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>

                <!-- ════════ RIGHT: Mes Emprunts ════════ -->
                <div class="lg:col-span-2 bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                    <h2 class="text-xl font-bold text-white mb-4">Mes Emprunts</h2>

                    <!-- Loan Filter Tabs -->
                    <div class="flex gap-2 mb-5">
                        @php
                            $loanFilters = [
                                null => 'Tous',
                                'en_cours' => 'En cours',
                                'retourne' => 'Retourn&eacute;s',
                                'en_retard' => 'En Retard',
                            ];
                        @endphp
                        @foreach($loanFilters as $key => $label)
                            <a href="{{ route('dashboard', array_merge(request()->query(), ['loan_filter' => $key])) }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg transition
                                {{ ($filter ?? '') == $key ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'bg-slate-900 text-slate-400 hover:bg-white/5 border border-white/10' }}">
                                {!! $label !!}
                            </a>
                        @endforeach
                    </div>

                    <!-- Loans Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-slate-500 text-xs uppercase border-b border-white/10">
                                    <th class="text-left py-3 font-medium">Titre</th>
                                    <th class="text-left py-3 font-medium">Date d'emprunt</th>
                                    <th class="text-left py-3 font-medium">Retour pr&eacute;vu</th>
                                    <th class="text-right py-3 font-medium">Amendes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loans as $loan)
                                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                        <td class="py-3">
                                            <div class="flex items-center gap-2">
                                                <span class="text-slate-200">{{ $loan->copy->book->titre ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-slate-400">{{ $loan->date_emprunt->format('d/m/Y') }}</td>
                                        <td class="py-3 text-slate-400">{{ $loan->date_retour_prevue->format('d/m/Y') }}</td>
                                        <td class="py-3 text-right">
                                            @if($loan->statut === 'en_retard')
                                                <div class="flex flex-col items-end gap-1">
                                                    <x-status-badge status="en_retard" />
                                                    @if($loan->fines->sum('montant') > 0)
                                                        <span class="text-rose-400 font-medium">{{ number_format($loan->fines->sum('montant'), 2) }} {{ \App\Models\Setting::CURRENCIES[$settings->currency]['symbol'] ?? $settings->currency }}</span>
                                                    @endif
                                                </div>
                                            @elseif($loan->statut === 'retourne')
                                                <x-status-badge status="retourne" />
                                            @else
                                                <x-status-badge status="en_cours" />
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-500">
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
    </div>
</x-app-layout>
