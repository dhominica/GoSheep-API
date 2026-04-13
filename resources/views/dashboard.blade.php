<x-layouts.admin>
    <x-slot:title>Ringkasan Admin</x-slot:title>
    <x-slot:header>Dashboard</x-slot:header>

    <!-- Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-500 p-6 md:p-8 text-white shadow-lg shadow-green-600/10 border border-green-400/20 group">
        <!-- Abstract Patterns inside Banner -->
        <div class="absolute inset-0 opacity-[0.07] bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZmZmIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iMTAiLz48L3N2Zz4=')] bg-[length:32px_32px] transition-transform duration-[15s] ease-linear group-hover:-translate-y-4 group-hover:translate-x-4"></div>
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-white/20 blur-[50px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white/20 backdrop-blur-sm border border-white/20 text-[10px] font-bold tracking-widest uppercase mb-3 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-300 animate-pulse"></span>
                    Sistem Berjalan Baik
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                <p class="text-green-50 max-w-xl text-xs md:text-sm leading-relaxed font-medium">Selamat datang di panel administrasi GoSheep. Saat ini ada <span class="bg-white/20 px-1.5 py-0.5 rounded font-bold">14 aktivitas</span> baru yang perlu diperiksa hari ini.</p>
            </div>
            
            <div class="hidden md:block">
                <button class="bg-white text-green-700 hover:bg-green-50 px-4 py-2.5 rounded-xl font-bold shadow-sm transition-all hover:scale-105 active:scale-95 flex items-center gap-1.5 text-sm border border-green-100">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    Buat Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
        <x-stat-card 
            title="Total Peternak" 
            value="1,248" 
            icon="users" 
            color="blue">
            <x-slot:trend>
                <span class="text-emerald-600 font-bold inline-flex items-center gap-1 bg-emerald-50 px-1.5 py-0.5 rounded-md text-[10px]">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> +12%
                </span>
                <span class="text-slate-400 font-semibold ml-1.5 text-[10px]">Aktivitas bertambah</span>
            </x-slot:trend>
        </x-stat-card>

        <x-stat-card 
            title="Kandang Aktif" 
            value="342" 
            icon="tent" 
            color="emerald">
            <x-slot:trend>
                <span class="text-emerald-600 font-bold inline-flex items-center gap-1 bg-emerald-50 px-1.5 py-0.5 rounded-md text-[10px]">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> +8
                </span>
                <span class="text-slate-400 font-semibold ml-1.5 text-[10px]">Penambahan baru</span>
            </x-slot:trend>
        </x-stat-card>
        
        <x-stat-card 
            title="Total Domba" 
            value="14" 
            icon="users" 
            color="green">
            <x-slot:trend>
                <span class="text-amber-600 font-bold inline-flex items-center gap-1 bg-amber-50 px-1.5 py-0.5 rounded-md text-[10px]">
                    <i data-lucide="minus" class="w-3 h-3"></i> 0%
                </span>
                <span class="text-slate-400 font-semibold ml-1.5 text-[10px]">Status terpantau normal</span>
            </x-slot:trend>
        </x-stat-card>
        
        <x-stat-card 
            title="Status Domba" 
            value="Sehat" 
            icon="heart" 
            color="blue">
            <x-slot:trend>
                <span class="text-purple-600 font-bold inline-flex items-center gap-1 bg-purple-50 px-1.5 py-0.5 rounded-md text-[10px]">
                    <i data-lucide="zap" class="w-3 h-3"></i> 24ms
                </span>
                <span class="text-slate-400 font-semibold ml-1.5 text-[10px]">Waktu respon rata-rata</span>
            </x-slot:trend>
        </x-stat-card>
    </div>

    <!-- Main Content Area -->
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-5 md:gap-6">
        
        <!-- Activity List -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-extrabold text-lg text-slate-800">Aktivitas Real-time</h3>
                <button class="text-[11px] font-bold text-green-600 hover:text-green-700 bg-green-50 px-3 py-1.5 rounded-lg transition-colors hover:bg-green-100 flex items-center gap-1">
                    Lihat Semua
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
            
            <div class="space-y-3">
                <div class="group flex items-center justify-between p-3.5 rounded-xl bg-slate-50/50 border border-slate-100 hover:border-green-200 hover:bg-white hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">Pendaftaran Peternak Baru</p>
                            <p class="text-xs text-slate-500 font-medium">Budi Raharjo, Jawa Tengah</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-[11px] font-bold text-slate-400">10 Menit lalu</span>
                        <span class="inline-block mt-0.5 px-1.5 py-0.5 bg-slate-100 text-slate-500 text-[9px] uppercase font-bold rounded">Proses</span>
                    </div>
                </div>

                <div class="group flex items-center justify-between p-3.5 rounded-xl bg-slate-50/50 border border-slate-100 hover:border-amber-200 hover:bg-white hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">
                            <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">Peringatan: Stok Konsentrat</p>
                            <p class="text-xs text-slate-500 font-medium">Kandang Utama A - Sisa 10 Kg</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-[11px] font-bold text-slate-400">1 Jam lalu</span>
                        <span class="inline-block mt-0.5 px-1.5 py-0.5 bg-amber-100 text-amber-700 text-[9px] uppercase font-bold rounded">Sistem</span>
                    </div>
                </div>

                <div class="group flex items-center justify-between p-3.5 rounded-xl bg-slate-50/50 border border-slate-100 hover:border-emerald-200 hover:bg-white hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-slate-800">Laporan Panen Tersimpan</p>
                            <p class="text-xs text-slate-500 font-medium">Laporan domba Q1 diunggah</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-[11px] font-bold text-slate-400">3 Jam lalu</span>
                        <span class="inline-block mt-0.5 px-1.5 py-0.5 bg-emerald-100 text-emerald-700 text-[9px] uppercase font-bold rounded">Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar Widgets -->
        <div class="space-y-4 md:space-y-6">
            <!-- Widget: Statistik Peternakan -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
                <h3 class="font-bold text-sm text-slate-800 mb-5 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-emerald-500"></i>
                    Statistik Peternakan
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs mb-1.5 font-bold">
                            <span class="text-slate-500">Kapasitas Kandang Terisi</span>
                            <span class="text-slate-700">78%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="bg-gradient-to-r from-emerald-400 to-teal-500 h-1.5 rounded-full w-[78%]"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-xs mb-1.5 font-bold">
                            <span class="text-slate-500">Kesehatan Ternak (Prima)</span>
                            <span class="text-slate-700">92%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-1.5 rounded-full w-[92%]"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget: Aksi Cepat / Shortcut -->
            <div class="bg-slate-900 border border-slate-800 text-white rounded-2xl shadow-lg p-6 relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-colors"></div>
                
                <div class="relative z-10 flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center border border-white/5">
                        <i data-lucide="zap" class="w-5 h-5 text-green-400"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-lg mb-0.5 tracking-tight">Tindakan Cepat</h3>
                        <p class="text-slate-400 text-xs font-semibold">Pencatatan Harian</p>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-white/10 space-y-2.5">
                    <button class="w-full py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-lg transition-all shadow-sm border border-emerald-500 flex items-center justify-center gap-2">
                        <i data-lucide="heart-pulse" class="w-3.5 h-3.5"></i>
                        Catat Cek Kesehatan
                    </button>
                    <button class="w-full py-2 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-lg transition-all shadow-sm border border-white/10 flex items-center justify-center gap-2">
                        <i data-lucide="scale" class="w-3.5 h-3.5"></i>
                        Input Berat Badan
                    </button>
                    <button class="w-full py-2 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-lg transition-all shadow-sm border border-white/10 flex items-center justify-center gap-2">
                        <i data-lucide="baby" class="w-3.5 h-3.5"></i>
                        Lapor Kelahiran
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-layouts.admin>
