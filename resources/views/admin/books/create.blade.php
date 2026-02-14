<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-400 hover:text-white mb-6 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour
            </a>

            <div class="bg-slate-800 rounded-2xl p-6 border border-white/10 shadow-lg shadow-black/10">
                <h2 class="text-xl font-bold text-white mb-6">Ajouter un livre</h2>

                @if($errors->any())
                    <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm mb-6">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Titre *</label>
                            <input type="text" name="titre" value="{{ old('titre') }}" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Auteur *</label>
                            <input type="text" name="auteur" value="{{ old('auteur') }}" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Cat&eacute;gorie *</label>
                            <select name="category_id" required class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                                <option value="">S&eacute;lectionner...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">ISBN</label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}" class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Ann&eacute;e de publication</label>
                            <input type="number" name="annee_publication" value="{{ old('annee_publication') }}" class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Couverture</label>
                            <input type="file" name="couverture" accept="image/*" class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2 text-sm text-slate-300 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-slate-700 file:text-slate-300">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-slate-300 focus:border-indigo-500/50 focus:outline-none resize-none">{{ old('description') }}</textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.books.index') }}" class="px-5 py-2.5 text-sm text-slate-400 hover:text-white transition">Annuler</a>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-lg shadow-indigo-500/25">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
