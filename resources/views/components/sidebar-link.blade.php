@props(['href' => '#', 'icon', 'active' => false])

@php
    $activeClasses = 'bg-green-50 text-green-700 font-bold';
    $inactiveClasses = 'hover:bg-slate-50 text-slate-600 hover:text-slate-900 font-semibold';
    
    $iconActiveClasses = 'text-green-600';
    $iconInactiveClasses = 'text-slate-400 group-hover:text-green-600';
@endphp

<a href="{{ $href }}" class="flex items-center gap-3 px-3 py-2.5 {{ $active ? $activeClasses : $inactiveClasses }} rounded-xl transition-all group">
    @if ($icon === 'logo')
        <div class="w-4 h-4 flex items-center justify-center {{ $active ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }} transition-opacity">
            <img src="{{ asset('assets/img/logo_app.png') }}" class="w-4 h-4 object-contain filter {{ $active ? 'grayscale-0' : 'grayscale group-hover:grayscale-0' }}" alt="">
        </div>
    @else
        <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $active ? $iconActiveClasses : $iconInactiveClasses }} transition-colors"></i>
    @endif
    {{ $slot }}
</a>
