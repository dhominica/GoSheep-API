<x-layouts.admin>
    <x-slot name="title">Riwayat Berat: {{ $sheep->eartag }}</x-slot>

    <!-- Breadcrumb / Back Button -->
    <div class="mb-6 flex items-center gap-3 text-sm">
        <a href="{{ route('berat.index') }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 hover:text-emerald-600 text-slate-500 flex items-center justify-center transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div class="flex items-center gap-2 text-slate-500 font-medium">
            <a href="{{ route('berat.index') }}" class="hover:text-emerald-600 transition-colors">Riwayat Berat</a>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
            <span class="text-slate-800 font-bold">Detail: {{ $sheep->eartag }}</span>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-bold text-white shadow-md border-2 border-white shrink-0"
                 style="background-color: {{ strtolower($sheep->eartag_color) === 'yellow' ? '#eab308' : (strtolower($sheep->eartag_color) === 'red' ? '#ef4444' : (strtolower($sheep->eartag_color) === 'blue' ? '#3b82f6' : (strtolower($sheep->eartag_color) === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                <i data-lucide="tag" class="w-7 h-7"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Eartag: {{ $sheep->eartag }}</h2>
                <div class="flex items-center gap-2 mt-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <span>{{ $sheep->breed ? $sheep->breed->name : 'Breed Lokal' }}</span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span>Umur: {{ \Carbon\Carbon::parse($sheep->birth_date)->age }} Bulan</span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span class="{{ $sheep->gender === 'male' ? 'text-blue-600' : 'text-rose-500' }}">
                        {{ $sheep->gender === 'male' ? 'Jantan' : 'Betina' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Kolom Kiri: Form Input -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-24">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center gap-2">
                        <i data-lucide="scale" class="w-5 h-5 text-emerald-500"></i>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Input Berat Baru</h3>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('berat.store', $sheep->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Catat</label>
                            <input type="text" value="{{ now()->format('d M Y') }}" disabled class="w-full bg-slate-100 border-none rounded-xl px-4 py-3 text-sm font-semibold text-slate-500 cursor-not-allowed">
                            <p class="text-[10px] text-slate-400 mt-1.5"><i data-lucide="info" class="w-3 h-3 inline"></i> Otomatis menggunakan tanggal hari ini</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Berat Badan (Kg) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="number" step="0.01" name="weight" required placeholder="0.00" class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-lg font-black text-slate-800 transition-all @error('weight') border-rose-500 @enderror">
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-bold">KG</span>
                                </div>
                            </div>
                            @error('weight')
                                <p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl py-3.5 transition-all shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan Berat
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Chart & Tabel -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Chart Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Grafik Pertumbuhan</h3>
                        <p class="text-xs text-slate-400 mt-1">Tren berat badan domba berdasarkan waktu pencatatan</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-5 h-5"></i>
                    </div>
                </div>
                
                @if($weightHistory->isEmpty())
                    <div class="h-64 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                        <i data-lucide="line-chart" class="w-10 h-10 text-slate-300 mb-2"></i>
                        <p class="text-sm font-semibold text-slate-500">Belum ada data grafik</p>
                        <p class="text-xs text-slate-400 mt-1">Silakan input berat badan pertama di form sebelah kiri.</p>
                    </div>
                @else
                    <div class="h-80 w-full relative">
                        <canvas id="weightChart"></canvas>
                    </div>
                @endif
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Riwayat Historis</h3>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full">{{ $weightHistory->count() }} Data</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">TANGGAL CATAT</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">BERAT BADAN</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">PENCATAT</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($weightHistory->sortByDesc('recorded_at') as $record)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-center text-sm font-medium text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($record->recorded_at)->format('d M Y') }}</div>
                                        <div class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($record->recorded_at)->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-black text-sm border border-emerald-100/50">
                                            {{ $record->weight }} kg
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                                {{ $record->recordedBy ? strtoupper(substr($record->recordedBy->name, 0, 1)) : '?' }}
                                            </div>
                                            <span class="text-sm font-medium text-slate-600">{{ $record->recordedBy ? $record->recordedBy->name : 'Sistem' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-400 font-medium">
                                        Belum ada data riwayat berat badan tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @if($weightHistory->isNotEmpty())
        <!-- Tambahkan CDN Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('weightChart').getContext('2d');
                
                // Siapkan data dari PHP ke JS
                const rawData = @json($weightHistory->map(function($record) {
                    return [
                        'date' => \Carbon\Carbon::parse($record->recorded_at)->format('d M Y'),
                        'weight' => $record->weight
                    ];
                }));

                const labels = rawData.map(item => item.date);
                const data = rawData.map(item => item.weight);

                // Setup Gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Berat Badan (kg)',
                            data: data,
                            borderColor: '#10b981',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4 // Smooth curve
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { family: 'Plus Jakarta Sans', size: 13 },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 14, weight: 'bold' },
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' kg';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: '#f1f5f9',
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: { family: 'Plus Jakarta Sans', size: 11 },
                                    color: '#64748b',
                                    callback: function(value) {
                                        return value + ' kg';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: { family: 'Plus Jakarta Sans', size: 11 },
                                    color: '#64748b'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</x-layouts.admin>
