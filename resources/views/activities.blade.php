<x-layouts.admin>
    <x-slot:title>Riwayat Aktivitas</x-slot:title>
    <x-slot:header>Riwayat Aktivitas</x-slot:header>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-extrabold text-lg text-slate-800">Semua Aktivitas Sistem</h3>
        </div>

        <div class="space-y-3">
            @forelse($activities as $activity)
                @php
                    // Tentukan icon dan warna berdasarkan tipe aksi atau entitas
                    $icon = 'activity';
                    $colorClass = 'blue';
                    $bgClass = 'bg-gradient-to-br from-blue-400 to-indigo-500';
                    $statusBadge = 'Sistem';
                    $statusColor = 'slate';

                    if (str_contains(strtolower($activity->action), 'create') || str_contains(strtolower($activity->action), 'tambah')) {
                        $icon = 'plus-circle';
                        $colorClass = 'emerald';
                        $bgClass = 'bg-gradient-to-r from-emerald-400 to-teal-500';
                        $statusBadge = 'Baru';
                        $statusColor = 'emerald';
                    } elseif (str_contains(strtolower($activity->action), 'update') || str_contains(strtolower($activity->action), 'ubah')) {
                        $icon = 'edit';
                        $colorClass = 'amber';
                        $bgClass = 'bg-gradient-to-br from-amber-400 to-orange-500';
                        $statusBadge = 'Update';
                        $statusColor = 'amber';
                    } elseif (str_contains(strtolower($activity->action), 'delete') || str_contains(strtolower($activity->action), 'hapus')) {
                        $icon = 'trash';
                        $colorClass = 'rose';
                        $bgClass = 'bg-gradient-to-br from-rose-400 to-red-500';
                        $statusBadge = 'Hapus';
                        $statusColor = 'rose';
                    }

                    $actionMap = [
                        'created' => 'Menambahkan',
                        'updated' => 'Memperbarui',
                        'deleted' => 'Menghapus',
                        'tambah' => 'Menambahkan',
                        'ubah' => 'Memperbarui',
                        'hapus' => 'Menghapus',
                    ];
                    $entityMap = [
                        'Sheep' => 'Domba',
                        'Weight_record' => 'Catatan Timbangan',
                        'Health_record' => 'Catatan Kesehatan',
                        'Cage' => 'Kandang',
                        'User' => 'Pengguna',
                        'Peternak' => 'Peternak',
                        'domba' => 'Domba',
                        'kandang' => 'Kandang',
                    ];

                    $translatedAction = $actionMap[strtolower($activity->action)] ?? $activity->action;
                    $translatedEntity = $entityMap[ucfirst($activity->entity)] ?? ucfirst($activity->entity);
                @endphp
                <div class="group flex items-center justify-between p-3.5 rounded-xl bg-slate-50/50 border border-slate-100 hover:border-{{ $colorClass }}-200 hover:bg-white hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-lg {{ $bgClass }} flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">
                            <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $translatedAction }} {{ $translatedEntity }}</p>
                            <p class="text-xs text-slate-500 font-medium">{{ $activity->description }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-[11px] font-bold text-slate-400">{{ \Carbon\Carbon::parse($activity->created_at)->locale('id')->diffForHumans() }}</span>
                        <span class="inline-block mt-0.5 px-1.5 py-0.5 bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700 text-[9px] uppercase font-bold rounded">{{ $activity->user ? $activity->user->name : 'Sistem' }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-6">
                    <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                    <p class="text-xs font-bold text-slate-500">Belum ada aktivitas.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</x-layouts.admin>
