@props(['status'])

@php
    $classes = match($status) {
        'en_cours' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20',
        'retourne' => 'bg-slate-500/15 text-slate-400 border-slate-500/20',
        'en_retard' => 'bg-rose-500/15 text-rose-400 border-rose-500/20',
        'disponible' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20',
        'emprunte' => 'bg-amber-500/15 text-amber-400 border-amber-500/20',
        'perdu' => 'bg-rose-500/15 text-rose-400 border-rose-500/20',
        'maintenance' => 'bg-sky-500/15 text-sky-400 border-sky-500/20',
        default => 'bg-slate-500/15 text-slate-400 border-slate-500/20',
    };

    $label = match($status) {
        'en_cours' => 'En cours',
        'retourne' => 'Retourn&eacute;',
        'en_retard' => 'En retard',
        'disponible' => 'Disponible',
        'emprunte' => 'Emprunt&eacute;',
        'perdu' => 'Perdu',
        'maintenance' => 'Maintenance',
        default => ucfirst($status),
    };
@endphp

<span class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full border {{ $classes }}">
    {!! $label !!}
</span>
