<x-layouts.admin>
    <x-slot name="title">Kelola Data Domba</x-slot>
    <x-slot name="header">Kelola Domba</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <!-- Page Header Section (Exactly like your screenshot) -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Ternak Domba</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1.5">Kelola data ternak domba, eartag, breed, dan riwayat pertumbuhannya dalam sistem.</p>
        </div>
    </div>

    <x-data-table 
        :data="$sheeps" 
        createUrl="{{ route('sheep.create') }}" 
        createText="Tambah Domba"
        title="Daftar Ternak Domba">
        
        <x-slot name="header">
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO.</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">EARTAG</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">JENIS KELAMIN</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">UMUR & TANGGAL LAHIR</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">BREED & KANDANG</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">STATUS</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
        </x-slot>

        @foreach($sheeps as $sheep)
            <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300 group">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                    {{ ($sheeps->currentPage() - 1) * $sheeps->perPage() + $loop->iteration }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white"
                             style="background-color: {{ strtolower($sheep->eartag_color) === 'yellow' ? '#eab308' : (strtolower($sheep->eartag_color) === 'red' ? '#ef4444' : (strtolower($sheep->eartag_color) === 'blue' ? '#3b82f6' : (strtolower($sheep->eartag_color) === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-700 group-hover:text-emerald-700 transition-colors">{{ $sheep->eartag }}</div>
                            <div class="text-xs text-slate-400 font-normal capitalize">Warna: {{ $sheep->eartag_color }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($sheep->gender === 'male')
                        <span class="inline-flex items-center gap-1.5 text-blue-600 text-sm font-semibold">
                            <i data-lucide="mars" class="w-4 h-4"></i> Jantan
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-rose-500 text-sm font-semibold">
                            <i data-lucide="venus" class="w-4 h-4"></i> Betina
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-semibold text-slate-700">
                        {{ \Carbon\Carbon::parse($sheep->birth_date)->age }} Bulan
                    </div>
                    <div class="text-xs text-slate-400 font-normal">
                        {{ \Carbon\Carbon::parse($sheep->birth_date)->format('d M Y') }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-semibold text-slate-700">
                        {{ $sheep->breed ? $sheep->breed->name : '-' }}
                    </div>
                    <div class="text-xs text-slate-400 font-normal flex items-center gap-1 mt-0.5">
                        <i data-lucide="box" class="w-3 h-3"></i>
                        {{ $sheep->cage ? $sheep->cage->name : 'Tanpa Kandang' }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($sheep->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                    @elseif($sheep->status === 'sold')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold border border-amber-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Terjual
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 text-xs font-semibold border border-rose-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Mati
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                    <div class="flex items-center justify-end gap-1 transition-opacity">
                        <a href="{{ route('sheep.edit', $sheep->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent rounded-lg transition-all tooltip bg-white shadow-sm inline-block">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('sheep.destroy', $sheep->id) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent rounded-lg transition-all tooltip bg-white shadow-sm">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-data-table>
</x-layouts.admin>
