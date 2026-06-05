<x-layouts.admin>
    <x-slot name="title">Riwayat Kesehatan: {{ $sheep->eartag }}</x-slot>

    <!-- Breadcrumb / Back Button -->
    <div class="mb-6 flex items-center gap-3 text-sm">
        <a href="{{ route('health-records.index') }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 hover:text-emerald-600 text-slate-500 flex items-center justify-center transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div class="flex items-center gap-2 text-slate-500 font-medium">
            <a href="{{ route('health-records.index') }}" class="hover:text-emerald-600 transition-colors">Catatan Kesehatan</a>
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
                        <i data-lucide="heart-pulse" class="w-5 h-5 text-emerald-500"></i>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Input Catatan Baru</h3>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('health-records.store', $sheep->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Catat</label>
                            <input type="text" value="{{ now()->format('d M Y') }}" disabled class="w-full bg-slate-100 border-none rounded-xl px-4 py-3 text-sm font-semibold text-slate-500 cursor-not-allowed">
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                            <select name="category" required class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-none">
                                <option value="health">Kesehatan</option>
                                <option value="nutrition">Nutrisi</option>
                                <option value="environment">Lingkungan</option>
                                <option value="maintenance">Pemeliharaan</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kondisi <span class="text-rose-500">*</span></label>
                            <select name="condition" required class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-none">
                                <option value="healthy">Sehat</option>
                                <option value="sick">Sakit</option>
                                <option value="injured">Cedera</option>
                                <option value="pregnant">Bunting</option>
                                <option value="vaccinated">Divaksin</option>
                                <option value="heat_stress_risk">Risiko Stres Panas</option>
                                <option value="low_appetite">Nafsu Makan Rendah</option>
                                <option value="normal_feed_intake">Porsi Makan Normal</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tingkat Keparahan <span class="text-rose-500">*</span></label>
                            <select name="severity" required class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-none">
                                <option value="normal">Normal</option>
                                <option value="ringan">Ringan</option>
                                <option value="sedang">Sedang</option>
                                <option value="berat">Berat</option>
                                <option value="warning">Peringatan</option>
                                <option value="critical">Kritis</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Tambahan</label>
                            <textarea name="notes" rows="3" class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 transition-all outline-none" placeholder="Opsional..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl py-3.5 transition-all shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan Catatan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Tabel History -->
        <div class="lg:col-span-8 space-y-6">
            <!-- Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Riwayat Historis</h3>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full">{{ $healthHistory->count() }} Data</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">TANGGAL CATAT</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">KONDISI</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">STATUS</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($healthHistory as $record)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 text-center text-sm font-medium text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($record->recorded_at)->format('d M Y') }}</div>
                                        <div class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($record->recorded_at)->format('H:i') }} WIB &bull; {{ $record->recordedBy ? $record->recordedBy->name : 'Sistem' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-sm font-semibold text-slate-700">
                                                {{ $record->translated_condition }}
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-[11px] font-normal text-slate-400 capitalize">
                                                Kategori: {{ $record->translated_category }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $severity = strtolower($record->severity);
                                            $badgeClass = 'bg-slate-50 text-slate-600 border-slate-200';
                                            $dotClass = 'bg-slate-400';
                                            
                                            if ($severity === 'normal') {
                                                $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                                $dotClass = 'bg-emerald-500';
                                            } elseif ($severity === 'ringan') {
                                                $badgeClass = 'bg-blue-50 text-blue-600 border-blue-100';
                                                $dotClass = 'bg-blue-500';
                                            } elseif ($severity === 'sedang' || $severity === 'warning') {
                                                $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                                                $dotClass = 'bg-amber-500';
                                            } elseif ($severity === 'berat' || $severity === 'critical') {
                                                $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';
                                                $dotClass = 'bg-rose-500';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-xs font-bold {{ $badgeClass }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                            {{ $record->translated_severity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                                        <!-- Delete Action -->
                                        <form action="{{ route('health-records.destroy', $record->id) }}" method="POST" class="inline-block delete-form opacity-0 group-hover:opacity-100 transition-opacity">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent rounded-lg transition-all bg-white shadow-sm"
                                                    title="Hapus Catatan">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @if($record->notes)
                                <tr class="bg-slate-50/30">
                                    <td colspan="5" class="px-6 pb-4 pt-1 border-t-0">
                                        <div class="flex gap-2">
                                            <i data-lucide="message-square" class="w-3 h-3 text-slate-400 mt-0.5"></i>
                                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed">{{ $record->notes }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400 font-medium">
                                        Belum ada riwayat kesehatan tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
