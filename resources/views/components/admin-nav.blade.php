@if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('bibliothecaire'))
<div class="bg-slate-800/50 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-1 overflow-x-auto py-2 scrollbar-hide">
            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.books.index') }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition whitespace-nowrap
                    {{ request()->routeIs('admin.books.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Livres
                </a>
                <a href="{{ route('admin.copies.index') }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition whitespace-nowrap
                    {{ request()->routeIs('admin.copies.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Exemplaires
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition whitespace-nowrap
                    {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Utilisateurs
                </a>
                <a href="{{ route('admin.settings.edit') }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition whitespace-nowrap
                    {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Param&egrave;tres
                </a>
            @endif
            @if(Auth::user()->hasAnyRole(['admin', 'bibliothecaire']))
                <a href="{{ route('admin.loans.index') }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition whitespace-nowrap
                    {{ request()->routeIs('admin.loans.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Emprunts
                </a>
            @endif
        </div>
    </div>
</div>
@endif
