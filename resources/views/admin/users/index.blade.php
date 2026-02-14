<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Gestion des Utilisateurs</h2>
                    <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-lg shadow-indigo-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter un utilisateur
                    </a>
                </div>

                <!-- Search -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
                    <div class="flex gap-3">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher par nom, email ou matricule..."
                               class="flex-1 bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 placeholder-slate-500 focus:border-indigo-500/50 focus:outline-none">
                        <button type="submit" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2.5 rounded-lg text-sm transition">Rechercher</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-slate-500 text-xs uppercase border-b border-white/10">
                                <th class="text-left py-3 px-3 font-medium">Utilisateur</th>
                                <th class="text-left py-3 px-3 font-medium">Matricule</th>
                                <th class="text-left py-3 px-3 font-medium">Email</th>
                                <th class="text-left py-3 px-3 font-medium">R&ocirc;les</th>
                                <th class="text-right py-3 px-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                    <td class="py-3 px-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="text-slate-200">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-slate-400 font-mono text-xs">{{ $user->matricule ?? '-' }}</td>
                                    <td class="py-3 px-3 text-slate-400">{{ $user->email }}</td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($user->roles as $role)
                                                <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-500/15 text-indigo-400 border border-indigo-500/20">{{ $role->nom }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-slate-400 hover:text-white transition p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-rose-400 transition p-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-12 text-center text-slate-500">Aucun utilisateur.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="mt-4">{{ $users->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
