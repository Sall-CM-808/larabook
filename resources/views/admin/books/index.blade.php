<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Gestion des Livres</h2>
                    <a href="{{ route('admin.books.create') }}" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-lg shadow-indigo-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter un livre
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-slate-500 text-xs uppercase border-b border-white/10">
                                <th class="text-left py-3 px-3 font-medium">Livre</th>
                                <th class="text-left py-3 px-3 font-medium">Cat&eacute;gorie</th>
                                <th class="text-left py-3 px-3 font-medium">ISBN</th>
                                <th class="text-center py-3 px-3 font-medium">Exemplaires</th>
                                <th class="text-center py-3 px-3 font-medium">Disponibles</th>
                                <th class="text-right py-3 px-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                    <td class="py-3 px-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-14 rounded-lg bg-slate-700/30 overflow-hidden shrink-0 ring-1 ring-white/5">
                                                @if($book->couverture)
                                                    <img src="{{ asset('storage/' . $book->couverture) }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-slate-200 font-medium">{{ $book->titre }}</p>
                                                <p class="text-xs text-slate-500">{{ $book->auteur }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-slate-400">{{ $book->category->nom }}</td>
                                    <td class="py-3 px-3 text-slate-400 font-mono text-xs">{{ $book->isbn ?? '-' }}</td>
                                    <td class="py-3 px-3 text-center text-slate-400">{{ $book->total_copies }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="{{ $book->available_copies > 0 ? 'text-emerald-400' : 'text-rose-400' }}">{{ $book->available_copies }}</span>
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.books.edit', $book) }}" class="text-slate-400 hover:text-white transition p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('Supprimer ce livre ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-rose-400 transition p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-12 text-center text-slate-500">Aucun livre.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($books->hasPages())
                    <div class="mt-4">{{ $books->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
