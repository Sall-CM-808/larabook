<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-400 hover:text-white mb-6 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour
            </a>
            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <h2 class="text-xl font-bold text-white mb-6">Modifier : {{ $user->name }}</h2>

                @if($errors->any())
                    <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm mb-6">
                        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Nom complet *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Matricule *</label>
                            <input type="text" name="matricule" value="{{ old('matricule', $user->matricule) }}" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Email *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">R&ocirc;les *</label>
                            <div class="flex flex-wrap gap-3 mt-1">
                                @foreach($roles as $role)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                               {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                                               class="rounded bg-slate-900 border-white/20 text-indigo-500 focus:ring-indigo-500/30">
                                        <span class="text-sm text-slate-300">{{ $role->nom }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="password" class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                            <p class="text-xs text-slate-600 mt-1">Laisser vide pour ne pas modifier</p>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Confirmer</label>
                            <input type="password" name="password_confirmation" class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm text-slate-400 hover:text-white transition">Annuler</a>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-lg shadow-indigo-500/25">Mettre &agrave; jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
