@props(['color' => 'amber', 'href' => null, 'type' => 'button'])

@php
    // Unified, high-end base classes for SIAKAD-style responsive buttons
    $baseClasses = 'w-full sm:w-auto px-8 py-3 text-sm font-extrabold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 relative overflow-hidden group hover:-translate-y-0.5 active:translate-y-0 active:scale-95';

    $colorClasses = [
        'amber' => 'text-white bg-gradient-to-tr from-amber-500 to-orange-400 shadow-md shadow-amber-500/20 hover:shadow-orange-500/30 hover:to-orange-500 border border-amber-400/50',
        'indigo' => 'text-white bg-gradient-to-tr from-indigo-600 to-blue-500 shadow-md shadow-indigo-500/20 hover:shadow-blue-500/30 hover:to-blue-400 border border-indigo-400/50',
        'emerald' => 'text-white bg-gradient-to-tr from-emerald-600 to-green-500 shadow-md shadow-emerald-500/20 hover:shadow-green-500/30 hover:to-green-400 border border-emerald-400/50',
        'slate' => 'text-slate-500 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-800 hover:border-slate-300 shadow-sm',
    ];

    $classes = $baseClasses . ' ' . ($colorClasses[$color] ?? $colorClasses['amber']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($color !== 'slate')
            <div class="absolute inset-0 bg-white/20 skew-x-12 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
        @endif
        <span class="relative z-10 flex items-center gap-2">{{ $slot }}</span>
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($color !== 'slate')
            <div class="absolute inset-0 bg-white/20 skew-x-12 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
        @endif
        <span class="relative z-10 flex items-center gap-2">{{ $slot }}</span>
    </button>
@endif
