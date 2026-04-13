@props([
    'title',
    'color' => 'indigo',
    'marginTop' => false
])

@php
    $colors = [
        'emerald' => 'bg-emerald-100 text-emerald-600 border-emerald-200/50',
        'blue'    => 'bg-blue-100 text-blue-600 border-blue-200/50',
        'rose'    => 'bg-rose-100 text-rose-600 border-rose-200/50',
        'indigo'  => 'bg-indigo-100 text-indigo-600 border-indigo-200/50',
        'slate'   => 'bg-slate-100 text-slate-600 border-slate-200/50',
    ];
    $theme = $colors[$color] ?? $colors['indigo'];
@endphp

<div class="col-span-1 md:col-span-2 pb-4 {{ $marginTop ? 'pt-4' : '' }} border-b border-slate-100 flex items-center gap-3">
    <div class="w-9 h-9 rounded-xl {{ $theme }} flex items-center justify-center shadow-sm border">
        {{ $icon ?? $slot }}
    </div>
    <h3 class="text-lg font-black text-slate-800 tracking-tight">{{ $title }}</h3>
</div>
