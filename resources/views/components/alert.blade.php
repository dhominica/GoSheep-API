@props([
    'title' => 'Pemberitahuan',
    'message',
    'type' => 'success'
])
@php
    $types = [
        'success' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-700',
            'icon' => 'check-circle-2',
            'border' => 'border-green-200'
        ],
        'info' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-700',
            'icon' => 'info',
            'border' => 'border-blue-200'
        ],
        'warning' => [
            'bg' => 'bg-amber-100',
            'text' => 'text-amber-700',
            'icon' => 'alert-triangle',
            'border' => 'border-amber-200'
        ],
    ];

    $style = $types[$type] ?? $types['success'];
@endphp

<!-- Disembunyikan karena digantikan oleh SweetAlert2 sesuai permintaan -->
<div class="hidden bg-white rounded-2xl shadow-sm border {{ $style['border'] }} p-6 mb-6">
    <div class="flex items-start gap-4">
        <div class="{{ $style['bg'] }} {{ $style['text'] }} p-3 rounded-xl shadow-inner">
            <i data-lucide="{{ $style['icon'] }}" class="w-6 h-6"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-800 tracking-tight">{{ $title }}</h2>
            <p class="text-gray-500 mt-1 leading-relaxed">{{ $message ?? $slot }}</p>
        </div>
    </div>
</div>

<!-- SweetAlert2 Muncul bila komponen ini dipanggil -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                title: "{{ $title }}",
                text: "{{ $message ?? $slot }}",
                icon: "{{ $type }}",
                draggable: true,
                confirmButtonColor: "#10b981",
            });
        }
    });
</script>
