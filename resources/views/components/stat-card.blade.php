@props([
    'title',
    'value',
    'icon',
    'color' => 'slate', // default color
])

@php
    $colors = [
        'blue' => [
            'iconBg' => 'bg-gradient-to-br from-blue-400 to-blue-500',
            'iconColor' => 'text-white',
            'shadow' => 'hover:shadow-blue-500/10',
            'border' => 'group-hover:border-blue-300'
        ],
        'amber' => [
            'iconBg' => 'bg-gradient-to-br from-amber-400 to-amber-500',
            'iconColor' => 'text-white',
            'shadow' => 'hover:shadow-amber-500/10',
            'border' => 'group-hover:border-amber-300'
        ],
        'emerald' => [
            'iconBg' => 'bg-gradient-to-br from-emerald-400 to-emerald-500',
            'iconColor' => 'text-white',
            'shadow' => 'hover:shadow-emerald-500/10',
            'border' => 'group-hover:border-emerald-300'
        ],
        'purple' => [
            'iconBg' => 'bg-gradient-to-br from-purple-400 to-purple-500',
            'iconColor' => 'text-white',
            'shadow' => 'hover:shadow-purple-500/10',
            'border' => 'group-hover:border-purple-300'
        ],
        'rose' => [
            'iconBg' => 'bg-gradient-to-br from-rose-400 to-rose-500',
            'iconColor' => 'text-white',
            'shadow' => 'hover:shadow-rose-500/10',
            'border' => 'group-hover:border-rose-300'
        ],
        'slate' => [
            'iconBg' => 'bg-gradient-to-br from-slate-400 to-slate-500',
            'iconColor' => 'text-white',
            'shadow' => 'hover:shadow-slate-500/10',
            'border' => 'group-hover:border-slate-300'
        ],
    ];
    $theme = $colors[$color] ?? $colors['slate'];
@endphp

<div class="group bg-white rounded-2xl p-5 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg {{ $theme['shadow'] }} border border-slate-100 {{ $theme['border'] }} cursor-default relative overflow-hidden">
    <div class="relative z-10 flex flex-col h-full justify-between">
        <div class="flex items-start justify-between mb-3">
            <div class="p-2.5 rounded-xl {{ $theme['iconBg'] }} {{ $theme['iconColor'] }} shadow-sm group-hover:scale-110 transition-transform duration-300 ease-out">
                <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
            </div>
        </div>

        <div>
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-0.5 group-hover:text-slate-600 transition-colors">{{ $title }}</p>
            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight leading-none tabular-nums">{{ $value }}</h3>
            
            @isset($trend)
                <div class="mt-3 pt-3 border-t border-slate-100 text-xs flex items-center">
                    {{ $trend }}
                </div>
            @endisset
        </div>
    </div>
</div>
