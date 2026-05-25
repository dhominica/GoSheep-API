@props(['href' => '#', 'icon', 'active' => false])

@php
    // White active background with rich dark green text for solid premium contrast
    $activeClasses = 'bg-white text-emerald-950 font-extrabold shadow-sm shadow-emerald-900/20';
    
    // Pure, crisp white text for maximum readability and clean contrast
    $inactiveClasses = 'hover:bg-white/10 text-white hover:text-white font-semibold';
    
    // Active icon inherits the dark emerald-950 text color for monochrome elegance
    $iconActiveClasses = 'text-emerald-950';
    
    // Inactive icon is pure white with elegant opacity, turning solid white on hover
    $iconInactiveClasses = 'text-white/60 group-hover:text-white';
@endphp

<a href="{{ $href }}" class="flex items-center gap-3 px-3 py-2.5 {{ $active ? $activeClasses : $inactiveClasses }} rounded-xl transition-all duration-200 group">
    <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $active ? $iconActiveClasses : $iconInactiveClasses }} transition-colors shrink-0"></i>
    <span class="text-sm tracking-wide">{{ $slot }}</span>
</a>
