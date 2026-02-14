<nav x-data="{ open: false }" class="bg-slate-900/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo + Nav Links -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 4H3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zM8 18H4V6h4v12zm6 0h-4V6h4v12zm6 0h-4V6h4v12z"/>
                    </svg>
                    <span class="text-xl font-bold text-white tracking-wide">LARA<span class="text-indigo-400">BOOK</span></span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('catalogue.index') }}"
                       class="text-sm font-medium {{ request()->routeIs('catalogue.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} transition">
                        Catalogue
                    </a>
                    <a href="{{ route('loans.index') }}"
                       class="text-sm font-medium {{ request()->routeIs('loans.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} transition">
                        Mes Emprunts
                    </a>
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.books.index') }}"
                           class="text-sm font-medium {{ request()->routeIs('admin.books.*') || request()->routeIs('admin.copies.*') || request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} transition">
                            Gestion
                        </a>
                    @endif
                    @if(Auth::user()->hasAnyRole(['admin', 'bibliothecaire']))
                        <a href="{{ route('admin.loans.index') }}"
                           class="text-sm font-medium {{ request()->routeIs('admin.loans.*') ? 'text-white' : 'text-slate-400 hover:text-white' }} transition">
                            Emprunts
                        </a>
                    @endif
                    <span class="text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full
                        @if(Auth::user()->hasRole('admin'))
                            bg-indigo-500/15 text-indigo-300 border border-indigo-500/20
                        @elseif(Auth::user()->hasRole('bibliothecaire'))
                            bg-violet-500/15 text-violet-300 border border-violet-500/20
                        @else
                            bg-slate-500/15 text-slate-400 border border-slate-500/20
                        @endif">
                        @if(Auth::user()->hasRole('admin'))
                            Admin
                        @elseif(Auth::user()->hasRole('bibliothecaire'))
                            Biblio
                        @else
                            &Eacute;tudiant
                        @endif
                    </span>
                </div>
            </div>

            <!-- Right: Matricule + Avatar + Dropdown -->
            <div class="hidden sm:flex items-center gap-4">
                @if(Auth::user()->matricule)
                    <span class="text-sm text-slate-500 font-mono">{{ Auth::user()->matricule }}</span>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 focus:outline-none group">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white font-bold text-sm ring-2 ring-white/10 group-hover:ring-indigo-400/30 transition">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-white/10">
                            <p class="text-sm font-medium text-slate-200">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                D&eacute;connexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-slate-400 hover:text-white hover:bg-white/10 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-800/95 backdrop-blur-xl border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Dashboard</a>
            <a href="{{ route('catalogue.index') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Catalogue</a>
            <a href="{{ route('loans.index') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Mes Emprunts</a>
            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.books.index') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Gestion Livres</a>
                <a href="{{ route('admin.copies.index') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Gestion Exemplaires</a>
                <a href="{{ route('admin.users.index') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Gestion Utilisateurs</a>
            @endif
            @if(Auth::user()->hasAnyRole(['admin', 'bibliothecaire']))
                <a href="{{ route('admin.loans.index') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Gestion Emprunts</a>
            @endif
        </div>
        <div class="pt-4 pb-3 border-t border-white/10 px-4">
            <div class="mb-3">
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="block py-2 text-sm text-slate-300 hover:text-white">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left py-2 text-sm text-slate-300 hover:text-white">D&eacute;connexion</button>
            </form>
        </div>
    </div>
</nav>
