@props(['data', 'createUrl' => null, 'createText' => 'Tambah Baru'])

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
    <!-- Top Action Bar -->
    <div class="p-4 md:p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto" id="filterForm">
            <!-- Entries per page -->
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-500 hidden sm:inline-block">Tampilkan</span>
                <div class="relative">
                    <select name="per_page" onchange="document.getElementById('filterForm').submit()" class="appearance-none bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-lg pl-3 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-colors cursor-pointer shadow-sm">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                    </div>
                </div>
                <span class="text-xs font-semibold text-slate-500 hidden sm:inline-block">data</span>
            </div>

            <!-- Search -->
            <div class="relative flex-1 sm:w-64 max-w-sm ml-auto sm:ml-0 group focus-within:w-full transition-all duration-300">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 group-focus-within:text-green-500 transition-colors"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." class="w-full pl-10 pr-4 py-2 bg-white border-2 border-slate-100 hover:border-slate-200 rounded-xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all shadow-sm">
            </div>
            
            <button type="submit" class="hidden">Search</button>
        </form>

        @if($createUrl)
        <a href="{{ $createUrl }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-500 hover:from-emerald-500 hover:to-green-400 text-white text-sm font-bold rounded-xl shadow-sm shadow-green-500/20 transition-all hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ $createText }}
        </a>
        @endif
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead class="sticky top-0 z-20">
                <tr class="bg-slate-50/95 backdrop-blur shadow-[0_1px_2px_rgba(0,0,0,0.03)] text-[11px] uppercase tracking-widest font-black text-slate-500">
                    {{ $header }}
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @if(isset($data) && count($data) > 0)
                    {{ $slot }}
                @else
                    <tr>
                        <td colspan="100%" class="px-6 py-16">
                            <div class="max-w-md mx-auto text-center flex flex-col items-center justify-center p-8 bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                                <div class="w-16 h-16 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-slate-300 mb-4 animate-[bounce_3s_infinite]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.25a2.25 2.25 0 032.25 2.25h15A2.25 2.25 0 0021.75 13.25V6.25a2.25 2.25 0 00-2.25-2.25H4.5A2.25 2.25 0 002.25 6.25v7z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 15.75v-10.5m-3.75 3.75l3.75-3.75 3.75 3.75" /></svg>
                                </div>
                                <h4 class="text-base font-black text-slate-800 tracking-tight">Belum Ada Data Ditemukan</h4>
                                <p class="text-xs font-semibold text-slate-400 mt-2 leading-relaxed">Sistem tidak dapat menemukan entri data yang sesuai. Cobalah untuk mengurangi filter pencarian atau tambahkan data pertama Anda.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($data) && $data->hasPages())
    <div class="p-4 md:px-5 border-t border-slate-100 bg-slate-50/50">
        {{ $data->links('vendor.pagination.tailwind-custom') }}
    </div>
    @endif
</div>
