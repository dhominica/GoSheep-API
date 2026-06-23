<x-layouts.admin>
    <x-slot name="title">Data Kehamilan Domba</x-slot>
    <x-slot name="header">Data Kehamilan Domba</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Data Kehamilan Domba</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1.5">Manajemen data domba betina yang sedang hamil (bunting).</p>
        </div>
    </div>

    <!-- Main Data Table -->
    <x-data-table :data="$pregnancies" title="Daftar Kehamilan">
        <x-slot name="header">
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO.</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">DOMBA BETINA</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">PEJANTAN</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">TGL. KAWIN</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">PREDIKSI LAHIR</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">STATUS</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
        </x-slot>

        @foreach($pregnancies as $pregnancy)
            <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                    {{ ($pregnancies->currentPage() - 1) * $pregnancies->perPage() + $loop->iteration }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white"
                             style="background-color: {{ strtolower($pregnancy->ewe->eartag_color ?? '') === 'yellow' ? '#eab308' : (strtolower($pregnancy->ewe->eartag_color ?? '') === 'red' ? '#ef4444' : (strtolower($pregnancy->ewe->eartag_color ?? '') === 'blue' ? '#3b82f6' : (strtolower($pregnancy->ewe->eartag_color ?? '') === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-700">
                                {{ $pregnancy->ewe->eartag ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700">
                    {{ $pregnancy->matingRecord->ram->eartag ?? 'N/A' }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-slate-700">
                        {{ \Carbon\Carbon::parse($pregnancy->start_date)->translatedFormat('d M Y') }}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold {{ $pregnancy->expected_birth_date ? 'text-slate-700' : 'text-slate-400 italic' }}">
                        {{ $pregnancy->expected_birth_date ? \Carbon\Carbon::parse($pregnancy->expected_birth_date)->translatedFormat('d M Y') : 'Belum diatur' }}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @php
                        $statusClass = 'bg-slate-50 text-slate-600 border-slate-200';
                        $statusLabel = 'Menunggu';
                        
                        if ($pregnancy->status === 'ongoing') {
                            $statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                            $statusLabel = 'Mengandung';
                        } elseif ($pregnancy->status === 'birthed') {
                            $statusClass = 'bg-blue-50 text-blue-600 border-blue-100';
                            $statusLabel = 'Telah Lahir';
                        } elseif ($pregnancy->status === 'miscarried') {
                            $statusClass = 'bg-rose-50 text-rose-600 border-rose-100';
                            $statusLabel = 'Keguguran';
                        }
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full border text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                    <div class="flex items-center justify-end gap-1.5">
                        <a href="{{ route('pregnancies.edit', $pregnancy->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent rounded-lg transition-all bg-white shadow-sm inline-block" title="Edit Data">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>

                        <form action="{{ route('pregnancies.destroy', $pregnancy->id) }}" method="POST" class="inline-block delete-form">
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
