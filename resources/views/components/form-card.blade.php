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
            'hex' => '#059669'
        ],
        'indigo' => [
            'hex' => '#4f46e5'
        ]
    ];
    $t = $colors[$color] ?? $colors['emerald'];
@endphp

<div class="max-w-4xl mx-auto">
    <!-- SIAKAD style Title, Breadcrumb and Meta directly on Page Canvas -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            @if($badgeText)
            <div class="flex items-center gap-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">
                <span>{{ $badgeText }}</span>
                <span class="text-slate-300">/</span>
                <span class="text-emerald-600 font-extrabold">Formulir</span>
            </div>
            @endif
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">{{ $title }}</h1>
            @if(isset($description))
            <p class="text-xs text-slate-400 font-semibold mt-1">
                {{ $description }}
            </p>
            @endif
        </div>
    </div>

    <!-- Clean SIAKAD Flat White Form Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 md:p-8">
        @php $formId = 'form-card-' . uniqid(); @endphp
        <form action="{{ $action }}" method="POST" id="{{ $formId }}" class="space-y-6">
            @csrf
            @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
                @method($method)
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{ $slot }}
            </div>

            @if(isset($actions))
            <div class="pt-6 mt-8 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100 bg-slate-50/50 -mx-6 -mb-6 md:-mx-8 md:-mb-8 p-5 md:p-6">
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
