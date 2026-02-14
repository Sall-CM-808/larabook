<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <h2 class="text-2xl font-bold text-white mb-6">Catalogue des Livres</h2>

                <!-- Search + Filters -->
                <form method="GET" action="{{ route('catalogue.index') }}" class="mb-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher un livre..."
                                   class="w-full bg-slate-900 border border-white/10 rounded-lg pl-10 pr-4 py-2.5 text-sm text-slate-300 placeholder-slate-500 focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/30 focus:outline-none">
                        </div>
                        <select name="filter_by" class="bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                            <option value="titre" {{ ($filterBy ?? 'titre') === 'titre' ? 'selected' : '' }}>Titre</option>
                            <option value="auteur" {{ ($filterBy ?? '') === 'auteur' ? 'selected' : '' }}>Auteur</option>
                            <option value="categorie" {{ ($filterBy ?? '') === 'categorie' ? 'selected' : '' }}>Cat&eacute;gorie</option>
                        </select>
                        <select name="category" class="bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                            <option value="">Toutes les cat&eacute;gories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ ($categorySlug ?? '') === $cat->slug ? 'selected' : '' }}>{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-lg shadow-indigo-500/25">
                            Rechercher
                        </button>
                    </div>
                </form>

                <!-- Filter Tabs -->
                <div class="flex gap-4 mb-6 border-b border-white/10 pb-3">
                    @foreach(['titre' => 'Titre', 'auteur' => 'Auteur', 'categorie' => 'Cat&eacute;gorie'] as $key => $label)
                        <a href="{{ route('catalogue.index', array_merge(request()->query(), ['filter_by' => $key])) }}"
                           class="text-sm font-medium pb-1 border-b-2 transition {{ ($filterBy ?? 'titre') === $key ? 'text-indigo-400 border-indigo-400' : 'text-slate-500 border-transparent hover:text-slate-300' }}">
                            {!! $label !!}
                        </a>
                    @endforeach
                </div>

                <!-- Books Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @forelse($books as $book)
                        <x-book-card :book="$book" />
                    @empty
                        <div class="col-span-full text-center py-12 text-slate-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Aucun livre trouv&eacute;.
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $books->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
