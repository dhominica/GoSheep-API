<x-layouts.admin>
    <x-slot name="title">Catatan Kesehatan Ternak</x-slot>
    <x-slot name="header">Catatan Kesehatan</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div x-data="{ showModal: false, selectedRecord: null }">
        <!-- Page Header Section (Exactly like your screenshot) -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Catatan Kesehatan Ternak</h2>
                <p class="text-xs font-semibold text-slate-400 mt-1.5">Kelola dan pantau semua riwayat kesehatan dan kondisi medis domba dalam sistem.</p>
            </div>
        </div>

        <!-- Main Data Table -->
        <x-data-table :data="$healthRecords" title="Daftar Catatan Kesehatan">
            <x-slot name="header">
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO.</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">EARTAG DOMBA</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">DICATAT OLEH</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">WAKTU PENCATATAN</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">KONDISI KESEHATAN</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">TINGKAT BAHAYA</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
            </x-slot>

            @foreach($healthRecords as $record)
                <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300 group">
                    <!-- No -->
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                        {{ ($healthRecords->currentPage() - 1) * $healthRecords->perPage() + $loop->iteration }}
                    </td>

                    <!-- Eartag -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white"
                                 style="background-color: {{ strtolower($record->sheep->eartag_color) === 'yellow' ? '#eab308' : (strtolower($record->sheep->eartag_color) === 'red' ? '#ef4444' : (strtolower($record->sheep->eartag_color) === 'blue' ? '#3b82f6' : (strtolower($record->sheep->eartag_color) === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                                <i data-lucide="tag" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-700 group-hover:text-emerald-700 transition-colors">
                                    {{ $record->sheep->eartag }}
                                </div>
                                <div class="text-xs text-slate-400 font-normal capitalize">
                                    Warna: {{ $record->sheep->eartag_color }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- Recorded By -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-500">
                                {{ strtoupper(substr($record->recordedBy ? $record->recordedBy->name : 'S', 0, 1)) }}
                            </div>
                            <div class="text-sm font-medium text-slate-600">
                                {{ $record->recordedBy ? $record->recordedBy->name : 'Sistem' }}
                            </div>
                        </div>
                    </td>

                    <!-- Recorded At -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($record->recorded_at)->translatedFormat('d M Y') }}
                        </div>
                        <div class="text-xs text-slate-400 font-normal mt-0.5">
                            {{ \Carbon\Carbon::parse($record->recorded_at)->format('H:i') }} WIB
                        </div>
                    </td>

                    <!-- Condition -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-sm font-semibold text-slate-700">
                                {{ $record->translated_condition }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-normal text-slate-400 capitalize">
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                Kategori: {{ $record->translated_category }}
                            </span>
                        </div>
                    </td>

                    <!-- Severity (Tingkat Bahaya) -->
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

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                        <div class="flex items-center justify-end gap-1.5">
                            <!-- Detail Button -->
                            <button @click="selectedRecord = {{ json_encode([
                                'id' => $record->id,
                                'eartag' => $record->sheep->eartag,
                                'eartag_color' => $record->sheep->eartag_color,
                                'category' => $record->translated_category,
                                'condition' => $record->translated_condition,
                                'severity' => $record->translated_severity,
                                'source' => $record->translated_source,
                                'notes' => $record->notes ?? 'Tidak ada catatan tambahan.',
                                'recorded_by' => $record->recordedBy ? $record->recordedBy->name : 'Sistem',
                                'recorded_at' => \Carbon\Carbon::parse($record->recorded_at)->translatedFormat('d F Y, H:i')
                            ]) }}; showModal = true" 
                                    class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-transparent rounded-lg transition-all bg-white shadow-sm inline-block"
                                    title="Lihat Detail Lengkap">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>

                            <!-- Delete Action -->
                            <form action="{{ route('health-records.destroy', $record->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent rounded-lg transition-all bg-white shadow-sm"
                                        title="Hapus Catatan">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-data-table>

        <!-- Premium Details Modal Overlay -->
        <div x-show="showModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
             
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModal = false"></div>

            <!-- Modal Content Card -->
            <div class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-200/80 w-full max-w-lg overflow-hidden z-10 transform transition-all relative"
                 x-show="showModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95">
                 
                 <!-- Modal Header with elegant green stripe -->
                 <div class="bg-emerald-600 h-1 w-full"></div>
                 <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                     <div class="flex items-center gap-3">
                         <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                             <i data-lucide="heart-pulse" class="w-4 h-4"></i>
                         </div>
                         <div>
                             <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Detail Catatan Kesehatan</h3>
                             <p class="text-[10px] text-slate-400 mt-0.5">Informasi lengkap status kesehatan domba</p>
                         </div>
                     </div>
                     <button @click="showModal = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                         <i data-lucide="x" class="w-4 h-4"></i>
                     </button>
                 </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-5">
                    <!-- Eartag Showcase Card -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <template x-if="selectedRecord">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center font-bold text-white shadow-sm border border-white"
                                     :style="'background-color: ' + (selectedRecord.eartag_color.toLowerCase() === 'yellow' ? '#eab308' : (selectedRecord.eartag_color.toLowerCase() === 'red' ? '#ef4444' : (selectedRecord.eartag_color.toLowerCase() === 'blue' ? '#3b82f6' : (selectedRecord.eartag_color.toLowerCase() === 'green' ? '#22c55e' : '#94a3b8'))))">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                </div>
                            </template>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Nomor Eartag</p>
                                <h4 class="text-sm font-bold text-slate-705 mt-0.5" x-text="selectedRecord ? selectedRecord.eartag : ''"></h4>
                            </div>
                        </div>
                        <template x-if="selectedRecord">
                            <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[10px] font-bold text-slate-500 uppercase tracking-wider capitalize" x-text="'Warna: ' + selectedRecord.eartag_color"></span>
                        </template>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-3.5">
                        <!-- Kategori -->
                        <div class="bg-white border border-slate-100 p-3 rounded-lg shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kategori</p>
                            <p class="text-[11px] font-semibold text-slate-705 mt-1 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span x-text="selectedRecord ? selectedRecord.category : ''"></span>
                            </p>
                        </div>

                        <!-- Kondisi -->
                        <div class="bg-white border border-slate-100 p-3 rounded-lg shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kondisi</p>
                            <p class="text-[11px] font-semibold text-slate-705 mt-1" x-text="selectedRecord ? selectedRecord.condition : ''"></p>
                        </div>

                        <!-- Tingkat Keparahan -->
                        <div class="bg-white border border-slate-100 p-3 rounded-lg shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Tingkat Bahaya</p>
                            <div class="mt-1">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full border text-[10px] font-semibold uppercase tracking-wider shadow-none"
                                      :class="{
                                          'bg-emerald-50 text-emerald-600 border-emerald-100': selectedRecord && selectedRecord.severity === 'Normal',
                                          'bg-blue-50 text-blue-600 border-blue-100': selectedRecord && selectedRecord.severity === 'Ringan',
                                          'bg-amber-50 text-amber-600 border-amber-100': selectedRecord && (selectedRecord.severity === 'Sedang' || selectedRecord.severity === 'Peringatan'),
                                          'bg-rose-50 text-rose-600 border-rose-100': selectedRecord && (selectedRecord.severity === 'Berat' || selectedRecord.severity === 'Kritis')
                                      }">
                                    <span class="w-1 h-1 rounded-full"
                                          :class="{
                                              'bg-emerald-500': selectedRecord && selectedRecord.severity === 'Normal',
                                              'bg-blue-500': selectedRecord && selectedRecord.severity === 'Ringan',
                                              'bg-amber-500': selectedRecord && (selectedRecord.severity === 'Sedang' || selectedRecord.severity === 'Peringatan'),
                                              'bg-rose-500': selectedRecord && (selectedRecord.severity === 'Berat' || selectedRecord.severity === 'Kritis')
                                          }"></span>
                                    <span x-text="selectedRecord ? selectedRecord.severity : ''"></span>
                                </span>
                            </div>
                        </div>

                        <!-- Sumber Data -->
                        <div class="bg-white border border-slate-100 p-3 rounded-lg shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Sumber Data</p>
                            <p class="text-[11px] font-semibold text-slate-705 mt-1 flex items-center gap-1.5">
                                <i class="w-3.5 h-3.5" :class="selectedRecord && selectedRecord.source === 'IoT' ? 'text-blue-500' : 'text-slate-500'" :data-lucide="selectedRecord && selectedRecord.source === 'IoT' ? 'cpu' : 'user'"></i>
                                <span x-text="selectedRecord ? selectedRecord.source : ''"></span>
                            </p>
                        </div>

                        <!-- Dicatat Oleh -->
                        <div class="bg-white border border-slate-100 p-3 rounded-lg shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Pencatat</p>
                            <p class="text-[11px] font-semibold text-slate-705 mt-1" x-text="selectedRecord ? selectedRecord.recorded_by : ''"></p>
                        </div>

                        <!-- Waktu Catat -->
                        <div class="bg-white border border-slate-100 p-3 rounded-lg shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Waktu Pencatatan</p>
                            <p class="text-[11px] font-semibold text-slate-705 mt-1" x-text="selectedRecord ? selectedRecord.recorded_at + ' WIB' : ''"></p>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Catatan Tambahan</p>
                        <div class="bg-slate-50 border-l-2 border-emerald-500 rounded-r-xl p-3 text-[11px] text-slate-650 leading-relaxed font-medium"
                             x-text="selectedRecord ? selectedRecord.notes : ''">
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50/50 p-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button @click="showModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200 transition-all shadow-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Watcher to trigger Lucide icon reload inside modal when open -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Keep checking when showModal changes to trigger Lucide updates
            const checkLucide = setInterval(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }, 300);
        });
    </script>
</x-layouts.admin>
