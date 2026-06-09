<x-layouts.admin>
    <x-slot:title>Profil Saya</x-slot:title>
    <x-slot:header>Pengaturan Akun</x-slot:header>

    @if (session('success'))
        <x-alert title="Pembaruan Berhasil" type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center flex flex-col items-center">
                <div class="relative w-28 h-28 mb-4">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full rounded-full object-cover border-4 border-emerald-100/50 shadow-sm">
                    @else
                        <div class="w-full h-full rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-3xl border-4 border-emerald-100/50 shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h3 class="text-base font-bold text-slate-800">{{ Auth::user()->name }}</h3>
                <span class="inline-flex items-center gap-1 mt-1.5 text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">
                    <i data-lucide="shield-check" class="w-3 h-3"></i> {{ Auth::user()->role }}
                </span>

                <div class="w-full border-t border-slate-50 my-5"></div>

                
                <div class="w-full space-y-3.5 text-left">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-400 font-medium">Status Akun</span>
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[9px] font-black uppercase tracking-wider border border-emerald-100/50 inline-flex items-center gap-1">
                            <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                            {{ Auth::user()->status }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-400 font-medium">Terdaftar Sejak</span>
                        <span class="text-slate-700 font-bold">{{ Auth::user()->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-gradient-to-br from-slate-900 to-emerald-950 rounded-2xl p-6 text-white shadow-sm flex flex-col justify-between min-h-[9rem]">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                        <i data-lucide="shield" class="w-5 h-5 text-emerald-300"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-xs tracking-wide uppercase">Keamanan Akun</h4>
                        <p class="text-[9px] text-white/50 font-bold uppercase mt-0.5">SIAKAD Security Guard</p>
                    </div>
                </div>
                <p class="text-[10px] text-emerald-100/70 leading-relaxed mt-4">
                    Akun Anda terlindungi dengan enkripsi mutakhir. Disarankan untuk menggunakan kombinasi sandi yang kuat dan unik secara berkala.
                </p>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-emerald-50/10 border-l-4 border-emerald-500">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Informasi Pribadi</h3>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Kelola identitas utama profil Anda</p>
                        </div>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                       
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-black text-slate-450 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                class="px-4 py-3 bg-slate-50/50 border border-slate-100 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 transition-all outline-none">
                            @error('name')
                                <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-black text-slate-450 uppercase tracking-wider">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                class="px-4 py-3 bg-slate-50/50 border border-slate-100 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 transition-all outline-none">
                            @error('email')
                                <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-1.5 md:col-span-2">
                            <label class="text-[10px] font-black text-slate-450 uppercase tracking-wider">Foto Profil (Opsional)</label>
                            <input type="file" name="avatar" accept="image/*"
                                class="px-4 py-3 bg-slate-50/50 border border-slate-100 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            @error('avatar')
                                <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-amber-50/10 border-l-4 border-amber-500">
                        <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i data-lucide="key-round" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Ubah Kata Sandi</h3>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Kosongkan jika Anda tidak ingin mengubah sandi utama</p>
                        </div>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-black text-slate-450 uppercase tracking-wider">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" autocomplete="new-password"
                                class="px-4 py-3 bg-slate-50/50 border border-slate-100 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-50 transition-all outline-none">
                            @error('password')
                                <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-black text-slate-450 uppercase tracking-wider">Ulangi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi sandi baru" autocomplete="new-password"
                                class="px-4 py-3 bg-slate-50/50 border border-slate-100 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-50 transition-all outline-none">
                        </div>
                    </div>
                </div>

                
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="submit" class="flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-[10px] uppercase tracking-wider px-8 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all active:scale-[0.98]">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layouts.admin>
