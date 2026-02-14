<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Gestion des Exemplaires</h2>
                    <a href="{{ route('admin.copies.create') }}" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-lg shadow-indigo-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter un exemplaire
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-slate-500 text-xs uppercase border-b border-white/10">
                                <th class="text-left py-3 px-3 font-medium">Code-barres</th>
                                <th class="text-left py-3 px-3 font-medium">Livre</th>
                                <th class="text-left py-3 px-3 font-medium">&Eacute;tat</th>
                                <th class="text-right py-3 px-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($copies as $copy)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                    <td class="py-3 px-3 text-slate-300 font-mono text-xs">{{ $copy->code_barre }}</td>
                                    <td class="py-3 px-3">
                                        <p class="text-slate-200">{{ $copy->book->titre }}</p>
                                        <p class="text-xs text-slate-500">{{ $copy->book->auteur }}</p>
                                    </td>
                                    <td class="py-3 px-3"><x-status-badge :status="$copy->etat" /></td>
                                    <td class="py-3 px-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.copies.edit', $copy) }}" class="text-slate-400 hover:text-white transition p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.copies.destroy', $copy) }}" onsubmit="return confirm('Supprimer cet exemplaire ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-rose-400 transition p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-12 text-center text-slate-500">Aucun exemplaire.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($copies->hasPages())
                    <div class="mt-4">{{ $copies->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
