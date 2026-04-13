<x-layouts.admin>
    <x-slot name="title">Kelola Peternak</x-slot>
    <x-slot name="header">Kelola Peternak</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <x-data-table 
        :data="$users" 
        createUrl="{{ route('peternak.create') }}" 
        createText="Tambah Peternak">
        
        <x-slot name="header">
            <th class="px-6 py-4 w-16 text-center">No.</th>
            <th class="px-6 py-4">Nama Peternak</th>
            <th class="px-6 py-4">Alamat Email</th>
            <th class="px-6 py-4 text-center">Akses Mobile</th>
            <th class="px-6 py-4 text-center">Status</th>
            <th class="px-6 py-4 text-right">Aksi</th>
        </x-slot>

        @foreach($users as $user)
            <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300 group">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-slate-400">
                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-400 flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 group-hover:text-amber-700 transition-colors">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500 font-medium">Bergabung {{ $user->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-semibold text-slate-600 flex items-center gap-1.5">
                        <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                        {{ $user->email }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-amber-50 text-amber-600 border border-amber-200/60 text-[10px] font-extrabold rounded-lg uppercase tracking-widest shadow-sm">
                        <i data-lucide="smartphone" class="w-3 h-3"></i> Tautkan Mobile
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($user->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-50 text-slate-500 text-xs font-bold border border-slate-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                    <div class="flex items-center justify-end gap-1 transition-opacity">
                        <a href="{{ route('peternak.edit', $user->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent rounded-lg transition-all tooltip bg-white shadow-sm inline-block">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('peternak.destroy', $user->id) }}" method="POST" class="inline-block delete-form">
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
