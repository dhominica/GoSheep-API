@props([
    'action',
    'method' => 'POST',
    'title',
    'badgeText' => '',
    'color' => 'emerald',
    'confirmSubmit' => false,
    'confirmTitle' => 'Konfirmasi Simpan',
    'confirmText' => 'Pastikan data yang Anda masukkan sudah benar.',
    'confirmIcon' => 'question'
])

@php
    $colors = [
        'emerald' => [
            'bgFrom' => 'from-slate-900',
            'bgVia' => 'via-slate-800',
            'bgTo' => 'to-slate-900',
            'border' => 'border-emerald-500',
            'glow' => 'bg-emerald-500/20',
            'badgeBg' => 'bg-white/10',
            'badgeBorder' => 'border-white/20',
            'badgeTextCol' => 'text-emerald-400',
            'hex' => '#10b981'
        ],
        'indigo' => [
            'bgFrom' => 'from-indigo-950',
            'bgVia' => 'via-slate-900',
            'bgTo' => 'to-indigo-900',
            'border' => 'border-indigo-500',
            'glow' => 'bg-indigo-500/20',
            'badgeBg' => 'bg-indigo-500/20',
            'badgeBorder' => 'border-indigo-400/30',
            'badgeTextCol' => 'text-indigo-300',
            'hex' => '#6366f1'
        ]
    ];
    $t = $colors[$color] ?? $colors['emerald'];
@endphp

<div class="max-w-4xl mx-auto">
    <!-- Premium Header Banner -->
    <div class="relative overflow-hidden rounded-t-2xl bg-gradient-to-br {{ $t['bgFrom'] }} {{ $t['bgVia'] }} {{ $t['bgTo'] }} p-8 text-white shadow-lg border-b-4 {{ $t['border'] }} group">
        <div class="absolute inset-0 opacity-[0.05] bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZmZmIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iMTAiLz48L3N2Zz4=')] bg-[length:32px_32px]"></div>
        <div class="absolute -top-32 -left-32 w-72 h-72 {{ $t['glow'] }} blur-[70px] rounded-full pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
        <div class="absolute -top-32 -right-32 w-64 h-64 {{ $t['glow'] }} blur-[60px] rounded-full pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                @if($badgeText)
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $t['badgeBg'] }} backdrop-blur-md border {{ $t['badgeBorder'] }} text-[10px] font-black tracking-widest {{ $t['badgeTextCol'] }} uppercase mb-4 shadow-sm shadow-black/20">
                    {{ $badgeIcon ?? '' }}
                    {{ $badgeText }}
                </div>
                @endif
                <h2 class="text-2xl md:text-3xl font-black tracking-tight mb-2 flex items-center gap-2">
                    {{ $title }}
                </h2>
                <div class="text-slate-300 font-medium text-sm max-w-xl leading-relaxed">
                    {{ $description ?? '' }}
                </div>
            </div>
            
            @if(isset($cornerIcon))
            <div class="hidden md:flex w-16 h-16 rounded-full bg-white/10 border border-white/20 items-center justify-center backdrop-blur-md shadow-2xl">
                {{ $cornerIcon }}
            </div>
            @endif
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-b-2xl border-x border-b border-slate-200 shadow-2xl shadow-slate-200/50 p-8 md:p-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-bl from-slate-50/80 to-transparent pointer-events-none"></div>

        @php $formId = 'form-card-' . uniqid(); @endphp
        <form action="{{ $action }}" method="POST" class="relative z-10" id="{{ $formId }}">
            @csrf
            @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
                @method($method)
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">
                {{ $slot }}
            </div>

            @if(isset($actions))
            <div class="pt-8 mt-10 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100 bg-slate-50/50 -mx-8 -mb-8 md:-mx-10 md:-mb-10 p-6 md:p-8 rounded-b-2xl">
                {{ $actions }}
            </div>
            @endif
        </form>
    </div>
</div>

@if($confirmSubmit)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('{{ $formId }}');
        if(form && typeof Swal !== 'undefined') {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "{{ $confirmTitle }}",
                    text: "{{ $confirmText }}",
                    icon: "{{ $confirmIcon }}",
                    showCancelButton: true,
                    confirmButtonColor: "{{ $t['hex'] }}",
                    cancelButtonColor: "#64748b",
                    confirmButtonText: "Ya, Lanjutkan!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });
</script>
@endif
