@props(['name', 'label', 'type' => 'text', 'placeholder' => '', 'required' => false, 'color' => 'amber', 'value' => ''])

<div class="space-y-2">
    <label for="{{ $name }}" class="block text-sm font-black text-slate-700">
        {{ $label }} @if($required)<span class="text-rose-500">*</span>@endif
    </label>
    <div class="relative group" @if($type === 'password') x-data="{ show: false }" @endif>
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            {{-- Icon slot using Heroicons --}}
            <div class="w-5 h-5 text-slate-400 group-focus-within:text-{{ $color }}-500 transition-colors duration-300">
                {{ $icon }}
            </div>
        </div>
        
        <input 
            @if($type === 'password') :type="show ? 'text' : 'password'" @else type="{{ $type }}" @endif
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            {{ $required ? 'required' : '' }}
            class="w-full pl-12 {{ $type === 'password' ? 'pr-12' : 'pr-4' }} py-3.5 bg-slate-50 hover:bg-slate-100/50 border-2 border-slate-200 rounded-xl text-sm font-bold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-{{ $color }}-500 focus:ring-4 focus:ring-{{ $color }}-500/10 transition-all duration-300 shadow-sm"
            placeholder="{{ $placeholder }}">
            
        @if($type === 'password')
        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none z-10 transition-colors">
            <!-- Heroicons Eye & Eye-off -->
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
        </button>
        @endif
    </div>
    @error($name)
        <p class="text-xs text-rose-500 font-bold flex items-center gap-1 mt-1.5">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            {{ $message }}
        </p>
    @enderror
</div>
