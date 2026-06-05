<x-layouts.admin>
    <x-slot name="title">Data Persilangan (Mating)</x-slot>
    <x-slot name="header">Data Persilangan (Mating)</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Data Persilangan Domba</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1.5">Riwayat hasil persilangan ternak domba. Untuk melakukan persilangan baru, gunakan fitur Rekomendasi Kawin.</p>
        </div>
        <div>
            <a href="{{ route('mating-recommendations.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm shadow-emerald-600/20 hover:shadow-emerald-600/40 hover:-translate-y-0.5">
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                Lihat Rekomendasi Kawin
            </a>
        </div>
    </div>

    <!-- Main Data Table -->
    <x-data-table :data="$matingRecords" title="Daftar Persilangan">
        <x-slot name="header">
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO.</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">DOMBA BETINA</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">DOMBA JANTAN</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">TANGGAL MULAI</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">TANGGAL SELESAI</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">HASIL</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
        </x-slot>

        @foreach($matingRecords as $record)
            <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                    {{ ($matingRecords->currentPage() - 1) * $matingRecords->perPage() + $loop->iteration }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white"
                             style="background-color: {{ strtolower($record->ewe->eartag_color ?? '') === 'yellow' ? '#eab308' : (strtolower($record->ewe->eartag_color ?? '') === 'red' ? '#ef4444' : (strtolower($record->ewe->eartag_color ?? '') === 'blue' ? '#3b82f6' : (strtolower($record->ewe->eartag_color ?? '') === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-700">
                                {{ $record->ewe->eartag ?? 'N/A' }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Betina</div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white"
                             style="background-color: {{ strtolower($record->ram->eartag_color ?? '') === 'yellow' ? '#eab308' : (strtolower($record->ram->eartag_color ?? '') === 'red' ? '#ef4444' : (strtolower($record->ram->eartag_color ?? '') === 'blue' ? '#3b82f6' : (strtolower($record->ram->eartag_color ?? '') === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-700">
                                {{ $record->ram->eartag ?? 'N/A' }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Jantan</div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-slate-700">
                        {{ \Carbon\Carbon::parse($record->mating_date)->translatedFormat('d M Y') }}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-slate-700">
                        {{ \Carbon\Carbon::parse($record->end_date)->translatedFormat('d M Y') }}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @php
                        $statusClass = 'bg-slate-50 text-slate-600 border-slate-200';
                        $statusLabel = 'Belum Diketahui';
                        
                        if ($record->result === 'pregnant') {
                            $statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                            $statusLabel = 'Bunting';
                        } elseif ($record->result === 'not_pregnant' || $record->result === 'failed') {
                            $statusClass = 'bg-rose-50 text-rose-600 border-rose-100';
                            $statusLabel = 'Gagal/Tidak Bunting';
                        }
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full border text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                    <div class="flex items-center justify-end gap-1.5">
                        <a href="{{ route('mating.edit', $record->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent rounded-lg transition-all bg-white shadow-sm inline-block" title="Edit Data">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>

                        <form action="{{ route('mating.destroy', $record->id) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent rounded-lg transition-all bg-white shadow-sm" title="Hapus Data">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-data-table>
</x-layouts.admin>
