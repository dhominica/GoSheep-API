<x-layouts.admin>
    <x-slot name="title">Riwayat Berat Domba</x-slot>
    <x-slot name="header">Riwayat Berat Domba</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Riwayat Berat Badan</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1.5">Pilih ternak domba di bawah ini untuk melihat statistik dan menginput data berat badan terbaru.</p>
        </div>
    </div>

    @if($sheeps->isEmpty())
        <div class="bg-white p-8 rounded-2xl border border-slate-100 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                <i data-lucide="tag" class="w-8 h-8"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-1">Belum ada data ternak</h3>
            <p class="text-slate-500 text-sm">Tambahkan data ternak domba terlebih dahulu di menu Master Data.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($sheeps as $sheep)
                <a href="{{ route('berat.show', $sheep->id) }}" class="group block bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                    
                    <!-- Dekorasi Background -->
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-slate-50 group-hover:bg-emerald-50 transition-colors -z-0"></div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-white shadow-md border-2 border-white"
                                     style="background-color: {{ strtolower($sheep->eartag_color) === 'yellow' ? '#eab308' : (strtolower($sheep->eartag_color) === 'red' ? '#ef4444' : (strtolower($sheep->eartag_color) === 'blue' ? '#3b82f6' : (strtolower($sheep->eartag_color) === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                                    <i data-lucide="tag" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="font-black text-slate-800 text-lg leading-tight group-hover:text-emerald-700 transition-colors">{{ $sheep->eartag }}</h3>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mt-1">{{ $sheep->breed ? $sheep->breed->name : 'Breed Lokal' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium">Jenis Kelamin</span>
                                @if($sheep->gender === 'male')
                                    <span class="text-blue-600 font-bold flex items-center gap-1"><i data-lucide="mars" class="w-3.5 h-3.5"></i> Jantan</span>
                                @else
                                    <span class="text-rose-500 font-bold flex items-center gap-1"><i data-lucide="venus" class="w-3.5 h-3.5"></i> Betina</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium">Umur</span>
                                <span class="text-slate-700 font-bold">{{ \Carbon\Carbon::parse($sheep->birth_date)->age }} Bulan</span>
                            </div>
                            
                            <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                                <span class="text-slate-500 text-xs font-semibold">Berat Terakhir</span>
                                @if($sheep->latestWeight)
                                    <span class="text-emerald-600 font-black text-lg">{{ $sheep->latestWeight->weight }} <span class="text-xs">kg</span></span>
                                @else
                                    <span class="text-amber-500 font-bold text-xs bg-amber-50 px-2 py-1 rounded-md">Belum Ada Data</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $sheeps->links() }}
        </div>
    @endif
</x-layouts.admin>
