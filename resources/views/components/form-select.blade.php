@props(['name', 'label', 'required' => false, 'color' => 'emerald'])

<div class="space-y-1.5">
    <!-- SIAKAD Label Style -->
    <label for="{{ $name }}" class="block text-[11px] font-black text-slate-400 uppercase tracking-widest">
        {{ $label }} @if($required)<span class="text-rose-500 font-bold">*</span>@endif
    </label>
    
    <div class="relative group">
        <select 
            name="{{ $name }}" 
            id="{{ $name }}" 
            {{ $required ? 'required' : '' }}
            class="appearance-none w-full px-4 pr-10 py-3 bg-slate-50 hover:bg-slate-100/50 hover:border-slate-300 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:outline-none focus:border-{{ $color }}-500 focus:ring-2 focus:ring-{{ $color }}-500/10 transition-all duration-300 shadow-sm cursor-pointer">
            {{ $slot }}
        </select>
        
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
        </div>
    </div>
    
    @error($name)
        <p class="text-xs text-rose-500 font-bold flex items-center gap-1 mt-1.5 animate-fade-in">
            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            {{ $message }}
        </p>
    @enderror
</div>
