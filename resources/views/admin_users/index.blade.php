<x-layouts.admin>
    <x-slot name="title">Kelola Admin/Owner</x-slot>
    <x-slot name="header">Akun Admin</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <x-data-table 
        :data="$users" 
        createUrl="{{ route('admin-users.create') }}" 
        createText="Tambah Admin">
        
        <x-slot name="header">
            <th class="px-6 py-4 w-16 text-center">No.</th>
            <th class="px-6 py-4">Nama Lengkap</th>
            <th class="px-6 py-4">Kontak</th>
            <th class="px-6 py-4">Peran</th>
            <th class="px-6 py-4 text-center">Status</th>
        </x-slot>

        @foreach($users as $user)
            <tr class="hover:bg-indigo-50/40 even:bg-slate-50/30 transition-all duration-300 group">
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-slate-400">
                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-400 flex items-center justify-center font-bold text-white shadow-sm border border-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="font-bold text-slate-800">{{ $user->name }}</div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-semibold text-slate-600">{{ $user->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($user->role === 'owner')
                        <span class="inline-flex px-2 py-1 bg-purple-50 text-purple-600 border border-purple-200 text-xs font-extrabold rounded-md uppercase">Owner</span>
                    @else
                        <span class="inline-flex px-2 py-1 bg-blue-50 text-blue-600 border border-blue-200 text-xs font-extrabold rounded-md uppercase">Staff</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($user->status === 'active')
                        <span class="inline-flex gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">Aktif</span>
                    @else
                        <span class="inline-flex gap-1.5 px-2.5 py-1 rounded-full bg-slate-50 text-slate-500 text-xs font-bold border border-slate-200">Nonaktif</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </x-data-table>
</x-layouts.admin>
