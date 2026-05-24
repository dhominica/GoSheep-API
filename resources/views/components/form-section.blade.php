@props([
    'title',
    'color' => 'indigo',
    'marginTop' => false
])

@php
    $colors = [
        'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
        'blue'    => 'bg-blue-50 text-blue-600 border-blue-100',
        'rose'    => 'bg-rose-50 text-rose-600 border-rose-100',
        'indigo'  => 'bg-indigo-50 text-indigo-600 border-indigo-100',
        'slate'   => 'bg-slate-50 text-slate-600 border-slate-100',
    ];
    $theme = $colors[$color] ?? $colors['indigo'];
@endphp

<div class="col-span-1 md:col-span-2 pb-2.5 {{ $marginTop ? 'pt-6' : '' }} border-b border-slate-100 flex items-center gap-2.5">
    <div class="w-8 h-8 rounded-lg {{ $theme }} flex items-center justify-center border text-xs">
        {{ $icon ?? $slot }}
    </div>
    <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">{{ $title }}</h3>
</div>
