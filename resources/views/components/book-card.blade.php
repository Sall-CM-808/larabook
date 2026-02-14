@props(['book'])

@php
    $available = $book->available_copies ?? $book->availableCopies()->count();
    $total = $book->total_copies ?? $book->copies->count();
    
    if ($available > 0) {
        $badgeText = 'Empruntable';
        $badgeClass = 'bg-emerald-500/90 text-white';
    } else {
        $badgeText = 'Indisponible';
        $badgeClass = 'bg-rose-500/90 text-white';
    }
@endphp

<div class="group relative">
    <a href="{{ route('catalogue.show', $book) }}" class="block">
        <div class="relative aspect-[2/3] rounded-xl overflow-hidden bg-slate-700/30 mb-3 ring-1 ring-white/5 group-hover:ring-indigo-500/20 transition-all duration-300">
            @if($book->couverture)
                <img src="{{ asset('storage/' . $book->couverture) }}"
                     alt="{{ $book->titre }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900/50 to-violet-900/50">
                    <svg class="w-12 h-12 text-indigo-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            @endif

            <!-- Badge -->
            <span class="absolute top-2 right-2 text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-sm {{ $badgeClass }}">
                {{ $badgeText }}
            </span>
        </div>

        <h3 class="text-sm font-medium text-slate-200 truncate group-hover:text-white transition">{{ $book->titre }}</h3>
        <p class="text-xs text-slate-500">{{ $book->auteur }}</p>
    </a>
</div>
