<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back -->
            <a href="{{ route('catalogue.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-400 hover:text-white mb-6 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour au catalogue
            </a>

            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Cover -->
                    <div class="w-full md:w-64 shrink-0">
                        <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-700/30 ring-1 ring-white/5">
                            @if($book->couverture)
                                <img src="{{ asset('storage/' . $book->couverture) }}" alt="{{ $book->titre }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900/50 to-violet-900/50">
                                    <svg class="w-16 h-16 text-indigo-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $book->titre }}</h1>
                        <p class="text-lg text-slate-400 mb-4">{{ $book->auteur }}</p>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <span class="text-xs text-slate-500 uppercase">Cat&eacute;gorie</span>
                                <p class="text-sm text-slate-300">{{ $book->category->nom }}</p>
                            </div>
                            @if($book->annee_publication)
                                <div>
                                    <span class="text-xs text-slate-500 uppercase">Ann&eacute;e</span>
                                    <p class="text-sm text-slate-300">{{ $book->annee_publication }}</p>
                                </div>
                            @endif
                            @if($book->isbn)
                                <div>
                                    <span class="text-xs text-slate-500 uppercase">ISBN</span>
                                    <p class="text-sm text-slate-300 font-mono">{{ $book->isbn }}</p>
                                </div>
                            @endif
                            <div>
                                <span class="text-xs text-slate-500 uppercase">Disponibilit&eacute;</span>
                                <p class="text-sm">
                                    @if($book->isAvailable())
                                        <span class="text-emerald-400">{{ $book->availableCopies->count() }} exemplaire(s) disponible(s)</span>
                                    @else
                                        <span class="text-rose-400">Indisponible</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($book->description)
                            <div class="mb-6">
                                <span class="text-xs text-slate-500 uppercase">Description</span>
                                <p class="text-sm text-slate-300 mt-1 leading-relaxed">{{ $book->description }}</p>
                            </div>
                        @endif

                        <!-- Exemplaires -->
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 mb-3">Exemplaires</h3>
                            <div class="space-y-2">
                                @foreach($book->copies as $copy)
                                    <div class="flex items-center justify-between bg-slate-900 rounded-lg px-4 py-2.5 border border-white/5">
                                        <span class="text-sm text-slate-400 font-mono">{{ $copy->code_barre }}</span>
                                        <x-status-badge :status="$copy->etat" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
