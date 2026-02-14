@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-900 border-white/10 text-slate-300 focus:border-indigo-500/50 focus:ring-indigo-500/30 rounded-lg shadow-sm placeholder-slate-500']) }}>
