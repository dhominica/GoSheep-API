@props(['data', 'createUrl' => null, 'createText' => 'Tambah Baru', 'title' => 'Daftar Data'])

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
    <!-- Top Action Bar (SIAKAD Balanced Style: 10 Data on the Left, Search & Actions on the Right) -->
    <div class="p-4 md:px-5 py-3 border-b border-slate-200/80 bg-slate-50/50">
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" id="filterForm">
            
            <!-- Left Side: Filter Dropdown (Tampilkan per page) -->
            <div class="relative shrink-0 w-full sm:w-auto">
                <select name="per_page" onchange="document.getElementById('filterForm').submit()" class="appearance-none bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-lg pl-3 pr-8 h-9 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors cursor-pointer shadow-sm w-full sm:w-auto">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Data</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 Data</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Data</option>
                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Data</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                </div>
            </div>

            <!-- Right Side: Search Input, Cari Button, and Tambah Button on the far right (Fixed h-9 height for ultimate neatness) -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 w-full sm:w-auto justify-end">
                <!-- Search input -->
                <div class="relative w-full sm:w-56 shrink-0 sm:shrink">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." class="h-9 w-full pl-3 pr-3 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                </div>

                <!-- Cari Button -->
                <button type="submit" class="h-9 px-4 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-lg transition-all shadow-sm shadow-emerald-600/10 flex items-center justify-center shrink-0">
                    Cari
                </button>

                @if($createUrl)
                    <!-- Tambah button -->
                    <a href="{{ $createUrl }}" class="h-9 px-4 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-lg transition-all shadow-md shadow-emerald-600/10 flex items-center justify-center gap-1.5 shrink-0 ml-1">
                        <i data-lucide="plus" class="w-3.5 h-3.5 text-white"></i>
                        <span>{{ $createText }}</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    {{ $header }}
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    @if($data->count() === 0)
        <div class="p-8 text-center bg-white border-t border-slate-100 flex flex-col items-center justify-center">
            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-3">
                <i data-lucide="folder-open" class="w-6 h-6"></i>
            </div>
            <p class="text-sm font-bold text-slate-500">Tidak ada data ditemukan</p>
            <p class="text-xs text-slate-400 mt-1 font-semibold">Coba sesuaikan kata kunci pencarian Anda.</p>
        </div>
    @endif

    <!-- Pagination Footer -->
    @if($data->hasPages())
        <div class="p-4 border-t border-slate-100 bg-white">
            {{ $data->appends(request()->query())->links() }}
        </div>
    @endif
</div>
