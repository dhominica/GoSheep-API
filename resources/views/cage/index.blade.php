<x-layouts.admin>
    <x-slot name="title">Kelola Kandang</x-slot>
    <x-slot name="header">Kelola Kandang</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    @if(session('error'))
        <x-alert type="error" message="{{ session('error') }}" />
    @endif

    <!-- Page Header Section (Exactly like your screenshot) -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Kelola Kandang</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1.5">Kelola dan pantau data kandang, daya tampung, serta populasi domba dalam sistem.</p>
        </div>
    </div>

    <x-data-table 
        :data="$cages" 
        createUrl="{{ route('cage.create') }}" 
        createText="Tambah Kandang"
        title="Daftar Kandang">
        
        <x-slot name="header">
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO.</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">NAMA KANDANG</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">JUMLAH DOMBA</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">KAPASITAS</th>
            <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
        </x-slot>

        @foreach($cages as $cage)
            @php
                $percentage = $cage->max_capacity > 0 ? round(($cage->sheep_count / $cage->max_capacity) * 100) : 0;
                $statusColor = $percentage >= 90 ? 'rose' : ($percentage >= 70 ? 'amber' : 'emerald');
            @endphp
            <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300 group">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                    {{ ($cages->currentPage() - 1) * $cages->perPage() + $loop->iteration }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-slate-200 to-slate-100 flex items-center justify-center font-bold text-slate-500 shadow-sm shrink-0 border border-slate-200">
                            <i data-lucide="home" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-700 group-hover:text-emerald-700 transition-colors">{{ $cage->name }}</div>
                            <div class="text-xs text-slate-400 font-normal">Ditambahkan {{ $cage->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="inline-flex items-center justify-center min-w-[3rem] px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-sm font-semibold border border-slate-200">
                        {{ $cage->sheep_count }} Ekor
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="w-full max-w-[200px]">
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-{{ $statusColor }}-600">{{ $percentage }}% Terisi</span>
                            <span class="text-slate-500">{{ $cage->sheep_count }} / {{ $cage->max_capacity }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200">
                            <div class="bg-{{ $statusColor }}-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                    <div class="flex items-center justify-end gap-1 transition-opacity">
                        <a href="{{ route('cage.edit', $cage->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent rounded-lg transition-all tooltip bg-white shadow-sm inline-block">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('cage.destroy', $cage->id) }}" method="POST" class="inline-block delete-form">
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
