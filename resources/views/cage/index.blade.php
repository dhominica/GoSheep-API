<x-layouts.admin>
    <x-slot name="title">Kelola Kandang</x-slot>
    <x-slot name="header">Kelola Kandang</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    @if(session('error'))
        <x-alert type="error" message="{{ session('error') }}" />
    @endif

    <x-data-table 
        :data="$cages" 
        createUrl="{{ route('cage.create') }}" 
        createText="Tambah Kandang">
        
        <x-slot name="header">
            <th class="px-6 py-4 w-16 text-center">No.</th>
            <th class="px-6 py-4">Nama Kandang</th>
            <th class="px-6 py-4 text-center">Jumlah Domba</th>
            <th class="px-6 py-4">Kapasitas</th>
            <th class="px-6 py-4 text-right">Aksi</th>
        </x-slot>

        @foreach($cages as $cage)
            @php
                $percentage = $cage->max_capacity > 0 ? round(($cage->sheep_count / $cage->max_capacity) * 100) : 0;
                $statusColor = $percentage >= 90 ? 'rose' : ($percentage >= 70 ? 'amber' : 'emerald');
            @endphp
            <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300 group">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-slate-400">
                    {{ ($cages->currentPage() - 1) * $cages->perPage() + $loop->iteration }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-slate-200 to-slate-100 flex items-center justify-center font-bold text-slate-500 shadow-sm shrink-0 border border-slate-200">
                            <i data-lucide="home" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">{{ $cage->name }}</div>
                            <div class="text-xs text-slate-500 font-medium">Ditambahkan {{ $cage->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="inline-flex items-center justify-center min-w-[3rem] px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-sm font-bold border border-slate-200">
                        {{ $cage->sheep_count }} Ekor
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="w-full max-w-[200px]">
                        <div class="flex justify-between text-xs font-bold mb-1">
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
