<x-layouts.admin>
    <x-slot name="title">Detail Peternak</x-slot>
    <x-slot name="header">Detail Profil</x-slot>

    <!-- Page Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                Identitas Peternak
            </h2>
            <p class="text-sm font-semibold text-slate-500 mt-2">Melihat informasi identitas akun peternak secara mendetail.</p>
        </div>
        <a href="{{ route('peternak.index') }}" class="group inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-900 transition-all shadow-sm hover:shadow-md">
            <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl overflow-hidden relative group/card">
        <!-- Banner -->
        <div class="relative w-full h-40 md:h-48 bg-gradient-to-br from-emerald-600 via-teal-500 to-emerald-800 overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-teal-400/20 rounded-full blur-xl"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        </div>
        
        <div class="px-6 md:px-10 pb-10 relative z-10">
            <div class="flex flex-col md:flex-row gap-6 md:items-end">
                <!-- Avatar -->
                <div class="relative group-hover/card:scale-105 transition-transform duration-500 -mt-16 md:-mt-20 self-start md:self-auto">
                    <div class="w-32 h-32 rounded-3xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center font-white text-white shadow-xl shrink-0 border-[6px] border-white text-6xl relative z-10">
                        {{ strtoupper(substr($peternak->name, 0, 1)) }}
                    </div>
                    <!-- Glow behind avatar -->
                    <div class="absolute inset-0 bg-orange-500 rounded-3xl blur-xl opacity-40"></div>
                </div>
                
                <!-- Info next to avatar -->
                <div class="flex-1 pb-1 md:pb-2 pt-2 md:pt-0">
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $peternak->name }}</h3>
                    <div class="flex flex-wrap items-center gap-3 mt-2.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-200 shadow-sm">
                            <i data-lucide="user-check" class="w-3.5 h-3.5"></i> Peternak Terverifikasi
                        </span>
                        @if($peternak->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-50 text-green-600 text-xs font-bold border border-green-200 shadow-sm">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-rose-50 text-rose-500 text-xs font-bold border border-rose-200 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Nonaktif
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Action Button -->
                <div class="pb-1 md:pb-2 w-full md:w-auto">
                     <a href="{{ route('peternak.edit', $peternak->id) }}" class="inline-flex items-center justify-center w-full md:w-auto gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 rounded-xl font-bold transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                        <i data-lucide="edit-3" class="w-4 h-4"></i> Kelola Akun
                    </a>
                </div>
            </div>

            <!-- Detail Cards Grid -->
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Email -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:border-blue-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50 transition-transform group-hover:scale-110"></div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 relative z-10 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="mail" class="w-6 h-6"></i>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest relative z-10">Alamat Email</p>
                    <p class="text-sm sm:text-base font-bold text-slate-800 mt-1 relative z-10 truncate" title="{{ $peternak->email }}">{{ $peternak->email }}</p>
                </div>

                <!-- Card 2: Bergabung -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:border-purple-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 opacity-50 transition-transform group-hover:scale-110"></div>
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4 relative z-10 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest relative z-10">Bergabung Sejak</p>
                    <p class="text-sm sm:text-base font-bold text-slate-800 mt-1 relative z-10">{{ $peternak->created_at->translatedFormat('d F Y') }}</p>
                </div>
                
                <!-- Card 3: Akses -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:border-orange-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-orange-50 rounded-bl-full -mr-4 -mt-4 opacity-50 transition-transform group-hover:scale-110"></div>
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 relative z-10 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="smartphone" class="w-6 h-6"></i>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest relative z-10">Akses Mobile</p>
                    <p class="text-sm sm:text-base font-bold text-slate-800 mt-1 relative z-10 flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i> Diizinkan
                    </p>
                </div>
                
                <!-- Card 4: Password -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:border-rose-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 {{ $peternak->request_password_reset ? 'bg-rose-50' : 'bg-emerald-50' }} rounded-bl-full -mr-4 -mt-4 opacity-50 transition-transform group-hover:scale-110"></div>
                    <div class="w-12 h-12 rounded-xl {{ $peternak->request_password_reset ? 'bg-rose-100 text-rose-600 group-hover:bg-rose-600' : 'bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600' }} flex items-center justify-center mb-4 relative z-10 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="shield" class="w-6 h-6"></i>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest relative z-10">Status Keamanan</p>
                    <div class="text-sm sm:text-base font-bold mt-1 relative z-10">
                        @if($peternak->request_password_reset)
                            <div class="flex items-center gap-2 text-rose-600">
                                <i data-lucide="alert-triangle" class="w-4 h-4 animate-pulse"></i> Meminta Reset
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-emerald-600">
                                <i data-lucide="shield-check" class="w-4 h-4"></i> Kata Sandi Aman
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
